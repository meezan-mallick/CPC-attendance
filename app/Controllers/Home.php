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

class Home extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function logout()
    {
        return redirect()->to(base_url("/"));
    }

    public function facultylogin()
    {
        $username = $this->request->getVar("username");
        $password = $this->request->getVar("password");
        $role = "HOD";

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if ($this->validate($rules)) {


            if ($username == "CPCHOD") {
                if ($password == "CPCHOD@123") {
                    $name = "PAVAN SIR";

                    setcookie("name", $name, time() + (86400 * 30), "/");
                    setcookie("username", $username, time() + (86400 * 30), "/");
                    setcookie("password", $password, time() + (86400 * 30), "/");
                    setcookie("login_token", true, time() + (86400 * 30), "/");
                    setcookie("role", $role, time() + (86400 * 30), "/");

                    return redirect()->to(base_url("/dashboard"));
                } else {
                    session()->setFlashdata("message", "Invalid password");
                    return redirect()->to(base_url("/"));
                }
            } else {
                $facultyModel = new FacultyModel();
                $data['faculty'] = $facultyModel->where('username', $username)->find();



                if (!empty($data['faculty'])) {
                    $data['faculty'] = $data['faculty'][0];

                    if ($password == $data['faculty']['password']) {
                        $name = $data['faculty']['name'];
                        $role = $data['faculty']['coordinator'] == true ? "Coordinator" : "Faculty";
                        setcookie("name", $name, time() + (86400 * 30), "/");
                        setcookie("id", $data['faculty']['id'], time() + (86400 * 30), "/");
                        setcookie("username", $username, time() + (86400 * 30), "/");
                        setcookie("password", $password, time() + (86400 * 30), "/");
                        setcookie("login_token", true, time() + (86400 * 30), "/");
                        setcookie("role", $role, time() + (86400 * 30), "/");
                        return redirect()->to(base_url("/dashboard"));
                    } else {
                        session()->setFlashdata("message", "Invalid password");
                        return redirect()->to(base_url("/"));
                    }
                } else {
                    session()->setFlashdata("message", "Invalid User");
                    return redirect()->to(base_url("/"));
                }
            }
        } else {
            $data["validation"] = $this->validator;
            return view('login', $data);
        }
    }

    public function dashboard()
    {
        // $subjectmodel= new SubjectModel();

        // $data['student']=$subjectmodel->getStudentAttendanceCount();
        $topicmodel = new TopicModel();
        $data['student'] = $topicmodel->getStudentAttendanceCount();
        $k = $data['student'];


        // foreach ($k as $key) {
        //     echo "<h4>";
        //     print_r($key);
        //     echo "</h4>";
        // }

        return view('dashboard');
    }
}
