<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CalendarModel;

class CalendarController extends BaseController
{
    protected $calendarModel;

    public function __construct()
    {
        $this->calendarModel = new CalendarModel();
    }

    private function checkAuth()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $role      = session()->get('role');
        $accountId = session()->get('account_id') ?? session()->get('user_id');

        $data = [
            'title'     => 'Job Fair Activity Calendar',
            'userRole'  => $role,
            'accountId' => $accountId,
        ];

        return view('user/calendar', $data);
    }

    /**
     * Return JSON data for FullCalendar
     */
    public function fetchEvents()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $role      = session()->get('role');
        $accountId = session()->get('account_id') ?? session()->get('user_id');

        // Joined fetch to get applicant display name from account table
        $applications = $this->calendarModel->getCalendarEvents($role, $accountId);
        $events       = [];

        foreach ($applications as $app) {
            $canEdit = ($role === 'Staff' || $role === 'Administrator' || (string)$app['account_id'] === (string)$accountId);

            $color = '#0d6efd';
            if (($app['status'] ?? '') === 'Approved') {
                $color = '#198754';
            } elseif (($app['status'] ?? '') === 'Pending') {
                $color = '#ffc107';
            } elseif (($app['status'] ?? '') === 'Rejected') {
                $color = '#dc3545';
            }

            $events[] = [
                'id'              => $app['id'],
                'title'           => $app['organization_name'],
                'start'           => $app['proposed_date'],
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'textColor'       => ($app['status'] === 'Pending') ? '#000000' : '#ffffff',
                'extendedProps'   => [
                    'account_id'        => $app['account_id'],
                    'applicant_name'    => $app['applicant_name'] ?? 'N/A',
                    'organization_name' => $app['organization_name'],
                    'jobfair_type'      => $app['jobfair_type'] ?? 'N/A',
                    'proposed_date'     => $app['proposed_date'],
                    'proposed_address'  => $app['proposed_address'] ?? 'N/A',
                    'status'            => $app['status'] ?? 'Pending',
                    'canEdit'           => $canEdit
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Update application proposed date, organization name, and status
     */
    public function updateDate()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $role      = session()->get('role');
        $accountId = session()->get('account_id') ?? session()->get('user_id');

        $id               = $this->request->getPost('id');
        $proposedDate     = $this->request->getPost('proposed_date');
        $organizationName = $this->request->getPost('organization_name');
        $applicantName    = $this->request->getPost('event_applicant');

        $application = $this->calendarModel->find($id);
        if (!$application) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Application not found.']);
        }

        // Permission check
        if ($role !== 'Staff' && $role !== 'Administrator' && (string)$application['account_id'] !== (string)$accountId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized action.']);
        }

        $updateData = [];

        if (!empty($proposedDate)) {
            $updateData['proposed_date'] = $proposedDate;
        }

        if ($organizationName !== null && $role === 'Administrator') {
            $updateData['organization_name'] = $organizationName;
        }

        if (in_array($role, ['Staff', 'Administrator']) && $this->request->getPost('status')) {
            $updateData['status'] = $this->request->getPost('status');
        }

        if (!empty($updateData)) {
            $this->calendarModel->update($id, $updateData);
        }

        // Optionally update display_name on account table if Admin changes applicant name
        if (!empty($applicantName) && !empty($application['account_id']) && $role === 'Administrator') {
            $accountModel = new \App\Models\AccountModel();
            $accountModel->update($application['account_id'], [
                'display_name' => $applicantName
            ]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Record updated successfully!']);
    }
}