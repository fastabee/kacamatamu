<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'idcustomer';
    protected $returnType = 'array';

    protected $allowedFields = ['nama_customer', 'no_telepon', 'created_at'];
}
