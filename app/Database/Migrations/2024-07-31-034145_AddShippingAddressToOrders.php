<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShippingAddressToOrders extends Migration
{
    public function up()
{
    $this->forge->addColumn('orders', [
        'shipping_address' => [
            'type' => 'TEXT',
            'null' => true,
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('orders', 'shipping_address');
}
}
