<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatStokKacamataModel extends Model
{
    protected $table      = 'riwayat_stok_kacamata';
    protected $primaryKey = 'idriwayat';
    protected $returnType = 'array';

    protected $useTimestamps = false;

    protected $allowedFields = [
        'idkacamata', 'jenis', 'jumlah',
        'stok_sebelum', 'stok_sesudah',
        'keterangan', 'referensi',
        'created_at', 'created_by'
    ];

    public function catat($idkacamata, $jenis, $jumlah, $stokSebelum, $stokSesudah, $keterangan = null, $referensi = null)
    {
        return $this->insert([
            'idkacamata'   => $idkacamata,
            'jenis'        => $jenis,
            'jumlah'       => $jumlah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'keterangan'   => $keterangan,
            'referensi'    => $referensi,
            'created_at'   => date('Y-m-d H:i:s'),
            'created_by'   => session('idpegawai'),
        ]);
    }
}
