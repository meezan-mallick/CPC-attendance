<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramsTable extends Migration
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
            'college_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => false,
            ],
            'program_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'program_duration' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'program_type' => [
                'type'       => 'ENUM',
                'constraint' => ['integrated', 'masters', 'bachelor', 'honours'],
                'null'       => false,
                'comment'    => 'Type of program: integrated (5 yrs), masters (2 yrs), bachelor (3 yrs), honours (4 yrs)',
            ],
            'total_semesters' => [ 
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
                'comment'    => 'Typically: 4/6/8/10 semesters based on program',
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

        $this->forge->addForeignKey('college_code', 'colleges', 'college_code', 'CASCADE', 'CASCADE');

        $this->forge->createTable('programs');
    }

    public function down()
    {
        $this->forge->dropTable('programs');
    }
}
