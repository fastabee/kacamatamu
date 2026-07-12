<?php

use App\Controllers\KategoriKegiatan;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('login', 'Auth::index');
$routes->post('proses_login', 'Auth::proses_login');
$routes->get('logout', 'Auth::logout');

$routes->get('/', 'Home::index', ['filter' => 'auth']);

//penduduk
$routes->get('data_penduduk', 'Penduduk::index', ['filter' => 'auth']);
$routes->get('data_penduduk_meninggal', 'Penduduk::index_meninggal', ['filter' => 'auth']);
$routes->get('formulir/data_penduduk', 'Penduduk::insert_formulir', ['filter' => 'auth']);
$routes->post('insert/penduduk', 'Penduduk::insert_penduduk', ['filter' => 'auth']);
$routes->get('edit/data_penduduk/(:num)', 'Penduduk::edit_data_penduduk/$1', ['filter' => 'auth']);

$routes->get('check/data_penduduk/(:num)', 'Penduduk::edit_data_penduduk2/$1', ['filter' => 'auth']);
$routes->post('update/penduduk/(:num)', 'Penduduk::update_data_penduduk/$1', ['filter' => 'auth']);
$routes->get('penduduk/delete/(:num)', 'Penduduk::delete_penduduk/$1', ['filter' => 'auth']);
$routes->post('penduduk/updateStatus', 'Penduduk::update_status', ['filter' => 'auth']);
$routes->get('export/penduduk', 'Penduduk::export_penduduk', ['filter' => 'auth']);
$routes->get('export/penduduk_meninggal', 'Penduduk::export_penduduk_meninggal', ['filter' => 'auth']);
$routes->post('import/penduduk', 'Penduduk::import_penduduk', ['filter' => 'auth']);
$routes->get('penduduk/datatable', 'Penduduk::datatablePenduduk', ['filter' => 'auth']);
$routes->get('penduduk/datatableMeninggal', 'Penduduk::datatablePendudukMeninggal', ['filter' => 'auth']);
$routes->get('penduduk/filterOptions', 'Penduduk::filterOptions', ['filter' => 'auth']);
$routes->get('penduduk/getDesaByKecamatanFilter', 'Penduduk::getDesaByKecamatanFilter', ['filter' => 'auth']);
$routes->get('penduduk/getDusunRtRwByDesaFilter', 'Penduduk::getDusunRtRwByDesaFilter', ['filter' => 'auth']);
$routes->get('penduduk/filterOptionsMeninggal', 'Penduduk::filterOptionsMeninggal', ['filter' => 'auth']);
$routes->get('penduduk/getDesaByKecamatanFilterMeninggal', 'Penduduk::getDesaByKecamatanFilterMeninggal', ['filter' => 'auth']);
$routes->get('penduduk/getDusunRtRwByDesaFilterMeninggal', 'Penduduk::getDusunRtRwByDesaFilterMeninggal', ['filter' => 'auth']);

//get alamat penduduk dropdown
$routes->get('penduduk/getKabupatenByProvinsi/(:any)', 'Penduduk::getKabupatenByProvinsi/$1');
$routes->get('penduduk/getKecamatanByKabupaten/(:any)', 'Penduduk::getKecamatanByKabupaten/$1');
$routes->get('penduduk/getDesaByKecamatan/(:any)', 'Penduduk::getDesaByKecamatan/$1');


