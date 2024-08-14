<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSearchHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'search_term' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'searched_at' => [
                'type' => 'DATETIME'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('search_history');
    }

    public function down()
    {
        $this->forge->dropTable('search_history');
    }
}
