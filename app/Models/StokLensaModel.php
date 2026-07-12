<?php

namespace App\Models;

use CodeIgniter\Model;

class StokLensaModel extends Model
{
    protected $table      = 'stok_lensa';
    protected $primaryKey = 'idstok_lensa';
    protected $returnType = 'array';

    protected $allowedFields = ['idlensa', 'jumlah'];

    public function getByLensa($idlensa)
    {
        return $this->where('idlensa', $idlensa)->first();
    }

    public function tambahStok($idlensa, $jumlah)
    {
        $stok = $this->getByLensa($idlensa);
        if ($stok) {
            $this->update($stok['idstok_lensa'], ['jumlah' => $stok['jumlah'] + $jumlah]);
        } else {
            $this->insert(['idlensa' => $idlensa, 'jumlah' => $jumlah]);
        }
    }

    public function kurangiStok($idlensa, $jumlah)
    {
        $stok = $this->getByLensa($idlensa);
        if ($stok) {
            $baru = max(0, $stok['jumlah'] - $jumlah);
            $this->update($stok['idstok_lensa'], ['jumlah' => $baru]);
        }
    }
}
