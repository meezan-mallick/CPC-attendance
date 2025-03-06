<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\ProgramModel;
use CodeIgniter\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();

        // Get filter values from GET request
        $selectedProgram = $this->request->getGet('program_id');
        $selectedSemester = $this->request->getGet('semester_number');

        // Fetch all programs for filter dropdown
        $data['programs'] = $programModel->findAll();

        // Build query with filters
        $query = $subjectModel->select('subjects.*, programs.program_name')
            ->join('programs', 'programs.id = subjects.program_id');

        if (!empty($selectedProgram)) {
            $query->where('subjects.program_id', $selectedProgram);
        }
        if (!empty($selectedSemester)) {
            $query->where('subjects.semester_number', $selectedSemester);
        }

        $data['subjects'] = $query->findAll();
        $data['selectedProgram'] = $selectedProgram;
        $data['selectedSemester'] = $selectedSemester;

        return view('subjects/index', $data);
    }


    public function add()
    {
        $programModel = new ProgramModel();
        $data['programs'] = $programModel->findAll();
        return view('subjects/add', $data);
    }

    public function store()
    {
        $subjectModel = new SubjectModel();

        $data = [
            'program_id'      => $this->request->getPost('program_id'),
            'semester_number' => $this->request->getPost('semester_number'),
            'subject_code'    => $this->request->getPost('subject_code'),
            'subject_name'    => $this->request->getPost('subject_name'),
            'credit'          => $this->request->getPost('credit'),
            'type'            => $this->request->getPost('type'),
            'internal_marks'  => $this->request->getPost('internal_marks'),
            'external_marks'  => $this->request->getPost('external_marks'),
        ];

        if (!$subjectModel->insert($data)) {
            print_r($subjectModel->errors());
            exit(); // Stop execution to check errors
        }

        return redirect()->to('/subjects')->with('success', 'Subject added successfully.');
    }



    public function edit($id)
    {
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();

        $data['subject'] = $subjectModel->find($id);
        $data['programs'] = $programModel->findAll();

        if (!$data['subject']) {
            return redirect()->to('/subjects')->with('error', 'Subject not found');
        }

        return view('subjects/edit', $data);
    }

    public function update($id)
    {
        $subjectModel = new SubjectModel();

        // 🔹 Fetch the existing subject
        $existingSubject = $subjectModel->find($id);
        if (!$existingSubject) {
            return redirect()->to('/subjects')->with('error', 'Subject not found.');
        }

        $data = [
            'program_id'      => $this->request->getPost('program_id'),
            'semester_number' => $this->request->getPost('semester_number'),
            'subject_code'    => $this->request->getPost('subject_code'),
            'subject_name'    => $this->request->getPost('subject_name'),
            'credit'          => $this->request->getPost('credit'),
            'type'            => $this->request->getPost('type'),
            'internal_marks'  => $this->request->getPost('internal_marks'),
            'external_marks'  => $this->request->getPost('external_marks'),
        ];

        // 🔹 Define custom validation rules
        $validationRules = [
            'subject_code' => "required|max_length[50]|is_unique[subjects.subject_code,id,{$id}]",
        ];

        // 🔹 Validate the data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 🔹 If validation passes, update the record
        if (!$subjectModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $subjectModel->errors());
        }

        return redirect()->to('/subjects')->with('success', 'Subject updated successfully.');
    }


    public function delete($id)
    {
        $subjectModel = new SubjectModel();

        if (!$subjectModel->delete($id)) {
            return redirect()->to('/subjects')->with('error', 'Subject not found');
        }

        return redirect()->to('/subjects')->with('success', 'Subject deleted successfully.');
    }

    // Subject Allocation
    public function assign()
    {
        $subjectModel = new SubjectModel();
        $userModel = new UserModel();

        $data['subjects'] = $subjectModel->findAll();
        $data['faculties'] = $userModel->where('role', 'Faculty')->findAll();

        return view('subjects/assign', $data);
    }

    public function storeAssignment()
    {
        $subjectModel = new SubjectModel();

        $data = [
            'subject_id'  => $this->request->getPost('subject_id'),
            'faculty_id'  => $this->request->getPost('faculty_id'),
        ];

        $subjectModel->insert($data);
        return redirect()->to('/subjects/assign')->with('success', 'Subject assigned successfully.');
    }
}
