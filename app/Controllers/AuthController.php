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
        'username'     => 'required|min_length[3]|is_unique[account.username]',
        'email'        => 'required|valid_email|is_unique[account.email]',
        'password'     => 'required|min_length[6]',
        'display_name' => 'required',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Default to 'User' if role post value is empty
    $role = $this->request->getPost('role') ?: 'User';

    // Hash the password securely before saving
    $this->accountModel->save([
        'username'     => $this->request->getPost('username'),
        'password'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        'display_name' => $this->request->getPost('display_name'),
        'role'         => $role,
        'assignment'   => $this->request->getPost('assignment'),
        'email'        => $this->request->getPost('email'),
        'address'      => $this->request->getPost('address'),
    ]);

    return redirect()->to('/login')->with('success', 'Account created successfully! Please log in.');
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

        if ($user && password_verify($password, $user['password'])) {
            // Store user info in session
            session()->set([
                'account_id'   => $user['id'],
                'username'     => $user['username'],
                'display_name' => $user['display_name'],
                'email'         => $user['email'],
                'role'         => $user['role'],
                'isLoggedIn'   => true,
            ]);

            return redirect()->to('/admin/dashboard');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
    }

    // --- LOGOUT ---

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}
