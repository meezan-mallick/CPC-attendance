<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubjectsTable extends Migration
{
    public function up()
    {
        // ✅ Drop the table if it exists (Clean start)
        $this->forge->dropTable('subjects', true);

        // ✅ Define the new `subjects` table structure
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'program_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'semester_number' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
            ],
            'subject_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'subject_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'credit' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['Practical', 'Theory'],
                'default'    => 'Theory',
            ],
            'internal_marks' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
            ],
            'external_marks' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
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

        // ✅ Define Primary Key
        $this->forge->addPrimaryKey('id');

        // ✅ Add Unique Constraint for `subject_code` Per `program_id`
        $this->forge->addUniqueKey(['program_id', 'subject_code'], 'unique_subject_per_program');

        // ✅ Create the Table
        $this->forge->createTable('subjects');
    }

    public function down()
    {
        // ✅ Drop the `subjects` table when rolling back migrations
        $this->forge->dropTable('subjects', true);
    }
}
