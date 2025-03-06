<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table      = 'subjects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'program_id',
        'semester_number',
        'subject_code',
        'subject_name',
        'credit',
        'type',
        'internal_marks',
        'external_marks'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'program_id'      => 'required|integer',
        'semester_number' => 'required|integer|greater_than[0]',
        'subject_code'    => 'required|max_length[50]', // 🔹 Remove `is_unique` from here
        'subject_name'    => 'required|max_length[255]',
        'credit'          => 'required|integer',
        'type'            => 'required|in_list[Practical,Theory]',
        'internal_marks'  => 'required|integer',
        'external_marks'  => 'required|integer',
    ];
}
