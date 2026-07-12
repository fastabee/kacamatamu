<?php

namespace App\Models;

use CodeIgniter\Model;

class BentukLensaModel extends Model
{
    protected $table      = 'bentuk_lensa';
    protected $primaryKey = 'idbentuk_lensa';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_bentuk'];
}
