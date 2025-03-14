<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\UserModel;
use App\Models\ProgramModel;
use App\Models\SubjectallocationModel;
use CodeIgniter\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();

        // Get logged-in user role and ID
        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Get filter values from GET request
        $selectedProgram = $this->request->getGet('program_id');
        $selectedSemester = $this->request->getGet('semester_number');

        // Build query with filters
        $query = $subjectModel->select('subjects.*, programs.program_name')
            ->join('programs', 'programs.id = subjects.program_id');

        // Superadmin: See all programs
        if ($userRole === 'Superadmin') {
            $data['programs'] = $programModel->findAll();
        }
        // Coordinator: See only assigned programs
        elseif ($userRole === 'Coordinator') {
            $assignedPrograms = $programModel->whereIn('id', function ($builder) use ($userId) {
                return $builder->select('program_id')->from('coordinator_programs')->where('user_id', $userId);
            })->findAll();

            // Convert program objects to array for filtering
            $data['programs'] = $assignedPrograms;
            $assignedProgramIds = array_column($assignedPrograms, 'id');

            // Apply restriction in query
            $query->whereIn('subjects.program_id', $assignedProgramIds);
        } else {
            // Unauthorized users are redirected
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        // Apply filters
        if (!empty($selectedProgram)) {
            $query->where('subjects.program_id', $selectedProgram);
        }
        if (!empty($selectedSemester)) {
            $query->where('subjects.semester_number', $selectedSemester);
        }

        $data['subjects'] = $query->findAll();
        $data['selectedProgram'] = $selectedProgram;
        $data['selectedSemester'] = $selectedSemester;

        return view('subjects/index', $data);
    }


    public function add()
    {
        $programModel = new ProgramModel();

        // Get logged-in user role and ID
        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        if ($userRole === 'Superadmin') {
            // Superadmin sees all programs
            $data['programs'] = $programModel->findAll();
        } elseif ($userRole === 'Coordinator') {
            // Coordinator sees only assigned programs
            $data['programs'] = $programModel->whereIn('id', function ($builder) use ($userId) {
                return $builder->select('program_id')->from('coordinator_programs')->where('user_id', $userId);
            })->findAll();
        } else {
            // Unauthorized access
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        return view('subjects/add', $data);
    }


    public function store()
    {
        $subjectModel = new SubjectModel();

        $data = [
            'program_id'      => $this->request->getPost('program_id'),
            'semester_number' => $this->request->getPost('semester_number'),
            'subject_code'    => $this->request->getPost('subject_code'),
            'subject_name'    => $this->request->getPost('subject_name'),
            'credit'          => $this->request->getPost('credit'),
            'type'            => $this->request->getPost('type'),
            'internal_marks'  => $this->request->getPost('internal_marks'),
            'external_marks'  => $this->request->getPost('external_marks'),
        ];

        if (!$subjectModel->insert($data)) {
            print_r($subjectModel->errors());
            exit(); // Stop execution to check errors
        }

        return redirect()->to('/subjects')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $subjectModel = new SubjectModel();
        $programModel = new ProgramModel();

        $data['subject'] = $subjectModel->find($id);
        $data['programs'] = $programModel->findAll();

        if (!$data['subject']) {
            return redirect()->to('/subjects')->with('error', 'Subject not found');
        }

        return view('subjects/edit', $data);
    }

    public function update($id)
    {
        $subjectModel = new SubjectModel();

        // 🔹 Fetch the existing subject
        $existingSubject = $subjectModel->find($id);
        if (!$existingSubject) {
            return redirect()->to('/subjects')->with('error', 'Subject not found.');
        }

        $data = [
            'program_id'      => $this->request->getPost('program_id'),
            'semester_number' => $this->request->getPost('semester_number'),
            'subject_code'    => $this->request->getPost('subject_code'),
            'subject_name'    => $this->request->getPost('subject_name'),
            'credit'          => $this->request->getPost('credit'),
            'type'            => $this->request->getPost('type'),
            'internal_marks'  => $this->request->getPost('internal_marks'),
            'external_marks'  => $this->request->getPost('external_marks'),
        ];

        // 🔹 Define custom validation rules
        $validationRules = [
            'subject_code' => "required|max_length[50]|is_unique[subjects.subject_code,id,{$id}]",
        ];

        // 🔹 Validate the data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 🔹 If validation passes, update the record
        if (!$subjectModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $subjectModel->errors());
        }

        return redirect()->to('/subjects')->with('success', 'Subject updated successfully.');
    }


    public function delete($id)
    {
        $subjectModel = new SubjectModel();

        if (!$subjectModel->delete($id)) {
            return redirect()->to('/subjects')->with('error', 'Subject not found');
        }

        return redirect()->to('/subjects')->with('success', 'Subject deleted successfully.');
    }

    // Subject Allocation

    public function Getassignsubjects()
    {
        $subjectallocationModel = new SubjectallocationModel();
        $programModel = new ProgramModel();
        $userModel = new UserModel();

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Fetch allocated subjects based on user role
        $data['allocatedsubjects'] = $subjectallocationModel->getAllocatedSubjectDetails($userRole, $userId);

        // Filter Programs Based on Role
        if ($userRole === 'Superadmin') {
            $data['programs'] = $programModel->findAll(); // Show all programs
        } elseif ($userRole === 'Coordinator') {
            $data['programs'] = $programModel
                ->join('coordinator_programs', 'programs.id = coordinator_programs.program_id', 'inner')
                ->where('coordinator_programs.user_id', $userId)
                ->findAll(); // Show only assigned programs
        }

        // Fetch unique semester numbers
        $data['semesters'] = $subjectallocationModel->select('semester_number')->groupBy('semester_number')->findAll();

        // Fetch faculty and coordinator names
        $data['faculties'] = $userModel->whereIn('role', ['Faculty', 'Coordinator'])->findAll();

        return view('subjects/assignsubjects', $data);
    }



    public function filterAllocatedSubjects()
    {
        $subjectallocationModel = new SubjectallocationModel();
        $program = $this->request->getPost('program');
        $semester = $this->request->getPost('semester');
        $faculty = $this->request->getPost('faculty');

        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        $query = $subjectallocationModel->select('allocatedsubjects.*, users.full_name AS faculty_name, programs.program_name, subjects.subject_name, colleges.college_code, colleges.college_name')
            ->join('users', 'allocatedsubjects.faculty_id = users.id', 'left')
            ->join('programs', 'allocatedsubjects.program_id = programs.id', 'inner')
            ->join('colleges', 'colleges.college_code = programs.college_code', 'inner')
            ->join('subjects', 'allocatedsubjects.subject_id = subjects.id', 'inner');

        if ($userRole === 'Coordinator') {
            $query->join('coordinator_programs', 'allocatedsubjects.program_id = coordinator_programs.program_id', 'inner')
                ->where('coordinator_programs.user_id', $userId);
        }

        if (!empty($program)) {
            $query->where('allocatedsubjects.program_id', $program);
        }
        if (!empty($semester)) {
            $query->where('allocatedsubjects.semester_number', $semester);
        }
        if (!empty($faculty)) {
            $query->where('users.full_name', $faculty);
        }

        $filteredSubjects = $query->findAll();

        foreach ($filteredSubjects as $subject) {
            echo "<tr>
                <td>{$subject['id']}</td>
                <td>{$subject['college_code']}</td>
                <td>{$subject['program_name']}</td>
                <td>{$subject['semester_number']}</td>
                <td>{$subject['subject_name']}</td>
                <td>{$subject['faculty_name']}</td>
                <td>
                    <a class='btn btn-sm btn-warning' href='subjectsallocation/edit/{$subject['id']}'>Edit</a> |
                    <a class='btn btn-sm btn-danger' href='subjectsallocation/delete/{$subject['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
        }
    }




    public function assign()
    {
        $subjectModel = new SubjectModel();
        $userModel = new UserModel();
        $programModel = new ProgramModel();

        // Get logged-in user role and ID
        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        if ($userRole === 'Superadmin') {
            // Superadmin sees all programs
            $data['programs'] = $programModel->findAll();
        } elseif ($userRole === 'Coordinator') {
            // Coordinator sees only assigned programs
            $data['programs'] = $programModel->whereIn('id', function ($builder) use ($userId) {
                return $builder->select('program_id')->from('coordinator_programs')->where('user_id', $userId);
            })->findAll();
        } else {
            // Unauthorized access
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }



        // Get unallocated subjects
        $data['subjects'] = $subjectModel
            ->whereNotIn('id', function ($builder) {
                $builder->select('subject_id')->from('allocatedsubjects');
            })
            ->findAll();

        // Fetch semesters dynamically
        $data['semesters'] = $subjectModel
            ->select('program_id, semester_number')
            ->groupBy(['program_id', 'semester_number'])
            ->findAll();

        // Fetch faculties and coordinators
        $data['faculties'] = $userModel->whereIn('role', ['Faculty', 'Coordinator'])->findAll();

        return view('subjects/assign', $data);
    }


    public function storeAssignment()
    {
        $subjectallocationModel = new SubjectallocationModel();

        $data = [
            'subject_id'  => $this->request->getPost('subject_id'),
            'faculty_id'  => $this->request->getPost('faculty_id'),
            'program_id'  => $this->request->getPost('program_id'),
            'semester_number'  => $this->request->getPost('semester_number'),
        ];

        $subjectallocationModel->insert($data);
        return redirect()->to('subjectsallocation')->with('success', 'Subject assigned successfully.');
    }


    public function editAssignment($id)
    {

        $subjectModel = new SubjectModel();
        $userModel = new UserModel();

        $programModel = new ProgramModel();
        // Get logged-in user role and ID
        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        if ($userRole === 'Superadmin') {
            // Superadmin sees all programs
            $data['programs'] = $programModel->findAll();
        } elseif ($userRole === 'Coordinator') {
            // Coordinator sees only assigned programs
            $data['programs'] = $programModel->whereIn('id', function ($builder) use ($userId) {
                return $builder->select('program_id')->from('coordinator_programs')->where('user_id', $userId);
            })->findAll();
        } else {
            // Unauthorized access
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        // Get subject allocation data for the given ID
        $subjectallocationModel = new SubjectallocationModel();
        $subjectModel = new SubjectModel();
        $userModel = new UserModel();

        // Get subject allocation data for the given ID
        $subjectallocationModel = new SubjectallocationModel();
        $subjectModel = new SubjectModel();
        $userModel = new UserModel();

        // Fetch the allocated subject
        $data['allocatesubject'] = $subjectallocationModel->find($id);

        if (!$data['allocatesubject']) {
            return redirect()->to('/subjectsallocation')->with('error', 'Subject allocation not found.');
        }

        // Fetch subjects that are either unallocated OR the currently allocated subject
        $data['subjects'] = $subjectModel
            ->whereNotIn('id', function ($builder) {
                $builder->select('subject_id')->from('allocatedsubjects');
            })
            ->orWhere('id', $data['allocatesubject']['subject_id']) // Ensure we include the currently allocated subject
            ->findAll();

        // Fetch unique semesters per program
        $data['semesters'] = $subjectModel
            ->select('program_id, semester_number')
            ->groupBy(['program_id', 'semester_number'])
            ->findAll();

        // Fetch faculties and coordinators
        $data['faculties'] = $userModel->whereIn('role', ['Faculty', 'Coordinator'])->findAll();

        // Fetch the currently allocated faculty for the selected subject
        $data['selected_faculty'] = $data['allocatesubject']['faculty_id'];



        return view('subjects/editassign', $data);
    }

    public function updateAssignment($id)
    {
        $subjectallocationModel = new SubjectallocationModel();

        $data = [
            'subject_id'  => $this->request->getPost('subject_id'),
            'faculty_id'  => $this->request->getPost('faculty_id'),
            'program_id'  => $this->request->getPost('program_id'),
            'semester_number'  => $this->request->getPost('semester_number'),
        ];

        $subjectallocationModel->update($id, $data);
        return redirect()->to('subjectsallocation')->with('success', 'Updated successfully.');
    }

    public function deleteAssignment($id)
    {
        $subjectallocationModel = new SubjectallocationModel();

        $subjectallocationModel->delete($id);
        return redirect()->to('subjectsallocation')->with('success', 'Deleted successfully.');
    }
}
