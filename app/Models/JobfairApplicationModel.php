<?php

namespace App\Models;

use CodeIgniter\Model;

class JobfairApplicationModel extends Model
{
    protected $table            = 'jobfair_activity_application';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'account_id', 
        'proposed_date', 
        'proposed_address', 
        'jobfair_type', 
        'document_link', 
        'clearance_date_issued', 
        'application_date_recieve', 
        'status', 
        'created_at'
    ];
    protected $useTimestamps    = true;

    /**
     * Fetch applications filtered by specific account ID
     */
    public function getApplicationsByAccount(int $accountId): array
    {
        return $this->where('account_id', $accountId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}