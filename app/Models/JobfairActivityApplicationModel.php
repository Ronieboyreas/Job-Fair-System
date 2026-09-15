<?php

namespace App\Models;

use CodeIgniter\Model;

class JobfairActivityApplicationModel extends Model
{
    protected $table            = 'jobfair_activity_application';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'account_id', 
        'proposed_date', 
        'proposed_address', 
        'jobfair_type', 
        'document_link', 
        'clearance_date_issued', 
        'application_date_recieve', 
        'status'
    ];
    protected $useTimestamps    = false;

    /**
     * Fetch applications joined with account details
     */
    public function getApplicationsWithUser()
    {
        return $this->select('jobfair_activity_application.*, account.display_name')
                    ->join('account', 'account.id = jobfair_activity_application.account_id', 'left')
                    ->orderBy('jobfair_activity_application.id', 'DESC')
                    ->findAll();
    }
}
