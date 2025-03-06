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

class AttendanceController extends BaseController
{
    

    public function allsubjects()
    {
        $id=$_COOKIE['id'];
       
        $subjectallocationmodel= new SubjectallocationModel();       
        $data['subject']=$subjectallocationmodel->getOneFacAllocatedSubjectDetails($id);
       
        $coordinatormodel= new CoordinatorModel();
        $data['coordinator_sub']=$coordinatormodel->getAllCoordinatorSubjects($id);
      
         return view('attendance-crud/allsubjoffac',$data);
    }

    public function alltopics($p_id,$s_id,$sub_id)
    {
        $id=$_COOKIE['id'];
       
        $timeslotmodel= new TimeslotModel();
        $data['timeslot']=$timeslotmodel->findAll();
        $studentmodel= new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $p_id)->where('semester_id', $s_id)->findAll();
        $data['sub_id']=$sub_id;
       
        $data['prog_id']=$p_id;
        $data['sem_id']=$s_id;
        $topicmodel= new TopicModel();       
        $data['topics']=$topicmodel->getAllTopics($sub_id);
        // $data['topics']=$topicmodel->findAll();
       
        return view('attendance-crud/alltopics',$data);
    }

    public function delete_topic($p_id,$s_id,$sub_id,$t_id)
    {
       
        $topicmodel= new TopicModel();       
        $data['topics']=$topicmodel->delete($t_id);
        return redirect()->to(base_url('/alltopics/'.$p_id.'/'.$s_id.'/'.$sub_id.'/'));
            
    }


    public function topic_store($p_id,$s_id,$sub_id)
    {
        $id=$_COOKIE['id'];
       
        $timeslotmodel= new TimeslotModel();
        $data['timeslot']=$timeslotmodel->findAll();
        $studentmodel= new Studentmodel();
        $data['batches'] = $studentmodel->distinct()->select('batch')->where('program_id', $p_id)->where('semester_id', $s_id)->findAll();
        $batches=$data['batches'];
        $data['sub_id']=$sub_id;
       
        $data['prog_id']=$p_id;
        $data['sem_id']=$s_id;


        $topicmodel= new TopicModel();       
        $data['topics']=$topicmodel->findAll();
       
         
        $rules = [
            'topic'=>'required|min_length[2]|max_length[100]',
           
        ];

        $batch=$this->request->getVar('batch');
       
        
        if($this->validate($rules)){
               
            if($batch=="all")
            {
                foreach ($batches as $key) {
                    $tdata = [
                        'topic'=>$this->request->getVar('topic'),
                        'date'=>$this->request->getVar('date'),
                        'time'=>$this->request->getVar('time'),
                        'subject_id'=>$sub_id,
                        'batch'=>$key['batch'],
                    ];
                    $topicmodel->save($tdata);
                }
            }
            else{
                $tdata = [
                    'topic'=>$this->request->getVar('topic'),
                    'date'=>$this->request->getVar('date'),
                    'time'=>$this->request->getVar('time'),
                    'subject_id'=>$sub_id,
                    'batch'=>$batch,
                ];
                $topicmodel->save($tdata);
            }
            
            
            return redirect()->to(base_url('/alltopics/'.$p_id.'/'.$s_id.'/'.$sub_id.'/'));
           
        }
        else{
            $data["validation"] = $this->validator;
            return view('attendance-crud/alltopics',$data);
        }

       
    }



    public function allstudents($p_id,$s_id,$sub_id,$t_id,$batch)
    {

        $timeslotmodel= new TimeslotModel();
        $data['timeslot']=$timeslotmodel->findAll();
        $studentmodel= new Studentmodel();
        // $data['student']=$studentmodel->where('program_id', $p_id)->Where('semester_id', $s_id)->Where('batch', $batch)->findAll();;

        $topicmodel= new TopicModel();       
        $data['s_topic']=$topicmodel->find($t_id);;
        
        $data['sub_id']=$sub_id;
       
        $data['batch']=$batch;
        $data['prog_id']=$p_id;
        $data['sem_id']=$s_id;
       
        $attendancemodel= new AttendanceModel();
       
        $data['student']=$attendancemodel->getStudentAttendanceLecture($p_id,$s_id,$sub_id,$t_id,$batch);
        
         return view('attendance-crud/allstudentlist',$data);
    }


    public function attendance_store($p_id,$s_id,$sub_id,$t_id,$batch)
    {

        $studentmodel= new Studentmodel();
        $studentIds = $this->request->getPost('student_ids');
        $attendanceData = $this->request->getPost('attendance');
        $att_ids = $this->request->getPost('att_ids');

        // Prepare the data for insertion
        $attendancemodel= new AttendanceModel();
       
        foreach ($studentIds as $studentId) {
           
            $data=$attendancemodel->where('topic_id', $t_id)->where('student_id', $studentId)->find();

            $records = [
                'topic_id'=>$t_id,
                'program_id'=>$p_id,
                'semester_id'=>$s_id,
                'subject_id'=>$sub_id,
                'batch'=>$batch,
                'student_id' => $studentId,
                'attendance' => isset($attendanceData[$studentId]) ? $attendanceData[$studentId] : 'Absent',
            ];
            if(!empty($data))
            {
                $attendance_id=$att_ids[$studentId];
                $attendancemodel->update($attendance_id,$records);
            }
            else{
                $attendancemodel->save($records);
            }
         
        }
          return redirect()->to(base_url('/alltopics/'.$p_id.'/'.$s_id.'/'.$sub_id.'/'));
       
      
    }
   
}
