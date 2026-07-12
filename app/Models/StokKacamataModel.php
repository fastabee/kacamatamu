<?php

namespace App\Models;

use CodeIgniter\Model;

class StokKacamataModel extends Model
{
    protected $table      = 'stok_kacamata';
    protected $primaryKey = 'idstok_kacamata';
    protected $returnType = 'array';

    protected $allowedFields = ['idkacamata', 'jumlah'];

    public function getByKacamata($idkacamata)
    {
        return $this->where('idkacamata', $idkacamata)->first();
    }

    public function tambahStok($idkacamata, $jumlah)
    {
        $stok = $this->getByKacamata($idkacamata);
        if ($stok) {
            $this->update($stok['idstok_kacamata'], ['jumlah' => $stok['jumlah'] + $jumlah]);
        } else {
            $this->insert(['idkacamata' => $idkacamata, 'jumlah' => $jumlah]);
        }
    }

    public function kurangiStok($idkacamata, $jumlah)
    {
        $stok = $this->getByKacamata($idkacamata);
        if ($stok) {
            $baru = max(0, $stok['jumlah'] - $jumlah);
            $this->update($stok['idstok_kacamata'], ['jumlah' => $baru]);
        }
    }
}
