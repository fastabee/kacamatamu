<?php

namespace App\Controllers\Admin\DataMaster;

use App\Controllers\BaseController;
use App\Models\VendorModel;

class Supplier extends BaseController
{
    protected $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }

    public function index()
    {
        return view('template', ['body' => 'Admin/DataMaster/supplier']);
    }

    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $builder = $this->vendorModel->builder()->where('deleted', 0);
        $total   = (clone $builder)->countAllResults(false);

        if (!empty($search)) {
            $builder->like('nama_supplier', $search);
        }

        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->limit($length, $start)->get()->getResultArray();

        $no = $start + 1; $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'no'           => $no++,
                'nama_supplier'=> esc($r['nama_supplier']),
                'aksi'         => '
                    <button class="btn btn-sm btn-warning btn-edit"
                        data-id="' . $r['idsupplier'] . '"
                        data-nama="' . esc($r['nama_supplier']) . '">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $r['idsupplier'] . '">
                        <i class="ti ti-trash"></i>
                    </button>',
            ];
        }

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data,
        ]);
    }

    public function store()
    {
        $this->vendorModel->insert([
            'nama_supplier' => $this->request->getPost('nama_supplier'),
            'deleted'       => 0,
        ]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Supplier berhasil disimpan']);
    }

    public function update($id)
    {
        $this->vendorModel->update($id, [
            'nama_supplier' => $this->request->getPost('nama_supplier'),
        ]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Supplier berhasil diupdate']);
    }

    public function delete($id)
    {
        $this->vendorModel->update($id, ['deleted' => 1]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Supplier berhasil dihapus']);
    }
}
