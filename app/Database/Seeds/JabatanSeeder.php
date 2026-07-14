<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idjabatan' => 1, 'nama_jabatan' => 'admin_root',  'deleted' => 0],
            ['idjabatan' => 2, 'nama_jabatan' => 'Admin',       'deleted' => 0],
            ['idjabatan' => 3, 'nama_jabatan' => 'Kasir',       'deleted' => 0],
            ['idjabatan' => 4, 'nama_jabatan' => 'Optometrist', 'deleted' => 0],
            ['idjabatan' => 5, 'nama_jabatan' => 'Gudang',      'deleted' => 0],
        ];

        $this->db->table('jabatan')->insertBatch($data);
    }
}
