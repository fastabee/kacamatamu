<?php

namespace App\Controllers\Admin\Stok;

use App\Controllers\BaseController;
use App\Models\StokOpnameModel;
use App\Models\StokOpnameDetailModel;
use App\Models\StokFrameModel;
use App\Models\StokLensaModel;
use App\Models\StokKacamataModel;
use App\Models\RiwayatStokFrameModel;
use App\Models\RiwayatStokLensaModel;
use App\Models\RiwayatStokKacamataModel;

class StokOpnameController extends BaseController
{
    protected StokOpnameModel       $opnameModel;
    protected StokOpnameDetailModel $detailModel;

    public function __construct()
    {
        $this->opnameModel = new StokOpnameModel();
        $this->detailModel = new StokOpnameDetailModel();
    }

    // ----------------------------------------------------------------
    // Halaman daftar stok opname
    // ----------------------------------------------------------------
    public function index(): string
    {
        return view('template', ['body' => 'Admin/StokOpname/index']);
    }

    // ----------------------------------------------------------------
    // DataTables server-side
    // ----------------------------------------------------------------
    public function datatable()
    {
        $draw   = (int)   ($this->request->getGet('draw')   ?? 1);
        $start  = (int)   ($this->request->getGet('start')  ?? 0);
        $length = (int)   ($this->request->getGet('length') ?? 10);
        $search = (string)($this->request->getGet('search')['value'] ?? '');

        $result = $this->opnameModel->getDatatable($start, $length, $search);

        $no   = $start + 1;
        $data = [];
        foreach ($result['rows'] as $r) {
            $statusBadge = $r['status'] === 'selesai'
                ? '<span class="badge bg-success">Selesai</span>'
                : '<span class="badge bg-warning text-dark">Draft</span>';

            $btnDetail = '<a href="' . base_url('stok-opname/detail/' . $r['idopname']) . '"
                            class="btn btn-sm btn-info text-white">
                            <i class="ti ti-list"></i> Detail
                          </a>';

            $btnProses = '';
            if ($r['status'] === 'draft') {
                $btnProses = '<a href="' . base_url('stok-opname/isi/' . $r['idopname']) . '"
                                class="btn btn-sm btn-primary ms-1">
                                <i class="ti ti-pencil"></i> Isi Fisik
                              </a>';
            }

            $btnHapus = '';
            if ($r['status'] === 'draft') {
                $btnHapus = '<button class="btn btn-sm btn-danger ms-1 btn-hapus"
                                data-id="' . $r['idopname'] . '">
                                <i class="ti ti-trash"></i>
                             </button>';
            }

            $data[] = [
                'no'            => $no++,
                'no_opname'     => esc($r['no_opname']),
                'tanggal'       => date('d/m/Y', strtotime($r['tanggal'])),
                'keterangan'    => esc($r['keterangan'] ?? '-'),
                'nama_pembuat'  => esc($r['nama_pembuat'] ?? '-'),
                'status'        => $statusBadge,
                'aksi'          => $btnDetail . $btnProses . $btnHapus,
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $result['total'],
            'recordsFiltered' => $result['filtered'],
            'data'            => $data,
        ]);
    }

