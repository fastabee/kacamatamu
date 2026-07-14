<?php

namespace App\Controllers\Admin\Stok;

use App\Controllers\BaseController;
use App\Models\StokFrameModel;
use App\Models\StokLensaModel;
use App\Models\StokKacamataModel;
use App\Models\RiwayatStokFrameModel;
use App\Models\RiwayatStokLensaModel;
use App\Models\RiwayatStokKacamataModel;
use App\Models\FrameModel;
use App\Models\LensaModel;
use App\Models\KacamataModel;

class StokController extends BaseController
{
    // ========== FRAME ==========

    public function frame()
    {
        return view('template', [
            'body'        => 'Admin/Stok/frame',
            'frame_list'  => (new FrameModel())->findAll(),
        ]);
    }

    public function datatableFrame()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('stok_frame sf')
            ->select('sf.idstok_frame, sf.idframe, f.nama_frame, sf.jumlah')
            ->join('frame f', 'f.idframe = sf.idframe', 'left');

        $total = (clone $builder)->countAllResults(false);
        if (!empty($search)) {
            $builder->like('f.nama_frame', $search);
        }
        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->limit($length, $start)->get()->getResultArray();

        $no   = $start + 1;
        $data = [];
        foreach ($rows as $r) {
            $badge = $r['jumlah'] <= 5
                ? '<span class="badge bg-danger">' . $r['jumlah'] . '</span>'
                : '<span class="badge bg-success">' . $r['jumlah'] . '</span>';
            $data[] = [
                'no'         => $no++,
                'nama_frame' => esc($r['nama_frame']),
                'jumlah'     => $badge,
                'aksi'       => '<button class="btn btn-sm btn-primary btn-transaksi"
                                    data-iditem="' . $r['idframe'] . '"
                                    data-nama="' . esc($r['nama_frame']) . '"
                                    data-stok="' . $r['jumlah'] . '">
                                    <i class="ti ti-arrows-exchange"></i> Transaksi
                                 </button>
                                 <button class="btn btn-sm btn-outline-secondary btn-riwayat"
                                    data-iditem="' . $r['idframe'] . '"
                                    data-nama="' . esc($r['nama_frame']) . '">
                                    <i class="ti ti-history"></i>
                                 </button>',
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function transaksiFrame()
    {
        $stokModel    = new StokFrameModel();
        $riwayatModel = new RiwayatStokFrameModel();

        $idframe  = $this->request->getPost('idframe');
        $jenis    = $this->request->getPost('jenis');
        $jumlah   = (int) $this->request->getPost('jumlah');
        $ket      = $this->request->getPost('keterangan');

        $stok         = $stokModel->getByFrame($idframe) ?? ['jumlah' => 0];
        $stokSebelum  = (int) $stok['jumlah'];
        $stokSesudah  = $jenis === 'masuk'
            ? $stokSebelum + $jumlah
            : ($jenis === 'keluar' ? max(0, $stokSebelum - $jumlah) : $jumlah);

        if ($jenis === 'masuk') {
            $stokModel->tambahStok($idframe, $jumlah);
        } elseif ($jenis === 'keluar') {
            $stokModel->kurangiStok($idframe, $jumlah);
        } else {
            // adjustment: set langsung
            $s = $stokModel->getByFrame($idframe);
            if ($s) $stokModel->update($s['idstok_frame'], ['jumlah' => $jumlah]);
            else $stokModel->insert(['idframe' => $idframe, 'jumlah' => $jumlah]);
        }

        $riwayatModel->catat($idframe, $jenis, $jumlah, $stokSebelum, $stokSesudah, $ket);

        return $this->response->setJSON(['status' => 'ok', 'message' => 'Transaksi berhasil']);
    }

    public function riwayatFrame($idframe)
    {
        $db   = \Config\Database::connect();
        $rows = $db->table('riwayat_stok_frame r')
            ->select('r.*, f.nama_frame, p.nama_pegawai')
            ->join('frame f', 'f.idframe = r.idframe', 'left')
            ->join('pegawai p', 'p.idpegawai = r.created_by', 'left')
            ->where('r.idframe', $idframe)
            ->orderBy('r.created_at', 'DESC')
            ->limit(50)
            ->get()->getResultArray();

        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }

    // ========== LENSA ==========

    public function lensa()
    {
        return view('template', [
            'body'       => 'Admin/Stok/lensa',
            'lensa_list' => (new LensaModel())->where('deleted', 0)->findAll(),
        ]);
    }

    public function datatableLensa()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('stok_lensa sl')
            ->select('sl.idstok_lensa, l.idframe as idlensa, l.nama_lensa, sl.jumlah')
            ->join('lensa l', 'l.idframe = sl.idlensa', 'left');

        $total = (clone $builder)->countAllResults(false);
        if (!empty($search)) $builder->like('l.nama_lensa', $search);
        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->limit($length, $start)->get()->getResultArray();

        $no = $start + 1;
        $data = [];
        foreach ($rows as $r) {
            $badge = $r['jumlah'] <= 5
                ? '<span class="badge bg-danger">' . $r['jumlah'] . '</span>'
                : '<span class="badge bg-success">' . $r['jumlah'] . '</span>';
            $data[] = [
                'no'         => $no++,
                'nama_lensa' => esc($r['nama_lensa']),
                'jumlah'     => $badge,
                'aksi'       => '<button class="btn btn-sm btn-primary btn-transaksi"
                                    data-iditem="' . $r['idlensa'] . '"
                                    data-nama="' . esc($r['nama_lensa']) . '"
                                    data-stok="' . $r['jumlah'] . '">
                                    <i class="ti ti-arrows-exchange"></i> Transaksi
                                 </button>
                                 <button class="btn btn-sm btn-outline-secondary btn-riwayat"
                                    data-iditem="' . $r['idlensa'] . '"
                                    data-nama="' . esc($r['nama_lensa']) . '">
                                    <i class="ti ti-history"></i>
                                 </button>',
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function transaksiLensa()
    {
        $stokModel    = new StokLensaModel();
        $riwayatModel = new RiwayatStokLensaModel();

        $idlensa      = $this->request->getPost('idlensa');
        $jenis        = $this->request->getPost('jenis');
        $jumlah       = (int) $this->request->getPost('jumlah');
        $ket          = $this->request->getPost('keterangan');

        $stok        = $stokModel->getByLensa($idlensa) ?? ['jumlah' => 0];
        $stokSebelum = (int) $stok['jumlah'];
        $stokSesudah = $jenis === 'masuk'
            ? $stokSebelum + $jumlah
            : ($jenis === 'keluar' ? max(0, $stokSebelum - $jumlah) : $jumlah);

        if ($jenis === 'masuk') $stokModel->tambahStok($idlensa, $jumlah);
        elseif ($jenis === 'keluar') $stokModel->kurangiStok($idlensa, $jumlah);
        else {
            $s = $stokModel->getByLensa($idlensa);
            if ($s) $stokModel->update($s['idstok_lensa'], ['jumlah' => $jumlah]);
            else $stokModel->insert(['idlensa' => $idlensa, 'jumlah' => $jumlah]);
        }

        $riwayatModel->catat($idlensa, $jenis, $jumlah, $stokSebelum, $stokSesudah, $ket);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Transaksi berhasil']);
    }

    public function riwayatLensa($idlensa)
    {
        $db   = \Config\Database::connect();
        $rows = $db->table('riwayat_stok_lensa r')
            ->select('r.*, l.nama_lensa, p.nama_pegawai')
            ->join('lensa l', 'l.idframe = r.idlensa', 'left')
            ->join('pegawai p', 'p.idpegawai = r.created_by', 'left')
            ->where('r.idlensa', $idlensa)
            ->orderBy('r.created_at', 'DESC')
            ->limit(50)
            ->get()->getResultArray();

        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }

    // ========== KACAMATA ==========

    public function kacamata()
    {
        return view('template', [
            'body'          => 'Admin/Stok/kacamata',
            'kacamata_list' => (new KacamataModel())->where('deleted', 0)->findAll(),
        ]);
    }

    public function datatableKacamata()
    {
        $draw   = $this->request->getGet('draw');
        $start  = $this->request->getGet('start') ?? 0;
        $length = $this->request->getGet('length') ?? 10;
        $search = $this->request->getGet('search')['value'] ?? '';

        $db      = \Config\Database::connect();
        $builder = $db->table('stok_kacamata sk')
            ->select('sk.idstok_kacamata, k.idkacamata, k.nama_kacamata, sk.jumlah')
            ->join('kacamata k', 'k.idkacamata = sk.idkacamata', 'left');

        $total = (clone $builder)->countAllResults(false);
        if (!empty($search)) $builder->like('k.nama_kacamata', $search);
        $filtered = (clone $builder)->countAllResults(false);
        $rows     = $builder->limit($length, $start)->get()->getResultArray();

        $no = $start + 1;
        $data = [];
        foreach ($rows as $r) {
            $badge = $r['jumlah'] <= 5
                ? '<span class="badge bg-danger">' . $r['jumlah'] . '</span>'
                : '<span class="badge bg-success">' . $r['jumlah'] . '</span>';
            $data[] = [
                'no'            => $no++,
                'nama_kacamata' => esc($r['nama_kacamata']),
                'jumlah'        => $badge,
                'aksi'          => '<button class="btn btn-sm btn-primary btn-transaksi"
                                        data-iditem="' . $r['idkacamata'] . '"
                                        data-nama="' . esc($r['nama_kacamata']) . '"
                                        data-stok="' . $r['jumlah'] . '">
                                        <i class="ti ti-arrows-exchange"></i> Transaksi
                                     </button>
                                     <button class="btn btn-sm btn-outline-secondary btn-riwayat"
                                        data-iditem="' . $r['idkacamata'] . '"
                                        data-nama="' . esc($r['nama_kacamata']) . '">
                                        <i class="ti ti-history"></i>
                                     </button>',
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function transaksiKacamata()
    {
        $stokModel    = new StokKacamataModel();
        $riwayatModel = new RiwayatStokKacamataModel();

        $idkacamata  = $this->request->getPost('idkacamata');
        $jenis       = $this->request->getPost('jenis');
        $jumlah      = (int) $this->request->getPost('jumlah');
        $ket         = $this->request->getPost('keterangan');

        $stok        = $stokModel->getByKacamata($idkacamata) ?? ['jumlah' => 0];
        $stokSebelum = (int) $stok['jumlah'];
        $stokSesudah = $jenis === 'masuk'
            ? $stokSebelum + $jumlah
            : ($jenis === 'keluar' ? max(0, $stokSebelum - $jumlah) : $jumlah);

        if ($jenis === 'masuk') $stokModel->tambahStok($idkacamata, $jumlah);
        elseif ($jenis === 'keluar') $stokModel->kurangiStok($idkacamata, $jumlah);
        else {
            $s = $stokModel->getByKacamata($idkacamata);
            if ($s) $stokModel->update($s['idstok_kacamata'], ['jumlah' => $jumlah]);
            else $stokModel->insert(['idkacamata' => $idkacamata, 'jumlah' => $jumlah]);
        }

        $riwayatModel->catat($idkacamata, $jenis, $jumlah, $stokSebelum, $stokSesudah, $ket);
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Transaksi berhasil']);
    }

    public function riwayatKacamata($idkacamata)
    {
        $db   = \Config\Database::connect();
        $rows = $db->table('riwayat_stok_kacamata r')
            ->select('r.*, k.nama_kacamata, p.nama_pegawai')
            ->join('kacamata k', 'k.idkacamata = r.idkacamata', 'left')
            ->join('pegawai p', 'p.idpegawai = r.created_by', 'left')
            ->where('r.idkacamata', $idkacamata)
            ->orderBy('r.created_at', 'DESC')
            ->limit(50)
            ->get()->getResultArray();

        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }
}
