<?php

namespace App\Controllers\Admin\DataMaster;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        return view('template', ['body' => 'Admin/DataMaster/customer']);
    }

    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $builder = $this->customerModel->builder();
        $total   = (clone $builder)->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('nama_customer', $search)
                ->orLike('no_telepon', $search)
                ->groupEnd();
        }

        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->limit($length, $start)->get()->getResultArray();

        $no = $start + 1; $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'no'           => $no++,
                'nama_customer'=> esc($r['nama_customer']),
                'no_telepon'   => esc($r['no_telepon'] ?? '-'),
                'created_at'   => $r['created_at'] ? date('d-m-Y H:i', strtotime($r['created_at'])) : '-',
                'aksi'         => '
                    <button class="btn btn-sm btn-warning btn-edit"
                        data-id="' . $r['idcustomer'] . '"
                        data-nama="' . esc($r['nama_customer']) . '"
                        data-telepon="' . esc($r['no_telepon']) . '">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $r['idcustomer'] . '">
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

    public function getById($id)
    {
        $data = $this->customerModel->find($id);
        if (!$data) return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        return $this->response->setJSON(['status' => 'ok', 'data' => $data]);
    }

    public function store()
    {
        $this->customerModel->insert([
            'nama_customer' => $this->request->getPost('nama_customer'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Customer berhasil disimpan']);
    }

    public function update($id)
    {
        $this->customerModel->update($id, [
            'nama_customer' => $this->request->getPost('nama_customer'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
        ]);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Customer berhasil diupdate']);
    }

    public function delete($id)
    {
        $this->customerModel->delete($id);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Customer berhasil dihapus']);
    }
}
