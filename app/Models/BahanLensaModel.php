<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanLensaModel extends Model
{
    protected $table      = 'bahan_lensa';
    protected $primaryKey = 'idbahan_lensa';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_bahan'];
}
