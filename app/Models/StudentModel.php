<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'university_enrollment_no',
        'full_name',
        'email',
        'mobile_number',
        'parent_mobile_number',
        'gender',
        'dob',
        'father_name',
        'mother_name',
        'category',
        'blood_group',
        'address_line1',
        'city',
        'state',
        'country',
        'pin_code',
        'placement_status',
        'placement_company',
        'placement_company_email',
        'placement_company_address',
        'designation',
        'placement_package',
        'abc_id_no',
        'program_id',
        'semester',
        'batch' // ✅ Ensure batch is here
    ];

    protected $useTimestamps = true;

    protected function beforeInsert(array $data)
    {
        $data = $this->hashPassword($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->hashPassword($data);
        return $data;
    }

    private function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    protected $validationRules = [
        'university_enrollment_no' => 'required|is_unique[students.university_enrollment_no]',
        'full_name' => 'required|max_length[255]',
        'email' => 'permit_empty|valid_email|is_unique[students.email]', // Allow empty emails but ensure unique & valid email

    ];
}
