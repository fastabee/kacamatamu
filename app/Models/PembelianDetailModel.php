<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianDetailModel extends Model
{
    protected $table      = 'pembelian_detail';
    protected $primaryKey = 'iddetail';
    protected $returnType = 'array';

    protected $allowedFields = [
        'idpembelian', 'jenis_produk', 'idproduk',
        'nama_produk', 'harga_beli', 'jumlah', 'subtotal'
    ];

    public function getByPembelian($idpembelian)
    {
        return $this->where('idpembelian', $idpembelian)->findAll();
    }
}
