<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table      = 'programs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['college_code', 'program_name', 'program_duration', 'program_type', 'total_semesters'];

    protected $useTimestamps = true;

    protected $validationRules = [
        'college_code'      => 'required|checkCollegeCode',
        'program_name'      => 'required|max_length[255]',
        'program_duration'  => 'required|in_list[2 Years,5 Years]',
        'program_type'      => 'required|in_list[0,1]', // 0 = Masters, 1 = Integrated
        'total_semesters'   => 'required|in_list[4,10]', // Ensuring only valid semester counts
    ];

    protected $validationMessages = [
        'college_code' => [
            'checkCollegeCode' => 'The selected college code does not exist.',
        ]
    ];
}
