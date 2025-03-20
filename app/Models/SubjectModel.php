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

    /**
     * ✅ Check if the subject code is unique within the same program
     * @param string $subject_code
     * @param int $program_id
     * @param int|null $exclude_id (For updating, exclude the current subject)
     * @return bool
     */
    public function isUniqueSubjectCode($subject_code, $program_id, $exclude_id = null)
    {
        $query = $this->where('subject_code', $subject_code)
            ->where('program_id', $program_id);

        if ($exclude_id !== null) {
            $query->where('id !=', $exclude_id);
        }

        return $query->countAllResults() == 0;
    }


    public function getCoordinatorSubjects($userId)
    {
        $db = \Config\Database::connect();

        // Subquery to fetch subject IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('subject_id')
            ->where('faculty_id', $userId)
            ->getCompiledSelect();

        // Subquery to fetch program IDs from coordinator_programs
        $subQueryCoordinator = $db->table('coordinator_programs')
            ->select('program_id')
            ->where('user_id', $userId)
            ->getCompiledSelect();

        return $db->table('subjects s')
            ->select('s.*') // Select all columns from subjects
            ->where("s.id IN ($subQueryAllocated)", null, false) // Use raw query string
            ->orWhere("s.program_id IN ($subQueryCoordinator)", null, false) // Use raw query string
            ->get()
            ->getResultArray();
    }

    public function getFacultySubjects($userId)
    {
        $db = \Config\Database::connect();

        // Subquery to fetch subject IDs from allocatedsubjects
        $subQueryAllocated = $db->table('allocatedsubjects')
            ->select('subject_id')
            ->where('faculty_id', $userId)
            ->getCompiledSelect();



        return $db->table('subjects s')
            ->select('s.*') // Select all columns from subjects
            ->where("s.id IN ($subQueryAllocated)", null, false) // Use raw query string
            ->get()
            ->getResultArray();
    }
}
