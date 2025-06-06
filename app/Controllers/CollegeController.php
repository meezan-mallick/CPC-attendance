<?php

namespace App\Controllers;

use App\Models\CollegeModel;
use CodeIgniter\Controller;

class CollegeController extends Controller
{
    public function index()
    {
        $collegeModel = new CollegeModel();
        $data['colleges'] = $collegeModel->findAll();
        return view('colleges/index', $data);
    }

    public function add()
    {
        return view('colleges/add');
    }

    public function store()
    {
        $collegeModel = new CollegeModel();

        $data = [
            'college_code' =>  strip_tags($this->request->getPost('college_code')),
            'college_name' =>  strip_tags($this->request->getPost('college_name')),
        ];

        if (!$collegeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $collegeModel->errors());
        }

        return redirect()->to('/colleges')->with('success', 'College added successfully');
    }

    public function edit($id)
    {
        $collegeModel = new CollegeModel();
        $data['college'] = $collegeModel->find($id);

        if (!$data['college']) {
            return redirect()->to('/colleges')->with('error', 'College not found');
        }

        return view('colleges/edit', $data);
    }

    public function update($id)
    {
        $collegeModel = new CollegeModel();

        $data = [
            'college_code' => strip_tags($this->request->getPost('college_code')),
            'college_name' => strip_tags($this->request->getPost('college_name')),
        ];

        if (!$collegeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $collegeModel->errors());
        }

        return redirect()->to('/colleges')->with('success', 'College updated successfully');
    }

    public function delete($id)
    {
        $collegeModel = new CollegeModel();

        $college = $collegeModel->find($id);
        if (!$college) {
            return redirect()->to('/colleges')->with('error', 'College not found');
        }

        $collegeModel->delete($id);

        return redirect()->to('/colleges')->with('success', 'College deleted successfully');
    }
}
