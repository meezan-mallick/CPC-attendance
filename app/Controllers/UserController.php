<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('users/index', $data);
    }

    public function add()
    {
        return view('users/add');
    }

    public function store()
    {
        log_message('debug', 'Submitted Data: ' . print_r($this->request->getPost(), true));

        $validation = \Config\Services::validation();

        $rules = [
            'full_name'     => 'required|max_length[255]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'mobile_number' => 'required|max_length[15]',
            'password'      => 'required|min_length[6]',
            'designation'   => 'required|in_list[ASSISTANT PROFESSOR,TEACHING ASSISTANT,TECHNICAL ASSISTANT,VISITING FACULTY]',
            'role'          => 'required|in_list[Superadmin,Coordinator,Faculty]',
            'status'        => 'required|in_list[Active,Inactive]',
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation Failed: ' . print_r($validation->getErrors(), true));
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $userModel = new UserModel();

        $data = [
            'full_name'     => $this->request->getPost('full_name'),
            'email'         => $this->request->getPost('email'),
            'mobile_number' => $this->request->getPost('mobile_number'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'designation'   => $this->request->getPost('designation'),
            'role'          => $this->request->getPost('role'),
            'status'        => $this->request->getPost('status'),
            'dob'           => $this->request->getPost('dob') ?: null,
            'gender'        => $this->request->getPost('gender') ?: null,
            'father_name'   => $this->request->getPost('father_name') ?: null,
            'mother_name'   => $this->request->getPost('mother_name') ?: null,
            'qualification' => $this->request->getPost('qualification') ?: null,
            'industry_experience' => $this->request->getPost('industry_experience') ?: null,
            'working_experience'  => $this->request->getPost('working_experience') ?: null,
            'achievements'  => $this->request->getPost('achievements') ?: null,
            'skillset'      => $this->request->getPost('skillset') ?: null,
            'address_line_1' => $this->request->getPost('address_line_1') ?: null,
            'state'         => $this->request->getPost('state') ?: null,
            'city'          => $this->request->getPost('city') ?: null,
            'country'       => $this->request->getPost('country') ?: null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        try {
            if (!$userModel->insert($data)) {
                $db = \Config\Database::connect();
                $error = $db->error();

                // Log MySQL error
                log_message('error', 'Database Error Code: ' . $error['code']);
                log_message('error', 'Database Error Message: ' . $error['message']);

                echo "<pre>";
                print_r($error);
                echo "</pre>";
                exit();
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            echo "</pre>";
            exit();
        }

        return redirect()->to('/users')->with('success', 'User added successfully.');
    }





    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $data = [
            'full_name'     => $this->request->getPost('full_name'),
            'email'         => $this->request->getPost('email'),
            'mobile_number' => $this->request->getPost('mobile_number'),
            'designation'   => $this->request->getPost('designation'),
            'role'          => $this->request->getPost('role'),
            'status'        => $this->request->getPost('status'),
        ];

        $userModel->update($id, $data);
        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/users')->with('success', 'User deleted successfully.');
    }

    public function assignCoordinator($id)
    {
        $userModel = new UserModel();
        $userModel->update($id, ['role' => 'Coordinator']);
        return redirect()->to('/users')->with('success', 'User assigned as Coordinator.');
    }
}
