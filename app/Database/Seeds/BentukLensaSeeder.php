<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BentukLensaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idbentuk_lensa' => 1, 'nama_bentuk' => 'Single Vision (Satu Fokus)'],
            ['idbentuk_lensa' => 2, 'nama_bentuk' => 'Bifocal (Dua Fokus)'],
            ['idbentuk_lensa' => 3, 'nama_bentuk' => 'Progressive (Multifokal)'],
            ['idbentuk_lensa' => 4, 'nama_bentuk' => 'Lensa Baca'],
            ['idbentuk_lensa' => 5, 'nama_bentuk' => 'Lensa Komputer (Anti-Radiasi)'],
            ['idbentuk_lensa' => 6, 'nama_bentuk' => 'Photochromic (Transisi)'],
        ];

        $this->db->table('bentuk_lensa')->insertBatch($data);
    }
}
