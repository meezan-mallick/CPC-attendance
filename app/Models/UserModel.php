<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Or 'object' based on your preference
    protected $useSoftDeletes = false; // Or true if you implement soft deletes

    // Make sure ALL fields you want to be able to update are listed here
    protected $allowedFields = [
        'full_name',
        'email',
        'mobile_number',
        'password', // Don't remove this, it's handled by beforeUpdate
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
        'date_of_joining', // If you have this field and want to update it
        'achievements',
        'skillset',
        'address',
        'state',
        'city',
        'country',
        // --- NEW FIELDS - ADD THEM IF THEY ARE MISSING ---
        'name_as_per_bank_account', // This one is now working, so it should be there
        'pan_card_no',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'aadhaar_no',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true; // Make sure this is true for created_at/updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // If using soft deletes

    // Validation
    // ... (your existing validation rules in the model, if any)

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate']; // This will trigger your password hashing
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeUpdate(array $data)
    {
        // ... (your existing beforeUpdate logic)
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']); // Prevent updating password if not provided
        }
        return $data;
    }
}