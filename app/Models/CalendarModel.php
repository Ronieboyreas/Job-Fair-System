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
     * Fetch job fair applications for calendar events
     */
    public function getCalendarEvents($role, $accountId)
    {
        $builder = $this->select('
            jobfair_activity_application.*,
            account.display_name
        ')
        ->join('account', 'account.id = jobfair_activity_application.account_id', 'left');

        // Filter by user ID if role is "User"
        if ($role === 'User') {
            $builder->where('jobfair_activity_application.account_id', $accountId);
        }

        return $builder->findAll();
    }
}