<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FrameSeeder extends Seeder
{
    public function run(): void
    {
        // idbentuk_frame: lihat BentukFrameSeeder
        // idbahan_frame:  lihat BahanFrameSeeder
        $data = [
            ['idframe' => 1, 'nama_frame' => 'Ray-Ban Aviator Classic',   'idbentuk_frame' => 1, 'idbahan_frame' => 2, 'harga_beli' => 350000,  'harga_jual' => 650000],
            ['idframe' => 2, 'nama_frame' => 'Oakley Wayfarer Pro',       'idbentuk_frame' => 2, 'idbahan_frame' => 1, 'harga_beli' => 280000,  'harga_jual' => 520000],
            ['idframe' => 3, 'nama_frame' => 'Police Round Titanium',     'idbentuk_frame' => 3, 'idbahan_frame' => 3, 'harga_beli' => 500000,  'harga_jual' => 950000],
            ['idframe' => 4, 'nama_frame' => 'Silhouette Rimless Silver', 'idbentuk_frame' => 9, 'idbahan_frame' => 4, 'harga_beli' => 420000,  'harga_jual' => 780000],
            ['idframe' => 5, 'nama_frame' => 'Fossil Cat-Eye Rose Gold',  'idbentuk_frame' => 7, 'idbahan_frame' => 2, 'harga_beli' => 300000,  'harga_jual' => 560000],
            ['idframe' => 6, 'nama_frame' => 'Gucci Square Gold',         'idbentuk_frame' => 5, 'idbahan_frame' => 2, 'harga_beli' => 800000,  'harga_jual' => 1500000],
            ['idframe' => 7, 'nama_frame' => 'Prada Oval Classic',        'idbentuk_frame' => 4, 'idbahan_frame' => 1, 'harga_beli' => 700000,  'harga_jual' => 1300000],
            ['idframe' => 8, 'nama_frame' => 'Kacamata Lokal Sporty',     'idbentuk_frame' => 2, 'idbahan_frame' => 8, 'harga_beli' => 80000,   'harga_jual' => 175000],
        ];

        $this->db->table('frame')->insertBatch($data);
    }
}
