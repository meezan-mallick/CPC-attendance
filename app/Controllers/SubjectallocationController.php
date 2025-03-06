<?php

namespace App\Controllers;
use App\Models\ProgramModel;
use App\Models\FacultyModel;
use App\Models\SubjectModel;
use App\Models\SubjectallocationModel;
use App\Models\StudentModel;
use App\Models\SemesterModel;

class SubjectallocationController extends BaseController
{
    
        public function allocatesubjects()
        {

            $subjectallocationmodel= new SubjectallocationModel();
            $data['allocatesubject']=$subjectallocationmodel->getAllocatedSubjectDetails();
            return view('allocatesub-crud/allallocatesub',$data);
        }
    
        public function allocate_subject()
        {
           
            $facultyModel= new FacultyModel();
            $data['faculty']=$facultyModel->findAll();
            $programmodel= new ProgramModel();
            $data['program']=$programmodel->findAll();
            $semestermodel= new SemesterModel();
            $data['semester']=$semestermodel->getSubjectSemesters();

    
            $subjectModel= new SubjectModel();
            $data['subject']=$subjectModel->where('allocated', false)->findAll();
            return view('allocatesub-crud/addallocatesub',$data);
        }
    
        public function update_allocatesubject($id)
        {
            $subjectallocationmodel= new SubjectallocationModel();
            $data['allocatesubject']=$subjectallocationmodel->find($id);
            $facultyModel= new FacultyModel();
            $data['faculty']=$facultyModel->findAll();
            $programmodel= new ProgramModel();
            $data['program']=$programmodel->findAll();
            $semestermodel= new SemesterModel();
            $data['semester']=$semestermodel->getSubjectSemesters();

    
            $subjectModel= new SubjectModel();
            $data['subject']=$subjectModel->where('allocated', false)->orWhere('id', $data['allocatesubject']['subject_id'])->findAll();
            return view('allocatesub-crud/updateallocatesub',$data);
        }


        public function allocatesubject_store()
        {
            
            $rules = [
                'faculty_id'=>'required',
               'program_id'=>'required',
               'semester_id'=>'required',
               'subject_id'=>'required',
            ];
    
           
            if($this->validate($rules)){
                    $subjectallocationmodel = new SubjectallocationModel();
                   
                    $data = [
                        'faculty_id'=>$this->request->getVar('faculty_id'),
                        'program_id'=>$this->request->getVar('program_id'),
                        'semester_id'=>$this->request->getVar('semester_id'),
                        'subject_id'=>$this->request->getVar('subject_id'),
                    ];
                    $sid=$this->request->getVar('subject_id');

                    $subjectallocationmodel->save($data);

                    $subjectmodel = new Subjectmodel();
                    $subjectmodel->find($sid);
                    $sdata = [
                        'allocated'=>true,
                    ];
                    $subjectmodel->update($sid,$sdata);

                    return redirect()->to(base_url('/allocatesubjects'));
            }
            else{
                $data["validation"] = $this->validator;
                 
                $facultyModel= new FacultyModel();
                $data['faculty']=$facultyModel->findAll();
                $programmodel= new ProgramModel();
                $data['program']=$programmodel->findAll();
                $semestermodel= new SemesterModel();
                $data['semester']=$semestermodel->findAll();
                $subjectModel= new SubjectModel();
                $data['subject']=$subjectModel->findAll();
                return view('allocatesub-crud/addallocatesub',$data);
            }
        }

        public function update_allocatesubjectstore($id)
        {
            $rules = [
                'faculty_id'=>'required',
               'program_id'=>'required',
               'semester_id'=>'required',
               'subject_id'=>'required',
            ];
    
           
            if($this->validate($rules)){
                    $subjectallocationmodel = new SubjectallocationModel();
                    $subjectallocationmodel->find($id);
                   
                    $sid=$this->request->getVar('subject_id');
                    $org_sub=$this->request->getVar('allot_sub');

                    if($sid!=$org_sub)
                    {
                        $subjectmodel = new Subjectmodel();
                        $subjectmodel->find($sid);
                        $sdata = [
                            'allocated'=>true,
                        ];
                        $subjectmodel->update($sid,$sdata);
                        $subjectmodel->find($org_sub);
                        $sdata = [
                            'allocated'=>false,
                        ];
                        $subjectmodel->update($org_sub,$sdata);
                        $data = [
                            'faculty_id'=>$this->request->getVar('faculty_id'),
                            'program_id'=>$this->request->getVar('program_id'),
                            'semester_id'=>$this->request->getVar('semester_id'),
                            'subject_id'=>$this->request->getVar('subject_id'),
                        ];

                    }
                    else{
                        $data = [
                            'faculty_id'=>$this->request->getVar('faculty_id'),
                           
                        ];

                    }


                    
                    $subjectallocationmodel->update($id,$data);
                    

                    return redirect()->to(base_url('/allocatesubjects'));
            }
            else{
                $data["validation"] = $this->validator;
                $subjectallocationmodel= new SubjectallocationModel();
                $data['allocatesubject']=$subjectallocationmodel->find($id);
                $facultyModel= new FacultyModel();
                $data['faculty']=$facultyModel->findAll();
                $programmodel= new ProgramModel();
                $data['program']=$programmodel->findAll();
                $semestermodel= new SemesterModel();
                $data['semester']=$semestermodel->getSubjectSemesters();
    
        
                $subjectModel= new SubjectModel();
                $data['subject']=$subjectModel->where('allocated', false)->orWhere('id', $data['allocatesubject']['subject_id'])->findAll();
                return view('allocatesub-crud/updateallocatesub',$data);
            }
            
        }

        public function delete_allocatesubject($id)
        {
            $subjectallocationmodel= new SubjectallocationModel();
            $d_sub= $subjectallocationmodel->find($id);
            $sid=$d_sub['subject_id'];
            
            $data=$subjectallocationmodel->delete($id);

            $subjectmodel = new Subjectmodel();
            $subjectmodel->find($sid);
            $sdata = [
                'allocated'=>false,
            ];
            $subjectmodel->update($sid,$sdata);

            return redirect()->to(base_url('/allocatesubjects'));
        }
}
