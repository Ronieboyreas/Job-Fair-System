<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployerModel extends Model
{
    protected $table            = 'employer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'company_email', 
        'company_address', 
        'company_contact_person', 
        'company_contact_number'
    ];
    protected $useTimestamps    = false;
}
