<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        if (!$data['user']) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        return view('users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $existingUser = $userModel->find($id);

        if (!$existingUser) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Prepare Data - Convert empty values to NULL
        $fields = [
            'full_name',
            'email',
            'mobile_number',
            'designation',
            'role',
            'status',
            'dob',
            'gender',
            'father_name',
            'mother_name',
            'qualification',
            'industry_experience',
            'working_experience',
            'achievements',
            'skillset',
            'address',
            'state',
            'city',
            'country'
        ];

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim($this->request->getPost($field)) !== '' ? $this->request->getPost($field) : null;
        }

        // Handle Password Update (Only if provided)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // 🔍 DEBUG: Print the sanitized data before update
        log_message('debug', 'Sanitized Data before update: ' . print_r($data, true));

        // Attempt to Update User
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $query = $builder->where('id', $id)->update($data);

        if (!$query) {
            $error = $db->error();

            // 🔍 DEBUG: Print and log database error
            log_message('error', '❌ Database Error: ' . print_r($error, true));
            echo "<pre>Database Error: ";
            print_r($error);
            echo "</pre>";
            exit();
        }

        // ✅ Check if the current logged-in user is a Faculty or Coordinator
        $userRole = session()->get('role'); // Get logged-in user's role
        if ($userRole == 'Faculty' || $userRole == 'Coordinator') {
            return redirect()->to('/faculty-subjects')->with('message', '✅ Profile updated successfully!');
        }

        // ✅ Default Redirect for Other Users
        return redirect()->to('/users')->with('message', '✅ User updated successfully!');
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

    // Export all user data in excel sheet
    public function exportUsers()
    {
        $userModel = new UserModel();
        // Fetch all users except Admin
        $users = $userModel->where('role !=', 'Superadmin')->findAll();

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Column Headers
        $sheet->setCellValue('A1', 'Sr no')
            ->setCellValue('B1', 'Full Name')
            ->setCellValue('C1', 'Email')
            ->setCellValue('D1', 'Mobile Number')
            ->setCellValue('E1', 'Role')
            ->setCellValue('F1', 'Designation')
            ->setCellValue('G1', 'Date Of Birth')
            ->setCellValue('H1', 'Gender')
            ->setCellValue('I1', 'Father Name')
            ->setCellValue('J1', 'Mother Name')
            ->setCellValue('K1', 'Qualification')
            ->setCellValue('L1', 'Industry Experience')
            ->setCellValue('M1', 'Academic Experience')
            ->setCellValue('N1', 'Date Of Joining')
            ->setCellValue('O1', 'Achievements')
            ->setCellValue('P1', 'skillset')
            ->setCellValue('Q1', 'Address')
            ->setCellValue('R1', 'state')
            ->setCellValue('S1', 'city')
            ->setCellValue('T1', 'country')
            ->setCellValue('U1', 'Status')
            ->setCellValue('V1', 'created_at');

        // Apply Formatting (Bold Headers)
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:V1')->applyFromArray($headerStyle);

        // Populate Data
        $row = 2;
        $serialNumber = 1;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $serialNumber)
                ->setCellValue('B' . $row, $user['full_name'])
                ->setCellValue('C' . $row, $user['email'])
                ->setCellValue('D' . $row, $user['mobile_number'])
                ->setCellValue('E' . $row, $user['role'])
                ->setCellValue('F' . $row, $user['designation'])
                ->setCellValue('G' . $row, $user['dob'])
                ->setCellValue('H' . $row, $user['gender'])
                ->setCellValue('I' . $row, $user['father_name'])
                ->setCellValue('J' . $row, $user['mother_name'])
                ->setCellValue('K' . $row, $user['qualification'])
                ->setCellValue('L' . $row, $user['industry_experience'])
                ->setCellValue('M' . $row, $user['working_experience'])
                ->setCellValue('N' . $row, $user['date_of_joining'])
                ->setCellValue('O' . $row, $user['achievements'])
                ->setCellValue('P' . $row, $user['skillset'])
                ->setCellValue('Q' . $row, $user['address'])
                ->setCellValue('R' . $row, $user['state'])
                ->setCellValue('S' . $row, $user['city'])
                ->setCellValue('T' . $row, $user['country'])
                ->setCellValue('U' . $row, $user['status'])
                ->setCellValue('V' . $row, $user['created_at']);
            $row++;
            $serialNumber++;
        }

        // Auto-Resize Columns
        foreach (range('A', 'V') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set File Name
        $fileName = 'Users_Master_Data_' . date('YmdHis') . '.xlsx';

        // Output to Browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
