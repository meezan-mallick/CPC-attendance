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
use App\Models\UserModel;
use TCPDF;


class ExportVoucherController extends BaseController
{
    public function get_lectures()
    {
        $id = session()->get('user_id');

        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $topicmodel = new TopicModel();

        if ($start_date != "" && $end_date != "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesSEDATE($start_date, $end_date);
        } else if ($start_date != "" && $end_date == "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesStartDATE($start_date);
        } else if ($start_date == "" && $end_date != "") {
            $data['lectures'] = $topicmodel->getFacultyTotalLecturesEndDATE($end_date);
        } else {
            $data['lectures'] = $topicmodel->getFacultyTotalLectures();
        }
        return view('Export/fpaymentvoucher', $data);
    }


    public function export_lec($program_id, $semester_number, $subject_id, $batch, $start_date, $end_date)
    {

        $topicmodel = new TopicModel();
        $id = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($id);

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

        $y=date("Y");

        // ✅ Fetch the Coordinator Name using SubjectallocationModel
        $subjectAllocationModel = new SubjectallocationModel();
        $coordinator = $subjectAllocationModel->select('users.full_name AS coordinator_name')
            ->join('coordinator_programs', 'allocatedsubjects.program_id = coordinator_programs.program_id', 'inner')
            ->join('users', 'coordinator_programs.user_id = users.id', 'left')
            ->where('allocatedsubjects.program_id', $program_id)
            ->first();

        // ✅ Handle empty coordinator case
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
                <td><strong>Ref:</strong> CPC/Accounts/_______/'.$y.'</td>
                <td align="right"><strong>Date:</strong> ' . $date . '</td>
            </tr>
        </table>

        <h3 style="padding-top: 15px;padding-bottom: 15px;text-align: center; text-decoration: underline;">Payment Voucher</h3>
        <p><strong>Name (As per the Bank Account):</strong> ' . $user['full_name'] . '</p>
        <p><strong>Course:</strong> ' . $program['program_name'] . '</p>
        <p><strong>Subject:</strong> ' . $subject['subject_name'] . '</p>
         <table width="100%">
            <tr>
                <td><strong>Semester:</strong> ' . $semester_number . ' </td>
                <td align="right" style="padding-right: 15px;"><strong>Section / Batch (If applicable) : </strong> ' . $batch . '</td>
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
            $html .= '<tr>
                            <td style="width:6%;">' . $i++ . '</td>
                            <td style="width: 45%;text-align:left">' . $topic['topic'] . '</td>
                            <td  style="width: 11%;">' . $topic['total_present'] . '</td>
                            <td style="width: 16%;">' . $topic['date'] . '</td>
                            <td style="width: 22%;">' . $topic['time'] . '</td>
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
                <th width="25%"></th>
           
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
                <td style="text-align: center;">________________________<br><b>Resource Person</b><br>' . $user['full_name'] . '</td>
                <td style="text-align: center;">________________________<br><b>Course Coordinator</b> <br> ' . $coordinator_name . '</td>
                <td style="text-align: center;">________________________<br><b>Director</b><br>Dr Paavan Pandit</td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('payment_voucher.pdf', 'D');
    }
}
