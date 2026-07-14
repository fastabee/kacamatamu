<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BahanLensaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idbahan_lensa' => 1, 'nama_bahan' => 'CR-39 (Plastik Standar)'],
            ['idbahan_lensa' => 2, 'nama_bahan' => 'Polikarbonat'],
            ['idbahan_lensa' => 3, 'nama_bahan' => 'Trivex'],
            ['idbahan_lensa' => 4, 'nama_bahan' => 'Hi-Index 1.67'],
            ['idbahan_lensa' => 5, 'nama_bahan' => 'Hi-Index 1.74'],
            ['idbahan_lensa' => 6, 'nama_bahan' => 'Kaca Mineral'],
        ];

        $this->db->table('bahan_lensa')->insertBatch($data);
    }
}
