<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTables extends Migration
{
    public function up(): void
    {
        // pembelian
        $this->forge->addField([
            'idpembelian'  => ['type' => 'INT', 'auto_increment' => true],
            'no_pembelian' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'idsupplier'   => ['type' => 'INT', 'null' => true],
            'total'        => ['type' => 'BIGINT', 'default' => 0],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'],
            'input_by'     => ['type' => 'INT', 'default' => 0, 'comment' => 'id pegawai'],
        ]);
        $this->forge->addPrimaryKey('idpembelian');
        $this->forge->createTable('pembelian');

        // pembelian_detail
        $this->forge->addField([
            'iddetail'    => ['type' => 'INT', 'auto_increment' => true],
            'idpembelian' => ['type' => 'INT'],
            'jenis_produk' => ['type' => 'ENUM', 'constraint' => ['kacamata', 'lensa', 'frame', 'aksesoris']],
            'idproduk'    => ['type' => 'INT'],
            'nama_produk' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'harga_beli'  => ['type' => 'BIGINT', 'default' => 0],
            'jumlah'      => ['type' => 'INT', 'default' => 1],
            'subtotal'    => ['type' => 'BIGINT', 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('iddetail');
        $this->forge->addKey('idpembelian');
        $this->forge->createTable('pembelian_detail');

        // penjualan
        $this->forge->addField([
            'idpenjualan'  => ['type' => 'INT', 'auto_increment' => true],
            'no_transaksi' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'idcustomer'   => ['type' => 'INT', 'null' => true],
            'total'        => ['type' => 'BIGINT', 'default' => 0],
            'diskon'       => ['type' => 'BIGINT', 'default' => 0],
            'grand_total'  => ['type' => 'BIGINT', 'default' => 0],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'],
            'input_by'     => ['type' => 'INT', 'default' => 0, 'comment' => 'idpegawai'],
        ]);
        $this->forge->addPrimaryKey('idpenjualan');
        $this->forge->createTable('penjualan');

        // penjualan_detail
        $this->forge->addField([
            'iddetail'    => ['type' => 'INT', 'auto_increment' => true],
            'idpenjualan' => ['type' => 'INT'],
            'jenis_produk' => ['type' => 'ENUM', 'constraint' => ['kacamata', 'lensa', 'frame', 'aksesoris']],
            'idproduk'    => ['type' => 'INT'],
            'nama_produk' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'harga_jual'  => ['type' => 'BIGINT', 'default' => 0],
            'jumlah'      => ['type' => 'INT', 'default' => 1],
            'subtotal'    => ['type' => 'BIGINT', 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('iddetail');
        $this->forge->addKey('idpenjualan');
        $this->forge->createTable('penjualan_detail');
    }

    public function down(): void
    {
        $this->forge->dropTable('pembelian_detail', true);
        $this->forge->dropTable('pembelian', true);
        $this->forge->dropTable('penjualan_detail', true);
        $this->forge->dropTable('penjualan', true);
    }
}
