<?php

namespace App\Models;

use CodeIgniter\Model;

class JobfairActivityReportModel extends Model
{
    protected $table            = 'jobfair_activity_report';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'jobfair_id', 'total_local_employer', 'total_local_employer_vacancy',
        'registered_male_jobseeker', 'registered_female_jobseeker',
        'qualified_male_jobseeker', 'qualified_female_jobseeker',
        'nearhired_male_jobseeker', 'nearhired_female_jobseeker',
        'hots_male_jobseeker', 'hots_female_jobseeker',
        'missmatch_male_jobseeker', 'missmatch_female_jobseeker',
        'tesda_male_availed', 'tesda_female_availed',
        'sss_male_availed', 'sss_female_availed',
        'philhealth_male_availed', 'philhealth_female_availed',
        'pagibig_male_availed', 'pagibig_female_availed',
        'nbi_male_availed', 'nbi_female_availed',
        'psa_male_availed', 'psa_female_availed',
        'prc_male_availed', 'prc_female_availed',
        'bir_male_availed', 'bir_female_availed',
        'dict_male_availed', 'dict_female_availed',
        'dti_male_availed', 'dti_female_availed',
        'other_agency_male_availed', 'other_agency_female_availed'
    ];
    protected $useTimestamps    = false;
}
