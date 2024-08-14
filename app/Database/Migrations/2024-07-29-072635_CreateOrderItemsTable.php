<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'order_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'quantity' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
