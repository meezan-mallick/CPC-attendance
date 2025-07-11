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
            'full_name'     => strip_tags($this->request->getPost('full_name')),
            'email'         => strip_tags($this->request->getPost('email')),
            'mobile_number' => strip_tags($this->request->getPost('mobile_number')),
            'password'      => password_hash(strip_tags($this->request->getPost('password')), PASSWORD_DEFAULT),
            'designation'   => strip_tags($this->request->getPost('designation')),
            'role'          => strip_tags($this->request->getPost('role')),
            'status'        => strip_tags($this->request->getPost('status')),
            'dob'           => strip_tags($this->request->getPost('dob') ?: null),
            'gender'        => strip_tags($this->request->getPost('gender') ?: null),
            'father_name'   => strip_tags($this->request->getPost('father_name') ?: null),
            'mother_name'   => strip_tags($this->request->getPost('mother_name') ?: null),
            'qualification' => strip_tags($this->request->getPost('qualification') ?: null),
            'industry_experience' => strip_tags($this->request->getPost('industry_experience') ?: null),
            'working_experience'  => strip_tags($this->request->getPost('working_experience') ?: null),
            'achievements'  => strip_tags($this->request->getPost('achievements') ?: null),
            'skillset'      => strip_tags($this->request->getPost('skillset') ?: null),
            'address_line_1' => strip_tags($this->request->getPost('address_line_1') ?: null),
            'state'         => strip_tags($this->request->getPost('state') ?: null),
            'city'          => strip_tags($this->request->getPost('city') ?: null),
            'country'       => strip_tags($this->request->getPost('country') ?: null),
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
            $data[$field] = trim(strip_tags($this->request->getPost($field))) !== '' ? strip_tags($this->request->getPost($field)) : null;
        }

        // Handle Password Update (Only if provided)
        $password = strip_tags($this->request->getPost('password'));
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

    public function import() {
        return view('users/import');   
    }


     // Download Sample Excel Template
    public function downloadSampleExcel()
    {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            	     // Header row
            $sheet->fromArray([
            [
                'Full Name',
                'Email',
                'Mobile Number',
                'Password',
                'Designation',
                'Role',
                'Date Of Birth',
                'Gender',
                'Father Name',
                'Mother Name',
                'Qualification',
                'Industry Experience',
                'Academic Experience',
                'Date Of Joining',
                'Achievements',
                'skillset',
                'Address',
                'state',
                'city',
                'country',
                'Status',
              
            ]
            ], NULL, 'A1');

            $writer = new Xlsx($spreadsheet);
            $highestColumn = $sheet->getHighestColumn(); 

           
            $sheet->setCellValue('E2', 'Select Designation From this ASSISTANT PROFESSOR, TEACHING ASSISTANT, TECHNICAL ASSISTANT, VISITING FACULTY'); // Add data in E2
            $sheet->setCellValue('F2', 'Select Role From this Superadmin, Coordinator, Faculty'); // Add data in E2
            $sheet->setCellValue('U2', 'Select Status From this Active, Inactive'); // Add data in E2

            // Convert column letter to number
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // Loop through all columns and set auto size
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
            }
            $filename = 'users_sample.xlsx';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $writer->save('php://output');
            exit;
    }

    public function importUsers(){
        $file = $this->request->getFile('user_file');

        if (!$file || !$file->isValid()) {
          return redirect()->back()->with('error', '❌ Invalid file uploaded. Please try again.');
        }
    
        // Check file type
        $fileType = $file->getClientMimeType();
        if ($fileType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
          return redirect()->back()->with('error', '❌ Please upload a valid Excel (.xlsx) file.');
        }
    
        try {
          $filePath = $file->getTempName();
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
          $spreadsheet = $reader->load($filePath);
          $sheetData = $spreadsheet->getActiveSheet()->toArray();
    
          if (empty($sheetData) || count($sheetData) < 2) {
            return redirect()->back()->with('error', '❌ The uploaded file is empty or missing data.');
          }
    
          $userModel = new UserModel();
          $errors = [];
    
         
          foreach ($sheetData as $index => $row) {
            if ($index == 0) continue; // Skip header row
    
            // Ensure row has at least 23 columns
            if (count($row) < 2) {
              return redirect()->back()->with('error', "❌ Error in row $index: Incorrect number of columns.");
            }
    
            $row = array_pad($row, 23, null);
    
            $data[] = [
                'full_name'=> trim($row[0]),
                'email'=> trim($row[1]),
                'mobile_number'=> trim($row[2]),
                'password'=> password_hash(trim($row[3]), PASSWORD_DEFAULT),
                'designation'=> trim($row[4]),
                'role'=> trim($row[5]),
                'dob'=>trim($row[6])?: null,
                'gender'=>trim($row[7])?: null,
                'father_name'=>trim($row[8])?: null,
                'mother_name'=>trim($row[9])?: null,
                'qualification'=>trim($row[10])?: null,
                'industry_experience'=>trim($row[11])?: null,
                'working_experience'=>trim($row[12])?: null,
                'date_of_joining'=>trim($row[13])?: null,
                'achievements'=>trim($row[14])?: null,
                'skillset'=>trim($row[15])?: null,
                'address'=>trim($row[16])?: null,
                'state'=>trim($row[17])?: null,
                'city'=>trim($row[18])?: null,
                'country'=>trim($row[19])?: null,
                'status'=>trim($row[20])?: null,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'), 
            ];
          }
    
          if (empty($data)) {
            return redirect()->back()->with('error', '❌ No valid user data found in the file.');
          }
    
          if (!$userModel->insertBatch($data)) {
            $errors = $userModel->errors();
          }
    
          if (!empty($errors)) {
            return redirect()->back()->with('error_import', implode(', ', $errors));
          }
    
          return redirect()->to('/users')
            ->with('success', '✅ Users imported successfully!');
        } catch (\Exception $e) {
          return redirect()->back()->with('error', '❌ Error processing file: ' . $e->getMessage());
        }
    }       
}