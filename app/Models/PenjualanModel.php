<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table      = 'penjualan';
    protected $primaryKey = 'idpenjualan';
    protected $returnType = 'array';

    protected $allowedFields = [
        'no_transaksi', 'idcustomer', 'total',
        'diskon', 'grand_total', 'keterangan',
        'created_at', 'input_by'
    ];

    public function generateNoTransaksi(): string
    {
        $today  = date('Ymd');
        $prefix = 'TRJ-' . $today . '-';
        $last   = $this->db->table($this->table)
            ->like('no_transaksi', $prefix, 'after')
            ->orderBy('idpenjualan', 'DESC')
            ->limit(1)->get()->getRowArray();

        $urut = $last ? (int) substr($last['no_transaksi'], -3) + 1 : 1;
        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }
}
