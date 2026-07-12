<?php

namespace App\Controllers\Admin\Penjualan;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\CustomerModel;
use App\Models\LensaModel;
use App\Models\FrameModel;
use App\Models\KacamataModel;
use App\Models\StokLensaModel;
use App\Models\StokFrameModel;
use App\Models\StokKacamataModel;
use App\Models\RiwayatStokLensaModel;
use App\Models\RiwayatStokFrameModel;
use App\Models\RiwayatStokKacamataModel;

class PenjualanController extends BaseController
{
    protected $penjualanModel;
    protected $detailModel;
    protected $customerModel;

    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
        $this->detailModel    = new PenjualanDetailModel();
        $this->customerModel  = new CustomerModel();
    }

    public function index()
    {
        return view('template', [
            'body'          => 'Admin/Penjualan/index',
            'customer_list' => $this->customerModel->findAll(),
        ]);
    }

    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan p')
            ->select('p.idpenjualan, p.no_transaksi, c.nama_customer, p.total, p.diskon, p.grand_total, p.created_at, pg.nama_pegawai')
            ->join('customer c', 'c.idcustomer = p.idcustomer', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left');

        $total = (clone $builder)->countAllResults(false);
        if (!empty($search)) {
            $builder->groupStart()
                ->like('p.no_transaksi', $search)
                ->orLike('c.nama_customer', $search)
                ->groupEnd();
        }

        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->orderBy('p.idpenjualan', 'DESC')->limit($length, $start)->get()->getResultArray();

        $no = $start + 1;
        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'no'            => $no++,
                'no_transaksi'  => esc($r['no_transaksi']),
                'nama_customer' => esc($r['nama_customer'] ?? 'Umum'),
                'total'         => 'Rp ' . number_format($r['total'], 0, ',', '.'),
                'diskon'        => 'Rp ' . number_format($r['diskon'], 0, ',', '.'),
                'grand_total'   => 'Rp ' . number_format($r['grand_total'], 0, ',', '.'),
                'created_at'    => date('d-m-Y H:i', strtotime($r['created_at'])),
                'input_by'      => esc($r['nama_pegawai'] ?? '-'),
                'aksi'          => '
                    <button class="btn btn-sm btn-info btn-detail" data-id="' . $r['idpenjualan'] . '">
                        <i class="ti ti-eye"></i> Detail
                    </button>
                    <a href="' . base_url('penjualan/cetak/' . $r['idpenjualan']) . '" target="_blank"
                        class="btn btn-sm btn-secondary">
                        <i class="ti ti-printer"></i>
                    </a>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $r['idpenjualan'] . '">
                        <i class="ti ti-trash"></i>
                    </button>',
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw), 'recordsTotal' => $total,
            'recordsFiltered' => $filtered, 'data' => $data,
        ]);
    }

    /**
     * Cari produk berdasarkan jenis (reuse dari pembelian, tapi pakai harga_jual)
     */
    public function searchProduk()
    {
        $jenis   = $this->request->getGet('jenis');
        $keyword = $this->request->getGet('q') ?? '';
        $result  = [];

        switch ($jenis) {
            case 'lensa':
                $rows = (new LensaModel())->where('deleted', 0)->like('nama_lensa', $keyword)->findAll(20);
                foreach ($rows as $r) {
                    $result[] = ['id' => $r['idframe'], 'text' => $r['nama_lensa'], 'harga' => $r['harga_jual']];
                }
                break;
            case 'frame':
                $rows = (new FrameModel())->like('nama_frame', $keyword)->findAll(20);
                foreach ($rows as $r) {
                    $result[] = ['id' => $r['idframe'], 'text' => $r['nama_frame'], 'harga' => $r['harga_jual']];
                }
                break;
            case 'kacamata':
                $rows = (new KacamataModel())->where('deleted', 0)->like('nama_kacamata', $keyword)->findAll(20);
                foreach ($rows as $r) {
                    $result[] = ['id' => $r['idkacamata'], 'text' => $r['nama_kacamata'], 'harga' => $r['harga_jual']];
                }
                break;
        }

        return $this->response->setJSON(['results' => $result]);
    }

    /**
     * Simpan transaksi penjualan + detail + kurangi stok
     */
    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $total      = (int) $this->request->getPost('total');
        $diskon     = (int) $this->request->getPost('diskon') ?: 0;
        $grandTotal = $total - $diskon;

        $idpenjualan = $this->penjualanModel->insert([
            'no_transaksi' => $this->penjualanModel->generateNoTransaksi(),
            'idcustomer'   => $this->request->getPost('idcustomer') ?: null,
            'total'        => $total,
            'diskon'       => $diskon,
            'grand_total'  => $grandTotal,
            'keterangan'   => $this->request->getPost('keterangan'),
            'created_at'   => date('Y-m-d H:i:s'),
            'input_by'     => session('idpegawai'),
        ], true);

        $items = json_decode($this->request->getPost('items'), true);
        foreach ($items as $item) {
            $subtotal = (int) $item['harga_jual'] * (int) $item['jumlah'];

            $this->detailModel->insert([
                'idpenjualan'  => $idpenjualan,
                'jenis_produk' => $item['jenis_produk'],
                'idproduk'     => $item['idproduk'],
                'nama_produk'  => $item['nama_produk'],
                'harga_jual'   => $item['harga_jual'],
                'jumlah'       => $item['jumlah'],
                'subtotal'     => $subtotal,
            ]);

            $this->updateStokKeluar($item['jenis_produk'], (int)$item['idproduk'], (int)$item['jumlah'], 'TRJ');
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Transaksi gagal disimpan']);
        }

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Penjualan berhasil disimpan']);
    }

    public function detail($id)
    {
        $penjualan = $this->penjualanModel->db->table('penjualan p')
            ->select('p.*, c.nama_customer, pg.nama_pegawai')
            ->join('customer c', 'c.idcustomer = p.idcustomer', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left')
            ->where('p.idpenjualan', $id)
            ->get()->getRowArray();

        $details = $this->detailModel->getByPenjualan($id);

        return $this->response->setJSON(['status' => 'ok', 'penjualan' => $penjualan, 'details' => $details]);
    }

    /**
     * Hapus penjualan + rollback stok
     */
    public function cetakNota($id)
    {
        $penjualan = $this->penjualanModel->db->table('penjualan p')
            ->select('p.*, c.nama_customer, c.no_telepon, pg.nama_pegawai')
            ->join('customer c', 'c.idcustomer = p.idcustomer', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left')
            ->where('p.idpenjualan', $id)
            ->get()->getRowArray();

        if (!$penjualan) {
            return redirect()->to(base_url('penjualan'))->with('gagal', 'Data tidak ditemukan');
        }

        $details = $this->detailModel->getByPenjualan($id);

        $html = view('Admin/Penjualan/cetak_nota', [
            'penjualan' => $penjualan,
            'details'   => $details,
        ]);

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => [80, 200],
            'margin_top'    => 5,
            'margin_bottom' => 5,
            'margin_left'   => 5,
            'margin_right'  => 5,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('nota-penjualan-' . $penjualan['no_transaksi'] . '.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $details = $this->detailModel->getByPenjualan($id);
        foreach ($details as $item) {
            $this->updateStokMasuk($item['jenis_produk'], (int)$item['idproduk'], (int)$item['jumlah'], 'CANCEL-TRJ');
        }

        $this->detailModel->where('idpenjualan', $id)->delete();
        $this->penjualanModel->delete($id);

        $db->transComplete();
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Penjualan berhasil dihapus']);
    }

    // ===== Helper =====

    private function updateStokKeluar(string $jenis, int $idproduk, int $jumlah, string $ref = '')
    {
        switch ($jenis) {
            case 'lensa':
                $m = new StokLensaModel(); $r = new RiwayatStokLensaModel();
                $s = $m->getByLensa($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'keluar', $jumlah, $s['jumlah'], max(0, $s['jumlah'] - $jumlah), null, $ref);
                $m->kurangiStok($idproduk, $jumlah);
                break;
            case 'frame':
                $m = new StokFrameModel(); $r = new RiwayatStokFrameModel();
                $s = $m->getByFrame($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'keluar', $jumlah, $s['jumlah'], max(0, $s['jumlah'] - $jumlah), null, $ref);
                $m->kurangiStok($idproduk, $jumlah);
                break;
            case 'kacamata':
                $m = new StokKacamataModel(); $r = new RiwayatStokKacamataModel();
                $s = $m->getByKacamata($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'keluar', $jumlah, $s['jumlah'], max(0, $s['jumlah'] - $jumlah), null, $ref);
                $m->kurangiStok($idproduk, $jumlah);
                break;
        }
    }

    private function updateStokMasuk(string $jenis, int $idproduk, int $jumlah, string $ref = '')
    {
        switch ($jenis) {
            case 'lensa':
                $m = new StokLensaModel(); $r = new RiwayatStokLensaModel();
                $s = $m->getByLensa($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'masuk', $jumlah, $s['jumlah'], $s['jumlah'] + $jumlah, null, $ref);
                $m->tambahStok($idproduk, $jumlah);
                break;
            case 'frame':
                $m = new StokFrameModel(); $r = new RiwayatStokFrameModel();
                $s = $m->getByFrame($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'masuk', $jumlah, $s['jumlah'], $s['jumlah'] + $jumlah, null, $ref);
                $m->tambahStok($idproduk, $jumlah);
                break;
            case 'kacamata':
                $m = new StokKacamataModel(); $r = new RiwayatStokKacamataModel();
                $s = $m->getByKacamata($idproduk) ?? ['jumlah' => 0];
                $r->catat($idproduk, 'masuk', $jumlah, $s['jumlah'], $s['jumlah'] + $jumlah, null, $ref);
                $m->tambahStok($idproduk, $jumlah);
                break;
        }
    }
}
