<?php

namespace App\Models;
use CodeIgniter\Model;


class TopicModel extends Model{
    
    protected $table = 'topics';
    protected $allowedFields = [
        'id',
        'topic',
        'date',
        'time',
        'batch',
        'subject_id',
       
       
    ];

    public function getAllTopics($sub_id) {
        
        return $this->select('topics.id, topics.topic, topics.date, topics.time, topics.batch, topics.subject_id, 
                      (SELECT COUNT(*) FROM students WHERE students.semester_id = subjects.semester_id AND students.batch = topics.batch) AS total_stud, 
                      COUNT(DISTINCT CASE WHEN attendance.attendance = "Present" THEN attendance.student_id END) AS total_present')
        ->join('attendance', 'attendance.topic_id = topics.id', 'left')
        ->join('subjects', 'subjects.id = topics.subject_id', 'inner')
        ->join('semesters', 'semesters.id = subjects.semester_id', 'inner')
        ->groupBy('topics.id, topics.topic, topics.date, topics.time, topics.batch, topics.subject_id')
        ->where('topics.subject_id',$sub_id)
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

   

}

?>
