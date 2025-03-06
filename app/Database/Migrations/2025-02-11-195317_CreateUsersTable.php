<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'mobile_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'designation' => [
                'type'       => 'ENUM',
                'constraint' => ['ASSISTANT PROFESSOR', 'TEACHING ASSISTANT', 'TECHNICAL ASSISTANT', 'VISITING FACULTY'],
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['Superadmin', 'Coordinator', 'Faculty'],
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
            ],
            'dob' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['Male', 'Female', 'Other'],
                'null'       => true,
            ],
            'father_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'mother_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'qualification' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'industry_experience' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => true,
            ],
            'working_experience' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => true,
            ],
            'date_of_joining' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'achievements' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'skillset' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
