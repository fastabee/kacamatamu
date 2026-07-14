<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KacamataSeeder extends Seeder
{
    public function run(): void
    {
        // idlensa  = idframe di tabel lensa
        // idframe  = idframe di tabel frame
        $data = [
            ['idkacamata' => 1, 'nama_kacamata' => 'Paket Aviator + Single Vision',    'idlensa' => 1, 'idframe' => 1, 'harga_beli' => 470000,  'harga_jual' => 900000,  'deleted' => 0],
            ['idkacamata' => 2, 'nama_kacamata' => 'Paket Wayfarer + Anti-Radiasi',    'idlensa' => 4, 'idframe' => 2, 'harga_beli' => 480000,  'harga_jual' => 940000,  'deleted' => 0],
            ['idkacamata' => 3, 'nama_kacamata' => 'Paket Progressive Titanium',       'idlensa' => 2, 'idframe' => 3, 'harga_beli' => 1300000, 'harga_jual' => 2450000, 'deleted' => 0],
            ['idkacamata' => 4, 'nama_kacamata' => 'Paket Cat-Eye + Photochromic',     'idlensa' => 5, 'idframe' => 5, 'harga_beli' => 900000,  'harga_jual' => 1660000, 'deleted' => 0],
            ['idkacamata' => 5, 'nama_kacamata' => 'Paket Sporty + Lensa Baca',        'idlensa' => 6, 'idframe' => 8, 'harga_beli' => 170000,  'harga_jual' => 355000,  'deleted' => 0],
            ['idkacamata' => 6, 'nama_kacamata' => 'Paket Gucci + Hi-Index 1.74',      'idlensa' => 8, 'idframe' => 6, 'harga_beli' => 1750000, 'harga_jual' => 3300000, 'deleted' => 0],
        ];

        $this->db->table('kacamata')->insertBatch($data);
    }
}
