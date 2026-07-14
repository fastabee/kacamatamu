<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokTables extends Migration
{
    public function up(): void
    {
        // stok_frame
        $this->forge->addField([
            'idstok_frame' => ['type' => 'INT', 'auto_increment' => true],
            'idframe'      => ['type' => 'INT', 'null' => true],
            'jumlah'       => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idstok_frame');
        $this->forge->createTable('stok_frame');

        // stok_lensa
        $this->forge->addField([
            'idstok_lensa' => ['type' => 'INT', 'auto_increment' => true],
            'idlensa'      => ['type' => 'INT', 'null' => true],
            'jumlah'       => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idstok_lensa');
        $this->forge->createTable('stok_lensa');

        // stok_kacamata
        $this->forge->addField([
            'idstok_kacamata' => ['type' => 'INT', 'auto_increment' => true],
            'idkacamata'      => ['type' => 'INT', 'null' => true],
            'jumlah'          => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idstok_kacamata');
        $this->forge->createTable('stok_kacamata');
    }

    public function down(): void
    {
        $this->forge->dropTable('stok_frame', true);
        $this->forge->dropTable('stok_lensa', true);
        $this->forge->dropTable('stok_kacamata', true);
    }
}
