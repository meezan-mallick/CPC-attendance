<?php

namespace App\Models;
use CodeIgniter\Model;


class SubjectallocationModel extends Model{
    protected $table = 'allocatedsubjects';
    protected $allowedFields = [
        'id',
        'faculty_id',
        'program_id',
        'semester_number',
        'subject_id',
       
    ];

    public function getAllocatedSubjectDetails()
    {
        return $this->select('allocatedsubjects.id AS id,allocatedsubjects.program_id,allocatedsubjects.semester_number,allocatedsubjects.subject_id, users.full_name AS faculty_name,programs.program_name,subjects.subject_name,colleges.college_code,colleges.college_name')
                    ->join('users', 'allocatedsubjects.faculty_id = users.id', 'inner')
                    ->join('programs', 'allocatedsubjects.program_id = programs.id', 'inner')
                    ->join('colleges', 'colleges.college_code = programs.college_code', 'inner')
                    ->join('subjects', 'allocatedsubjects.subject_id = subjects.id', 'inner')
                    ->findAll();
    }

    public function getOneFacAllocatedSubjectDetails($id)
    {
        return $this->select('allocatedsubjects.id AS id,allocatedsubjects.program_id,semester_number,allocatedsubjects.subject_id, users.full_name AS faculty_name,programs.program_name,subjects.subject_name')
                    ->join('users', 'allocatedsubjects.faculty_id = users.id', 'inner')
                    ->join('programs', 'allocatedsubjects.program_id = programs.id', 'inner')
                    ->join('subjects', 'allocatedsubjects.subject_id = subjects.id', 'inner')
                    ->where('allocatedsubjects.faculty_id', $id)
                    ->findAll();
    }


   


   
    
}

?>
