<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // Password: admin123  → bcrypt hash
        $passwordAdmin = '$2a$12$MMPdXIejE0nrIZIbi.jqW.Zz6CwYneBfoQO.ivmCAcY9haQKUDDte';

        $data = [
            [
                'idpegawai'    => 1,
                'kode_pegawai' => 'PGW-001',
                'nama_pegawai' => 'Admin Root',
                'email'        => 'admin@optikku.com',
                'password'     => $passwordAdmin,
                'nik_pegawai'  => '0000000000000000',
                'idjabatan'    => 1,
                'idunit'       => 1,
                'status_aktif' => 0,
                'deleted'      => 0,
            ],
            [
                'idpegawai'    => 2,
                'kode_pegawai' => 'PGW-002',
                'nama_pegawai' => 'Budi Santoso',
                'email'        => 'budi@optikku.com',
                'password'     => $passwordAdmin,
                'nik_pegawai'  => '3201010101010001',
                'idjabatan'    => 3,
                'idunit'       => 1,
                'status_aktif' => 0,
                'deleted'      => 0,
            ],
            [
                'idpegawai'    => 3,
                'kode_pegawai' => 'PGW-003',
                'nama_pegawai' => 'Sari Dewi',
                'email'        => 'sari@optikku.com',
                'password'     => $passwordAdmin,
                'nik_pegawai'  => '3201010101010002',
                'idjabatan'    => 4,
                'idunit'       => 1,
                'status_aktif' => 0,
                'deleted'      => 0,
            ],
        ];

        $this->db->table('pegawai')->insertBatch($data);
    }
}
