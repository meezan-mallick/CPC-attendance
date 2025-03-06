<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCollegesTable extends Migration
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
                'unique'     => true,
            ],
            'college_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('colleges');
    }

    public function down()
    {
        $this->forge->dropTable('colleges');
    }
}
