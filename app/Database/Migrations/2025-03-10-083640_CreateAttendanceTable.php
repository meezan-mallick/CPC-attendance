<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceTable extends Migration
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
            'topic_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'student_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'program_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'semester_number' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'subject_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'batch' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'attendance' => [
                'type'       => 'ENUM',
                'constraint' => ['Present', 'Absent'],
                'null'       => false,
            ],
            
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('topic_id', 'topics', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('program_id', 'programs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('attendance');
    }

    public function down()
    {
        $this->forge->dropTable('attendance');
    }
}
