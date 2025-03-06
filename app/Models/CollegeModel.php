<?php

namespace App\Models;

use CodeIgniter\Model;

class CollegeModel extends Model
{
    protected $table      = 'colleges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['college_code', 'college_name'];

    protected $useTimestamps = true;

    protected $validationRules = [
        'college_code'  => 'required|is_unique[colleges.college_code]|max_length[5]|min_length[3]|numeric',
        'college_name'  => 'required|max_length[255]',
    ];
}
