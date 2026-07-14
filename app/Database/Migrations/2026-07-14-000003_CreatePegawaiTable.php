<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawaiTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'idpegawai'            => ['type' => 'INT', 'auto_increment' => true],
            'kode_pegawai'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_pegawai'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'password'             => ['type' => 'TEXT', 'null' => true],
            'nik_pegawai'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'idprovinsi_pegawai'   => ['type' => 'INT', 'null' => true],
            'idkabupaten_pegawai'  => ['type' => 'INT', 'null' => true],
            'idkecamatan_pegawai'  => ['type' => 'INT', 'null' => true],
            'iddesa_pegawai'       => ['type' => 'INT', 'null' => true],
            'alamat_lengkap'       => ['type' => 'TEXT', 'null' => true],
            'idjabatan'            => ['type' => 'INT', 'null' => true],
            'idunit'               => ['type' => 'INT', 'null' => true],
            'status_aktif'         => ['type' => 'INT', 'null' => true, 'comment' => '0 = aktif, 1 = tidak aktif'],
            'deleted'              => ['type' => 'INT', 'null' => true, 'comment' => '0 = aktif, 1 = dihapus'],
        ]);
        $this->forge->addPrimaryKey('idpegawai');
        $this->forge->createTable('pegawai');
    }

    public function down(): void
    {
        $this->forge->dropTable('pegawai', true);
    }
}
