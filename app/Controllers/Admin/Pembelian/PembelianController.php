<?php

namespace App\Controllers\Admin\Pembelian;

use App\Controllers\BaseController;
use App\Models\PembelianModel;
use App\Models\PembelianDetailModel;
use App\Models\VendorModel;
use App\Models\LensaModel;
use App\Models\FrameModel;
use App\Models\KacamataModel;
use App\Models\StokLensaModel;
use App\Models\StokFrameModel;
use App\Models\StokKacamataModel;
use App\Models\RiwayatStokLensaModel;
use App\Models\RiwayatStokFrameModel;
use App\Models\RiwayatStokKacamataModel;

class PembelianController extends BaseController
{
    protected $pembelianModel;
    protected $detailModel;
    protected $vendorModel;

    public function __construct()
    {
        $this->pembelianModel = new PembelianModel();
        $this->detailModel    = new PembelianDetailModel();
        $this->vendorModel    = new VendorModel();
    }

    public function index()
    {
        return view('template', [
            'body'          => 'Admin/Pembelian/index',
            'supplier_list' => $this->vendorModel->where('deleted', 0)->findAll(),
        ]);
    }

    public function datatable()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('pembelian p')
            ->select('p.idpembelian, p.no_pembelian, v.nama_supplier, p.total, p.created_at, pg.nama_pegawai')
            ->join('vendor v', 'v.idsupplier = p.idsupplier', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left');

        $total = (clone $builder)->countAllResults(false);
        if (!empty($search)) {
            $builder->groupStart()
                ->like('p.no_pembelian', $search)
                ->orLike('v.nama_supplier', $search)
                ->groupEnd();
        }

        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->orderBy('p.idpembelian', 'DESC')->limit($length, $start)->get()->getResultArray();

        $no = $start + 1; $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'no'           => $no++,
                'no_pembelian' => esc($r['no_pembelian']),
                'nama_supplier'=> esc($r['nama_supplier'] ?? '-'),
                'total'        => 'Rp ' . number_format($r['total'], 0, ',', '.'),
                'created_at'   => date('d-m-Y H:i', strtotime($r['created_at'])),
                'input_by'     => esc($r['nama_pegawai'] ?? '-'),
                'aksi'         => '
                    <button class="btn btn-sm btn-info btn-detail" data-id="' . $r['idpembelian'] . '">
                        <i class="ti ti-eye"></i> Detail
                    </button>
                    <a href="' . base_url('pembelian/cetak/' . $r['idpembelian']) . '" target="_blank"
                        class="btn btn-sm btn-secondary">
                        <i class="ti ti-printer"></i>
                    </a>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $r['idpembelian'] . '">
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
     * Cari produk berdasarkan jenis dan keyword untuk select2
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
                    $result[] = ['id' => $r['idframe'], 'text' => $r['nama_lensa'], 'harga' => $r['harga_beli']];
                }
                break;
            case 'frame':
                $rows = (new FrameModel())->like('nama_frame', $keyword)->findAll(20);
                foreach ($rows as $r) {
                    $result[] = ['id' => $r['idframe'], 'text' => $r['nama_frame'], 'harga' => $r['harga_beli']];
                }
                break;
            case 'kacamata':
                $rows = (new KacamataModel())->where('deleted', 0)->like('nama_kacamata', $keyword)->findAll(20);
                foreach ($rows as $r) {
                    $result[] = ['id' => $r['idkacamata'], 'text' => $r['nama_kacamata'], 'harga' => $r['harga_beli']];
                }
                break;
        }

        return $this->response->setJSON(['results' => $result]);
    }

    /**
     * Simpan transaksi pembelian + detail + update stok
     */
    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan header
        $idpembelian = $this->pembelianModel->insert([
            'no_pembelian' => $this->pembelianModel->generateNoPembelian(),
            'idsupplier'   => $this->request->getPost('idsupplier'),
            'total'        => $this->request->getPost('total'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'created_at'   => date('Y-m-d H:i:s'),
            'input_by'     => session('idpegawai'),
        ], true);

        // Simpan detail + update stok
        $items = json_decode($this->request->getPost('items'), true);
        foreach ($items as $item) {
            $subtotal = (int)$item['harga_beli'] * (int)$item['jumlah'];

            $this->detailModel->insert([
                'idpembelian'  => $idpembelian,
                'jenis_produk' => $item['jenis_produk'],
                'idproduk'     => $item['idproduk'],
                'nama_produk'  => $item['nama_produk'],
                'harga_beli'   => $item['harga_beli'],
                'jumlah'       => $item['jumlah'],
                'subtotal'     => $subtotal,
            ]);

            $this->updateStokMasuk($item['jenis_produk'], $item['idproduk'], $item['jumlah'], 'PBL');
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Transaksi gagal disimpan']);
        }

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Pembelian berhasil disimpan']);
    }

    /**
     * Get detail pembelian by ID
     */
    public function detail($id)
    {
        $pembelian = $this->pembelianModel->db->table('pembelian p')
            ->select('p.*, v.nama_supplier, pg.nama_pegawai')
            ->join('vendor v', 'v.idsupplier = p.idsupplier', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left')
            ->where('p.idpembelian', $id)
            ->get()->getRowArray();

        $details = $this->detailModel->getByPembelian($id);

        return $this->response->setJSON(['status' => 'ok', 'pembelian' => $pembelian, 'details' => $details]);
    }

    /**
     * Hapus pembelian + rollback stok
     */
    public function cetakNota($id)
    {
        $pembelian = $this->pembelianModel->db->table('pembelian p')
            ->select('p.*, v.nama_supplier, pg.nama_pegawai')
            ->join('vendor v', 'v.idsupplier = p.idsupplier', 'left')
            ->join('pegawai pg', 'pg.idpegawai = p.input_by', 'left')
            ->where('p.idpembelian', $id)
            ->get()->getRowArray();

        if (!$pembelian) {
            return redirect()->to(base_url('pembelian'))->with('gagal', 'Data tidak ditemukan');
        }

        $details = $this->detailModel->getByPembelian($id);

        $html = view('Admin/Pembelian/cetak_nota', [
            'pembelian' => $pembelian,
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
        $mpdf->Output('nota-pembelian-' . $pembelian['no_pembelian'] . '.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $details = $this->detailModel->getByPembelian($id);
        foreach ($details as $item) {
            $this->updateStokKeluar($item['jenis_produk'], $item['idproduk'], $item['jumlah'], 'CANCEL-PBL');
        }

        $this->detailModel->where('idpembelian', $id)->delete();
        $this->pembelianModel->delete($id);

        $db->transComplete();

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Pembelian berhasil dihapus']);
    }

    // ===== Helper update stok =====

    private function updateStokMasuk(string $jenis, int $idproduk, int $jumlah, string $ref = '')
    {
        switch ($jenis) {
            case 'lensa':
                $stokModel = new StokLensaModel();
                $riwayat   = new RiwayatStokLensaModel();
                $stok      = $stokModel->getByLensa($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'masuk', $jumlah, $stok['jumlah'], $stok['jumlah'] + $jumlah, null, $ref);
                $stokModel->tambahStok($idproduk, $jumlah);
                break;
            case 'frame':
                $stokModel = new StokFrameModel();
                $riwayat   = new RiwayatStokFrameModel();
                $stok      = $stokModel->getByFrame($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'masuk', $jumlah, $stok['jumlah'], $stok['jumlah'] + $jumlah, null, $ref);
                $stokModel->tambahStok($idproduk, $jumlah);
                break;
            case 'kacamata':
                $stokModel = new StokKacamataModel();
                $riwayat   = new RiwayatStokKacamataModel();
                $stok      = $stokModel->getByKacamata($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'masuk', $jumlah, $stok['jumlah'], $stok['jumlah'] + $jumlah, null, $ref);
                $stokModel->tambahStok($idproduk, $jumlah);
                break;
        }
    }

    private function updateStokKeluar(string $jenis, int $idproduk, int $jumlah, string $ref = '')
    {
        switch ($jenis) {
            case 'lensa':
                $stokModel = new StokLensaModel();
                $riwayat   = new RiwayatStokLensaModel();
                $stok      = $stokModel->getByLensa($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'keluar', $jumlah, $stok['jumlah'], max(0, $stok['jumlah'] - $jumlah), null, $ref);
                $stokModel->kurangiStok($idproduk, $jumlah);
                break;
            case 'frame':
                $stokModel = new StokFrameModel();
                $riwayat   = new RiwayatStokFrameModel();
                $stok      = $stokModel->getByFrame($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'keluar', $jumlah, $stok['jumlah'], max(0, $stok['jumlah'] - $jumlah), null, $ref);
                $stokModel->kurangiStok($idproduk, $jumlah);
                break;
            case 'kacamata':
                $stokModel = new StokKacamataModel();
                $riwayat   = new RiwayatStokKacamataModel();
                $stok      = $stokModel->getByKacamata($idproduk) ?? ['jumlah' => 0];
                $riwayat->catat($idproduk, 'keluar', $jumlah, $stok['jumlah'], max(0, $stok['jumlah'] - $jumlah), null, $ref);
                $stokModel->kurangiStok($idproduk, $jumlah);
                break;
        }
    }
}
