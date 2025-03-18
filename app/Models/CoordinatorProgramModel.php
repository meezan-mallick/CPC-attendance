<?php

namespace App\Models;

use CodeIgniter\Model;

class CoordinatorProgramModel extends Model
{
    protected $table      = 'coordinator_programs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'program_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    /**
     * Get all programs assigned to a coordinator
     */
    public function getProgramsByCoordinator($user_id)
    {
        return $this->where('user_id', $user_id)->findAll();
    }

        
    
}
