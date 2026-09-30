<?php

namespace App\Controllers;
use App\Models\AccountModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    // --- REGISTRATION ---

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $rules = [
            'display_name'   => 'required|min_length[3]|max_length[100]',
            'username'       => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[account.username]',
            'email'          => 'required|valid_email|is_unique[account.email]',
            'contact_number' => 'required|numeric|min_length[7]|max_length[15]',
            'password'       => 'required|min_length[8]',
            'role'           => 'required',
            'assignment'     => 'permit_empty|max_length[255]',
            'address'        => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Collect user data
        $userData = [
            'display_name'   => $this->request->getPost('display_name'),
            'username'       => $this->request->getPost('username'),
            'email'          => $this->request->getPost('email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'password'       => $this->request->getPost('password'),
            'role'           => $this->request->getPost('role') ?? 'User',
            'assignment'     => $this->request->getPost('assignment'),
            'address'        => $this->request->getPost('address'),
        ];

        // Insert using accountModel (Fixed variable name)
        $userId = $this->accountModel->insert($userData);

        if ($userId) {
            $sessionData = [
                'id'           => $userId,
                'account_id'   => $userId,
                'display_name' => $userData['display_name'],
                'username'     => $userData['username'],
                'email'        => $userData['email'],
                'role'         => $userData['role'],
                'isLoggedIn'   => true,
            ];

            session()->set($sessionData);

            return redirect()->to('user/dashboard')->with('success', 'Account registered successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to register account. Please try again.');
    }

    // --- LOGIN ---

    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->accountModel->where('username', $username)->first();

        if ($username == $user['username'] && $password === $user['password']) {
            // Store user info in session
            session()->set([
                'account_id'   => $user['id'],
                'username'     => $user['username'],
                'display_name' => $user['display_name'],
                'email'         => $user['email'],
                'contact_number'         => $user['contact_number'],
                'role'         => $user['role'],
                'isLoggedIn'   => true,
            ]);
            if ($user['role'] == "Administrator"){
                return redirect()->to('/admin/dashboard');
            }else{
                return redirect()->to('/user/dashboard');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
    }

    // --- LOGOUT ---

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Logged out successfully.');
    }
}
