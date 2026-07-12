<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'idpegawai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_pegawai',
        'nama_pegawai',
        'email',
        'password',
        'nik_pegawai',
        'idprovinsi_pegawai',
        'idkabupaten_pegawai',
        'idkecamatan_pegawai',
        'iddesa_pegawai',
        'alamat_lengkap',
        'idjabatan',
        'idunit',
        'status_aktif',
        'deleted'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_pegawai' => 'required|max_length[255]',
        'nik_pegawai'  => 'permit_empty|max_length[255]',
        'kode_pegawai' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages   = [
        'nama_pegawai' => [
            'required' => 'Nama pegawai harus diisi',
            'max_length' => 'Nama pegawai maksimal 255 karakter'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get pegawai aktif (tidak deleted)
     */
    public function getPegawaiAktif()
    {
        return $this->where('deleted', 0)
                    ->where('status_aktif', 0)
                    ->findAll();
    }

    /**
     * Get pegawai by ID dengan validasi
     */
    public function getPegawaiById($id)
    {
        return $this->where('idpegawai', $id)
                    ->where('deleted', 0)
                    ->first();
    }

    /**
     * Cari pegawai berdasarkan email beserta data jabatan & unit (untuk login)
     */
    public function findByEmailWithRelations(string $email)
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, j.nama_jabatan, u.nama_unit')
            ->join('jabatan j', 'j.idjabatan = p.idjabatan', 'left')
            ->join('unit u', 'u.idunit = p.idunit', 'left')
            ->where('p.email', $email)
            ->where('p.deleted', 0)
            ->get()
            ->getRowArray();
    }

    /**
     * Cari pegawai berdasarkan email untuk keperluan login
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)
                    ->where('deleted', 0)
                    ->first();
    }

    /**
     * Soft delete pegawai
     */
    public function softDelete($id)
    {
        return $this->update($id, ['deleted' => 1]);
    }

    /**
     * Get pegawai dengan join relasi (provinsi, kabupaten, dll)
     */
    public function getPegawaiWithRelations($id = null)
    {
        $builder = $this->db->table($this->table);
        
        if ($id !== null) {
            $builder->where($this->table . '.idpegawai', $id);
        }
        
        $builder->where($this->table . '.deleted', 0);
        
        return $id !== null ? $builder->get()->getRowArray() : $builder->get()->getResultArray();
    }
}
