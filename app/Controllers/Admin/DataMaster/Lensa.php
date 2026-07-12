<?php

namespace App\Controllers\Admin\DataMaster;

use App\Controllers\BaseController;
use App\Models\LensaModel;
use App\Models\BentukLensaModel;
use App\Models\BahanLensaModel;

class Lensa extends BaseController
{
    protected $lensaModel;
    protected $bentukModel;
    protected $bahanModel;

    public function __construct()
    {
        $this->lensaModel  = new LensaModel();
        $this->bentukModel = new BentukLensaModel();
        $this->bahanModel  = new BahanLensaModel();
    }

    public function index()
    {
        $data = [
            'body'        => 'Admin/DataMaster/lensa',
            'bentuk_list' => $this->bentukModel->findAll(),
            'bahan_list'  => $this->bahanModel->findAll(),
        ];
        return view('template', $data);
    }

    // Datatable server-side
    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db = \Config\Database::connect();
        $builder = $db->table('lensa l')
            ->select('l.idframe, l.nama_lensa, b.nama_bentuk, bh.nama_bahan, l.harga_beli, l.harga_jual')
            ->join('bentuk_lensa b', 'b.idbentuk_lensa = l.idbentuk_lensa', 'left')
            ->join('bahan_lensa bh', 'bh.idbahan_lensa = l.idbahan_lensa', 'left')
            ->where('l.deleted', 0);

        $totalRecords = (clone $builder)->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('l.nama_lensa', $search)
                ->orLike('b.nama_bentuk', $search)
                ->orLike('bh.nama_bahan', $search)
                ->groupEnd();
        }

        $totalFiltered = (clone $builder)->countAllResults(false);

        $rows = $builder->limit($length, $start)->get()->getResultArray();

        $data = [];
        $no = $start + 1;
        foreach ($rows as $row) {
            $data[] = [
                'no'          => $no++,
                'nama_lensa'  => esc($row['nama_lensa']),
                'nama_bentuk' => esc($row['nama_bentuk'] ?? '-'),
                'nama_bahan'  => esc($row['nama_bahan'] ?? '-'),
                'harga_beli'  => 'Rp ' . number_format($row['harga_beli'], 0, ',', '.'),
                'harga_jual'  => 'Rp ' . number_format($row['harga_jual'], 0, ',', '.'),
                'aksi'        => '
                    <button class="btn btn-sm btn-warning btn-edit"
                        data-id="' . $row['idframe'] . '"
                        data-nama="' . esc($row['nama_lensa']) . '">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row['idframe'] . '">
                        <i class="ti ti-trash"></i>
                    </button>',
            ];
        }

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data,
        ]);
    }

    // Get data lensa by ID untuk edit
    public function getById($id)
    {
        $lensa = $this->lensaModel->find($id);
        if (!$lensa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $lensa]);
    }

    public function store()
    {
        $data = [
            'nama_lensa'      => $this->request->getPost('nama_lensa'),
            'idbentuk_lensa'  => $this->request->getPost('idbentuk_lensa'),
            'idbahan_lensa'   => $this->request->getPost('idbahan_lensa'),
            'harga_beli'      => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'      => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
            'deleted'         => 0,
        ];

        $this->lensaModel->insert($data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil disimpan']);
    }

    public function update($id)
    {
        $data = [
            'nama_lensa'      => $this->request->getPost('nama_lensa'),
            'idbentuk_lensa'  => $this->request->getPost('idbentuk_lensa'),
            'idbahan_lensa'   => $this->request->getPost('idbahan_lensa'),
            'harga_beli'      => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'      => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
        ];

        $this->lensaModel->update($id, $data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil diupdate']);
    }

    public function delete($id)
    {
        $this->lensaModel->update($id, ['deleted' => 1]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil dihapus']);
    }

    // Tambah bentuk lensa inline
    public function storeBentuk()
    {
        $nama = trim($this->request->getPost('nama_bentuk'));
        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama bentuk tidak boleh kosong']);
        }
        $id = $this->bentukModel->insert(['nama_bentuk' => $nama], true);
        return $this->response->setJSON(['status' => 'ok', 'id' => $id, 'nama' => $nama]);
    }

    // Tambah bahan lensa inline
    public function storeBahan()
    {
        $nama = trim($this->request->getPost('nama_bahan'));
        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama bahan tidak boleh kosong']);
        }
        $id = $this->bahanModel->insert(['nama_bahan' => $nama], true);
        return $this->response->setJSON(['status' => 'ok', 'id' => $id, 'nama' => $nama]);
    }
}
