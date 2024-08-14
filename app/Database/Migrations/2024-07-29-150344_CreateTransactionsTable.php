<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => false
            ],
            'gross_amount' => [
                'type' => 'DOUBLE'
            ],
            'payment_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'transaction_time' => [
                'type' => 'DATETIME'
            ],
            'transaction_status' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
