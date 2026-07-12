<?php

namespace App\Models;

use CodeIgniter\Model;

class LensaModel extends Model
{
    protected $table      = 'lensa';
    protected $primaryKey = 'idframe';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_lensa', 'idbentuk_lensa', 'idbahan_lensa',
        'harga_beli', 'harga_jual', 'deleted'
    ];

    public function getAll()
    {
        return $this->db->table('lensa l')
            ->select('l.*, b.nama_bentuk, bh.nama_bahan')
            ->join('bentuk_lensa b', 'b.idbentuk_lensa = l.idbentuk_lensa', 'left')
            ->join('bahan_lensa bh', 'bh.idbahan_lensa = l.idbahan_lensa', 'left')
            ->where('l.deleted', 0)
            ->get()->getResultArray();
    }

    public function getDatatable()
    {
        return $this->db->table('lensa l')
            ->select('l.idframe, l.nama_lensa, b.nama_bentuk, bh.nama_bahan, l.harga_beli, l.harga_jual')
            ->join('bentuk_lensa b', 'b.idbentuk_lensa = l.idbentuk_lensa', 'left')
            ->join('bahan_lensa bh', 'bh.idbahan_lensa = l.idbahan_lensa', 'left')
            ->where('l.deleted', 0)
            ->get()->getResultArray();
    }
}
