<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table      = 'pembelian';
    protected $primaryKey = 'idpembelian';
    protected $returnType = 'array';

    protected $allowedFields = [
        'no_pembelian', 'idsupplier', 'total',
        'keterangan', 'created_at', 'input_by'
    ];

    public function generateNoPembelian(): string
    {
        $today  = date('Ymd');
        $prefix = 'PBL-' . $today . '-';
        $last   = $this->db->table($this->table)
            ->like('no_pembelian', $prefix, 'after')
            ->orderBy('idpembelian', 'DESC')
            ->limit(1)->get()->getRowArray();

        $urut = $last ? (int) substr($last['no_pembelian'], -3) + 1 : 1;
        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }
}
