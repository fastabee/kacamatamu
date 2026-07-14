<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendorTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idsupplier'    => ['type' => 'INT', 'auto_increment' => true],
            'nama_supplier' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'deleted'       => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idsupplier');
        $this->forge->createTable('vendor');
    }

    public function down(): void
    {
        $this->forge->dropTable('vendor', true);
    }
}
