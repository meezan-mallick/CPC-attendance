<?php

namespace App\Models;

use CodeIgniter\Model;


class SubjectallocationModel extends Model
{
    protected $table = 'allocatedsubjects';
    protected $allowedFields = [
        'id',
        'faculty_id',
        'program_id',
        'semester_number',
        'subject_id',

    ];


    public function getAllocatedSubjectDetails($userRole = 'Superadmin', $userId = null)
    {
        $query = $this->select('
                    allocatedsubjects.id AS id,
                    allocatedsubjects.program_id,
                    allocatedsubjects.semester_number,
                    allocatedsubjects.subject_id,
                    users.full_name AS faculty_name,
                    programs.program_name,
                    subjects.subject_name,
                    colleges.college_code,
                    colleges.college_name
                ')
            ->join('users', 'allocatedsubjects.faculty_id = users.id', 'left')
            ->join('programs', 'allocatedsubjects.program_id = programs.id', 'inner')
            ->join('colleges', 'colleges.college_code = programs.college_code', 'left')
            ->join('subjects', 'allocatedsubjects.subject_id = subjects.id', 'inner');

        if ($userRole === 'Coordinator' && $userId !== null) {
            $query->join('coordinator_programs', 'allocatedsubjects.program_id = coordinator_programs.program_id', 'inner')
                ->where('coordinator_programs.user_id', $userId);
        }

        return $query->findAll();
    }


    public function getOneFacAllocatedSubjectDetails($id)
    {
        return $this->select('allocatedsubjects.id AS id,allocatedsubjects.program_id,allocatedsubjects.semester_number,allocatedsubjects.subject_id,colleges.college_name, COALESCE(users.full_name, "-") AS coordinator,programs.program_name,subjects.subject_name')
            ->join('programs', 'allocatedsubjects.program_id = programs.id', 'inner')
            ->join('colleges', 'colleges.college_code = programs.college_code', 'inner')
            ->join('subjects', 'allocatedsubjects.subject_id = subjects.id', 'inner')
            ->join('coordinator_programs', 'coordinator_programs.program_id = programs.id', 'left')
            ->join('users', 'coordinator_programs.user_id = users.id', 'left')
            ->where('allocatedsubjects.faculty_id', $id)
            ->findAll();
    }
}
