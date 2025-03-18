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

    public function getAssignedColleges($id)
    {
        $db = \Config\Database::connect();

        // Subquery: Get program IDs from coordinator_programs
        $subQueryCoordinator = $db->table('coordinator_programs')
            ->select('program_id')
            ->where('user_id', $id)
            ->getCompiledSelect();

        // Subquery: Get program IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('program_id')
            ->where('faculty_id', $id)
            ->getCompiledSelect();

        // Fetch distinct colleges based on program_id
        return $db->table('colleges c')
            ->select('c.*') // Get all college details
            ->join('programs p', 'p.college_code = c.college_code') // Join with programs
            ->where("p.id IN ($subQueryCoordinator)", null, false)
            ->orWhere("p.id IN ($subQueryAllocated)", null, false)
            ->groupBy('c.id') // Ensure unique colleges
            ->get()
            ->getResultArray();
    }

    public function  getFacultyAssignedColleges($id)
    {
        $db = \Config\Database::connect();

        
        // Subquery: Get program IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('program_id')
            ->where('faculty_id', $id)
            ->getCompiledSelect();

        // Fetch distinct colleges based on program_id
        return $db->table('colleges c')
            ->select('c.*') // Get all college details
            ->join('programs p', 'p.college_code = c.college_code') // Join with programs
             ->orWhere("p.id IN ($subQueryAllocated)", null, false)
            ->groupBy('c.id') // Ensure unique colleges
            ->get()
            ->getResultArray();
    }

}