    // ----------------------------------------------------------------
    // Halaman form buat opname baru (pilih produk)
    // ----------------------------------------------------------------
    public function create(): string
    {
        $db = \Config\Database::connect();

        // Ambil semua produk aktif beserta stok sistem saat ini
        $frames = $db->table('frame f')
            ->select('f.idframe as idproduk, f.nama_frame as nama_produk,
                      COALESCE(sf.jumlah, 0) as stok_sistem')
            ->join('stok_frame sf', 'sf.idframe = f.idframe', 'left')
            ->orderBy('f.nama_frame')
            ->get()->getResultArray();

        $lensas = $db->table('lensa l')
            ->select('l.idframe as idproduk, l.nama_lensa as nama_produk,
                      COALESCE(sl.jumlah, 0) as stok_sistem')
            ->join('stok_lensa sl', 'sl.idlensa = l.idframe', 'left')
            ->where('l.deleted', 0)
            ->orderBy('l.nama_lensa')
            ->get()->getResultArray();

        $kacamatas = $db->table('kacamata k')
            ->select('k.idkacamata as idproduk, k.nama_kacamata as nama_produk,
                      COALESCE(sk.jumlah, 0) as stok_sistem')
            ->join('stok_kacamata sk', 'sk.idkacamata = k.idkacamata', 'left')
            ->where('k.deleted', 0)
            ->orderBy('k.nama_kacamata')
            ->get()->getResultArray();

        return view('template', [
            'body'      => 'Admin/StokOpname/create',
            'frames'    => $frames,
            'lensas'    => $lensas,
            'kacamatas' => $kacamatas,
        ]);
    }

    // ----------------------------------------------------------------
    // Simpan header + detail opname (POST)
    // ----------------------------------------------------------------
    public function store()
    {
        $tanggal    = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');
        $jenisList  = $this->request->getPost('jenis')   ?? [];  // array
        $idList     = $this->request->getPost('idproduk') ?? []; // array
        $namaList   = $this->request->getPost('nama')    ?? [];
        $sistemList = $this->request->getPost('stok_sistem') ?? [];

        if (empty($tanggal)) {
            session()->setFlashdata('gagal', 'Tanggal harus diisi');
            return redirect()->back();
        }
        if (empty($jenisList)) {
            session()->setFlashdata('gagal', 'Pilih minimal satu produk');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan header
        $idopname = $this->opnameModel->insert([
            'no_opname'  => $this->opnameModel->generateNomor(),
            'tanggal'    => $tanggal,
            'keterangan' => $keterangan,
            'status'     => 'draft',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session('idpegawai'),
        ], true);

        // Simpan detail
        $items = [];
        foreach ($jenisList as $i => $jenis) {
            $items[] = [
                'jenis'       => $jenis,
                'idproduk'    => (int) $idList[$i],
                'nama'        => $namaList[$i],
                'stok_sistem' => (int) $sistemList[$i],
            ];
        }
        $this->detailModel->insertBulk((int) $idopname, $items);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('gagal', 'Gagal menyimpan stok opname');
            return redirect()->back();
        }

        session()->setFlashdata('sukses', 'Stok opname berhasil dibuat, silakan isi stok fisik');
        return redirect()->to(base_url('stok-opname/isi/' . $idopname));
    }

    // ----------------------------------------------------------------
    // Halaman isi stok fisik (form pengisian)
    // ----------------------------------------------------------------
    public function isi(int $idopname): string
    {
        $opname = $this->opnameModel->find($idopname);
        if (!$opname || $opname['status'] !== 'draft') {
            session()->setFlashdata('gagal', 'Opname tidak ditemukan atau sudah selesai');
            return redirect()->to(base_url('stok-opname'));
        }

        $details = $this->detailModel->getByOpname($idopname);

        return view('template', [
            'body'    => 'Admin/StokOpname/isi',
            'opname'  => $opname,
            'details' => $details,
        ]);
    }

    // ----------------------------------------------------------------
    // Simpan hasil stok fisik (AJAX POST)
    // ----------------------------------------------------------------
    public function simpanFisik(int $idopname)
    {
        $opname = $this->opnameModel->find($idopname);
        if (!$opname || $opname['status'] !== 'draft') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Opname tidak valid']);
        }

        // inputs: array [iddetail => stok_fisik]
        $inputs = $this->request->getPost('fisik') ?? [];
        if (empty($inputs)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data kosong']);
        }

        $this->detailModel->updateFisik($idopname, $inputs);

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Tersimpan']);
    }

    // ----------------------------------------------------------------
    // Selesaikan opname → update stok sistem & catat riwayat
    // ----------------------------------------------------------------
    public function selesaikan(int $idopname)
    {
        $opname = $this->opnameModel->find($idopname);
        if (!$opname || $opname['status'] !== 'draft') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Opname tidak valid']);
        }

        $details = $this->detailModel->getByOpname($idopname);

        // Pastikan semua item sudah diisi stok fisik
        foreach ($details as $d) {
            if ($d['stok_fisik'] === null) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Semua item harus diisi stok fisik terlebih dahulu',
                ]);
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $noRef        = $opname['no_opname'];
        $stokFrame    = new StokFrameModel();
        $stokLensa    = new StokLensaModel();
        $stokKacamata = new StokKacamataModel();
        $rwFrame      = new RiwayatStokFrameModel();
        $rwLensa      = new RiwayatStokLensaModel();
        $rwKacamata   = new RiwayatStokKacamataModel();

        foreach ($details as $d) {
            $idproduk  = (int) $d['idproduk'];
            $stokFisik = (int) $d['stok_fisik'];
            $selisih   = (int) $d['selisih'];

            // Hanya update jika ada selisih
            if ($selisih === 0) continue;

            switch ($d['jenis_produk']) {
                case 'frame':
                    $stokNow = $stokFrame->getByFrame($idproduk);
                    $before  = $stokNow ? (int) $stokNow['jumlah'] : 0;
                    if ($stokNow) {
                        $stokFrame->update($stokNow['idstok_frame'], ['jumlah' => $stokFisik]);
                    } else {
                        $stokFrame->insert(['idframe' => $idproduk, 'jumlah' => $stokFisik]);
                    }
                    $rwFrame->catat(
                        $idproduk,
                        'adjustment',
                        abs($selisih),
                        $before,
                        $stokFisik,
                        'Stok Opname: ' . $noRef,
                        $noRef
                    );
                    break;

                case 'lensa':
                    $stokNow = $stokLensa->getByLensa($idproduk);
                    $before  = $stokNow ? (int) $stokNow['jumlah'] : 0;
                    if ($stokNow) {
                        $stokLensa->update($stokNow['idstok_lensa'], ['jumlah' => $stokFisik]);
                    } else {
                        $stokLensa->insert(['idlensa' => $idproduk, 'jumlah' => $stokFisik]);
                    }
                    $rwLensa->catat(
                        $idproduk,
                        'adjustment',
                        abs($selisih),
                        $before,
                        $stokFisik,
                        'Stok Opname: ' . $noRef,
                        $noRef
                    );
                    break;

                case 'kacamata':
                    $stokNow = $stokKacamata->getByKacamata($idproduk);
                    $before  = $stokNow ? (int) $stokNow['jumlah'] : 0;
                    if ($stokNow) {
                        $stokKacamata->update($stokNow['idstok_kacamata'], ['jumlah' => $stokFisik]);
                    } else {
                        $stokKacamata->insert(['idkacamata' => $idproduk, 'jumlah' => $stokFisik]);
                    }
                    $rwKacamata->catat(
                        $idproduk,
                        'adjustment',
                        abs($selisih),
                        $before,
                        $stokFisik,
                        'Stok Opname: ' . $noRef,
                        $noRef
                    );
                    break;
            }
        }

        // Update status opname menjadi selesai
        $this->opnameModel->update($idopname, [
            'status'     => 'selesai',
            'selesai_at' => date('Y-m-d H:i:s'),
            'selesai_by' => session('idpegawai'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memproses opname']);
        }

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Stok opname berhasil diselesaikan']);
    }

    // ----------------------------------------------------------------
    // Halaman detail / lihat hasil opname
    // ----------------------------------------------------------------
    public function detail(int $idopname): string
    {
        $opname = $this->opnameModel->find($idopname);
        if (!$opname) {
            session()->setFlashdata('gagal', 'Opname tidak ditemukan');
            return redirect()->to(base_url('stok-opname'));
        }

        $details = $this->detailModel->getByOpname($idopname);

        return view('template', [
            'body'    => 'Admin/StokOpname/detail',
            'opname'  => $opname,
            'details' => $details,
        ]);
    }

    // ----------------------------------------------------------------
    // Hapus opname (hanya yang masih draft)
    // ----------------------------------------------------------------
    public function hapus(int $idopname)
    {
        $opname = $this->opnameModel->find($idopname);
        if (!$opname || $opname['status'] !== 'draft') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak dapat dihapus']);
        }

        $db = \Config\Database::connect();
        $db->table('stok_opname_detail')->where('idopname', $idopname)->delete();
        $db->table('stok_opname')->where('idopname', $idopname)->delete();

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Opname berhasil dihapus']);
    }
}
