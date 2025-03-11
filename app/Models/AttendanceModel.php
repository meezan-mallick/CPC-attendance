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

    public function getStudentAttendanceLecture($program_id,$semester_number,$subject_id,$topic_id,$batch){
        return $this->select('attendance.id AS attendance_id,students.id AS id,students.batch, students.full_name,students.university_enrollment_no,attendance.attendance')
        ->join('students', 'students.id = attendance.student_id  AND attendance.topic_id='.(int)$topic_id.'', 'right')
        ->join('programs', 'students.program_id = programs.id', 'inner')
        ->where('students.batch',$batch)
        ->where('students.semester',$semester_number)
        ->where('students.program_id',$program_id)
        ->findAll();
    }

   


}

?>
