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

    public function index()
    {
        // Enforce authentication
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // Fetch applications from the database
        $data = [
            'title'        => 'Job Fair Activity Applications',
            'applications' => $this->applicationModel->getApplicationsWithUser(),
        ];

        return view('applications/index', $data);
    }
    // --- CREATE / SUBMIT APPLICATION ---
    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $rules = [
            'proposed_date'            => 'required|valid_date',
            'proposed_address'         => 'required|min_length[3]',
            'jobfair_type'             => 'required',
            'application_date_recieve' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle Optional Document Link/Upload URL
        $documentLink = $this->request->getPost('document_link') ?: null;

        $this->applicationModel->save([
            'account_id'               => session()->get('account_id'),
            'proposed_date'            => $this->request->getPost('proposed_date'),
            'proposed_address'         => $this->request->getPost('proposed_address'),
            'jobfair_type'             => $this->request->getPost('jobfair_type'),
            'document_link'            => $documentLink,
            'application_date_recieve' => $this->request->getPost('application_date_recieve'),
            'status'                   => 'Pending',
        ]);

        return redirect()->to('/applications')->with('success', 'Job Fair Activity Application submitted successfully!');
    }
    // --- UPDATE APPLICATION ---
    public function update($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
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
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $application = $this->applicationModel->find($id);
        if (!$application) {
            return redirect()->to('/applications')->with('error', 'Application not found.');
        }

        $this->applicationModel->delete($id);

        return redirect()->to('/applications')->with('success', 'Application #' . $id . ' deleted successfully!');
    }
}