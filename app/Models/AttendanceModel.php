<?php

namespace App\Models;
use CodeIgniter\Model;


class AttendanceModel extends Model{
    
    protected $table = 'attendance';
    protected $allowedFields = [
        'id',
        'topic_id',
        'student_id',
        'program_id',
        'semester_number',
        'subject_id',
        'batch',
        'attendance',
       
       
    ];

    public function getStudentAttendanceLecture($p_id,$s_id,$sub_id,$t_id,$batch){
        return $this->select('attendance.id AS att_id,students.id, students.stud_name,students.enroll_no,attendance.attendance')
        ->join('students', 'students.id = attendance.student_id  AND attendance.topic_id='.(int)$t_id.'', 'right')
        ->join('programs', 'students.program_id = programs.id', 'inner')
        ->join('semesters', 'students.semester_id = semesters.id', 'inner')
        ->where('students.batch',$batch)
        ->where('semesters.id',$s_id)
        ->findAll();
    }

   


}

?>
