<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTopicTable extends Migration
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
            'topic' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'date' => [
                'type'       => 'DATE',
                'null'       => false,
            ],
            'time' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'batch' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'subject_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('topics');
    }

    public function down()
    {
        $this->forge->dropTable('topics');
    }
}
