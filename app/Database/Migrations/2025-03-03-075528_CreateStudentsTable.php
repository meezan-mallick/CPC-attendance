<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateStudentsTable extends Migration
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
            'university_enrollment_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 12, // Example: 202419600001
                'unique'     => true,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Store file path
            ],
            'program_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'admission_year' => [
                'type'       => 'YEAR',
                'null'       => true,
            ],
            'semester' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'batch' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0, // ✅ Ensure batch is never NULL
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
                'null'       => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'mobile_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
            ],
            'parent_mobile_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['Male', 'Female', 'Other'],
                'null'       => true,
            ],
            'dob' => [
                'type'       => 'DATE',
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
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'blood_group' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
            ],
            'address_line1' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'pin_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'enrolment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'default'    => 'Active',
            ],
            'placement_status' => [
                'type'       => 'BOOLEAN',
                'default'    => false, // False = Not Placed, True = Placed
            ],
            'placement_company' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'placement_company_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'placement_company_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'designation' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'placement_package' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true, // Example: 5.50 (5.5 LPA)
            ],
            'abc_id_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('program_id', 'programs', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
