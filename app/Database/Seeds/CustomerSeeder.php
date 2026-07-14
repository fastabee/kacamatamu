<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['idcustomer' => 1, 'nama_customer' => 'Ahmad Fauzi',    'no_telepon' => '081234567890', 'created_at' => '2026-01-05 09:00:00'],
            ['idcustomer' => 2, 'nama_customer' => 'Rina Marlina',   'no_telepon' => '082345678901', 'created_at' => '2026-01-10 10:30:00'],
            ['idcustomer' => 3, 'nama_customer' => 'Hendra Gunawan', 'no_telepon' => '083456789012', 'created_at' => '2026-02-03 08:15:00'],
            ['idcustomer' => 4, 'nama_customer' => 'Siti Aisyah',    'no_telepon' => '084567890123', 'created_at' => '2026-02-20 14:00:00'],
            ['idcustomer' => 5, 'nama_customer' => 'Deni Kusuma',    'no_telepon' => '085678901234', 'created_at' => '2026-03-01 11:45:00'],
        ];

        $this->db->table('customer')->insertBatch($data);
    }
}
