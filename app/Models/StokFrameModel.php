<?php

namespace App\Models;

use CodeIgniter\Model;

class StokFrameModel extends Model
{
    protected $table      = 'stok_frame';
    protected $primaryKey = 'idstok_frame';
    protected $returnType = 'array';

    protected $allowedFields = ['idframe', 'jumlah'];

    public function getByFrame($idframe)
    {
        return $this->where('idframe', $idframe)->first();
    }

    public function tambahStok($idframe, $jumlah)
    {
        $stok = $this->getByFrame($idframe);
        if ($stok) {
            $this->update($stok['idstok_frame'], ['jumlah' => $stok['jumlah'] + $jumlah]);
        } else {
            $this->insert(['idframe' => $idframe, 'jumlah' => $jumlah]);
        }
    }

    public function kurangiStok($idframe, $jumlah)
    {
        $stok = $this->getByFrame($idframe);
        if ($stok) {
            $baru = max(0, $stok['jumlah'] - $jumlah);
            $this->update($stok['idstok_frame'], ['jumlah' => $baru]);
        }
    }
}
