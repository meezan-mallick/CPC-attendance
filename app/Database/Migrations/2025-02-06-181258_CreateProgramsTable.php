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
                'type'       => 'ENUM',
                'constraint' => ['2 Years', '5 Years'],
                'null'       => false,
            ],
            'program_type' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'comment'    => 'True = Integrated, False = Masters',
            ],
            'total_semesters' => [ // 🔹 New column for storing semester count
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

        $this->forge->addForeignKey('college_code', 'colleges', 'college_code', 'CASCADE', 'CASCADE');

        $this->forge->createTable('programs');
    }

    public function down()
    {
        $this->forge->dropTable('programs');
    }
}
