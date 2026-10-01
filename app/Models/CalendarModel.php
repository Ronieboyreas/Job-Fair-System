<?php

namespace App\Models;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table            = 'jobfair_activity_application';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'account_id',
        'organization_name',
        'business_address',
        'type_of_business',
        'nature_of_business',
        'jobfair_type',
        'proposed_date',
        'proposed_address',
        'document_link',
        'peso_manager',
        'peso_office',
        'application_date_recieve',
        'status'
    ];

    /**
     * Fetch job fair applications with joined account details
     */
    public function getCalendarEvents($role = null, $accountId = null)
    {
        $builder = $this->select('
            jobfair_activity_application.*,
            account.display_name AS applicant_name,
            account.email AS applicant_email
        ')
        ->join('account', 'account.id = jobfair_activity_application.account_id', 'left');

        // Filter by account ID if role is regular "User"
        if ($role === 'User' && !empty($accountId)) {
            $builder->where('jobfair_activity_application.account_id', $accountId);
        }

        return $builder->findAll();
    }
}