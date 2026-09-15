<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Use model() helper function for CI4 best practice
        $this->userModel = model(UserModel::class);
    }

    /**
     * Display the accounts list view
     */
    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/account', $data);
    }
    public function store()
    {
        // 1. Validation Rules (including unique username constraint)
        $rules = [
            'display_name' => 'required|min_length[2]|max_length[100]',
            'email'        => 'required|valid_email|is_unique[account.email]',
            'username'     => 'required|alpha_dash|min_length[3]|max_length[30]|is_unique[account.username]',
            'role'         => 'required|in_list[User,Staff,Administrator]',
            'address'      => 'permit_empty|string|max_length[255]',
            'assignment'   => 'permit_empty|string|max_length[255]',
            'password'     => 'required|min_length[8]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Collect Data
        $userData = [
            'display_name' => trim($this->request->getPost('display_name')),
            'email'        => trim($this->request->getPost('email')),
            'username'     => trim($this->request->getPost('username')),
            'role'         => $this->request->getPost('role'),
            'address'      => trim($this->request->getPost('address')),
            'assignment'   => trim($this->request->getPost('assignment')),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        // 3. Save to Database
        $userModel = new UserModel();
        if ($userModel->insert($userData)) {
            return redirect()->to(base_url('admin/account'))->with('success', 'Account created successfully.');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create account. Please try again.');
    }
    /**
     * Update existing account details
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/account')->with('error', 'User record not found.');
        }

        // Validation rules (check email uniqueness excluding current user)
        $rules = [
            'display_name' => 'required|min_length[2]|max_length[100]',
            'email'        => "required|valid_email|is_unique[account.email,id,{$id}]",
            'role'         => 'required|in_list[User,Staff,Administrator]',
            'address'      => 'permit_empty|string',
            'assignment'   => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'display_name' => $this->request->getPost('display_name'),
            'email'        => $this->request->getPost('email'),
            'role'         => $this->request->getPost('role'),
            'address'      => $this->request->getPost('address'),
            'assignment'   => $this->request->getPost('assignment'),
        ];

        // Hash and update password only if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/account')->with('success', 'User account updated successfully.');
    }

    /**
     * Delete an account
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/account')->with('error', 'User record not found.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/account')->with('success', 'User account deleted successfully.');
    }
}