<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanFrameModel extends Model
{
    protected $table      = 'bahan_frame';
    protected $primaryKey = 'idbahan_frame';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_bahan'];
}
