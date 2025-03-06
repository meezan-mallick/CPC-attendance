<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProgramModel;
use App\Models\CoordinatorProgramModel;
use CodeIgniter\Controller;

class CoordinatorController extends Controller
{
    public function index()
    {
        $userModel = new UserModel();
        $programModel = new ProgramModel();
        $coordinatorProgramModel = new CoordinatorProgramModel();

        $coordinators = $userModel->where('role', 'Coordinator')->findAll();

        // Get all programs
        $allPrograms = $programModel->findAll();

        // Get all assigned programs
        $assignedPrograms = $coordinatorProgramModel->findAll();

        // Create an array of already assigned program IDs
        $assignedProgramIds = [];
        foreach ($assignedPrograms as $assignment) {
            $assignedProgramIds[] = $assignment['program_id'];
        }

        // Filter out programs that are already assigned
        $availablePrograms = [];
        foreach ($allPrograms as $program) {
            if (!in_array($program['id'], $assignedProgramIds)) {
                $availablePrograms[] = $program;
            }
        }

        return view('coordinators/assign', [
            'coordinators' => $coordinators,
            'programs' => $availablePrograms
        ]);
    }

    public function list()
    {
        $userModel = new UserModel();
        $programModel = new ProgramModel();
        $coordinatorProgramModel = new CoordinatorProgramModel();

        // Fetch all coordinators
        $coordinators = $userModel->where('role', 'Coordinator')->findAll();

        // Fetch all assigned coordinators with their programs
        $coordinatorAssignments = [];

        foreach ($coordinators as $coordinator) {
            $assignedPrograms = $coordinatorProgramModel
                ->where('user_id', $coordinator['id'])
                ->join('programs', 'programs.id = coordinator_programs.program_id')
                ->findAll();

            $coordinatorAssignments[] = [
                'coordinator' => $coordinator,
                'programs'    => $assignedPrograms,
            ];
        }

        return view('coordinators/list', [
            'coordinatorAssignments' => $coordinatorAssignments
        ]);
    }

    public function assign()
    {
        $coordinatorProgramModel = new CoordinatorProgramModel();

        $user_id = $this->request->getPost('user_id');
        $program_ids = $this->request->getPost('program_ids');

        if (!$user_id || empty($program_ids) || !is_array($program_ids)) {
            return redirect()->back()->with('error', 'Please select a coordinator and at least one program.');
        }

        // Debugging: Check received data
        log_message('debug', 'Assigning programs: ' . json_encode($program_ids) . ' to user ID: ' . $user_id);

        // Remove existing assignments for this coordinator
        $coordinatorProgramModel->where('user_id', $user_id)->delete();

        // Bulk Insert for efficiency
        $data = [];
        foreach ($program_ids as $program_id) {
            $data[] = [
                'user_id'    => $user_id,
                'program_id' => $program_id,
            ];
        }

        if (!empty($data)) {
            $coordinatorProgramModel->insertBatch($data);
        }

        return redirect()->back()->with('success', 'Programs assigned successfully!');
    }


    //remove program coordinator assignment
    public function removeAssignment($coordinator_id, $program_id)
    {
        $coordinatorProgramModel = new CoordinatorProgramModel();

        // Delete the specific program assignment
        $coordinatorProgramModel->where('user_id', $coordinator_id)
            ->where('program_id', $program_id)
            ->delete();

        return redirect()->back()->with('success', 'Program assignment removed successfully!');
    }
}
