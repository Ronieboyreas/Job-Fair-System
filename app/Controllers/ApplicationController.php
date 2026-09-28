<?php

namespace App\Controllers;

use App\Models\JobfairActivityApplicationModel;

class ApplicationController extends BaseController
{
    protected $applicationModel;

    public function __construct()
    {
        $this->applicationModel = new JobfairActivityApplicationModel();
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

        $data = [
            'title'        => 'Job Fair Activity Applications',
            'applications' => $this->applicationModel->getApplicationsWithUser(),
        ];

        return view('applications/index', $data);
    }
    // --- CREATE / SUBMIT APPLICATION ---
    public function store()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // 1. Validation Rules
        $rules = [
            'organization_name'  => 'required|min_length[3]|max_length[255]',
            'business_address'   => 'required',
            'type_of_business'   => 'required|in_list[National Government,Local Government Unit,School Based Institution,Private Entity]',
            'nature_of_business' => 'required',
            'type_of_jobfair'    => 'required|in_list[Local,Overseas,Both]',
            'proposed_date'      => 'required|valid_date[Y-m-d]',
            'proposed_address'  => 'required',
            'document_link'      => 'permit_empty|valid_url',
            'peso_manager'       => 'permit_empty|max_length[255]',
            'peso_office'        => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepare Data for Insertion matching Database Schema
        $data = [
            'account_id'               => session()->get('account_id') ?? session()->get('user_id'),
            'organization_name'        => $this->request->getPost('organization_name'),
            'business_address'         => $this->request->getPost('business_address'),
            'type_of_business'         => $this->request->getPost('type_of_business'),
            'nature_of_business'       => $this->request->getPost('nature_of_business'),
            'jobfair_type'             => $this->request->getPost('type_of_jobfair'),
            'proposed_date'            => $this->request->getPost('proposed_date'),
            'proposed_address'         => $this->request->getPost('proposed_address'),
            'document_link'            => $this->request->getPost('document_link') ?: null,
            'peso_manager'             => $this->request->getPost('peso_manager') ?: null,
            'peso_office'              => $this->request->getPost('peso_office') ?: null,
            'application_date_recieve' => date('Y-m-d'),
            'status'                   => 'Pending',
        ];

        if ($this->applicationModel->save($data)) {
            $redirectUrl = (session()->get('role') === 'Administrator') ? '/applications' : 'user/dashboard';
            return redirect()->to($redirectUrl)->with('success', 'Job Fair Clearance Application submitted successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to submit application. Please try again.');
    }
    // --- UPDATE APPLICATION ---
    public function update($id = null)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }
        if (empty($id) || !is_numeric($id) || $id <= 0) {
            return redirect()->to('/applications')->with('error', 'Invalid application ID.');
        }
        $application = $this->applicationModel->find($id);
        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found.');
        }

        $rules = [
            'proposed_date'            => 'required|valid_date',
            'proposed_address'         => 'required|min_length[3]',
            'jobfair_type'             => 'required',
            'clearance_date_issued'    => 'permit_empty|valid_date',
            'application_date_recieve' => 'required|valid_date',
            'status'                   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->applicationModel->update($id, [
            'proposed_date'            => $this->request->getPost('proposed_date'),
            'proposed_address'         => $this->request->getPost('proposed_address'),
            'jobfair_type'             => $this->request->getPost('jobfair_type'),
            'document_link'            => $this->request->getPost('document_link') ?: null,
            'clearance_date_issued'    => $this->request->getPost('clearance_date_issued') ?: null,
            'application_date_recieve' => $this->request->getPost('application_date_recieve'),
            'status'                   => $this->request->getPost('status'),
        ]);

        return redirect()->to('/applications')->with('success', 'Application #' . $id . ' updated successfully!');
    }

    // --- DELETE APPLICATION ---
    public function delete($id = null)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $application = $this->applicationModel->find($id);
        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found.');
        }

        $this->applicationModel->delete($id);

        return redirect()->to('/applications')->with('success', 'Application #' . $id . ' deleted successfully!');
    }
}