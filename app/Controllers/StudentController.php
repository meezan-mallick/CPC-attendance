<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ProgramModel;
use App\Models\SemesterModel;
use App\Models\BatchModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class StudentController extends Controller
{
  protected $studentModel;
  protected $programModel;
  protected $semesterModel;
  protected $batchModel;

  public function __construct()
  {
    $this->studentModel = new StudentModel();
    $this->programModel = new ProgramModel();
    $this->semesterModel = new SemesterModel();
    $this->batchModel = new BatchModel();
  }

  // Select Course and Semester View
  public function index()
  {

    if (session()->get('role') === 'Coordinator') {
      $assignedPrograms = session()->get('assigned_program_id');

      if (empty($assignedPrograms)) {
        return redirect()->back()->with('error', 'No programs assigned to you.');
      }

      $programs = $this->programModel->whereIn('id', $assignedPrograms)->findAll();
    } else {
      $programs = $this->programModel->findAll(); // Superadmin sees all programs
    }


    return view('students/select_course', ['programs' => $programs]);
  }

  // Fetch Semesters based on Selected Course (AJAX Request)
  public function getSemesters()
  {
    if ($this->request->isAJAX()) {
      $program_id = $this->request->getPost('program_id');

      // Fetch the program type (Integrated or Master)
      $programModel = new ProgramModel();
      $program = $programModel->find($program_id);

      if (!$program) {
        return $this->response->setJSON(['error' => 'Invalid program selected']);
      }

      // Determine the number of semesters based on program type
      $semesterCount = ($program['program_type'] == 'Integrated') ? 10 : 4;

      // Generate semester list dynamically
      $semesters = [];
      for ($i = 1; $i <= $semesterCount; $i++) {
        $semesters[] = ['id' => $i, 'semester_name' => "Semester $i"];
      }

      return $this->response->setJSON($semesters);
    }
  }

  //List Students based on Program, Semester, and Batch
  public function list()
  {
    $studentModel = new StudentModel();
    $programModel = new ProgramModel();

    // Fetch query parameters
    $course_id = $this->request->getGet('course');
    $semester_id = $this->request->getGet('semester');
    $batch_id = $this->request->getGet('batch') ?? 0; // Default batch to 0 if not provided

    // Validate course and semester
    if (!$course_id || !$semester_id) {
      return redirect()->to('/students')->with('error', 'Course and Semester are required.');
    }

    // Fetch program details
    $program = $programModel->find($course_id);
    if (!$program) {
      return redirect()->to('/students')->with('error', 'Invalid course selected.');
    }

    // Restrict access for coordinators
    if (session()->get('role') === 'Coordinator' && !in_array($course_id, session()->get('assigned_program_id'))) {
      return redirect()->to('/students')->with('error', 'You can only manage students of your assigned program.');
    }

    // Prepare query to fetch students
    $studentQuery = $studentModel->where('program_id', $course_id)
      ->where('semester', $semester_id);

    if (!empty($batch_id)) {
      $studentQuery->where('batch', $batch_id);
    }

    $students = $studentQuery->findAll();

    return view('students/index', [
      'students'    => $students,
      'program_id'  => $course_id,
      'semester' => $semester_id,
      'batch'    => $batch_id,
      'program_name' => $program['program_name']
    ]);
  }

  // add single student
  public function add()
  {
    $programModel = new ProgramModel();
    $data['programs'] = $programModel->findAll(); // Fetch programs for dropdown

    // Get values from query parameters (if provided)
    $data['program_id'] = $this->request->getGet('course') ?? '';
    $data['semester'] = $this->request->getGet('semester') ?? '';
    $data['batch'] = $this->request->getGet('batch') ?? '';

    return view('students/form', $data);
  }


  // Store single student
  public function store()
  {
    $studentModel = new StudentModel();

    $data = [
      'full_name' => $this->request->getPost('full_name'),
      'email' => $this->request->getPost('email'),
      'mobile_number' => $this->request->getPost('mobile_number'),
      'program_id' => $this->request->getPost('program_id'),
      'semester' => $this->request->getPost('semester'),
      'batch' => $this->request->getPost('batch') ?: 0, // Default batch to 0 if blank
    ];

    if ($studentModel->insert($data)) {
      return redirect()->to('/students?course=' . $data['program_id'] . '&semester=' . $data['semester'] . '&batch=' . $data['batch'])
        ->with('success', 'Student added successfully!');
    } else {
      return redirect()->back()->with('error', 'Failed to add student.');
    }
  }


  // Delete a single student
  public function delete($id)
  {
    $student = $this->studentModel->find($id);
    if (!$student) {
      return redirect()->back()->with('error', 'Student not found.');
    }

    $this->studentModel->delete($id);
    return redirect()->back()->with('success', 'Student deleted successfully!');
  }

  // Bulk Delete students
  public function bulkDelete()
  {
    $request = service('request');

    // Get selected student IDs from the AJAX request
    $input = $request->getJSON();
    $ids = $input->student_ids ?? [];

    if (empty($ids)) {
      return $this->response->setJSON(['success' => false, 'message' => 'No students selected for deletion.']);
    }

    $this->studentModel->whereIn('id', $ids)->delete();

    return $this->response->setJSON(['success' => true, 'message' => 'Selected students deleted successfully!']);
  }

  // Download Sample Excel Template
  public function downloadSampleExcel()
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header row
    $sheet->fromArray([
      [
        'University Enrollment No',
        'Full Name',
        'Email',
        'Mobile Number',
        'Parent Mobile Number',
        'Gender',
        'DOB',
        'Father Name',
        'Mother Name',
        'Category',
        'Blood Group',
        'Address',
        'City',
        'State',
        'Country',
        'Pin Code',
        'Placement Status',
        'Placement Company',
        'Placement Email',
        'Placement Address',
        'Designation',
        'Placement Package',
        'ABC ID No'
      ]
    ], NULL, 'A1');

    $writer = new Xlsx($spreadsheet);
    $filename = 'student_sample.xlsx';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $writer->save('php://output');
    exit;
  }

  // Import Students from Excel
  public function processImport($program_id, $semester, $batch = 0)
  {
    $file = $this->request->getFile('student_file');

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

      $studentModel = new StudentModel();
      $dataBatch = [];
      $errors = [];

      // Ensure batch is always 0 if blank
      $batch = (isset($batch) && is_numeric($batch) && $batch > 0) ? (int)$batch : 0;

      foreach ($sheetData as $index => $row) {
        if ($index == 0) continue; // Skip header row

        // Ensure row has at least 23 columns
        if (count($row) < 23) {
          return redirect()->back()->with('error', "❌ Error in row $index: Incorrect number of columns.");
        }

        $row = array_pad($row, 23, null);

        $dataBatch[] = [
          'university_enrollment_no' => trim($row[0]),
          'full_name' => trim($row[1]),
          'email' => empty(trim($row[2])) ? null : trim($row[2]),
          'mobile_number' => trim($row[3]),
          'parent_mobile_number' => trim($row[4]),
          'gender' => trim($row[5]),
          'dob' => trim($row[6]),
          'father_name' => trim($row[7]),
          'mother_name' => trim($row[8]),
          'category' => trim($row[9]),
          'blood_group' => trim($row[10]),
          'address_line1' => trim($row[11]),
          'city' => trim($row[12]),
          'state' => trim($row[13]),
          'country' => trim($row[14]),
          'pin_code' => trim($row[15]),
          'placement_status' => (strtolower(trim($row[16])) === 'true') ? 1 : 0,
          'placement_company' => trim($row[17]),
          'placement_company_email' => trim($row[18]),
          'placement_company_address' => trim($row[19]),
          'designation' => trim($row[20]),
          'placement_package' => trim($row[21]),
          'abc_id_no' => trim($row[22]),
          'program_id' => $program_id,
          'semester' => $semester,
          'batch' => $batch, // ✅ Batch is set like program_id & semester
        ];
      }

      if (empty($dataBatch)) {
        return redirect()->back()->with('error', '❌ No valid student data found in the file.');
      }

      if (!$studentModel->insertBatch($dataBatch)) {
        $errors = $studentModel->errors();
      }

      if (!empty($errors)) {
        return redirect()->back()->with('error_import', implode(', ', $errors));
      }

      return redirect()->to('/students/list?course=' . $program_id . '&semester=' . $semester)
        ->with('success', '✅ Students imported successfully!');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', '❌ Error processing file: ' . $e->getMessage());
    }
  }
}
