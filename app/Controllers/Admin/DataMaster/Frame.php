<?php

namespace App\Controllers\Admin\DataMaster;

use App\Controllers\BaseController;
use App\Models\FrameModel;
use App\Models\BentukFrameModel;
use App\Models\BahanFrameModel;

class Frame extends BaseController
{
    protected $frameModel;
    protected $bentukModel;
    protected $bahanModel;

    public function __construct()
    {
        $this->frameModel  = new FrameModel();
        $this->bentukModel = new BentukFrameModel();
        $this->bahanModel  = new BahanFrameModel();
    }

    public function index()
    {
        $data = [
            'body'        => 'Admin/DataMaster/frame',
            'bentuk_list' => $this->bentukModel->findAll(),
            'bahan_list'  => $this->bahanModel->findAll(),
        ];
        return view('template', $data);
    }

    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('frame f')
            ->select('f.idframe, f.nama_frame, b.nama_bentuk, bh.nama_bahan, f.harga_beli, f.harga_jual')
            ->join('bentuk_frame b', 'b.idbentuk_frame = f.idbentuk_frame', 'left')
            ->join('bahan_frame bh', 'bh.idbahan_frame = f.idbahan_frame', 'left');

        $totalRecords = (clone $builder)->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('f.nama_frame', $search)
                ->orLike('b.nama_bentuk', $search)
                ->orLike('bh.nama_bahan', $search)
                ->groupEnd();
        }

        $totalFiltered = (clone $builder)->countAllResults(false);
        $rows          = $builder->limit($length, $start)->get()->getResultArray();

        $data = [];
        $no   = $start + 1;
        foreach ($rows as $row) {
            $data[] = [
                'no'          => $no++,
                'nama_frame'  => esc($row['nama_frame']),
                'nama_bentuk' => esc($row['nama_bentuk'] ?? '-'),
                'nama_bahan'  => esc($row['nama_bahan'] ?? '-'),
                'harga_beli'  => 'Rp ' . number_format($row['harga_beli'], 0, ',', '.'),
                'harga_jual'  => 'Rp ' . number_format($row['harga_jual'], 0, ',', '.'),
                'aksi'        => '
                    <button class="btn btn-sm btn-warning btn-edit" data-id="' . $row['idframe'] . '">
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

    public function getById($id)
    {
        $frame = $this->frameModel->find($id);
        if (!$frame) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $frame]);
    }

    public function store()
    {
        $data = [
            'nama_frame'     => $this->request->getPost('nama_frame'),
            'idbentuk_frame' => $this->request->getPost('idbentuk_frame'),
            'idbahan_frame'  => $this->request->getPost('idbahan_frame'),
            'harga_beli'     => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'     => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
        ];

        $this->frameModel->insert($data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil disimpan']);
    }

    public function update($id)
    {
        $data = [
            'nama_frame'     => $this->request->getPost('nama_frame'),
            'idbentuk_frame' => $this->request->getPost('idbentuk_frame'),
            'idbahan_frame'  => $this->request->getPost('idbahan_frame'),
            'harga_beli'     => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'     => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
        ];

        $this->frameModel->update($id, $data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil diupdate']);
    }

    public function delete($id)
    {
        $this->frameModel->delete($id);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil dihapus']);
    }

    public function storeBentuk()
    {
        $nama = trim($this->request->getPost('nama_bentuk'));
        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama bentuk tidak boleh kosong']);
        }
        $id = $this->bentukModel->insert(['nama_bentuk' => $nama], true);
        return $this->response->setJSON(['status' => 'ok', 'id' => $id, 'nama' => $nama]);
    }

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
