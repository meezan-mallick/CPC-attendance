<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'full_name',
        'email',
        'mobile_number',
        'password',
        'designation',
        'role',
        'status',
        'dob',
        'gender',
        'father_name',
        'mother_name',
        'qualification',
        'industry_experience',
        'working_experience',
        'date_of_joining',
        'achievements',
        'skillset',
        'address',
        'state',
        'city',
        'country'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'full_name'        => 'required|max_length[255]',
        'email'            => 'required|valid_email|is_unique[users.email,id,{id}]', // Allows updating without triggering uniqueness error
        'mobile_number'    => 'required|max_length[15]',
        'password'         => 'permit_empty|min_length[6]',
        'designation'      => 'required|in_list[ASSISTANT PROFESSOR,TEACHING ASSISTANT,TECHNICAL ASSISTANT,VISITING FACULTY]',
        'role'             => 'required|in_list[Superadmin,Coordinator,Faculty]',
        'status'           => 'required|in_list[Active,Inactive]',
    ];




    /**
     * Hash password before saving
     */
    protected function beforeInsert(array $data)
    {
        $data = $this->hashPassword($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']); // Prevent updating password if not provided
        }
        return $data;
    }


    private function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Get user by email for login
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
