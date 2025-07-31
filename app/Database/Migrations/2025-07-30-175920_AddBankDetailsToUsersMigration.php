<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBankDetailsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'name_as_per_bank_account' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'full_name', // Optional: Position the column after 'full_name'
            ],
            'pan_card_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'email', // Optional: Position the column after 'email'
            ],
            'bank_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'mobile_number', // Optional: Position the column after 'mobile_number'
            ],
            'bank_account_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'bank_name',
            ],
            'ifsc_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '11',
                'null'       => true,
                'after'      => 'bank_account_no',
            ],
            'aadhaar_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '12',
                'null'       => true,
                'after'      => 'pan_card_no', // Optional: Position the column after 'pan_card_no'
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'name_as_per_bank_account',
            'pan_card_no',
            'bank_name',
            'bank_account_no',
            'ifsc_code',
            'aadhaar_no'
        ]);
    }
}