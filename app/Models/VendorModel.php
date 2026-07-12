<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorModel extends Model
{
    protected $table      = 'vendor';
    protected $primaryKey = 'idsupplier';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_supplier', 'deleted'];
}
