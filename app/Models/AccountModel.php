<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table            = 'account';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'username', 
        'password', 
        'display_name', 
        'role', 
        'assignment', 
        'username', 
        'email', 
        'contact_number', 
        'address'
    ];
    protected $useTimestamps    = false;
}
