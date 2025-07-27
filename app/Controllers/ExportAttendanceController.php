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
use App\Models\UserModel;
use App\Models\CoordinatorProgramModel;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportAttendanceController extends BaseController
{
    public function get_allsubjects()
    {
        $id = session()->get('user_id');
        $role=session()->get('role');
      
        if($role=="Coordinator")
        {
            $collegeModel = new CollegeModel();
            $data['college'] = $collegeModel-> getAssignedColleges($id);
            $programmodel = new ProgramModel();
            $data['program'] = $programmodel->getAssignedProgramsandSubs($id); // Get array of assigned program IDs
            
            $subjectModel = new SubjectModel();
            $data['subject'] = $subjectModel->getCoordinatorSubjects($id);
            $studentModel = new StudentModel();
            $data['batch'] = $studentModel->select('program_id,semester,batch')->distinct()->findAll();
       

        }
        else if($role=="Faculty")
        {
            $collegeModel = new CollegeModel();
            $data['college'] = $collegeModel->getFacultyAssignedColleges($id);
            $programmodel = new ProgramModel();
            $data['program'] = $programmodel->getFacultyAssignedProgramsandSubs($id); // Get array of assigned program IDs
            
            $subjectModel = new SubjectModel();
            $data['subject'] = $subjectModel->getFacultySubjects($id);
            $studentModel = new StudentModel();
            $data['batch'] = $studentModel->select('program_id,semester,batch')->distinct()->findAll();
        }
        else{
        // Superadmin  
            $collegeModel = new CollegeModel();
            $data['college'] = $collegeModel->findAll();
            $programmodel = new ProgramModel();
            $data['program'] = $programmodel->findAll();
            $subjectModel = new SubjectModel();
            $data['subject'] = $subjectModel->findAll();
            $studentModel = new StudentModel();
            $data['batch'] = $studentModel->select('program_id,semester,batch')->distinct()->findAll();
       

        }
       
         return view('attendance/exportAttendancereport', $data);
    }

    public function ExcelHeader($lastColumn, $sheet, $program, $semester_number, $batch)
    {

        $mergeRange = "A1:{$lastColumn}1"; // Example: 'A1:D1'
        $sheet->mergeCells($mergeRange);
        $sheet->setCellValue('A1', 'GUJARAT UNIVERSITY'); // Title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $mergeRange = "A2:{$lastColumn}2"; // Example: 'A1:D1'
        $sheet->mergeCells($mergeRange);
        $sheet->setCellValue('A2', 'CENTRE FOR PROFESSIONAL COURSES'); // Title
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $mergeRange = "A3:{$lastColumn}3"; // Example: 'A1:D1'
        $sheet->mergeCells($mergeRange);
        $cla = $program['program_name'] . " SEM " . $semester_number;
        $cla = $batch == "all" ? $cla : $cla . " Batch - " . $batch;
        $sheet->setCellValue('A3', $cla); // Title
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function export_attendance()
    {
        $allSubjects = explode(',', $this->request->getPost('all_subjects')); // Convert string to array

        $p_id = $this->request->getVar('program_id');
        $semester_number = $this->request->getVar('semester_number');
        $sub_id = $this->request->getVar('subject_id');
        $batch = $this->request->getVar('batch');
        $programmodel = new ProgramModel();
        $program = $programmodel->find($p_id);

        $studentmodel = new Studentmodel();

        if ($batch == "all") {
            $students = $studentmodel->where('program_id', $p_id)->Where('semester', $semester_number)->orderBy('university_enrollment_no', 'ASC')->findAll();;
        } else {
            $students = $studentmodel->where('program_id', $p_id)->Where('semester', $semester_number)->Where('batch', $batch)->orderBy('university_enrollment_no', 'ASC')->findAll();;
        }

        $subjectmodel = new Subjectmodel();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Initialize $ss to a default value
        $ss = "All_Subjects"; // Default filename for all subjects export

        // Define Column Headers Dynamically
        $columns = ['SR NO', 'Enrollment No', 'Student Name']; // Add more columns if needed


        if ($sub_id == "all") {

            foreach ($allSubjects as $k) {
                if($k!="all")
                {
                    $subject = $subjectmodel->find($k);
                array_push($columns, $subject['subject_name']);

                }

            }
            // Add the new final percentage column header
            array_push($columns, 'Final Percentage');

            // Get Last Column Letter Dynamically (e.g., 'D' for 4 columns)
            $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($columns));

            ExportAttendanceController::ExcelHeader($lastColumn, $sheet, $program, $semester_number, $batch);


            $columnLetter = 'A';
            foreach ($columns as $columnTitle) {
                $sheet->setCellValue($columnLetter . '4', $columnTitle);
                $sheet->getStyle($columnLetter . '4')->getFont()->setBold(true);
                $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
                $columnLetter++;
            }


            // Insert Data
            $rowNumber = 5;
            $sr = 1;
            foreach ($students as $s) {
                $sheet->setCellValue('A' . $rowNumber, $sr);
                $sheet->setCellValue('B' . $rowNumber, $s['university_enrollment_no']);
                $sheet->getStyle('B' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->setCellValue('C' . $rowNumber, $s['full_name']);

                $columnLetter = 'D';
                $total_overall_present_days = 0;
                $total_overall_class_days = 0;

                foreach ($allSubjects as $sub_id_loop) { // Renamed $sub_id to avoid conflict with outer $sub_id
                    if($sub_id_loop=="all")
                    {
                        continue;
                    }
                    $attendancemodel = new AttendanceModel();
                    $topicmodel = new TopicModel(); // Need TopicModel to get total class days

                    // Get attendance for the current student in the current subject
                    $stud_attendance = $attendancemodel->getStudentPresentPerc($s['id'], $sub_id_loop);

                    // Get total class days for the current subject and batch (or all batches if 'all')
                    if ($batch == "all") {
                        $topics = $topicmodel->where('subject_id', $sub_id_loop)->findAll();
                    } else {
                        $topics = $topicmodel->where('subject_id', $sub_id_loop)->where('batch', $batch)->findAll();
                    }
                    $total_class_days = count($topics);


                    $per = "0";
                    if (!empty($stud_attendance)) {
                        $present_days = $stud_attendance['present_count']; // Assuming getStudentPresentPerc returns present_count
                        $total_days_recorded = $stud_attendance['total_count']; // Assuming getStudentPresentPerc returns total_count (classes student *could* have attended)

                        // To calculate percentage for *this* subject accurately, you need both present days and total classes.
                        // If getStudentPresentPerc gives a percentage, you might need to re-evaluate how you get raw counts.
                        // For the cumulative, we need the raw counts.
                        // Let's assume getStudentPresentPerc gives you total_present and total_classes for that subject
                        if($total_days_recorded > 0) {
                            $per = ($present_days / $total_days_recorded) * 100;
                            $per = number_format($per, 2);
                        }

                        $total_overall_present_days += $present_days;
                        $total_overall_class_days += $total_class_days; // Use the actual total classes for the subject
                    }
                    $sheet->setCellValue($columnLetter . '' . $rowNumber, $per);
                    $columnLetter++;
                }

                // Calculate and set the Final Percentage
                $final_percentage = 0;
                if ($total_overall_class_days > 0) {
                    $final_percentage = ($total_overall_present_days / $total_overall_class_days) * 100;
                }
                $final_percentage = number_format($final_percentage, 2);
                $sheet->setCellValue($columnLetter . '' . $rowNumber, $final_percentage);
                $sheet->getStyle($columnLetter . '' . $rowNumber)->getFont()->setBold(true);
                $sheet->getStyle($columnLetter . '' . $rowNumber)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $sr++;
                $rowNumber++;
            }
            // Set $ss for all subjects export
            $ss = "All_Subjects_Attendance"; // Or any other suitable name for all subjects export

        } else {
            // ... (your existing code for single subject export remains here)
            $topicmodel = new TopicModel();
            if ($batch == "all") {
                $topics = $topicmodel->Where('subject_id', $sub_id)->orderBy('date', 'ASC')->findAll();
            } else {
                $topics = $topicmodel->Where('subject_id', $sub_id)->Where('batch', $batch)->orderBy('date', 'ASC')->findAll();
            }


            foreach ($topics as $key) {
                array_push($columns, date("d-m-Y", strtotime($key['date'])));
            }

            array_push($columns, 'Percentage');




            // Get Last Column Letter Dynamically (e.g., 'D' for 4 columns)
            $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($columns));


            ExportAttendanceController::ExcelHeader($lastColumn, $sheet, $program, $semester_number, $batch);



            $subj = $subjectmodel->find($sub_id);
            $mergeRange = "A4:{$lastColumn}4"; // Example: 'A1:D1'
            $sheet->mergeCells($mergeRange);
            $ss = $subj['subject_name']; // $ss is correctly defined here for single subject
            $sheet->setCellValue('A4', $ss); // Title
            $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);




            $columnLetter = 'A';
            foreach ($columns as $columnTitle) {
                $sheet->setCellValue($columnLetter . '6', $columnTitle);
                $sheet->getStyle($columnLetter . '6')->getFont()->setBold(true);
                $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
                $sheet->getStyle($columnLetter . '6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $columnLetter++;
            }


            // Insert Data
            $rowNumber = 7;
            $sr = 1;
            foreach ($students as $s) {
                $sheet->setCellValue('A' . $rowNumber, $sr);
                $sheet->getStyle('A' . $sr)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue('B' . $rowNumber, $s['university_enrollment_no']);
                $sheet->getStyle('B' . $rowNumber, $s['university_enrollment_no'])->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->setCellValue('C' . $rowNumber, $s['full_name']);

                $columnLetter = 'D';
                $total = 0;
                $pre = 0;
                foreach ($topics as $t) {
                    $attendancemodel = new AttendanceModel();

                    $stud_attendance = $attendancemodel->where('topic_id', $t['id'])->where('student_id', $s['id'])->find();
                    $att = "A";
                    if (!empty($stud_attendance)) {
                        $att = $stud_attendance[0]['attendance'] == "Present" ? "P" : "A";


                        if ($att == "P") {
                            $sheet->setCellValue($columnLetter . '' . $rowNumber, $att);
                            $sheet->getStyle($columnLetter . '' . $rowNumber)->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => '006100'], // White text color
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'C6EFCE'], // Blue background
                                ],

                            ]);
                            $pre += 1;
                        } else {
                            $sheet->setCellValue($columnLetter . '' . $rowNumber, $att);
                            $sheet->getStyle($columnLetter . '' . $rowNumber)->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => '9C0006'], // White text color
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FFC7CE'], // Blue background
                                ],

                            ]);
                        }

                        $total += 1;
                    } else {
                        $sheet->setCellValue($columnLetter . '' . $rowNumber, '-');
                    }
                    $sheet->getStyle($columnLetter . '' . $rowNumber)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $columnLetter++;
                }


                $pe = $pre > 0 ? ($pre / $total) * 100 : 0;
                $pe = number_format($pe, 2);
                $sheet->setCellValue($columnLetter . '' . $rowNumber, $pe);
                $sheet->getStyle($columnLetter . '' . $rowNumber)->getFont()->setBold(true);
                $sheet->getStyle($columnLetter . '' . $rowNumber)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sr++;
                $rowNumber++;
            }
        }

        // Get the highest row and column
        $highestRow = $sheet->getHighestRow(); // e.g., 10
        $highestColumn = $sheet->getHighestColumn(); // e.g., 'D'

        // Define the range (from A1 to last used cell)
        $range = 'A1:' . $highestColumn . $highestRow;

        // Apply border to the entire sheet
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // Thin border
                    'color' => ['rgb' => '000000'], // Black color
                ],
            ],
        ]);

        // Set Headers for Download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$ss.'_attendance_export_report_SEM_'.$semester_number.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();

        return redirect()->to('attendance-report');
    }
}
