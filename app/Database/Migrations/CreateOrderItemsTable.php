<?
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
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
            'order_id' => [
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
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
