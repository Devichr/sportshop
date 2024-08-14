<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 3
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cart');
    }

    public function down()
    {
        $this->forge->dropTable('cart');
    }
}
