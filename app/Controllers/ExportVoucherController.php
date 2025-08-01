<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TopicModel;
use App\Models\SubjectModel;
use App\Models\ProgramModel;
use App\Models\SubjectallocationModel; 
use App\Libraries\MyPdf; // Import your custom TCPDF class



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
        // ... (data fetching logic)
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

        $userModel = new UserModel();
        $subjectAllocationModel = new SubjectallocationModel(); 

        $allocatedFaculty = $subjectAllocationModel
            ->select('faculty_id')
            ->where('program_id', $program_id)
            ->where('subject_id', $subject_id)
            ->where('semester_number', $semester_number)
            ->first();
        
        $faculty_id_for_voucher = null;
        if ($allocatedFaculty && isset($allocatedFaculty['faculty_id'])) {
            $faculty_id_for_voucher = $allocatedFaculty['faculty_id'];
        }

        $user = null; 
        if ($faculty_id_for_voucher) {
            $user = $userModel->find($faculty_id_for_voucher);
        }

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

        $coordinator = $subjectAllocationModel->select('users.full_name AS coordinator_name')
            ->join('coordinator_programs', 'allocatedsubjects.program_id = coordinator_programs.program_id', 'inner')
            ->join('users', 'coordinator_programs.user_id = users.id', 'left')
            ->where('allocatedsubjects.program_id', $program_id)
            ->first();

        $coordinator_name = ($coordinator) ? $coordinator['coordinator_name'] : "Not Assigned";


        // --- PDF SETUP ---
        $pdf = new MyPdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Gujarat University | Centre for Professional Courses');
        $pdf->SetTitle('Payment Voucher');
        $pdf->SetMargins(10, 65, 10);
        $pdf->SetAutoPageBreak(TRUE, 55); // Increased bottom margin to fit the footer
        $pdf->AddPage();

        // Pass dynamic data to the PDF footer
        $pdf->setCustomFooterData($user['full_name'] ?? 'N/A', $coordinator_name);


        // --- MAIN CONTENT ---
        $html = '
        <table border="1" cellpadding="5" style="width:100%; font-size: 12pt;">
            <tr>
                <td colspan="2"><strong>Name (As per Bank A/C):</strong> ' . strtoupper(esc($user['name_as_per_bank_account'] ?? 'N/A')) . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Mobile Number:</strong> ' . esc($user['mobile_number'] ?? 'N/A') . '</td>
                <td width="50%"><strong>PAN Card No:</strong> ' . esc($user['pan_card_no'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Bank Name:</strong> ' . strtoupper(esc($user['bank_name'] ?? 'N/A')) . '</td>
                <td width="50%"><strong>Bank Account No:</strong> ' . esc($user['bank_account_no'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>IFSC Code:</strong> ' . esc($user['ifsc_code'] ?? 'N/A') . '</td>
                <td width="50%"><strong>Aadhaar No:</strong> ' . esc($user['aadhaar_no'] ?? 'N/A') . '</td>
            </tr>
        </table>
        
        <table border="0" cellpadding="5" style="width:100%; font-size: 12pt;">
            <tr>
                <td colspan="2"><strong>Program:</strong> ' . esc($program['program_name'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td width="50%"><strong>Subject:</strong> ' . strtoupper(esc($subject['subject_name'] ?? 'N/A')) . '</td>
                
            </tr>
            <tr>
                <td width="50%"><strong>Semester:</strong> ' . esc($semester_number ?? 'N/A') . '</td>
                <td width="50%"><strong>Section / Batch (If applicable) :</strong> ' . esc($batch ?? 'N/A') . '</td>
            </tr>
           
        </table>
        
        <div style="padding-top: 15px;padding-bottom: 15px;" width="100%"></div>
        <table style="text-align:center" border="1" cellpadding="5">
            <thead>
                <tr>
                    <th style="width:6%;">Sr.</th>
                    <th style="width: 45%;">Topic Name</th>
                    <th style="width:11%;">No of Students in Class</th>
                    <th style="width: 16%;">Date</th>
                    <th style="width: 22%;">Time</th>
                </tr>
            </thead>
            <tbody>';
        
        $i = 1;
        foreach ($lectures as $topic) {
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
        </table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // --- TOTALS SUMMARY BLOCK (will appear only once at the end) ---
        $total_lectures_count = count($lectures);
        $summaryHtml = '
            <br>
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
            </table>';
            
        $pdf->writeHTML($summaryHtml, true, false, true, false, '');

        $pdf->Output('payment_voucher.pdf', 'D');
    }
}