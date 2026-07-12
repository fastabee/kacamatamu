<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatStokLensaModel extends Model
{
    protected $table      = 'riwayat_stok_lensa';
    protected $primaryKey = 'idriwayat';
    protected $returnType = 'array';

    protected $useTimestamps = false;

    protected $allowedFields = [
        'idlensa', 'jenis', 'jumlah',
        'stok_sebelum', 'stok_sesudah',
        'keterangan', 'referensi',
        'created_at', 'created_by'
    ];

    public function catat($idlensa, $jenis, $jumlah, $stokSebelum, $stokSesudah, $keterangan = null, $referensi = null)
    {
        return $this->insert([
            'idlensa'      => $idlensa,
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
