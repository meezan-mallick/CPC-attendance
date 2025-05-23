<?php

namespace App\Controllers;

use App\Models\FacultyModel;
use App\Models\ProgramModel;
use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\SemesterModel;
use App\Models\CoordinatorModel;
use App\Models\TopicModel;
use App\Models\SubjectallocationModel;
use App\Models\TimeslotModel;
use App\Models\AttendanceModel;
use App\Models\CollegeModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceController extends BaseController
{


    public function allsubjects()
    {
        $id = session()->get('user_id');

        $subjectallocationModel = new SubjectallocationModel();

        $data['subjects'] = $subjectallocationModel->getOneFacAllocatedSubjectDetails($id);

        return view('attendance/subjectlist', $data);
    }

    public function alltopics($program_id, $semester_number, $subject_id)
    {
        $id = session()->get('user_id');

        $timeslotmodel = new TimeslotModel();
        $data['timeslot'] = $timeslotmodel->findAll();
        $studentmodel = new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $program_id)->where('semester', $semester_number)->findAll();

        $data['subject_id'] = $subject_id;
        $data['program_id'] = $program_id;
        $data['semester_number'] = $semester_number;
        $topicmodel = new TopicModel();
        $data['topics'] = $topicmodel->getAllTopics($subject_id);

        // $data['topics']=$topicmodel->findAll();

        return view('attendance/topics', $data);
    }

    public function exportTopics($program_id, $semester_number, $subject_id)
    {
        $topicModel = new TopicModel();
        $subjectModel = new SubjectModel();
        $studentModel = new StudentModel();

        // Fetch subject details
        $subject = $subjectModel->select('subjects.subject_name, subjects.subject_code, programs.program_name, users.full_name AS coordinator_name, subjects.semester_number')
            ->join('programs', 'programs.id = subjects.program_id')
            ->join('coordinator_programs', 'coordinator_programs.program_id = programs.id', 'left')
            ->join('users', 'users.id = coordinator_programs.user_id', 'left')
            ->where('subjects.id', $subject_id)
            ->first();

        // Fetch topics with batch-wise total students
        $topics = $topicModel->select('topics.*, 
                    (SELECT COUNT(*) FROM attendance WHERE attendance.topic_id = topics.id AND attendance.attendance = "Present") AS total_present,
                    (SELECT COUNT(*) FROM students WHERE students.program_id = ' . $program_id . ' 
                     AND students.semester = ' . $semester_number . ' 
                     AND students.batch = topics.batch) AS total_students')
            ->where('topics.subject_id', $subject_id)
            ->findAll();

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Header Titles
        $sheet->setCellValue('A1', 'Centre for Professional Courses');
        $sheet->setCellValue('A2', 'Program: ' . ($subject['program_name'] ?? 'N/A'));
        $sheet->setCellValue('A3', 'Subject: ' . ($subject['subject_name'] ?? 'N/A'));
        $sheet->setCellValue('A4', 'Coordinator: ' . ($subject['coordinator_name'] ?? 'N/A'));
        $sheet->setCellValue('A5', 'Subject Name & Code: ' . ($subject['subject_name'] ?? 'N/A') . ' (' . ($subject['subject_code'] ?? 'N/A') . ')');
        $sheet->setCellValue('A6', 'Semester: ' . ($semester_number ?? 'N/A'));

        // Merge Header Cells for Formatting
        for ($i = 1; $i <= 6; $i++) {
            $sheet->mergeCells("A$i:G$i");
            $sheet->getStyle("A$i")->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle("A$i")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Set Column Headers (Start from Row 8)
        $sheet->setCellValue('A8', 'S.No')
            ->setCellValue('B8', 'Topic Name')
            ->setCellValue('C8', 'Date')
            ->setCellValue('D8', 'Time')
            ->setCellValue('E8', 'Batch')
            ->setCellValue('F8', 'Present Students')
            ->setCellValue('G8', 'Total Students in Batch'); // New column for total students in batch

        // Apply Formatting (Bold Headers)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A8:G8')->applyFromArray($headerStyle);

        // Populate Data with Serial Numbers (Start from Row 9)
        $row = 9;
        $serialNumber = 1;
        foreach ($topics as $topic) {
            $sheet->setCellValue('A' . $row, $serialNumber)
                ->setCellValue('B' . $row, $topic['topic'])
                ->setCellValue('C' . $row, $topic['date'])
                ->setCellValue('D' . $row, $topic['time'])
                ->setCellValue('E' . $row, $topic['batch'])
                ->setCellValue('F' . $row, $topic['total_present'] ?? 0) // Default to 0 if null
                ->setCellValue('G' . $row, $topic['total_students'] ?? 0); // Default to 0 if null

            // Apply Styling to Each Row
            $rowStyle = [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
            ];
            $sheet->getStyle("A$row:G$row")->applyFromArray($rowStyle);

            $row++;
            $serialNumber++;
        }

        // Auto-Resize Columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set File Name
        $fileName = 'Topics_List_' . date('YmdHis') . '.xlsx';

        // Output to Browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function edit_topic($program_id, $semester_number, $subject_id, $topic_id)
    {
        $id = session()->get('user_id');

        $timeslotmodel = new TimeslotModel();
        $data['timeslot'] = $timeslotmodel->findAll();
        $studentmodel = new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $program_id)->where('semester', $semester_number)->findAll();

        $data['subject_id'] = $subject_id;
        $data['program_id'] = $program_id;
        $data['semester_number'] = $semester_number;
        $topicmodel = new TopicModel();
        $data['topic'] = $topicmodel->find($topic_id);
        return view('attendance/edittopic', $data);
    }

    public function delete_topic($program_id, $semester_number, $subject_id, $topic_id)
    {

        $topicmodel = new TopicModel();
        $data['topics'] = $topicmodel->delete($topic_id);
        return redirect()->to(base_url('/topics-list/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/'));
    }

    // ---------------------------------------------



    public function update_topicstore($program_id, $semester_number, $subject_id, $topic_id)
    {
        $id = session()->get('user_id');

        $timeslotmodel = new TimeslotModel();
        $data['timeslot'] = $timeslotmodel->findAll();
        $studentmodel = new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $program_id)->where('semester', $semester_number)->findAll();

        $data['subject_id'] = $subject_id;
        $data['program_id'] = $program_id;
        $data['semester_number'] = $semester_number;


        $topicmodel = new TopicModel();
        $data['topics'] = $topicmodel->findAll();

        $ct=$this->request->getVar('custom_time');
     
        $time="";
        if($ct=="true")
        {
            $start_time=$this->request->getVar('start_time');
            $end_time=$this->request->getVar('end_time');
            
            $start_time=strlen($start_time)==5?$start_time.":00":$start_time;
            $end_time=strlen($end_time)==5?$end_time.":00":$end_time;
             $time=$start_time." - ".$end_time;

            
            
        }
        else{
            $time=$this->request->getVar('time');
           
        }


        $batch = $this->request->getVar('batch');
        $old_batch = $this->request->getVar('old_batch');


        if ($batch != $old_batch) {

            $attendancemodel = new AttendanceModel();
            $attendancemodel->where('topic_id', $topic_id)->delete();
        }

        $tdata = [
            'topic' => $this->request->getVar('topic'),
            'date' => $this->request->getVar('date'),
            'time' => $time,
            'batch' => $batch,
        ];

        if (!$topicmodel->update($topic_id, $tdata)) {
            $errors = $topicmodel->errors();
        }

        if (!empty($errors)) {
            return redirect()->back()->with('error_import', implode(', ', $errors));
        }
        return redirect()->to(base_url('/topics-list/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/'));
    }


    public function topic_store($program_id, $semester_number, $subject_id)
    {
        $id = session()->get('user_id');

        $timeslotmodel = new TimeslotModel();
        $data['timeslot'] = $timeslotmodel->findAll();
        $studentmodel = new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $program_id)->where('semester', $semester_number)->findAll();

        $data['subject_id'] = $subject_id;
        $data['program_id'] = $program_id;
        $data['semester_number'] = $semester_number;


        $topicmodel = new TopicModel();
        $data['topics'] = $topicmodel->findAll();

       $ct=$this->request->getVar('custom_time');
     
        $time="";
        if($ct=="true")
        {
            $start_time=$this->request->getVar('start_time');
            $end_time=$this->request->getVar('end_time');

            $start_time=strlen($start_time)==5?$start_time.":00":$start_time;
            $end_time=strlen($end_time)==5?$end_time.":00":$end_time;
           $time=$start_time." - ".$end_time;
        }
        else{
            $time=$this->request->getVar('time');
           
        }

        $batch = $this->request->getVar('batch');


        if ($batch == "all") {
            foreach ($batches as $key) {
                $tdata = [
                    'topic' => $this->request->getVar('topic'),
                    'date' => $this->request->getVar('date'),
                    'time' => $time,
                    'subject_id' => $subject_id,
                    'batch' => $key['batch'],
                ];
            }
        } else {
            $tdata = [
                'topic' => $this->request->getVar('topic'),
                'date' => $this->request->getVar('date'),
                'time' =>$time,
                'subject_id' => $subject_id,
                'batch' => $batch,
            ];
        }

        if (!$topicmodel->insert($tdata)) {
            $errors = $topicmodel->errors();
        }

        if (!empty($errors)) {
            return redirect()->back()->with('error_import', implode(', ', $errors));
        }
        return redirect()->to(base_url('/topics-list/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/'));
    }



    public function allstudents($program_id, $semester_number, $subject_id, $topic_id, $batch)
    {
        $studentModel = new StudentModel();
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();
        $topicModel = new TopicModel();
        $attendanceModel = new AttendanceModel();

        // ✅ Fetch topic details (for date & time slot)
        $topic = $topicModel->find($topic_id);

        // ✅ Fetch subject details
        $subject = $subjectModel->find($subject_id);

        // ✅ Fetch program details
        $program = $programModel->find($program_id);

        // ✅ Fetch students with their attendance records
        $students = $attendanceModel->getStudentAttendanceLecture($program_id, $semester_number, $subject_id, $topic_id, $batch);

        // ✅ Debugging: Print students to check if data exists
        if (empty($students)) {
            $students = []; // Set empty array if no students found
            log_message('error', "No students found for Program: $program_id, Semester: $semester_number, Subject: $subject_id, Topic: $topic_id, Batch: $batch");
        } else {
            log_message('info', "Students fetched successfully for Program: $program_id, Semester: $semester_number, Subject: $subject_id, Topic: $topic_id, Batch: $batch");
        }

        // ✅ Pass all required data to the view
        return view('attendance/students', [
            'program_id' => $program_id,
            'program' => $program,
            'subject_id' => $subject_id,
            'subject' => $subject,
            'semester_number' => $semester_number,
            'topic' => $topic,
            'batch' => $batch,
            'students' => $students // ✅ Pass students correctly
        ]);
    }








    public function attendance_store($program_id, $semester_number, $subject_id, $topic_id, $batch)
    {
        $attendanceModel = new AttendanceModel();
        $studentIds = $this->request->getPost('student_ids');
        $attendanceData = $this->request->getPost('attendance');
        $attendanceIds = $this->request->getPost('attendance_ids');

        foreach ($studentIds as $studentId) {
            $existingRecord = $attendanceModel->where('topic_id', $topic_id)->where('student_id', $studentId)->first();
            $attendanceStatus = isset($attendanceData[$studentId]) ? $attendanceData[$studentId] : 'Absent';

            $records = [
                'topic_id' => $topic_id,
                'program_id' => $program_id,
                'semester_number' => $semester_number,
                'subject_id' => $subject_id,
                'batch' => $batch,
                'student_id' => $studentId,
                'attendance' => $attendanceStatus,
            ];

            if ($existingRecord) {
                $attendanceModel->update($existingRecord['id'], $records);
            } else {
                $attendanceModel->insert($records);
            }
        }

        return redirect()->to(base_url('/topics-list/' . $program_id . '/' . $semester_number . '/' . $subject_id . '/'));
    }
}
