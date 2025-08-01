<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

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
        'country',
        'name_as_per_bank_account',
        'pan_card_no',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'aadhaar_no',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callbacks
    protected $allowCallbacks = true;
    // --- FIX START: Add 'beforeInsert' and 'beforeUpdate' to both callbacks ---
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    // --- FIX END ---
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // --- FIX START: Create a single, reusable 'hashPassword' function ---
    protected function hashPassword(array $data)
    {
        // Check if the 'password' field exists and is not empty in the data being saved.
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            // Unset the password if it's empty, to prevent overwriting existing passwords on update.
            // This is especially important for the update() method.
            unset($data['data']['password']);
        }
        return $data;
    }
    // --- FIX END ---
}