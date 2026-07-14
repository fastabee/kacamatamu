<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // ── Statistik produk ──────────────────────────────────────────
        $totalFrame    = $db->table('frame')->countAllResults();
        $totalLensa    = $db->table('lensa')->where('deleted', 0)->countAllResults();
        $totalKacamata = $db->table('kacamata')->where('deleted', 0)->countAllResults();
        $totalSupplier = $db->table('vendor')->where('deleted', 0)->countAllResults();
        $totalCustomer = $db->table('customer')->countAllResults();

        // ── Stok menipis (≤ 5) ───────────────────────────────────────
        $stokMenipisFrame = $db->table('stok_frame sf')
            ->select('f.nama_frame as nama, sf.jumlah')
            ->join('frame f', 'f.idframe = sf.idframe', 'left')
            ->where('sf.jumlah <=', 5)
            ->orderBy('sf.jumlah', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        $stokMenipisLensa = $db->table('stok_lensa sl')
            ->select('l.nama_lensa as nama, sl.jumlah')
            ->join('lensa l', 'l.idframe = sl.idlensa', 'left')
            ->where('sl.jumlah <=', 5)
            ->where('l.deleted', 0)
            ->orderBy('sl.jumlah', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        $stokMenipisKacamata = $db->table('stok_kacamata sk')
            ->select('k.nama_kacamata as nama, sk.jumlah')
            ->join('kacamata k', 'k.idkacamata = sk.idkacamata', 'left')
            ->where('sk.jumlah <=', 5)
            ->where('k.deleted', 0)
            ->orderBy('sk.jumlah', 'ASC')
            ->limit(5)
            ->get()->getResultArray();

        // ── Transaksi bulan ini ───────────────────────────────────────
        $bulanIni = date('Y-m');

        $pembelianBulanIni = $db->table('pembelian')
            ->selectSum('total')
            ->like('created_at', $bulanIni)
            ->get()->getRow();

        $penjualanBulanIni = $db->table('penjualan')
            ->selectSum('grand_total')
            ->like('created_at', $bulanIni)
            ->get()->getRow();

        $totalPembelian = (int) ($pembelianBulanIni->total ?? 0);
        $totalPenjualan = (int) ($penjualanBulanIni->grand_total ?? 0);

        // ── Transaksi penjualan 7 hari terakhir (chart) ──────────────
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl    = date('Y-m-d', strtotime("-{$i} days"));
            $label  = date('d/m', strtotime($tgl));
            $row    = $db->table('penjualan')
                ->selectSum('grand_total', 'total')
                ->where('DATE(created_at)', $tgl)
                ->get()->getRow();
            $chartData[] = [
                'label' => $label,
                'total' => (int) ($row->total ?? 0),
            ];
        }

        // ── 5 Penjualan terakhir ──────────────────────────────────────
        $penjualanTerakhir = $db->table('penjualan p')
            ->select('p.idpenjualan, p.no_transaksi, p.grand_total, p.created_at, c.nama_customer')
            ->join('customer c', 'c.idcustomer = p.idcustomer', 'left')
            ->orderBy('p.idpenjualan', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('template', [
            'body'                => 'dashboard',
            'totalFrame'          => $totalFrame,
            'totalLensa'          => $totalLensa,
            'totalKacamata'       => $totalKacamata,
            'totalSupplier'       => $totalSupplier,
            'totalCustomer'       => $totalCustomer,
            'stokMenipisFrame'    => $stokMenipisFrame,
            'stokMenipisLensa'    => $stokMenipisLensa,
            'stokMenipisKacamata' => $stokMenipisKacamata,
            'totalPembelian'      => $totalPembelian,
            'totalPenjualan'      => $totalPenjualan,
            'chartData'           => $chartData,
            'penjualanTerakhir'   => $penjualanTerakhir,
        ]);
    }
}
