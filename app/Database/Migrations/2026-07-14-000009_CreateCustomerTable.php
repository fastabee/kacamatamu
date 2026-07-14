<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idcustomer'    => ['type' => 'INT', 'auto_increment' => true],
            'nama_customer' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'no_telepon'    => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idcustomer');
        $this->forge->createTable('customer');
    }

    public function down(): void
    {
        $this->forge->dropTable('customer', true);
    }
}
