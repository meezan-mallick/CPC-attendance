<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class HomeController extends Controller
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard'); // If logged in, go to Dashboard
        } else {
            return redirect()->to('/login'); // If not logged in, go to Login
        }
    }
}
