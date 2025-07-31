<?php

namespace App\Controllers;

use App\Models\FacultyModel;
use App\Models\ProgramModel;
use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\SemesterModel;
use App\Models\CoordinatorModel;
use App\Models\TopicModel;
use App\Models\SubjectallocationModel; // This model maps to 'allocatedsubjects' table
use App\Models\TimeslotModel;
use App\Models\AttendanceModel;
use App\Models\UserModel;
use TCPDF;


class ExportVoucherController extends BaseController
{
    public function get_lectures()
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');
    
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $topicmodel = new TopicModel();

        if ($start_date != "" && $end_date != "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesSEDATE($start_date, $end_date,$userRole,$userId);
        } else if ($start_date != "" && $end_date == "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesStartDATE($start_date,$userRole,$userId);
        } else if ($start_date == "" && $end_date != "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesEndDATE($end_date,$userRole,$userId);
        } else {
            $data['lectures'] = $topicmodel->getFacultyTotalLectures($userRole,$userId);
        }
        return view('Export/fpaymentvoucher', $data);
    }


    public function export_lec($program_id, $semester_number, $subject_id, $batch, $start_date, $end_date)
    {
        $topicmodel = new TopicModel();
        
        $subjectModel = new SubjectModel();
        $subject = $subjectModel->find($subject_id);
        
        $programModel = new ProgramModel();
        $program = $programModel->find($program_id);
        
        if ($start_date == 0 && $end_date == 0) {
            $lectures = $topicmodel->ExportFacPaymentVoucherAll($subject_id, $batch);
        } else if ($start_date != 0 && $end_date == 0) {
            $lectures = $topicmodel->ExportFacPaymentVoucherStartDate($subject_id, $batch, $start_date);
        } else if ($start_date == 0 && $end_date != 0) {
            $lectures = $topicmodel->ExportFacPaymentVoucherEndDate($subject_id, $batch, $end_date);
        } else {
            $lectures = $topicmodel->ExportFacPaymentVoucherStartEndDate($subject_id, $batch, $start_date, $end_date);
        }

        // --- MODIFICATION FOR FACULTY DETAILS - REMOVED 'batch' from where clause ---
        $userModel = new UserModel();
        $subjectAllocationModel = new SubjectallocationModel(); // Instance the model

        // Find the specific faculty_id for this subject allocation
        $allocatedFaculty = $subjectAllocationModel
            ->select('faculty_id')
            ->where('program_id', $program_id)
            ->where('subject_id', $subject_id)
            ->where('semester_number', $semester_number)
            // ->where('batch', $batch) // THIS LINE HAS BEEN REMOVED because 'batch' is not in 'allocatedsubjects'
            ->first();
        
        $faculty_id_for_voucher = null;
        if ($allocatedFaculty && isset($allocatedFaculty['faculty_id'])) {
            $faculty_id_for_voucher = $allocatedFaculty['faculty_id'];
        }

        $user = null; // Initialize $user as null
        if ($faculty_id_for_voucher) {
            $user = $userModel->find($faculty_id_for_voucher);
        }

        // Fallback or Error Handling if faculty details aren't found for the allocation
        // Ensure all banking fields have a fallback to prevent errors in PDF rendering
        if (is_null($user) || empty($user)) {
            $user = [
                'full_name' => 'Error: Faculty Not Found',
                'mobile_number' => 'N/A',
                'name_as_per_bank_account' => 'N/A',
                'pan_card_no' => 'N/A',
                'bank_name' => 'N/A',
                'bank_account_no' => 'N/A',
                'ifsc_code' => 'N/A',
                'aadhaar_no' => 'N/A'
            ];
        }
        // --- END OF MODIFICATION FOR FACULTY DETAILS ---


        // Calculate total hours/lectures
        $total_lectures_count = count($lectures); // This counts the number of topics fetched

        $y=date("Y");

        // Fetch the Coordinator Name using SubjectallocationModel
        $coordinator = $subjectAllocationModel->select('users.full_name AS coordinator_name')
            ->join('coordinator_programs', 'allocatedsubjects.program_id = coordinator_programs.program_id', 'inner')
            ->join('users', 'coordinator_programs.user_id = users.id', 'left')
            ->where('allocatedsubjects.program_id', $program_id)
            ->first();

        // Handle empty coordinator case
        $coordinator_name = ($coordinator) ? $coordinator['coordinator_name'] : "Not Assigned";

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Gujarat University');
        $pdf->SetTitle('Payment Voucher');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();


        $date = date("d-m-Y");

        $html = ' 
        <table cellpadding="5" border="0" style="width:100%;">
            <tr>
                <td style="text-align: center; font-size:16px; font-weight:bold;">CENTRE FOR PROFESSIONAL COURSES</td>
            </tr>
            <tr>
                <td style="text-align: center; font-size:16px; font-weight:bold;">GUJARAT UNIVERSITY</td>
            </tr>
            <tr>
                <td style="text-align: center;">Maharshi Aryabhatt Building, Gujarat University, Ahmedabad - 380009</td>
            </tr>
        </table>
        
        <div style="padding-top: 15px;padding-bottom: 15px;" width="100%">
            <hr >
        </div>
        <table width="100%">
            <tr>
                <td align="right"><strong>Date:</strong> ' . $date . '</td>
            </tr>
        </table>

        <h3 style="padding-top: 15px;padding-bottom: 15px;text-align: center; text-decoration: underline;">Payment Voucher</h3>
        
        <table border="0" cellpadding="5" style="width:100%; font-size: 10pt;">
            <tr>
                <td colspan="2"><strong>Name (As per Bank A/C):</strong> ' . esc($user['name_as_per_bank_account'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Mobile Number:</strong> ' . esc($user['mobile_number'] ?? 'N/A') . '</td>
                <td width="50%"><strong>PAN Card No:</strong> ' . esc($user['pan_card_no'] ?? 'N/A') . '</td>
            </tr>
            <tr style="margin:10px 10px;">
                <td width="50%"><strong>Bank Name:</strong> ' . esc($user['bank_name'] ?? 'N/A') . '</td>
                <td width="50%"><strong>Aadhaar No:</strong> ' . esc($user['aadhaar_no'] ?? 'N/A') . '</td>
                
            </tr>
            <tr>
                <td width="50%"><strong>Bank Account No:</strong> ' . esc($user['bank_account_no'] ?? 'N/A') . '</td>
                <td width="50%"><strong>IFSC Code:</strong> ' . esc($user['ifsc_code'] ?? 'N/A') . '</td>
            </tr>
        </table>
        
        <p><strong>Course:</strong> ' . esc($program['program_name'] ?? 'N/A') . '</p>
        <p><strong>Subject:</strong> ' . esc($subject['subject_name'] ?? 'N/A') . '</p>
        <table width="100%">
            <tr>
                <td><strong>Semester:</strong> ' . esc($semester_number ?? 'N/A') . ' </td>
                <td align="right" style="padding-right: 15px;"><strong>Section / Batch (If applicable) : </strong> ' . esc($batch ?? 'N/A') . '</td>
            </tr>
        </table>
       
        <div style="padding-top: 15px;padding-bottom: 15px;" width="100%">
          
        </div>

        <table style="text-align:center" border="1" cellpadding="5">
            <thead>
                <tr>
                    <th style="width:6%;">Sr.</th>
                    <th style="width: 45%;">Topic Name</th>
                    <th style="width:11%;">Present Students</th>
                    <th style="width: 16%;">Date</th>
                    <th style="width: 22%;">Time</th>
                </tr>
            </thead>
            <tbody>';
        $i = 1;
        foreach ($lectures as $topic) {
            // Convert the date format here
            $formatted_lecture_date = date('d-m-Y', strtotime($topic['date']));

            $html .= '<tr>
                            <td style="width:6%;">' . $i++ . '</td>
                            <td style="width: 45%;text-align:left">' . esc($topic['topic'] ?? 'N/A') . '</td>
                            <td  style="width: 11%;">' . esc($topic['total_present'] ?? 'N/A') . '</td>
                            <td style="width: 16%;">' . esc($formatted_lecture_date ?? 'N/A') . '</td>
                            <td style="width: 22%;">' . esc($topic['time'] ?? 'N/A') . '</td>
                        </tr>';
        }
        $html .= '</tbody>
        </table>

        <div style="padding-top: 15px;padding-bottom: 15px;" width="100%">
          
        </div>

        <table border="1" cellpadding="5" width="100%" style="margin-top: 15px;">
            <tr>
                <th align="left" width="60%">Remuneration Per Lecture:</th>
                <th align="right" width="15%">Total Hours:</th>
                <th width="25%" style="text-align:center">' . esc($total_lectures_count ?? '0') . '</th>
            </tr>
           
            <tr>
                <th align="right"  colspan="2" width="75%">Total Amount Claimed:</th>
                <th width="25%"></th>
            </tr>
        </tbody>
        </table>

        <br>
        <table style="padding-top:50px" width="100%">
            <tr>
                <td style="text-align: center;">________________________<br><b>Resource Person</b><br>' . esc($user['full_name'] ?? 'N/A') . '</td>
                <td style="text-align: center;">________________________<br><b>Course Coordinator</b> <br> ' . esc($coordinator_name ?? 'N/A') . '</td>
                <td style="text-align: center;">________________________<br><b>Director</b><br>Dr Paavan Pandit</td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('payment_voucher.pdf', 'D');
    }
}