<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table      = 'unit';
    protected $primaryKey = 'idunit';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_unit', 'deleted'];
}
