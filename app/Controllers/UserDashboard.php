<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobfairApplicationModel;
use App\Models\UserModel;

class UserDashboard extends BaseController
{
    protected $applicationModel;
    protected $userModel;

    public function __construct()
    {
        $this->applicationModel = new JobfairApplicationModel();
        $this->userModel        = new UserModel();
    }
    
    public function index()
    {
        // 1. Get logged-in user ID from session
        $session = session();
        $accountId = $session->get('account_id');

        if (!$accountId) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // 2. Fetch applications assigned only to this account
        $applicationModel = new \App\Models\JobfairApplicationModel();
        $applications = $applicationModel->getApplicationsByAccount($accountId);

        // Calculate metrics filtered for this specific user
        $data['totalApps'] = count($applications);
        $data['pendingApps'] = count(array_filter($applications, fn($app) => strtolower($app['status'] ?? '') === 'pending'));
        $data['approvedApps'] = count(array_filter($applications, fn($app) => in_array(strtolower($app['status'] ?? ''), ['approved', 'hired'])));
        $data['rejectedApps'] = count(array_filter($applications, fn($app) => strtolower($app['status'] ?? '') === 'rejected'));

        $data['applications'] = $applications;
        $data['username']     = $session->get('display_name') ?? $session->get('username') ?? 'User';
        $data['role']     = $session->get('role') ?? 'User';

        return view('user/dashboard', $data);
            
        }
        public function apply()
        {
            $session = session();
            $accountId = $session->get('account_id');

            if (!$accountId) {
                return redirect()->to('/login')->with('error', 'Please log in to apply.');
            }

            // Fetch logged-in user profile to pre-fill form fields
            $user = $this->userModel->find($accountId);

            $data = [
                'userName' => $session->get('display_name') ?? $session->get('username') ?? 'User',
                'userRole' => $session->get('role') ?? 'User',
                'user'     => $user,
            ];

            return view('user/application', $data);
        }
}