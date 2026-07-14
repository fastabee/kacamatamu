<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        $db = \Config\Database::connect();

        // Nonaktifkan foreign key check agar TRUNCATE aman
        $db->query('SET FOREIGN_KEY_CHECKS = 0');

        // Truncate semua tabel terlebih dahulu (urutan terbalik dari dependensi)
        $tables = [
            'stok_kacamata',
            'stok_lensa',
            'stok_frame',
            'riwayat_stok_kacamata',
            'riwayat_stok_lensa',
            'riwayat_stok_frame',
            'kacamata',
            'lensa',
            'frame',
            'customer',
            'vendor',
            'bentuk_lensa',
            'bentuk_frame',
            'bahan_lensa',
            'bahan_frame',
            'pegawai',
            'jabatan',
            'unit',
        ];
        foreach ($tables as $table) {
            $db->query("TRUNCATE TABLE `{$table}`");
        }

        $db->query('SET FOREIGN_KEY_CHECKS = 1');

        // Urutan penting: master dulu, lalu produk, lalu transaksi
        $this->call('UnitSeeder');
        $this->call('JabatanSeeder');
        $this->call('PegawaiSeeder');
        $this->call('BahanFrameSeeder');
        $this->call('BahanLensaSeeder');
        $this->call('BentukFrameSeeder');
        $this->call('BentukLensaSeeder');
        $this->call('VendorSeeder');
        $this->call('CustomerSeeder');
        $this->call('FrameSeeder');
        $this->call('LensaSeeder');
        $this->call('KacamataSeeder');
        $this->call('StokSeeder');
    }
}
