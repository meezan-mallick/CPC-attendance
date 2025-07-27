<?php

namespace App\Models;

use CodeIgniter\Model;


class AttendanceModel extends Model
{

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

    public function getStudentAttendanceLecture($program_id, $semester_number, $subject_id, $topic_id, $batch)
    {
        return $this->select('attendance.id AS attendance_id,students.id AS id,students.batch, students.full_name,students.university_enrollment_no,attendance.attendance')
            ->join('students', 'students.id = attendance.student_id  AND attendance.topic_id=' . (int)$topic_id . '', 'right')
            ->join('programs', 'students.program_id = programs.id', 'inner')
            ->where('students.batch', $batch)
            ->where('students.semester', $semester_number)
            ->where('students.program_id', $program_id)
            ->findAll();
    }

    public function getStudentPresentPerc($studentId, $subjectId, $batch = null)
    {
        $builder = $this->db->table('attendance');
        $builder->select('attendance.attendance');
        $builder->join('topics', 'topics.id = attendance.topic_id');
        $builder->where('attendance.student_id', $studentId);
        $builder->where('topics.subject_id', $subjectId);

        // Add batch condition if provided and not "all"
        if ($batch !== null && $batch !== "all") {
            $builder->where('topics.batch', $batch);
        }

        $result = $builder->get()->getResultArray(); // This will be an array of rows if results exist, otherwise empty array

        $presentCount = 0;
        $totalRecordedAttendances = 0; // This is the count of individual attendance records found for the student in this subject

        foreach ($result as $row) {
            $totalRecordedAttendances++;
            if ($row['attendance'] == 'Present') {
                $presentCount++;
            }
        }

        // Now, get the total classes conducted for the *subject* and *batch* (if applicable)
        $topicModel = new \App\Models\TopicModel(); // Ensure correct namespace for TopicModel

        $topicBuilder = $topicModel->builder();
        $topicBuilder->where('subject_id', $subjectId);
        if ($batch !== null && $batch !== "all") {
            $topicBuilder->where('batch', $batch);
        }
        $totalSubjectClasses = $topicBuilder->countAllResults(); // This counts topics based on criteria

        // Calculate percentage for this specific subject (optional, but good to return)
        $percentage = ($totalSubjectClasses > 0) ? ($presentCount / $totalSubjectClasses) * 100 : 0;

        return [
            'present_count' => $presentCount,
            'total_count' => $totalRecordedAttendances, // This is count of attendance records for the student
            'total_subject_classes' => $totalSubjectClasses, // This is the total number of classes taught for this subject/batch
            'present_percentage' => number_format($percentage, 2)
        ];
    }
}
