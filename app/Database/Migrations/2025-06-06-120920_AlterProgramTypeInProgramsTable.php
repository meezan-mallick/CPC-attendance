<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterProgramTypeInProgramsTable extends Migration
{
    public function up()
    {
        // Modify program_type from BOOLEAN to VARCHAR(20)
        $fields = [
            'program_type' => [
                'name'       => 'program_type',
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'comment'    => 'Program type: integrated, masters, bachelor, honours',
            ],
        ];
        $this->forge->modifyColumn('programs', $fields);

        // Update existing data to new string-based types
        $this->db->query("UPDATE programs SET program_type = 'masters' WHERE program_type = '0'");
        $this->db->query("UPDATE programs SET program_type = 'integrated' WHERE program_type = '1'");

        // Set semester count based on program_type
        $this->db->query("UPDATE programs SET total_semesters = 10 WHERE program_type = 'integrated'");
        $this->db->query("UPDATE programs SET total_semesters = 4 WHERE program_type = 'masters'");
        $this->db->query("UPDATE programs SET total_semesters = 6 WHERE program_type = 'bachelor'");
        $this->db->query("UPDATE programs SET total_semesters = 8 WHERE program_type = 'honours'");
    }

    public function down()
    {
        // Revert program_type back to BOOLEAN
        $fields = [
            'program_type' => [
                'name'       => 'program_type',
                'type'       => 'BOOLEAN',
                'null'       => false,
                'comment'    => 'True = Integrated, False = Masters',
            ],
        ];
        $this->forge->modifyColumn('programs', $fields);
    }
}
