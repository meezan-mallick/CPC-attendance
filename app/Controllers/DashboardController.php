<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\SubjectModel;
use App\Models\ProgramModel;
use App\Models\CollegeModel;
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

        // Fetch total counts
        $data = [
            'total_students' => $studentModel->countAll(),
            'total_coordinators' => $userModel->where('role', 'Coordinator')->countAllResults(),
            'total_faculties' => $userModel->where('role', 'Faculty')->countAllResults(),
            'total_subjects' => $subjectModel->countAll(),
            'total_programs' => $programModel->countAll(),
            'total_colleges' => $collegeModel->countAll(),
        ];

        return view('dashboard/index', $data);
    }
}
