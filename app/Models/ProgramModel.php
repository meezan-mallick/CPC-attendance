<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table      = 'programs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'college_code',
        'program_name',
        'program_duration',
        'program_type',
        'total_semesters',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'college_code'      => 'required|checkCollegeCode',
        'program_name'      => 'required|max_length[255]',
        'program_duration'  => 'required|in_list[2 Years,3 Years,4 Years,5 Years]',
        'program_type'      => 'required|in_list[integrated,masters,bachelor,honours]',
        'total_semesters'   => 'required|in_list[4,6,8,10]',
    ];

    protected $validationMessages = [
        'college_code' => [
            'checkCollegeCode' => 'The selected college code does not exist.',
        ],
    ];

    public function getAssignedProgramsandSubs($id)
    {
        $db = \Config\Database::connect();

        // Get program IDs from coordinator_programs
        $subQueryCoordinator = $db->table('coordinator_programs')
            ->select('program_id')
            ->where('user_id', $id)
            ->getCompiledSelect();

        // Get program IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('program_id')
            ->where('faculty_id', $id)
            ->getCompiledSelect();

        // Fetch all program details
        return $db->table('programs p')
            ->select('p.*')
            ->where("p.id IN ($subQueryCoordinator)", null, false)
            ->orWhere("p.id IN ($subQueryAllocated)", null, false)
            ->get()
            ->getResultArray();
    }

    public function getFacultyAssignedProgramsandSubs($id)
    {
        $db = \Config\Database::connect();

        // Get program IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('program_id')
            ->where('faculty_id', $id)
            ->getCompiledSelect();

        // Fetch all program details
        return $db->table('programs p')
            ->select('p.*')
            ->orWhere("p.id IN ($subQueryAllocated)", null, false)
            ->get()
            ->getResultArray();
    }
}
