<?php

namespace App\Models;

use CodeIgniter\Model;

class BentukFrameModel extends Model
{
    protected $table      = 'bentuk_frame';
    protected $primaryKey = 'idbentuk_frame';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_bentuk'];
}
