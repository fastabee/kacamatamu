<?php

namespace App\Models;

use CodeIgniter\Model;

class KacamataModel extends Model
{
    protected $table      = 'kacamata';
    protected $primaryKey = 'idkacamata';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_kacamata', 'idlensa', 'idframe',
        'harga_beli', 'harga_jual', 'deleted'
    ];
}
