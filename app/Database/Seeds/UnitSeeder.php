<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idunit' => 1, 'nama_unit' => 'Pusat'],
            ['idunit' => 2, 'nama_unit' => 'Cabang Utara'],
            ['idunit' => 3, 'nama_unit' => 'Cabang Selatan'],
        ];

        $this->db->table('unit')->insertBatch($data);
    }
}