//jadwal sumbangan
$routes->get('jadwal_sumbangan', 'JadwalSumbangan::index', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/datatable', 'JadwalSumbangan::datatableJadwal', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/ajax_detail/(:num)', 'JadwalSumbangan::ajaxDetailJadwal/$1', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/datatable_detail/(:num)', 'JadwalSumbangan::datatableDetailJadwal/$1', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/filter_options/(:num)', 'JadwalSumbangan::getFilterOptionsDetail/$1', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/filter_desa/(:num)', 'JadwalSumbangan::getDesaFilterDetail/$1', ['filter' => 'auth']);
$routes->get('jadwal_sumbangan/filter_dusun_rt_rw/(:num)', 'JadwalSumbangan::getDusunRtRwFilterDetail/$1', ['filter' => 'auth']);
$routes->get('pelaksanaan_sumbangan', 'JadwalSumbangan::pelaksanaan_sumbangan', ['filter' => 'auth']);
$routes->post('simpan_tanggal_sumbangan', 'JadwalSumbangan::simpan_jadwal_pelaksanaan', ['filter' => 'auth']);
$routes->get('delete_jadwal_sumbangan/(:num)', 'JadwalSumbangan::delete_jadwal/$1', ['filter' => 'auth']);
$routes->get('detail/jadwal_sumbangan/(:num)', 'JadwalSumbangan::detail_jadwal/$1', ['filter' => 'auth']);
$routes->post('update/jadwalpelaksanaan', 'JadwalSumbangan::update_jadwalsumbangan', ['filter' => 'auth']);
$routes->get('pelaksanaan/jadwal_sumbangan/(:num)', 'JadwalSumbangan::list_pelaksanaan_sumbangan/$1', ['filter' => 'auth']);
$routes->post('terverifikasi/sumbangan/(:num)/(:num)', 'JadwalSumbangan::verivikasi_penduduk_sumbangan/$1/$2', ['filter' => 'auth']);
$routes->get('terlaksana_jadwal_sumbangan/(:num)', 'JadwalSumbangan::terlaksana_sumbangan/$1', ['filter' => 'auth']);
$routes->get('export/jadwal_detail/(:num)', 'JadwalSumbangan::jadwalDetailExcel/$1', ['filter' => 'auth']);
$routes->get('export/penduduk_tercetak/(:num)', 'JadwalSumbangan::tercetaktoExcel/$1', ['filter' => 'auth']);
$routes->get('transfer/berhasil/(:num)/(:num)', 'JadwalSumbangan::verivikasi_transfer_berhasil/$1/$2', ['filter' => 'auth']);
$routes->get('export/pelaksanaan_detail/(:num)', 'JadwalSumbangan::pelaksanaanDetailExcel/$1', ['filter' => 'auth']);
$routes->post('import/jadwal_undangan/(:num)', 'JadwalSumbangan::importJadwalUndangan/$1', ['filter' => 'auth']);
$routes->get('download/template_import_undangan', 'JadwalSumbangan::downloadTemplateImportUndangan', ['filter' => 'auth']);
$routes->post('penduduk/updateStatus2', 'Penduduk::update_status2', ['filter' => 'auth']);

//printundangan
$routes->get('print/jadwal_detail/(:num)', 'JadwalSumbangan::print_semuaundangan/$1', ['filter' => 'auth']);
$routes->get('cetak/undangan/(:num)/(:num)', 'JadwalSumbangan::print_undangansatuan/$1/$2', ['filter' => 'auth']);
//Rekening
$routes->get('data_rekening', 'Rekening::index', ['filter' => 'auth']);
$routes->post('input_nama_rekening', 'Rekening::insert', ['filter' => 'auth']);
$routes->post('update_rekening', 'Rekening::edit', ['filter' => 'auth']);

//Kategori Kegiatan
$routes->get('kategori_kegiatan', 'KategoriKegiatan::index', ['filter' => 'auth']);
$routes->post('input_kategori_kegiatan', 'KategoriKegiatan::insert', ['filter' => 'auth']);
$routes->post('update_kategori_kegiatan', 'KategoriKegiatan::edit', ['filter' => 'auth']);


//Wakil Penerima
$routes->get('data_wakil', 'WakilPenerima::index', ['filter' => 'auth']);
$routes->get('formulir/data_wakilpenerima', 'WakilPenerima::insert_formulir', ['filter' => 'auth']);
$routes->post('insert/wakil_penerima', 'WakilPenerima::insert_wakil_penerima', ['filter' => 'auth']);
$routes->get('edit/data_wakil/(:num)', 'WakilPenerima::edit_data_wakil/$1', ['filter' => 'auth']);
$routes->post('update/wakil/(:num)', 'WakilPenerima::update_wakil_penerima/$1', ['filter' => 'auth']);
$routes->get('data_wakil/delete/(:num)', 'WakilPenerima::delete_wakil/$1', ['filter' => 'auth']);
$routes->get('check/data_wakil/(:num)', 'WakilPenerima::edit_data_wakil2/$1', ['filter' => 'auth']);
$routes->get('export/wakil-penerima', 'WakilPenerima::export_wakil_penerima', ['filter' => 'auth']);
$routes->post('import/wakil-penerima', 'WakilPenerima::import_wakil_penerima', ['filter' => 'auth']);
$routes->get('wakil/datatable', 'WakilPenerima::datatableWakil', ['filter' => 'auth']);
$routes->get('wakil/filterOptions', 'WakilPenerima::filterOptionsWakil', ['filter' => 'auth']);
$routes->get('wakil/getDesaByKecamatan', 'WakilPenerima::getDesaByKecamatanWakil', ['filter' => 'auth']);
$routes->get('wakil/getDusunRtRwByDesa', 'WakilPenerima::getDusunRtRwByDesaWakil', ['filter' => 'auth']);

$routes->get('contoh_undangan', 'TestPdf::contoh_undangan', ['filter' => 'auth']);

//penarikan
$routes->get('penarikan/list', 'Penarikan::index', ['filtes' => 'auth']);
$routes->get('penarikan/detail/(:num)', 'Penarikan::detail_saldo/$1', ['filtes' => 'auth']);
$routes->post('penarikan/simpan', 'Penarikan::simpan_satuan', ['filtes' => 'auth']);
$routes->get('format_excell/penarikan_saldo', 'Penarikan::download_format_excell', ['filtes' => 'auth']);
$routes->post('import/penarikan', 'Penarikan::import_penarikan', ['filtes' => 'auth']);

// Lensa
$routes->get('lensa', 'Admin\DataMaster\Lensa::index', ['filter' => 'auth']);
$routes->get('lensa/datatable', 'Admin\DataMaster\Lensa::datatable', ['filter' => 'auth']);
$routes->get('lensa/get/(:num)', 'Admin\DataMaster\Lensa::getById/$1', ['filter' => 'auth']);
$routes->post('lensa/store', 'Admin\DataMaster\Lensa::store', ['filter' => 'auth']);
$routes->post('lensa/update/(:num)', 'Admin\DataMaster\Lensa::update/$1', ['filter' => 'auth']);
$routes->get('lensa/delete/(:num)', 'Admin\DataMaster\Lensa::delete/$1', ['filter' => 'auth']);
$routes->post('lensa/bentuk/store', 'Admin\DataMaster\Lensa::storeBentuk', ['filter' => 'auth']);
$routes->post('lensa/bahan/store', 'Admin\DataMaster\Lensa::storeBahan', ['filter' => 'auth']);

// Frame
$routes->get('frame', 'Admin\DataMaster\Frame::index', ['filter' => 'auth']);
$routes->get('frame/datatable', 'Admin\DataMaster\Frame::datatable', ['filter' => 'auth']);
$routes->get('frame/get/(:num)', 'Admin\DataMaster\Frame::getById/$1', ['filter' => 'auth']);
$routes->post('frame/store', 'Admin\DataMaster\Frame::store', ['filter' => 'auth']);
$routes->post('frame/update/(:num)', 'Admin\DataMaster\Frame::update/$1', ['filter' => 'auth']);
$routes->get('frame/delete/(:num)', 'Admin\DataMaster\Frame::delete/$1', ['filter' => 'auth']);
$routes->post('frame/bentuk/store', 'Admin\DataMaster\Frame::storeBentuk', ['filter' => 'auth']);
$routes->post('frame/bahan/store', 'Admin\DataMaster\Frame::storeBahan', ['filter' => 'auth']);

// Kacamata
$routes->get('kacamata', 'Admin\DataMaster\Kacamata::index', ['filter' => 'auth']);
$routes->get('kacamata/datatable', 'Admin\DataMaster\Kacamata::datatable', ['filter' => 'auth']);
$routes->get('kacamata/get/(:num)', 'Admin\DataMaster\Kacamata::getById/$1', ['filter' => 'auth']);
$routes->post('kacamata/store', 'Admin\DataMaster\Kacamata::store', ['filter' => 'auth']);
$routes->post('kacamata/update/(:num)', 'Admin\DataMaster\Kacamata::update/$1', ['filter' => 'auth']);
$routes->get('kacamata/delete/(:num)', 'Admin\DataMaster\Kacamata::delete/$1', ['filter' => 'auth']);

// Pembelian
$routes->get('pembelian', 'Admin\Pembelian\PembelianController::index', ['filter' => 'auth']);
$routes->get('pembelian/datatable', 'Admin\Pembelian\PembelianController::datatable', ['filter' => 'auth']);
$routes->get('pembelian/search-produk', 'Admin\Pembelian\PembelianController::searchProduk', ['filter' => 'auth']);
$routes->post('pembelian/store', 'Admin\Pembelian\PembelianController::store', ['filter' => 'auth']);
$routes->get('pembelian/detail/(:num)', 'Admin\Pembelian\PembelianController::detail/$1', ['filter' => 'auth']);
$routes->get('pembelian/cetak/(:num)', 'Admin\Pembelian\PembelianController::cetakNota/$1', ['filter' => 'auth']);
$routes->get('pembelian/delete/(:num)', 'Admin\Pembelian\PembelianController::delete/$1', ['filter' => 'auth']);

// Penjualan
$routes->get('penjualan', 'Admin\Penjualan\PenjualanController::index', ['filter' => 'auth']);
$routes->get('penjualan/datatable', 'Admin\Penjualan\PenjualanController::datatable', ['filter' => 'auth']);
$routes->get('penjualan/search-produk', 'Admin\Penjualan\PenjualanController::searchProduk', ['filter' => 'auth']);
$routes->post('penjualan/store', 'Admin\Penjualan\PenjualanController::store', ['filter' => 'auth']);
$routes->get('penjualan/detail/(:num)', 'Admin\Penjualan\PenjualanController::detail/$1', ['filter' => 'auth']);
$routes->get('penjualan/cetak/(:num)', 'Admin\Penjualan\PenjualanController::cetakNota/$1', ['filter' => 'auth']);
$routes->get('penjualan/delete/(:num)', 'Admin\Penjualan\PenjualanController::delete/$1', ['filter' => 'auth']);

// Customer
$routes->get('customer', 'Admin\DataMaster\Customer::index', ['filter' => 'auth']);
$routes->get('customer/datatable', 'Admin\DataMaster\Customer::datatable', ['filter' => 'auth']);
$routes->post('customer/store', 'Admin\DataMaster\Customer::store', ['filter' => 'auth']);
$routes->post('customer/update/(:num)', 'Admin\DataMaster\Customer::update/$1', ['filter' => 'auth']);
$routes->get('customer/delete/(:num)', 'Admin\DataMaster\Customer::delete/$1', ['filter' => 'auth']);

// Supplier
$routes->get('supplier', 'Admin\DataMaster\Supplier::index', ['filter' => 'auth']);
$routes->get('supplier/datatable', 'Admin\DataMaster\Supplier::datatable', ['filter' => 'auth']);
$routes->post('supplier/store', 'Admin\DataMaster\Supplier::store', ['filter' => 'auth']);
$routes->post('supplier/update/(:num)', 'Admin\DataMaster\Supplier::update/$1', ['filter' => 'auth']);
$routes->get('supplier/delete/(:num)', 'Admin\DataMaster\Supplier::delete/$1', ['filter' => 'auth']);
$routes->get('stok/frame',               'Admin\Stok\StokController::frame',            ['filter' => 'auth']);
$routes->get('stok/frame/datatable',     'Admin\Stok\StokController::datatableFrame',   ['filter' => 'auth']);
$routes->post('stok/frame/transaksi',    'Admin\Stok\StokController::transaksiFrame',   ['filter' => 'auth']);
$routes->get('stok/frame/riwayat/(:num)','Admin\Stok\StokController::riwayatFrame/$1', ['filter' => 'auth']);

$routes->get('stok/lensa',               'Admin\Stok\StokController::lensa',            ['filter' => 'auth']);
$routes->get('stok/lensa/datatable',     'Admin\Stok\StokController::datatableLensa',   ['filter' => 'auth']);
$routes->post('stok/lensa/transaksi',    'Admin\Stok\StokController::transaksiLensa',   ['filter' => 'auth']);
$routes->get('stok/lensa/riwayat/(:num)','Admin\Stok\StokController::riwayatLensa/$1', ['filter' => 'auth']);

$routes->get('stok/kacamata',                'Admin\Stok\StokController::kacamata',            ['filter' => 'auth']);
$routes->get('stok/kacamata/datatable',      'Admin\Stok\StokController::datatableKacamata',   ['filter' => 'auth']);
$routes->post('stok/kacamata/transaksi',     'Admin\Stok\StokController::transaksiKacamata',   ['filter' => 'auth']);
$routes->get('stok/kacamata/riwayat/(:num)', 'Admin\Stok\StokController::riwayatKacamata/$1',  ['filter' => 'auth']);
