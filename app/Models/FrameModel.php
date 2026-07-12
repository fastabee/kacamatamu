<?php

namespace App\Models;

use CodeIgniter\Model;

class FrameModel extends Model
{
    protected $table      = 'frame';
    protected $primaryKey = 'idframe';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_frame', 'idbentuk_frame', 'idbahan_frame',
        'harga_beli', 'harga_jual'
    ];
}
