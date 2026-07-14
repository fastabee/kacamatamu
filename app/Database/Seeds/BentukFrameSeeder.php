<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BentukFrameSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idbentuk_frame' => 1, 'nama_bentuk' => 'Aviator'],
            ['idbentuk_frame' => 2, 'nama_bentuk' => 'Wayfarer'],
            ['idbentuk_frame' => 3, 'nama_bentuk' => 'Bulat (Round)'],
            ['idbentuk_frame' => 4, 'nama_bentuk' => 'Oval'],
            ['idbentuk_frame' => 5, 'nama_bentuk' => 'Persegi (Square)'],
            ['idbentuk_frame' => 6, 'nama_bentuk' => 'Persegi Panjang (Rectangle)'],
            ['idbentuk_frame' => 7, 'nama_bentuk' => 'Cat-Eye'],
            ['idbentuk_frame' => 8, 'nama_bentuk' => 'Clubmaster'],
            ['idbentuk_frame' => 9, 'nama_bentuk' => 'Rimless'],
        ];

        $this->db->table('bentuk_frame')->insertBatch($data);
    }
}
