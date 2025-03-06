<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubjectsTable extends Migration
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
            'subject_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'unique'     => true,
            ],
            'subject_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'credit' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['Practical', 'Theory'],
                'null'       => false,
            ],
            'internal_marks' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'external_marks' => [
                'type'       => 'INT',
                'constraint' => 3,
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
        $this->forge->createTable('subjects');
    }

    public function down()
    {
        $this->forge->dropTable('subjects');
    }
}
