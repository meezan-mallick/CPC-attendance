<?php

namespace App\Models;
use CodeIgniter\Model;


class CoordinatorModel extends Model{
    
    protected $table = 'coordinators';
    protected $allowedFields = [
        'id',
        'program_id',
        'faculty_id',
    ];

    public function getAllCoordinatorDetails()
    {
        return $this->select('coordinators.id AS id,coordinators.program_id, faculties.name AS faculty_name,programs.program_name')
                    ->join('faculties', 'coordinators.faculty_id = faculties.id', 'inner')
                    ->join('programs', 'coordinators.program_id = programs.id', 'inner')
                    ->findAll();
    }

    public function getAllCoordinatorSubjects($id){
        return $this->select('subjects.id AS sub_id, subjects.sub_name,programs.program_name,programs.id AS prog_id,semesters.id AS sem_id')
                    ->join('faculties', 'coordinators.faculty_id = faculties.id', 'inner')
                    ->join('programs', 'coordinators.program_id = programs.id', 'inner')
                    ->join('subjects', 'subjects.program_id = programs.id', 'inner')
                    ->join('semesters', 'subjects.semester_id = semesters.id', 'inner')
                    ->where('subjects.id NOT IN (SELECT subject_id FROM subjectallocation)', null, false)
                    ->findAll();
    }
}

?>
