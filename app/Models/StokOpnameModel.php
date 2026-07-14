<?php

namespace App\Models;

use CodeIgniter\Model;

class StokOpnameModel extends Model
{
    protected $table      = 'stok_opname';
    protected $primaryKey = 'idopname';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'no_opname',
        'tanggal',
        'keterangan',
        'status',
        'created_at',
        'created_by',
        'selesai_at',
        'selesai_by',
    ];

    /**
     * Generate nomor opname otomatis: OPN-YYYYMMDD-XXXX
     */
    public function generateNomor(): string
    {
        $prefix = 'OPN-' . date('Ymd') . '-';
        $last   = $this->like('no_opname', $prefix, 'after')
            ->orderBy('idopname', 'DESC')
            ->first();

        $seq = 1;
        if ($last) {
            $parts = explode('-', $last['no_opname']);
            $seq   = (int) end($parts) + 1;
        }

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Ambil daftar opname lengkap dengan nama pembuat
     */
    public function getDatatable(int $start, int $length, string $search = ''): array
    {
        $builder = $this->db->table('stok_opname o')
            ->select('o.*, p.nama_pegawai as nama_pembuat')
            ->join('pegawai p', 'p.idpegawai = o.created_by', 'left');

        if ($search !== '') {
            $builder->groupStart()
                ->like('o.no_opname', $search)
                ->orLike('o.keterangan', $search)
                ->groupEnd();
        }

        $total    = (clone $builder)->countAllResults(false);
        $filtered = $total; // sudah include search

        $rows = $builder->orderBy('o.idopname', 'DESC')
            ->limit($length, $start)
            ->get()->getResultArray();

        return compact('total', 'filtered', 'rows');
    }
}
