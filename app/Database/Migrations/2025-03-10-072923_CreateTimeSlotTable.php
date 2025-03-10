<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTimeSlotTable extends Migration
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
            'start_time' => [
                'type'       => 'TIME',
               'null'     => false,
            ],
            'end_time' => [
                'type'       => 'TIME',
                'null'       => false,
            ],
           'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addPrimaryKey('id');
         $this->forge->createTable('timeslots');
    }

    public function down()
    {
        $this->forge->dropTable('timeslots');
    }
}
