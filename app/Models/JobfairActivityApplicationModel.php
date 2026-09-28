<?php

namespace App\Models;

use CodeIgniter\Model;

class JobfairActivityApplicationModel extends Model
{
    protected $table            = 'jobfair_activity_application';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields    = [
        'account_id', 
        'organization_name',
        'focal_person',
        'email',
        'mobile_number',
        'business_address',
        'type_of_business',
        'nature_of_business',
        'jobfair_type', 
        'proposed_date', 
        'proposed_address', 
        'document_link', 
        'peso_manager',
        'peso_office',
        'clearance_date_issued', 
        'application_date_recieve', 
        'status'
    ];

    protected $useTimestamps = false;

    /**
     * Fetch applications joined with account details
     */
    public function getApplicationsWithUser()
    {
        return $this->select('jobfair_activity_application.*, account.display_name, account.email AS email,account.contact_number AS contact_number')
                    ->join('account', 'account.id = jobfair_activity_application.account_id', 'left')
                    ->orderBy('jobfair_activity_application.id', 'DESC')
                    ->findAll();
    }
}
