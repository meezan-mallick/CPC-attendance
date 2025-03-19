<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CoordinatorProgramModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        // ✅ If user is already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        try {
            $userModel = new UserModel();
            $coordinatorProgramModel = new CoordinatorProgramModel(); // Load Model for assigned programs

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // ✅ Check if the database connection is working
            $db = \Config\Database::connect();
            if (!$db->connect()) {
                throw new \CodeIgniter\Database\Exceptions\DatabaseException("Database connection failed.");
            }

            // ✅ Fetch user details
            $user = $userModel->where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('message', '❌ User not found.');
            }

            // ✅ Verify password
            if (!password_verify($password, $user['password'])) {
                if ($password != $user['password']) {
                    return redirect()->back()->with('message', '❌ Invalid credentials.');
                }
            }

            // ✅ Fetch assigned programs if the user is a Coordinator
            $assignedPrograms = [];
            if ($user['role'] === 'Coordinator') {
                $assignedPrograms = $coordinatorProgramModel
                    ->where('user_id', $user['id'])
                    ->findColumn('program_id'); // Get array of assigned program IDs

                if (!$assignedPrograms) {
                    $assignedPrograms = []; // Ensuring empty array if no assigned programs found
                }
            }

            // ✅ Set session variables
            session()->set([
                'user_id'           => $user['id'],
                'full_name'         => $user['full_name'],
                'email'             => $user['email'],
                'role'              => $user['role'],
                'assigned_program_id' => $assignedPrograms, // Store multiple assigned programs in session
                'logged_in'         => true,
            ]);

            // ✅ Redirect Based on Role
            if ($user['role'] == 'Faculty') {
                return redirect()->to('/faculty-subjects')->with('message', '✅ Welcome, ' . $user['full_name'] . '!');
            }

            return redirect()->to('/dashboard')->with('message', '✅ Login successful!');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // ✅ Database connection error message
            return redirect()->back()->with('message', '❌ Unable to connect to the database. Please try again later.');
        }
    }



    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Logged out successfully.');
    }
}
