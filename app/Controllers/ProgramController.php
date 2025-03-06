<?php

namespace App\Controllers;

use App\Models\ProgramModel;
use App\Models\CollegeModel;
use CodeIgniter\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        $programModel = new ProgramModel();
        $data['programs'] = $programModel->findAll();
        return view('programs/index', $data);
    }

    public function add()
    {
        $collegeModel = new CollegeModel();
        $data['colleges'] = $collegeModel->findAll(); // Fetch all colleges for dropdown
        return view('programs/add', $data);
    }

    public function store()
    {
        $programModel = new ProgramModel();



        $data = [
            'college_code'      => $this->request->getPost('college_code'),
            'program_name'      => $this->request->getPost('program_name'),
            'program_duration'  => $this->request->getPost('program_duration'),
            'program_type'      => $this->request->getPost('program_type'),
            'total_semesters'   => $this->request->getPost('total_semesters'),
        ];

        if (!$programModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $programModel->errors());
        }

        return redirect()->to('/programs')->with('success', 'Program added successfully');
    }


    public function edit($id)
    {
        $programModel = new ProgramModel();
        $collegeModel = new CollegeModel();

        $data['program'] = $programModel->find($id);
        $data['colleges'] = $collegeModel->findAll();

        if (!$data['program']) {
            return redirect()->to('/programs')->with('error', 'Program not found');
        }

        return view('programs/edit', $data);
    }

    public function update($id)
    {
        $programModel = new ProgramModel();

        $data = [
            'college_code'      => $this->request->getPost('college_code'),
            'program_name'      => $this->request->getPost('program_name'),
            'program_duration'  => $this->request->getPost('program_duration'),
            'program_type'      => $this->request->getPost('program_type'),
        ];

        if (!$programModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $programModel->errors());
        }

        return redirect()->to('/programs')->with('success', 'Program updated successfully');
    }

    public function delete($id)
    {
        $programModel = new ProgramModel();

        if (!$programModel->delete($id)) {
            return redirect()->to('/programs')->with('error', 'Program not found');
        }

        return redirect()->to('/programs')->with('success', 'Program deleted successfully');
    }
}
