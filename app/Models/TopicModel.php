<?php

namespace App\Models;
use CodeIgniter\Model;


class TopicModel extends Model{
    
    protected $table = 'topics';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'topic',
        'date',
        'time',
        'batch',
        'subject_id',
       
       
    ];

    protected $validationRules = [
        'topic' => 'required|max_length[255]',
        'date' => 'required',
        'batch' => 'required',
        'time' => 'required|max_length[255]',
        'subject_id' => 'required|integer',
        
    ];
    public function getAllTopics($sub_id) {
        
        // return $this->select('topics.id, topics.topic, topics.date, topics.time, topics.batch, topics.subject_id, subjects.semester_number AS semester,
        //               (SELECT COUNT(*) FROM students WHERE students.semester = subjects.semester_number AND students.batch = topics.batch) AS total_stud, 
        //               COUNT(DISTINCT CASE WHEN attendance.attendance = "Present" THEN attendance.student_id END) AS total_present')
        // ->join('attendance', 'attendance.topic_id = topics.id', 'left')
        // ->join('subjects', 'subjects.id = topics.subject_id', 'inner')
        // ->groupBy('topics.id, topics.topic, topics.date, topics.time, topics.batch, topics.subject_id')
        // ->where('topics.subject_id',$sub_id)
        // ->findAll();
        return $this->select('
                topics.id, 
                topics.topic, 
                topics.date, 
                topics.time, 
                topics.batch, 
                topics.subject_id, 
                subjects.semester_number AS semester,
                IF(topics.id NOT IN (SELECT topic_id FROM attendance), "-", (SELECT COUNT(*) FROM students WHERE students.semester = subjects.semester_number AND students.batch = topics.batch)) AS total_stud,
                IF(topics.id NOT IN (SELECT topic_id FROM attendance), "-", COUNT(DISTINCT CASE WHEN attendance.attendance = "Present" THEN attendance.student_id END)) AS total_present
            ')
            ->join('attendance', 'attendance.topic_id = topics.id', 'left')
            ->join('subjects', 'subjects.id = topics.subject_id', 'inner')
            ->groupBy('topics.id, topics.topic, topics.date, topics.time, topics.batch, topics.subject_id')
            ->where('topics.subject_id', $sub_id)
            ->findAll();

    }

    public function getStudentAttendanceCount() {
        return $this->select('topics.subject_id AS sub_id, 
                        topics.id, 
                        topics.date, 
                        SUM(CASE WHEN attendance.attendance = "Present" THEN 1 ELSE 0 END) AS total_present, 
                        SUM(CASE WHEN attendance.attendance = "Absent" THEN 1 ELSE 0 END) AS total_absent')
                ->join('attendance', 'attendance.topic_id = topics.id', 'left')
                ->groupBy('topics.id')
                ->orderBy('topics.date')
                ->get()
                ->getResultArray();

    }

   
    

    public function getFacultyTotalLectures(){
        return $this->select('users.id,users.full_name,programs.id AS program_id, programs.program_name,subjects.semester_number,subjects.id AS subject_id,subjects.subject_name, topics.batch, COUNT(topics.id) as total_lectures')
            ->join('subjects', 'topics.subject_id = subjects.id', 'left')
            ->join('programs', 'subjects.program_id = programs.id', 'inner')
            ->join('allocatedsubjects', 'subjects.id = allocatedsubjects.subject_id', 'left')
            ->join('users', 'allocatedsubjects.faculty_id = users.id', 'left')
            ->groupBy('users.full_name, subjects.subject_name, topics.batch')
            ->get()
            ->getResultArray();
        
    }

    public function getFacultyTotalLecturesSEDATE($start_date,$end_date){
        return $this->select('users.id, users.full_name,programs.id AS program_id, programs.program_name, subjects.semester_number,subjects.id AS subject_id, subjects.subject_name, topics.batch, COUNT(topics.id) as total_lectures')
        ->join('subjects', 'topics.subject_id = subjects.id', 'left')
        ->join('programs', 'subjects.program_id = programs.id', 'inner')
        ->join('allocatedsubjects', 'subjects.id = allocatedsubjects.subject_id', 'left')
        ->join('users', 'allocatedsubjects.faculty_id = users.id', 'left')
        ->where('topics.date >=', $start_date) // Start date condition
        ->where('topics.date <=', $end_date)   // End date condition
        ->groupBy('users.full_name, subjects.subject_name, topics.batch')
        ->get()
        ->getResultArray();
        
    }
}

?>
