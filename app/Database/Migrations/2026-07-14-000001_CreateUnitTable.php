<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUnitTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idunit'     => ['type' => 'INT', 'auto_increment' => true],
            'nama_unit'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idunit');
        $this->forge->createTable('unit');
    }

    public function down(): void
    {
        $this->forge->dropTable('unit', true);
    }
}
