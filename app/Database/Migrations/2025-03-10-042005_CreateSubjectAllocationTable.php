<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubjectAllocationTable extends Migration
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
            'faculty_id' => [ // Foreign Key: Links to users table
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'subject_id' => [ // Foreign Key: Links to subject table
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'program_id' => [ // Foreign Key: Links to programs table
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'semester_number' => [ // Stores semester (1-10 for Integrated, 1-4 for Masters)
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
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
        $this->forge->addForeignKey('program_id', 'programs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('faculty_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('allocatedsubjects');
    }

    public function down()
    {
        $this->forge->dropTable('allocatedsubjects');
    }
}
