<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $userModel->insert([
            'full_name'     => 'Superadmin',
            'email'         => 'admin@cpc.com',
            'mobile_number' => '7874101259',
            'password'      => password_hash('admin123', PASSWORD_DEFAULT),
            'designation'   => 'Superadmin',
            'role'          => 'Superadmin',
            'status'        => 'Active',
        ]);
    }
}
