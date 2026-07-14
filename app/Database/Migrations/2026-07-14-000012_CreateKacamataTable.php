<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKacamataTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idkacamata'    => ['type' => 'INT', 'auto_increment' => true],
            'nama_kacamata' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'idlensa'       => ['type' => 'INT', 'null' => true],
            'idframe'       => ['type' => 'INT', 'null' => true],
            'harga_jual'    => ['type' => 'INT', 'null' => true],
            'harga_beli'    => ['type' => 'INT', 'null' => true],
            'deleted'       => ['type' => 'INT', 'null' => true, 'comment' => '0 ada, 1 dihapus'],
        ]);
        $this->forge->addPrimaryKey('idkacamata');
        $this->forge->createTable('kacamata');
    }

    public function down(): void
    {
        $this->forge->dropTable('kacamata', true);
    }
}
