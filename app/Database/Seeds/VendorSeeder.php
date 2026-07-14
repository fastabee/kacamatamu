<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idsupplier' => 1, 'nama_supplier' => 'PT. Optik Nusantara',       'deleted' => 0],
            ['idsupplier' => 2, 'nama_supplier' => 'CV. Lensa Prima',           'deleted' => 0],
            ['idsupplier' => 3, 'nama_supplier' => 'PT. Frame Internasional',   'deleted' => 0],
            ['idsupplier' => 4, 'nama_supplier' => 'UD. Kacamata Jaya',         'deleted' => 0],
            ['idsupplier' => 5, 'nama_supplier' => 'PT. Essilor Indonesia',     'deleted' => 0],
        ];

        $this->db->table('vendor')->insertBatch($data);
    }
}
