<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokOpnameTables extends Migration
{
    public function up(): void
    {
        // Header stok opname
        $this->forge->addField([
            'idopname'    => ['type' => 'INT', 'auto_increment' => true],
            'no_opname'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tanggal'     => ['type' => 'DATE', 'null' => false],
            'keterangan'  => ['type' => 'TEXT', 'null' => true],
            // draft = belum diproses, selesai = stok sudah diupdate
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'selesai'],
                'default'    => 'draft',
            ],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'created_by'  => ['type' => 'INT', 'null' => true],
            'selesai_at'  => ['type' => 'DATETIME', 'null' => true],
            'selesai_by'  => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('idopname');
        $this->forge->createTable('stok_opname');

        // Detail per item
        $this->forge->addField([
            'iddetail'      => ['type' => 'INT', 'auto_increment' => true],
            'idopname'      => ['type' => 'INT'],
            'jenis_produk'  => [
                'type'       => 'ENUM',
                'constraint' => ['frame', 'lensa', 'kacamata'],
            ],
            'idproduk'      => ['type' => 'INT'],
            'nama_produk'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'stok_sistem'   => ['type' => 'INT', 'default' => 0, 'comment' => 'Stok di sistem saat opname dibuat'],
            'stok_fisik'    => ['type' => 'INT', 'null' => true, 'comment' => 'Stok hasil hitung fisik'],
            'selisih'       => ['type' => 'INT', 'null' => true, 'comment' => 'stok_fisik - stok_sistem'],
        ]);
        $this->forge->addPrimaryKey('iddetail');
        $this->forge->addKey('idopname');
        $this->forge->createTable('stok_opname_detail');
    }

    public function down(): void
    {
        $this->forge->dropTable('stok_opname_detail', true);
        $this->forge->dropTable('stok_opname', true);
    }
}
