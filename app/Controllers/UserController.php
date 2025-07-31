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

        // Combined rules from model and controller, with new fields
        // Note: It's generally better to define all rules in the model for consistency.
        // If you keep them here, ensure they match the model's.
        $rules = [
            'full_name'     => 'required|max_length[255]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'mobile_number' => 'required|max_length[15]',
            'password'      => 'required|min_length[6]', // Password is required on add
            'designation'   => 'required|in_list[ASSISTANT PROFESSOR,TEACHING ASSISTANT,TECHNICAL ASSISTANT,VISITING FACULTY]',
            'role'          => 'required|in_list[Superadmin,Coordinator,Faculty]',
            'status'        => 'required|in_list[Active,Inactive]',
            // --- NEW FIELDS VALIDATION ---
            'name_as_per_bank_account' => 'permit_empty|max_length[255]',
            'pan_card_no'              => 'permit_empty|exact_length[10]|alpha_numeric', // Basic PAN validation
            'bank_name'                => 'permit_empty|max_length[255]',
            'bank_account_no'          => 'permit_empty|max_length[50]|alpha_numeric',
            'ifsc_code'                => 'permit_empty|exact_length[11]|alpha_numeric', // Basic IFSC validation
            'aadhaar_no'               => 'permit_empty|exact_length[12]|numeric', // Aadhaar is numeric
            // --- END NEW FIELDS VALIDATION ---
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation Failed: ' . print_r($validation->getErrors(), true));
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $userModel = new UserModel();

        $data = [
            'full_name'     => trim(strip_tags($this->request->getPost('full_name'))),
            'email'         => trim(strip_tags($this->request->getPost('email'))),
            'mobile_number' => trim(strip_tags($this->request->getPost('mobile_number'))),
            'password'      => trim(strip_tags($this->request->getPost('password'))), // Password will be hashed by beforeInsert
            'designation'   => trim(strip_tags($this->request->getPost('designation'))),
            'role'          => trim(strip_tags($this->request->getPost('role'))),
            'status'        => trim(strip_tags($this->request->getPost('status'))),
            'dob'           => trim(strip_tags($this->request->getPost('dob') ?: null)),
            'gender'        => trim(strip_tags($this->request->getPost('gender') ?: null)),
            'father_name'   => trim(strip_tags($this->request->getPost('father_name') ?: null)),
            'mother_name'   => trim(strip_tags($this->request->getPost('mother_name') ?: null)),
            'qualification' => trim(strip_tags($this->request->getPost('qualification') ?: null)),
            'industry_experience' => trim(strip_tags($this->request->getPost('industry_experience') ?: null)),
            'working_experience'  => trim(strip_tags($this->request->getPost('working_experience') ?: null)),
            'achievements'  => trim(strip_tags($this->request->getPost('achievements') ?: null)),
            'skillset'      => trim(strip_tags($this->request->getPost('skillset') ?: null)),
            'address'       => trim(strip_tags($this->request->getPost('address_line_1') ?: null)), // Changed from address_line_1 to address
            'state'         => trim(strip_tags($this->request->getPost('state') ?: null)),
            'city'          => trim(strip_tags($this->request->getPost('city') ?: null)),
            'country'       => trim(strip_tags($this->request->getPost('country') ?: null)),
            // --- NEW FIELDS DATA ---
            'name_as_per_bank_account' => trim(strip_tags($this->request->getPost('name_as_per_bank_account') ?: null)),
            'pan_card_no'              => trim(strip_tags($this->request->getPost('pan_card_no') ?: null)),
            'bank_name'                => trim(strip_tags($this->request->getPost('bank_name') ?: null)),
            'bank_account_no'          => trim(strip_tags($this->request->getPost('bank_account_no') ?: null)),
            'ifsc_code'                => trim(strip_tags($this->request->getPost('ifsc_code') ?: null)),
            'aadhaar_no'               => trim(strip_tags($this->request->getPost('aadhaar_no') ?: null)),
            // --- END NEW FIELDS ---
            // 'created_at'    => date('Y-m-d H:i:s'), // Model's useTimestamps handles these
            // 'updated_at'    => date('Y-m-d H:i:s'), // Model's useTimestamps handles these
        ];

        try {
            // Using $userModel->insert() will trigger the beforeInsert callback for password hashing
            if (!$userModel->insert($data)) {
                $db = \Config\Database::connect();
                $error = $db->error();

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
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Get the role of the currently logged-in user from the session
        $loggedInUserRole = session()->get('role');

        $data = [
            'user'             => $user,
            'loggedInUserRole' => $loggedInUserRole // <-- Pass this to your view
        ];

        return view('users/edit', $data); 
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $existingUser = $userModel->find($id);

        if (!$existingUser) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Define rules for update (password is optional)
        $rules = [
            'full_name'     => 'required|max_length[255]',
            'email'         => 'required|valid_email|is_unique[users.email,id,' . $id . ']', // Allows updating without triggering uniqueness error
            'mobile_number' => 'required|max_length[15]',
            'password'      => 'permit_empty|min_length[6]', // Password is optional on update
            'designation'   => 'required|in_list[ASSISTANT PROFESSOR,TEACHING ASSISTANT,TECHNICAL ASSISTANT,VISITING FACULTY]',
            'role'          => 'required|in_list[Superadmin,Coordinator,Faculty]',
            'status'        => 'required|in_list[Active,Inactive]',
            // --- NEW FIELDS VALIDATION ---
            'name_as_per_bank_account' => 'permit_empty|max_length[255]',
            'pan_card_no'              => 'permit_empty|exact_length[10]|alpha_numeric',
            'bank_name'                => 'permit_empty|max_length[255]',
            'bank_account_no'          => 'permit_empty|max_length[50]|alpha_numeric',
            'ifsc_code'                => 'permit_empty|exact_length[11]|alpha_numeric',
            'aadhaar_no'               => 'permit_empty|exact_length[12]|numeric',
            // --- END NEW FIELDS VALIDATION ---
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Prepare Data - Convert empty values to NULL using the same approach as store()
        $data = [
            'full_name'     => trim(strip_tags($this->request->getPost('full_name'))),
            'email'         => trim(strip_tags($this->request->getPost('email'))),
            'mobile_number' => trim(strip_tags($this->request->getPost('mobile_number'))),
            // Password will be handled by model's beforeUpdate callback if provided
            'password'      => trim(strip_tags($this->request->getPost('password'))),
            'designation'   => trim(strip_tags($this->request->getPost('designation'))),
            'role'          => trim(strip_tags($this->request->getPost('role'))),
            'status'        => trim(strip_tags($this->request->getPost('status'))),
            'dob'           => trim(strip_tags($this->request->getPost('dob') ?: null)),
            'gender'        => trim(strip_tags($this->request->getPost('gender') ?: null)),
            'father_name'   => trim(strip_tags($this->request->getPost('father_name') ?: null)),
            'mother_name'   => trim(strip_tags($this->request->getPost('mother_name') ?: null)),
            'qualification' => trim(strip_tags($this->request->getPost('qualification') ?: null)),
            'industry_experience' => trim(strip_tags($this->request->getPost('industry_experience') ?: null)),
            'working_experience'  => trim(strip_tags($this->request->getPost('working_experience') ?: null)),
            'achievements'  => trim(strip_tags($this->request->getPost('achievements') ?: null)),
            'skillset'      => trim(strip_tags($this->request->getPost('skillset') ?: null)),
            'address'       => trim(strip_tags($this->request->getPost('address') ?: null)), // Consistent with model and edit view
            'state'         => trim(strip_tags($this->request->getPost('state') ?: null)),
            'city'          => trim(strip_tags($this->request->getPost('city') ?: null)),
            'country'       => trim(strip_tags($this->request->getPost('country') ?: null)),
            // --- NEW FIELDS DATA ---
            'name_as_per_bank_account' => trim(strip_tags($this->request->getPost('name_as_per_bank_account') ?: null)),
            'pan_card_no'              => trim(strip_tags($this->request->getPost('pan_card_no') ?: null)),
            'bank_name'                => trim(strip_tags($this->request->getPost('bank_name') ?: null)),
            'bank_account_no'          => trim(strip_tags($this->request->getPost('bank_account_no') ?: null)),
            'ifsc_code'                => trim(strip_tags($this->request->getPost('ifsc_code') ?: null)),
            'aadhaar_no'               => trim(strip_tags($this->request->getPost('aadhaar_no') ?: null)),
            // --- END NEW FIELDS ---
        ];

        // 🔍 DEBUG: Print the sanitized data before update
        log_message('debug', 'Sanitized Data before update: ' . print_r($data, true));
        echo "<pre>Data being sent to model:\n";
        print_r($data);
        echo "</pre>";
        
        try {
            // ✅ FIX: Use $userModel->update() to trigger the beforeUpdate callback
            if (!$userModel->update($id, $data)) {
                $db = \Config\Database::connect(); // Get database instance to retrieve errors
                $error = $db->error();

                echo "<pre>Raw Database Error:\n";
                print_r($error);
                echo "</pre>";
                exit(); 

                // 🔍 DEBUG: Print and log database error
                log_message('error', '❌ Database Error during update: ' . print_r($error, true));
                return redirect()->back()->withInput()->with('error', 'Failed to update user. Database Error: ' . $error['message']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during update: ' . $e->getMessage());
            // This 'exit()' is here so you can see the database error from the 'try' block first.
            // If you reach here, it's a PHP exception, not a DB error caught by $db->error().
            echo "<pre>Exception Caught:\n";
            print_r($e->getMessage());
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
        // Fetch all users except Superadmin
        $users = $userModel->where('role !=', 'Superadmin')->findAll();

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Column Headers - All existing and NEW fields included
        $sheet->setCellValue('A1', 'Sr no')
            ->setCellValue('B1', 'Full Name')
            ->setCellValue('C1', 'Name as per Bank Account') // NEW FIELD
            ->setCellValue('D1', 'Email')
            ->setCellValue('E1', 'Mobile Number')
            ->setCellValue('F1', 'PAN Card No') // NEW FIELD
            ->setCellValue('G1', 'Aadhaar No') // NEW FIELD
            ->setCellValue('H1', 'Bank Name') // NEW FIELD
            ->setCellValue('I1', 'Bank Account No') // NEW FIELD
            ->setCellValue('J1', 'IFSC Code') // NEW FIELD
            ->setCellValue('K1', 'Role')
            ->setCellValue('L1', 'Designation')
            ->setCellValue('M1', 'Date Of Birth')
            ->setCellValue('N1', 'Gender')
            ->setCellValue('O1', 'Father Name')
            ->setCellValue('P1', 'Mother Name')
            ->setCellValue('Q1', 'Qualification')
            ->setCellValue('R1', 'Industry Experience')
            ->setCellValue('S1', 'Academic Experience') // Maps to 'working_experience'
            ->setCellValue('T1', 'Date Of Joining')
            ->setCellValue('U1', 'Achievements')
            ->setCellValue('V1', 'Skillset')
            ->setCellValue('W1', 'Address')
            ->setCellValue('X1', 'State')
            ->setCellValue('Y1', 'City')
            ->setCellValue('Z1', 'Country')
            ->setCellValue('AA1', 'Status')
            ->setCellValue('AB1', 'Created At');

        // Apply Formatting (Bold Headers)
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:AB1')->applyFromArray($headerStyle); // Adjusted range for new columns

        // Populate Data - All existing and NEW fields included
        $row = 2;
        $serialNumber = 1;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $serialNumber)
                ->setCellValue('B' . $row, $user['full_name'])
                ->setCellValue('C' . $row, $user['name_as_per_bank_account']) // NEW FIELD DATA
                ->setCellValue('D' . $row, $user['email'])
                ->setCellValue('E' . $row, $user['mobile_number'])
                ->setCellValue('F' . $row, $user['pan_card_no']) // NEW FIELD DATA
                ->setCellValue('G' . $row, $user['aadhaar_no']) // NEW FIELD DATA
                ->setCellValue('H' . $row, $user['bank_name']) // NEW FIELD DATA
                ->setCellValue('I' . $row, $user['bank_account_no']) // NEW FIELD DATA
                ->setCellValue('J' . $row, $user['ifsc_code']) // NEW FIELD DATA
                ->setCellValue('K' . $row, $user['role'])
                ->setCellValue('L' . $row, $user['designation'])
                ->setCellValue('M' . $row, $user['dob'])
                ->setCellValue('N' . $row, $user['gender'])
                ->setCellValue('O' . $row, $user['father_name'])
                ->setCellValue('P' . $row, $user['mother_name'])
                ->setCellValue('Q' . $row, $user['qualification'])
                ->setCellValue('R' . $row, $user['industry_experience'])
                ->setCellValue('S' . $row, $user['working_experience'])
                ->setCellValue('T' . $row, $user['date_of_joining'])
                ->setCellValue('U' . $row, $user['achievements'])
                ->setCellValue('V' . $row, $user['skillset'])
                ->setCellValue('W' . $row, $user['address'])
                ->setCellValue('X' . $row, $user['state'])
                ->setCellValue('Y' . $row, $user['city'])
                ->setCellValue('Z' . $row, $user['country'])
                ->setCellValue('AA' . $row, $user['status'])
                ->setCellValue('AB' . $row, $user['created_at']);
            $row++;
            $serialNumber++;
        }

        // Auto-Resize Columns
        $lastColumnNumber = 28; // 'AB' is the 28th column

        for ($i = 1; $i <= $lastColumnNumber; $i++) {
            $columnLetter = '';
            $currentColNum = $i;
            while ($currentColNum > 0) {
                $modulo = ($currentColNum - 1) % 26;
                $columnLetter = chr(65 + $modulo) . $columnLetter; // Convert number to letter
                $currentColNum = floor(($currentColNum - $modulo) / 26);
            }
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
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


     // Download Sample Excel Template - UPDATED
    public function downloadSampleExcel()
    {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
                     // Header row
            $sheet->fromArray([
            [
                'Full Name',
                'Name as per Bank Account', // NEW
                'Email',
                'Mobile Number',
                'Password',
                'PAN Card No', // NEW
                'Aadhaar No', // NEW
                'Bank Name', // NEW
                'Bank Account No', // NEW
                'IFSC Code', // NEW
                'Designation',
                'Role',
                'Date Of Birth',
                'Gender',
                'Father Name',
                'Mother Name',
                'Qualification',
                'Industry Experience',
                'Academic Experience', // This maps to 'working_experience'
                'Date Of Joining',
                'Achievements',
                'Skillset', // Corrected case from 'skillset'
                'Address', // Consistent 'address'
                'State',
                'City',
                'Country',
                'Status',
            ]
            ], NULL, 'A1');

            $writer = new Xlsx($spreadsheet);
            $highestColumn = $sheet->getHighestColumn(); 

           
            $sheet->setCellValue('K2', 'Select Designation From this ASSISTANT PROFESSOR, TEACHING ASSISTANT, TECHNICAL ASSISTANT, VISITING FACULTY'); // Adjusted column for Designation
            $sheet->setCellValue('L2', 'Select Role From this Superadmin, Coordinator, Faculty'); // Adjusted column for Role
            $sheet->setCellValue('AB2', 'Select Status From this Active, Inactive'); // Adjusted column for Status, will be AB based on new headers

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
    
            // Ensure row has at least the correct number of columns (21 + 6 new = 27)
            // It's safer to check against expected number of columns after padding
            $expectedColumnCount = 27; // Based on the sample excel template now
            if (count($row) < $expectedColumnCount) {
              // Pad the row to ensure all expected columns exist, even if empty
              $row = array_pad($row, $expectedColumnCount, null);
            }

            // Map data from Excel columns to database fields
            $data[] = [
                'full_name'                 => trim($row[0]),
                'name_as_per_bank_account'  => trim($row[1]), // NEW - Index 1
                'email'                     => trim($row[2]),
                'mobile_number'             => trim($row[3]),
                'password'                  => password_hash(trim($row[4]), PASSWORD_DEFAULT),
                'pan_card_no'               => trim($row[5]), // NEW - Index 5
                'aadhaar_no'                => trim($row[6]), // NEW - Index 6
                'bank_name'                 => trim($row[7]), // NEW - Index 7
                'bank_account_no'           => trim($row[8]), // NEW - Index 8
                'ifsc_code'                 => trim($row[9]), // NEW - Index 9
                'designation'               => trim($row[10]), // Adjusted index
                'role'                      => trim($row[11]), // Adjusted index
                'dob'                       => trim($row[12])?: null, // Adjusted index
                'gender'                    => trim($row[13])?: null, // Adjusted index
                'father_name'               => trim($row[14])?: null, // Adjusted index
                'mother_name'               => trim($row[15])?: null, // Adjusted index
                'qualification'             => trim($row[16])?: null, // Adjusted index
                'industry_experience'       => trim($row[17])?: null, // Adjusted index
                'working_experience'        => trim($row[18])?: null, // Adjusted index (Academic Experience in template)
                'date_of_joining'           => trim($row[19])?: null, // Adjusted index
                'achievements'              => trim($row[20])?: null, // Adjusted index
                'skillset'                  => trim($row[21])?: null, // Adjusted index
                'address'                   => trim($row[22])?: null, // Adjusted index (consistent 'address')
                'state'                     => trim($row[23])?: null, // Adjusted index
                'city'                      => trim($row[24])?: null, // Adjusted index
                'country'                   => trim($row[25])?: null, // Adjusted index
                'status'                    => trim($row[26])?: null, // Adjusted index
                // 'created_at'    => date('Y-m-d H:i:s'), // Model's useTimestamps handles these
                // 'updated_at'    => date('Y-m-d H:i:s'), // Model's useTimestamps handles these
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