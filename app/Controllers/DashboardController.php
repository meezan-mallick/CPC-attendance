<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\SubjectModel;
use App\Models\ProgramModel;
use App\Models\CollegeModel;
use App\Models\AttendanceModel;
use CodeIgniter\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        $studentModel = new StudentModel();
        $userModel = new UserModel();
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();
        $collegeModel = new CollegeModel();
        $attendanceModel = new AttendanceModel();

        $today = date('Y-m-d');

        $totalLecturesToday = $attendanceModel
            ->where('DATE(created_at)', $today) // Filter records for today's date
            ->groupBy('topic_id') // Group by topic to count unique lectures
            ->countAllResults();


        // ✅ Count total Visiting/Guest Faculty Members
        $totalVisitingFaculty = $userModel
            ->where('designation', 'VISITING FACULTY') // Filter users by designation
            ->countAllResults();


        // Fetch total counts
        $data = [
            'total_students' => $studentModel->countAll(),
            'total_coordinators' => $userModel->where('role', 'Coordinator')->countAllResults(),
            'total_faculties' => $userModel->where('role', 'Faculty')->countAllResults(),
            'totalVisitingFaculty' => $totalVisitingFaculty,
            'total_subjects' => $subjectModel->countAll(),
            'total_programs' => $programModel->countAll(),
            'total_colleges' => $collegeModel->countAll(),
            'totalLecturesToday' => $totalLecturesToday,
        ];

        return view('dashboard/index', $data);
    }
}
