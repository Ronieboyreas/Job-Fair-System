<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'account';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'display_name',
        'username',
        'email',
        'contact_number',
        'password',
        'role',
        'assignment',
        'address'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Update account profile details
     */
    public function updateAccountProfile(int $userId, array $data): bool
    {
        return $this->update($userId, $data);
    }

    /**
     * Update user password with secure hashing
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        return $this->update($userId, [
            'password' => $newPassword
        ]);
    }
}