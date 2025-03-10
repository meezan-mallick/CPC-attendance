<?php

namespace App\Controllers;
use App\Models\FacultyModel;
use App\Models\ProgramModel;
use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\SemesterModel;
use App\Models\CoordinatorModel;

use App\Models\SubjectallocationModel;
use App\Models\TimeslotModel;


class TimeslotController extends BaseController
{
    

    public function timeslots()
    {
        $timeslotmodel= new TimeslotModel();
        $data['timeslot']=$timeslotmodel->findAll();
        return view('timeslots/index',$data);
    }

    public function add_timeslot()
    {
        return view('timeslots/add');
    }

    public function edit_timeslot($id)
    {
        $timeslotmodel= new TimeslotModel();
        $data['timeslot']=$timeslotmodel->find($id);
        return view('timeslots/edit',$data);
    }

    public function timeslot_store()
    {

        $rules = [
            'start_time'=>'required',
            'end_time'=>'required',
           
        ];

        if($this->validate($rules)){
                $timeslotmodel = new TimeslotModel();
                $data = [
                'start_time'=>$this->request->getVar('start_time'),
                'end_time'=>$this->request->getVar('end_time'),
               
            ];
            $timeslotmodel->save($data);
            
            return redirect()->to(base_url('/time-slots'));
        }
        else{
            $data["validation"] = $this->validator;
           
            return view('timeslot-crud/addtimeslot',$data);
        }
      
    }

    public function update_timeslotstore($id)
    {

        $rules = [
            'start_time'=>'required',
            'end_time'=>'required',
           
        ];

        if($this->validate($rules)){
                $timeslotmodel = new TimeslotModel();
                $data = [
                'start_time'=>$this->request->getVar('start_time'),
                'end_time'=>$this->request->getVar('end_time'),
               
            ];
            $timeslotmodel->update($id,$data);
            
            return redirect()->to(base_url('/time-slots'));
        }
        else{
            $data["validation"] = $this->validator;
           
            return view('time-slots/edit',$data);
        }
      
    }

    public function delete_timeslot($id)
    {

        $timeslotmodel = new TimeslotModel();
        $timeslotmodel->delete($id);
        
        return redirect()->to(base_url('/time-slots'));
        
      
    }
   
}
