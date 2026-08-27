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
        'email', 
        'address'
    ];
    protected $useTimestamps    = false;
}
