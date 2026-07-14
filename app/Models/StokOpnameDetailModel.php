<?php

namespace App\Models;

use CodeIgniter\Model;

class StokOpnameDetailModel extends Model
{
    protected $table      = 'stok_opname_detail';
    protected $primaryKey = 'iddetail';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'idopname',
        'jenis_produk',
        'idproduk',
        'nama_produk',
        'stok_sistem',
        'stok_fisik',
        'selisih',
    ];

    /**
     * Ambil semua detail satu opname beserta nama produk dari tabel asalnya
     */
    public function getByOpname(int $idopname): array
    {
        return $this->where('idopname', $idopname)
            ->orderBy('jenis_produk')
            ->orderBy('iddetail')
            ->findAll();
    }

    /**
     * Bulk-insert detail dari array produk yang dipilih
     * $items = [['jenis'=>'frame','idproduk'=>1,'nama'=>'...','stok_sistem'=>5], ...]
     */
    public function insertBulk(int $idopname, array $items): void
    {
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                'idopname'    => $idopname,
                'jenis_produk' => $item['jenis'],
                'idproduk'    => $item['idproduk'],
                'nama_produk' => $item['nama'],
                'stok_sistem' => $item['stok_sistem'],
                'stok_fisik'  => null,
                'selisih'     => null,
            ];
        }
        if ($rows) {
            $this->insertBatch($rows);
        }
    }

    /**
     * Update stok_fisik & selisih sekaligus untuk satu idopname
     * $inputs = [iddetail => stok_fisik, ...]
     */
    public function updateFisik(int $idopname, array $inputs): void
    {
        foreach ($inputs as $iddetail => $stokFisik) {
            $detail = $this->find((int) $iddetail);
            if (!$detail || (int) $detail['idopname'] !== $idopname) continue;

            $stokFisik = (int) $stokFisik;
            $this->update((int) $iddetail, [
                'stok_fisik' => $stokFisik,
                'selisih'    => $stokFisik - (int) $detail['stok_sistem'],
            ]);
        }
    }
}
