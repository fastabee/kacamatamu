<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BahanFrameSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idbahan_frame' => 1, 'nama_bahan' => 'Plastik / Asetat'],
            ['idbahan_frame' => 2, 'nama_bahan' => 'Logam / Metal'],
            ['idbahan_frame' => 3, 'nama_bahan' => 'Titanium'],
            ['idbahan_frame' => 4, 'nama_bahan' => 'Stainless Steel'],
            ['idbahan_frame' => 5, 'nama_bahan' => 'Aluminium'],
            ['idbahan_frame' => 6, 'nama_bahan' => 'Karbon'],
            ['idbahan_frame' => 7, 'nama_bahan' => 'Kayu'],
            ['idbahan_frame' => 8, 'nama_bahan' => 'Karet / Silikon'],
        ];

        $this->db->table('bahan_frame')->insertBatch($data);
    }
}
