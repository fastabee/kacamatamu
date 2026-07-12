<?php

namespace App\Controllers\Admin\DataMaster;

use App\Controllers\BaseController;
use App\Models\KacamataModel;
use App\Models\LensaModel;
use App\Models\FrameModel;

class Kacamata extends BaseController
{
    protected $kacamataModel;
    protected $lensaModel;
    protected $frameModel;

    public function __construct()
    {
        $this->kacamataModel = new KacamataModel();
        $this->lensaModel    = new LensaModel();
        $this->frameModel    = new FrameModel();
    }

    public function index()
    {
        $data = [
            'body'       => 'Admin/DataMaster/kacamata',
            'lensa_list' => $this->lensaModel->where('deleted', 0)->findAll(),
            'frame_list' => $this->frameModel->findAll(),
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
        $builder = $db->table('kacamata k')
            ->select('k.idkacamata, k.nama_kacamata, l.nama_lensa, f.nama_frame, k.harga_beli, k.harga_jual')
            ->join('lensa l', 'l.idframe = k.idlensa', 'left')
            ->join('frame f', 'f.idframe = k.idframe', 'left')
            ->where('k.deleted', 0);

        $totalRecords = (clone $builder)->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('k.nama_kacamata', $search)
                ->orLike('l.nama_lensa', $search)
                ->orLike('f.nama_frame', $search)
                ->groupEnd();
        }

        $totalFiltered = (clone $builder)->countAllResults(false);
        $rows          = $builder->limit($length, $start)->get()->getResultArray();

        $data = [];
        $no   = $start + 1;
        foreach ($rows as $row) {
            $data[] = [
                'no'           => $no++,
                'nama_kacamata'=> esc($row['nama_kacamata']),
                'nama_lensa'   => esc($row['nama_lensa'] ?? '-'),
                'nama_frame'   => esc($row['nama_frame'] ?? '-'),
                'harga_beli'   => 'Rp ' . number_format($row['harga_beli'], 0, ',', '.'),
                'harga_jual'   => 'Rp ' . number_format($row['harga_jual'], 0, ',', '.'),
                'aksi'         => '
                    <button class="btn btn-sm btn-warning btn-edit" data-id="' . $row['idkacamata'] . '">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row['idkacamata'] . '">
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
        $data = $this->kacamataModel->where('deleted', 0)->find($id);
        if (!$data) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $data]);
    }

    public function store()
    {
        $data = [
            'nama_kacamata' => $this->request->getPost('nama_kacamata'),
            'idlensa'       => $this->request->getPost('idlensa'),
            'idframe'       => $this->request->getPost('idframe'),
            'harga_beli'    => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'    => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
            'deleted'       => 0,
        ];

        $this->kacamataModel->insert($data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil disimpan']);
    }

    public function update($id)
    {
        $data = [
            'nama_kacamata' => $this->request->getPost('nama_kacamata'),
            'idlensa'       => $this->request->getPost('idlensa'),
            'idframe'       => $this->request->getPost('idframe'),
            'harga_beli'    => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_beli')),
            'harga_jual'    => preg_replace('/[^0-9]/', '', $this->request->getPost('harga_jual')),
        ];

        $this->kacamataModel->update($id, $data);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil diupdate']);
    }

    public function delete($id)
    {
        $this->kacamataModel->update($id, ['deleted' => 1]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Data berhasil dihapus']);
    }
}
