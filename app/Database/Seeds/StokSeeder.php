<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        // Stok awal frame
        $stokFrame = [];
        for ($i = 1; $i <= 8; $i++) {
            $stokFrame[] = ['idframe' => $i, 'jumlah' => rand(5, 20)];
        }
        $this->db->table('stok_frame')->insertBatch($stokFrame);

        // Stok awal lensa
        $stokLensa = [];
        for ($i = 1; $i <= 8; $i++) {
            $stokLensa[] = ['idlensa' => $i, 'jumlah' => rand(5, 15)];
        }
        $this->db->table('stok_lensa')->insertBatch($stokLensa);

        // Stok awal kacamata
        $stokKacamata = [];
        for ($i = 1; $i <= 6; $i++) {
            $stokKacamata[] = ['idkacamata' => $i, 'jumlah' => rand(3, 10)];
        }
        $this->db->table('stok_kacamata')->insertBatch($stokKacamata);
    }
}
