<?php

namespace App\Controllers;
use App\Models\FacultyModel;
use App\Models\CoordinatorModel;
use App\Models\ProgramModel;
use App\Models\SubjectModel;
use App\Models\SubjectallocationModel;
use App\Models\StudentModel;
use App\Models\SemesterModel;
class FacultyController extends BaseController
{
    

    public function faculties()
    {
        $facultymodel= new Facultymodel();
        $data['faculty']=$facultymodel->findAll();
        return view('faculty-crud/allFaculties',$data);
    }

    public function add_faculty()
    {
        return view('faculty-crud/addFaculty');
    }

    public function delete_faculty($id)
    {
        
        $subjectmmodel = new Subjectmodel();
        $data=$subjectmmodel->setAllocateOnFacultyDelete($id);


       
       $facultymodel = new Facultymodel();
      $data=$facultymodel->delete($id);

       
      return redirect()->to(base_url('/faculties'));
    }

    public function update_faculty($id)
    {
        $facultymodel = new Facultymodel();
        $data['faculty']=$facultymodel->find($id);
        return view('faculty-crud/updateFaculty',$data);
    }

    public function faculty_store()
    {
        
        $rules = [
            'name'=>'required|min_length[2]|max_length[100]',
            'username'=>'required|min_length[5]|max_length[100]|is_unique[faculties.username]',
            'password'=>'required|min_length[5]|max_length[100]|',
        ];

        if($this->validate($rules)){
                $facultymodel = new facultymodel();
                $data = [
                'name'=>$this->request->getVar('name'),
                'username'=>$this->request->getVar('username'),
                'password'=>$this->request->getVar('password'),
                'coordinator'=>$this->request->getVar('coordinator')==true?true:false,
                
            ];
            $facultymodel->save($data);
            
            return redirect()->to(base_url('/faculties'));
        }
        else{
            $data["validation"] = $this->validator;
            return view('faculty-crud/addFaculty',$data);
        }
    }

    public function update_facultystore($id)
    {
        
        $rules = [
            'name'=>'required|min_length[2]|max_length[100]',
            'username'=>'required|min_length[5]|max_length[100]',
            'password'=>'required|min_length[5]|max_length[100]|',
           
           
        ];

        $data['faculty']=[
                'id'=>$id,
                'name'=>$this->request->getVar('name'),
                'username'=>$this->request->getVar('username'),
                'password'=>$this->request->getVar('password'),
                'coordinator'=>$this->request->getVar('coordinator')==true?true:false,
        ];

        $coord=$this->request->getVar('coordinator');
        if($this->validate($rules)){
                $facultymodel = new facultymodel();
                $facultymodel->find($id);
                $fdata = [
                'name'=>$this->request->getVar('name'),
                'username'=>$this->request->getVar('username'),
                'password'=>$this->request->getVar('password'),
                'coordinator'=>$this->request->getVar('coordinator')==true?true:false,
                
            ];
           
           
            try{

                $facultymodel->update($id,$fdata);
                if($coord==false){
                    $coordinatormodel= new CoordinatorModel();
                    $coordinatormodel->where('faculty_id', $id)->delete();
    
                }
                return redirect()->to(base_url('/faculties'));
      
            }catch(\Exception $e){
                $data["validationdup"] = "User Already exists";
                return view('faculty-crud/updateFaculty',$data);
            }
        }
        else{
            $data["validation"] = $this->validator;
            return view('faculty-crud/updateFaculty',$data);
        }
    }

}
