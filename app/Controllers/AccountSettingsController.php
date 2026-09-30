<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AccountSettingsController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id') ?? session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('login')->with('error', 'User session expired or invalid.');
        }

        $data = [
            'title' => 'Account Settings',
            'user'  => $user
        ];

        return view('account_settings/index', $data);
    }

    public function updateProfile()
    {
        $accountId = session()->get('account_id') ?? session()->get('id');

        $rules = [
            'display_name' => 'required|min_length[2]|max_length[100]',
            'email'     => "required|valid_email|is_unique[account.email,id,{$accountId}]",
            'username'  => "required|alpha_numeric_space|min_length[3]|max_length[50]|is_unique[account.username,id,{$accountId}]",
            'contact_number'     => 'permit_empty|min_length[11]|max_length[12]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'display_name' => $this->request->getPost('display_name'),
            'email'     => $this->request->getPost('email'),
            'username'  => $this->request->getPost('username'),
            'contact_number'     => $this->request->getPost('contact_number'),
        ];

        if ($this->userModel->updateAccountProfile($accountId, $data)) {
            // Update session data if necessary
            session()->set([
                'display_name' => $data['display_name'],
                'email'     => $data['email'],
                'username'  => $data['username'],
            ]);

            return redirect()->to('account_settings')->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
    }

    public function changePassword()
    {
        $accountId = session()->get('account_id') ?? session()->get('id');
        $user = $this->userModel->find($accountId);

        if (!$user) {
            return redirect()->back()->with('error', 'User account not found.');
        }

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        // Custom validation for current password check
        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getPost('current_password');

        // Handle column name variations (password vs password_hash)
        $storedPassword = $user['password'] ?? $user['password_hash'] ?? null;

        if (!$storedPassword) {
            return redirect()->back()->with('error', 'Password field invalid in account record.');
        }

        if (!password_verify($currentPassword, $storedPassword)) {
            if ($currentPassword === $storedPassword) {
                // Update to secure hash automatically
                $this->userModel->updatePassword($accountId, $this->request->getPost('new_password'));
                return redirect()->to('account_settings')->with('success', 'Password updated successfully!');
            }

            return redirect()->back()->with('error', 'Current password does not match.');
        }

        $newPassword = $this->request->getPost('new_password');

        if ($this->userModel->updatePassword($accountId, $newPassword)) {
            return redirect()->to('account_settings')->with('success', 'Password changed successfully!');
        }

        return redirect()->back()->with('error', 'Failed to change password. Please try again.');
    }
}