<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatStokTables extends Migration
{
    public function up(): void
    {
        $commonFields = [
            'jenis'        => ['type' => 'ENUM', 'constraint' => ['masuk', 'keluar', 'adjustment']],
            'jumlah'       => ['type' => 'INT'],
            'stok_sebelum' => ['type' => 'INT'],
            'stok_sesudah' => ['type' => 'INT'],
            'keterangan'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'referensi'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'created_by'   => ['type' => 'INT', 'null' => true],
        ];

        // riwayat_stok_frame
        $this->forge->addField(
            array_merge(
                ['idriwayat' => ['type' => 'INT', 'auto_increment' => true]],
                ['idframe'   => ['type' => 'INT']],
                $commonFields
            )
        );
        $this->forge->addPrimaryKey('idriwayat');
        $this->forge->addKey('idframe');
        $this->forge->createTable('riwayat_stok_frame');

        // riwayat_stok_lensa
        $this->forge->addField(
            array_merge(
                ['idriwayat' => ['type' => 'INT', 'auto_increment' => true]],
                ['idlensa'   => ['type' => 'INT']],
                $commonFields
            )
        );
        $this->forge->addPrimaryKey('idriwayat');
        $this->forge->addKey('idlensa');
        $this->forge->createTable('riwayat_stok_lensa');

        // riwayat_stok_kacamata
        $this->forge->addField(
            array_merge(
                ['idriwayat'  => ['type' => 'INT', 'auto_increment' => true]],
                ['idkacamata' => ['type' => 'INT']],
                $commonFields
            )
        );
        $this->forge->addPrimaryKey('idriwayat');
        $this->forge->addKey('idkacamata');
        $this->forge->createTable('riwayat_stok_kacamata');
    }

    public function down(): void
    {
        $this->forge->dropTable('riwayat_stok_frame', true);
        $this->forge->dropTable('riwayat_stok_lensa', true);
        $this->forge->dropTable('riwayat_stok_kacamata', true);
    }
}
