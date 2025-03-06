<?php

namespace App\Models;
use CodeIgniter\Model;


class SubjectallocationModel extends Model{
    
    protected $table = 'subjectallocation';
    protected $allowedFields = [
        'id',
        'faculty_id',
        'program_id',
        'semester_id',
        'subject_id',
       
    ];

    public function getAllocatedSubjectDetails()
    {
        return $this->select('subjectallocation.id AS id,subjectallocation.program_id,subjectallocation.semester_id,subjectallocation.subject_id, faculties.name AS faculty_name,programs.program_name, semesters.semester,subjects.sub_name')
                    ->join('faculties', 'subjectallocation.faculty_id = faculties.id', 'inner')
                    ->join('programs', 'subjectallocation.program_id = programs.id', 'inner')
                    ->join('semesters', 'subjectallocation.semester_id = semesters.id', 'inner')
                    ->join('subjects', 'subjectallocation.subject_id = subjects.id', 'inner')
                    ->findAll();
    }

    public function getOneFacAllocatedSubjectDetails($id)
    {
        return $this->select('subjectallocation.id AS id,subjectallocation.program_id,subjectallocation.semester_id,subjectallocation.subject_id, faculties.name AS faculty_name,programs.program_name, semesters.semester,subjects.sub_name')
                    ->join('faculties', 'subjectallocation.faculty_id = faculties.id', 'inner')
                    ->join('programs', 'subjectallocation.program_id = programs.id', 'inner')
                    ->join('semesters', 'subjectallocation.semester_id = semesters.id', 'inner')
                    ->join('subjects', 'subjectallocation.subject_id = subjects.id', 'inner')
                    ->where('subjectallocation.faculty_id', $id)
                    ->findAll();
    }


   

   
    
}

?>
