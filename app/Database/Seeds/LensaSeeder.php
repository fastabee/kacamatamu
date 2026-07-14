<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LensaSeeder extends Seeder
{
    public function run(): void
    {
        // idframe (PK tabel lensa) = alias idlensa
        // idbentuk_lensa: lihat BentukLensaSeeder
        // idbahan_lensa:  lihat BahanLensaSeeder
        $data = [
            ['idframe' => 1, 'nama_lensa' => 'Essilor Single Vision CR-39',    'idbentuk_lensa' => 1, 'idbahan_lensa' => 1, 'harga_beli' => '120000', 'harga_jual' => '250000', 'deleted' => 0],
            ['idframe' => 2, 'nama_lensa' => 'Essilor Progressive Hi-Index',   'idbentuk_lensa' => 3, 'idbahan_lensa' => 4, 'harga_beli' => '800000', 'harga_jual' => '1500000', 'deleted' => 0],
            ['idframe' => 3, 'nama_lensa' => 'Zeiss Polikarbonat Bifocal',     'idbentuk_lensa' => 2, 'idbahan_lensa' => 2, 'harga_beli' => '350000', 'harga_jual' => '700000', 'deleted' => 0],
            ['idframe' => 4, 'nama_lensa' => 'Hoya Anti-Radiasi Komputer',     'idbentuk_lensa' => 5, 'idbahan_lensa' => 1, 'harga_beli' => '200000', 'harga_jual' => '420000', 'deleted' => 0],
            ['idframe' => 5, 'nama_lensa' => 'Transition Photochromic 1.67',   'idbentuk_lensa' => 6, 'idbahan_lensa' => 4, 'harga_beli' => '600000', 'harga_jual' => '1100000', 'deleted' => 0],
            ['idframe' => 6, 'nama_lensa' => 'Lensa Baca CR-39 Standar',       'idbentuk_lensa' => 4, 'idbahan_lensa' => 1, 'harga_beli' => '90000',  'harga_jual' => '180000', 'deleted' => 0],
            ['idframe' => 7, 'nama_lensa' => 'Trivex Single Vision Premium',   'idbentuk_lensa' => 1, 'idbahan_lensa' => 3, 'harga_beli' => '450000', 'harga_jual' => '850000', 'deleted' => 0],
            ['idframe' => 8, 'nama_lensa' => 'Hi-Index 1.74 Ultra Tipis',      'idbentuk_lensa' => 3, 'idbahan_lensa' => 5, 'harga_beli' => '950000', 'harga_jual' => '1800000', 'deleted' => 0],
        ];

        $this->db->table('lensa')->insertBatch($data);
    }
}
