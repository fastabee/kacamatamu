<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Tandai migration 001-015 sebagai sudah selesai di tabel migrations,
 * karena tabel-tabel tersebut sudah dibuat via import SQL manual.
 *
 * Jalankan SEKALI: php spark db:seed MarkMigrationsSeeder
 * Setelah itu jalankan: php spark migrate
 */
class MarkMigrationsSeeder extends Seeder
{
    public function run(): void
    {
        $migrations = [
            '2026-07-14-000001' => 'App\Database\Migrations\CreateUnitTable',
            '2026-07-14-000002' => 'App\Database\Migrations\CreateJabatanTable',
            '2026-07-14-000003' => 'App\Database\Migrations\CreatePegawaiTable',
            '2026-07-14-000004' => 'App\Database\Migrations\CreateBahanFrameTable',
            '2026-07-14-000005' => 'App\Database\Migrations\CreateBahanLensaTable',
            '2026-07-14-000006' => 'App\Database\Migrations\CreateBentukFrameTable',
            '2026-07-14-000007' => 'App\Database\Migrations\CreateBentukLensaTable',
            '2026-07-14-000008' => 'App\Database\Migrations\CreateVendorTable',
            '2026-07-14-000009' => 'App\Database\Migrations\CreateCustomerTable',
            '2026-07-14-000010' => 'App\Database\Migrations\CreateFrameTable',
            '2026-07-14-000011' => 'App\Database\Migrations\CreateLensaTable',
            '2026-07-14-000012' => 'App\Database\Migrations\CreateKacamataTable',
            '2026-07-14-000013' => 'App\Database\Migrations\CreateStokTables',
            '2026-07-14-000014' => 'App\Database\Migrations\CreateRiwayatStokTables',
            '2026-07-14-000015' => 'App\Database\Migrations\CreateTransaksiTables',
        ];

        $now = time();
        foreach ($migrations as $version => $class) {
            // Cek dulu, jangan insert duplikat
            $exists = $this->db->table('migrations')
                ->where('class', $class)
                ->countAllResults();
            if ($exists) continue;

            $this->db->table('migrations')->insert([
                'version'   => $version,
                'class'     => $class,
                'group'     => 'default',
                'namespace' => 'App',
                'time'      => $now,
                'batch'     => 1,
            ]);
        }

        echo "Migration lama berhasil ditandai.\n";
    }
}
