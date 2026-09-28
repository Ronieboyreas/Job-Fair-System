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

        $role = session()->get('role');
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
        $role = session()->get('role');
        $accountId = session()->get('account_id') ?? session()->get('user_id');

        $applications = $this->calendarModel->getCalendarEvents($role, $accountId);
        $events = [];

        foreach ($applications as $app) {
            // Determine if the current user is allowed to edit this event
            $canEdit = ($role === 'Staff' || $role === 'Administrator' || (string)$app['account_id'] === (string)$accountId);

            // Determine badge color based on status
            $color = '#0d6efd'; // Primary blue default
            if ($app['status'] === 'Approved') $color = '#198754';
            elseif ($app['status'] === 'Pending') $color = '#ffc107';
            elseif ($app['status'] === 'Rejected') $color = '#dc3545';

            $events[] = [
                'id'            => $app['id'],
                'title'         => $app['organization_name'],
                'start'         => $app['proposed_date'],
                'backgroundColor' => $color,
                'borderColor'   => $color,
                'textColor'     => ($app['status'] === 'Pending') ? '#000' : '#fff',
                'extendedProps' => [
                    'account_id'       => $app['account_id'],
                    'display_name'     => $app['display_name'] ?? 'N/A',
                    'organization_name'=> $app['organization_name'],
                    'jobfair_type'     => $app['jobfair_type'] ?? 'N/A',
                    'proposed_date'    => $app['proposed_date'],
                    'proposed_address' => $app['proposed_address'] ?? 'N/A',
                    'status'           => $app['status'] ?? 'Pending',
                    'canEdit'          => $canEdit
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Update application proposed date via drag-and-drop or modal submit
     */
    public function updateDate()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }
        $role = session()->get('role');
        $accountId = session()->get('account_id') ?? session()->get('user_id');

        $id = $this->request->getPost('id');
        $proposedDate = $this->request->getPost('proposed_date');

        $application = $this->calendarModel->find($id);
        if (!$application) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Application not found.']);
        }

        // Permission check: Staff/Admin can edit all; User can edit only their own
        if ($role !== 'Staff' && $role !== 'Administrator' && (string)$application['account_id'] !== (string)$accountId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized: You do not have permission to edit this event.']);
        }

        $updateData = ['proposed_date' => $proposedDate];
        
        // Allow Staff/Admin to also update status if provided
        if (in_array($role, ['Staff', 'Administrator']) && $this->request->getPost('status')) {
            $updateData['status'] = $this->request->getPost('status');
        }

        if ($this->calendarModel->update($id, $updateData)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Date updated successfully!']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update.']);
    }
}