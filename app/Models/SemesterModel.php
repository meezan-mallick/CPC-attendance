<?php

namespace App\Models;
use CodeIgniter\Model;


class SemesterModel extends Model{
    
    protected $table = 'semesters';
    protected $allowedFields = [
        'id',
        'semester',
    ];

    public function getSubjectSemesters()
    {
        return $this->select('semesters.id, semesters.semester')
                    ->distinct()
                    ->join('subjects', 'semesters.id = subjects.semester_id', 'inner')
                    ->findAll();
    }
   
}

?>
