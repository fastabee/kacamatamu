<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table      = 'penjualan_detail';
    protected $primaryKey = 'iddetail';
    protected $returnType = 'array';

    protected $allowedFields = [
        'idpenjualan', 'jenis_produk', 'idproduk',
        'nama_produk', 'harga_jual', 'jumlah', 'subtotal'
    ];

    public function getByPenjualan($idpenjualan)
    {
        return $this->where('idpenjualan', $idpenjualan)->findAll();
    }
}
