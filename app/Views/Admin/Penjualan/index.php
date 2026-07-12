<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Penjualan</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPenjualan">
                        <i class="ti ti-plus me-1"></i> Tambah Penjualan
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblPenjualan" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>No. Transaksi</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Diskon</th>
                                <th>Grand Total</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th width="130">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL TAMBAH PENJUALAN ===== -->
<div class="modal fade" id="modalTambahPenjualan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Header -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Customer</label>
                        <select class="form-select" id="idcustomer">
                            <option value="">-- Umum / Tanpa Customer --</option>
                            <?php foreach ($customer_list as $c): ?>
                                <option value="<?= $c['idcustomer'] ?>"><?= esc($c['nama_customer']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Diskon (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" id="inputDiskon" placeholder="0" value="0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keteranganJual" placeholder="Opsional">
                    </div>
                </div>

                <!-- Tambah Item -->
                <div class="card border mb-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Tambah Item</h6>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Jenis Produk</label>
                                <select class="form-select" id="jenisProdukJual">
                                    <option value="lensa">Lensa</option>
                                    <option value="frame">Frame</option>
                                    <option value="kacamata">Kacamata</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Produk</label>
                                <select class="form-select" id="selectProdukJual" style="width:100%">
                                    <option value="">-- Cari Produk --</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Harga Jual</label>
                                <input type="text" class="form-control" id="hargaJual" placeholder="0">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlahItemJual" min="1" value="1">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success w-100" id="btnTambahItemJual">
                                    <i class="ti ti-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Item -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Jenis</th>
                                <th>Nama Produk</th>
                                <th>Harga Jual</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyItemJual">
                            <tr id="trEmptyJual"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold table-light">
                                <td colspan="4" class="text-end">Total</td>
                                <td colspan="2" id="lblTotal">Rp 0</td>
                            </tr>
                            <tr class="fw-bold table-warning">
                                <td colspan="4" class="text-end">Diskon</td>
                                <td colspan="2" id="lblDiskon">Rp 0</td>
                            </tr>
                            <tr class="fw-bold table-success">
                                <td colspan="4" class="text-end">Grand Total</td>
                                <td colspan="2" id="lblGrandTotal">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanPenjualan">
                    <i class="ti ti-device-floppy me-1"></i> Simpan Penjualan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL DETAIL ===== -->
<div class="modal fade" id="modalDetailJual" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDetailJualBody">
                <div class="text-center py-4"><span class="spinner-border"></span></div>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_JUAL = "<?= base_url() ?>";

// ===== DataTable =====
const tblPenjualan = $('#tblPenjualan').DataTable({
    processing: true, serverSide: true,
    ajax: { url: BASE_JUAL + 'penjualan/datatable', type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'no_transaksi' },
        { data: 'nama_customer' },
        { data: 'total' },
        { data: 'diskon' },
        { data: 'grand_total' },
        { data: 'created_at' },
        { data: 'input_by' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

// ===== Format Rupiah =====
function fmtRpJ(val) { return parseInt(val || 0).toLocaleString('id-ID'); }
function stripRpJ(val) { return String(val).replace(/\./g, '').replace(/[^0-9]/g, ''); }

$('#hargaJual, #inputDiskon').on('input', function () {
    let raw = stripRpJ($(this).val());
    $(this).val(raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
    hitungTotalJual();
});

// ===== Select2 produk AJAX =====
function initSelectProdukJual() {
    $('#selectProdukJual').select2({
        dropdownParent: $('#modalTambahPenjualan'),
        width: '100%', theme: 'bootstrap-5',
        placeholder: '-- Cari Produk --', allowClear: true,
        ajax: {
            url: BASE_JUAL + 'penjualan/search-produk',
            dataType: 'json', delay: 300,
            data: function (params) {
                return { jenis: $('#jenisProdukJual').val(), q: params.term };
            },
            processResults: function (data) { return data; },
        },
    }).on('select2:select', function (e) {
        const harga = e.params.data.harga ?? 0;
        $('#hargaJual').val(fmtRpJ(harga));
    });
}

$('#modalTambahPenjualan').on('shown.bs.modal', function () {
    initSelectProdukJual();
    $('#idcustomer').select2({ dropdownParent: $('#modalTambahPenjualan'), width: '100%', theme: 'bootstrap-5' });
});

$('#jenisProdukJual').on('change', function () {
    $('#selectProdukJual').val(null).trigger('change');
    $('#hargaJual').val('');
});

$('#modalTambahPenjualan').on('hidden.bs.modal', function () {
    $('#idcustomer').val('').trigger('change');
    $('#keteranganJual, #inputDiskon').val('');
    $('#inputDiskon').val('0');
    $('#tbodyItemJual').html('<tr id="trEmptyJual"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>');
    ['#lblTotal','#lblDiskon','#lblGrandTotal'].forEach(id => $(id).text('Rp 0'));
    itemListJual = [];
});

// ===== State item =====
let itemListJual = [];

function hitungTotalJual() {
    const total     = itemListJual.reduce((s, i) => s + i.subtotal, 0);
    const diskon    = parseInt(stripRpJ($('#inputDiskon').val())) || 0;
    const grandTotal = Math.max(0, total - diskon);
    $('#lblTotal').text('Rp ' + fmtRpJ(total));
    $('#lblDiskon').text('Rp ' + fmtRpJ(diskon));
    $('#lblGrandTotal').text('Rp ' + fmtRpJ(grandTotal));
}

function renderItemsJual() {
    if (!itemListJual.length) {
        $('#tbodyItemJual').html('<tr id="trEmptyJual"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>');
        hitungTotalJual();
        return;
    }
    let html = '';
    itemListJual.forEach((item, i) => {
        html += `<tr>
            <td><span class="badge bg-secondary">${item.jenis_produk}</span></td>
            <td>${item.nama_produk}</td>
            <td>Rp ${fmtRpJ(item.harga_jual)}</td>
            <td>${item.jumlah}</td>
            <td>Rp ${fmtRpJ(item.subtotal)}</td>
            <td><button class="btn btn-sm btn-danger btn-hapus-item-jual" data-idx="${i}"><i class="ti ti-x"></i></button></td>
        </tr>`;
    });
    $('#tbodyItemJual').html(html);
    hitungTotalJual();
}

// ===== Tambah Item =====
$('#btnTambahItemJual').on('click', function () {
    const produkOpt = $('#selectProdukJual').select2('data')[0];
    if (!produkOpt || !produkOpt.id) { Swal.fire('Perhatian', 'Pilih produk terlebih dahulu', 'warning'); return; }
    const jumlah   = parseInt($('#jumlahItemJual').val()) || 1;
    const harga    = parseInt(stripRpJ($('#hargaJual').val())) || 0;

    itemListJual.push({
        jenis_produk: $('#jenisProdukJual').val(),
        idproduk:     produkOpt.id,
        nama_produk:  produkOpt.text,
        harga_jual:   harga,
        jumlah,
        subtotal: harga * jumlah,
    });

    renderItemsJual();
    $('#selectProdukJual').val(null).trigger('change');
    $('#hargaJual').val('');
    $('#jumlahItemJual').val(1);
});

$(document).on('click', '.btn-hapus-item-jual', function () {
    itemListJual.splice($(this).data('idx'), 1);
    renderItemsJual();
});

// ===== Simpan Penjualan =====
$('#btnSimpanPenjualan').on('click', function () {
    if (!itemListJual.length) { Swal.fire('Perhatian', 'Tambahkan minimal 1 item!', 'warning'); return; }

    const total     = itemListJual.reduce((s, i) => s + i.subtotal, 0);
    const diskon    = parseInt(stripRpJ($('#inputDiskon').val())) || 0;
    const $btn      = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    $.ajax({
        url: BASE_JUAL + 'penjualan/store', method: 'POST',
        data: {
            idcustomer:  $('#idcustomer').val() || '',
            keterangan:  $('#keteranganJual').val(),
            total, diskon,
            items: JSON.stringify(itemListJual),
        },
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalTambahPenjualan').modal('hide');
                tblPenjualan.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        complete: function () {
            $btn.prop('disabled', false).html('<i class="ti ti-device-floppy me-1"></i> Simpan Penjualan');
        }
    });
});

// ===== Lihat Detail =====
$(document).on('click', '.btn-detail', function () {
    const id = $(this).data('id');
    $('#modalDetailJualBody').html('<div class="text-center py-4"><span class="spinner-border"></span></div>');
    $('#modalDetailJual').modal('show');

    $.get(BASE_JUAL + 'penjualan/detail/' + id, function (res) {
        const p = res.penjualan;
        let rows = '';
        res.details.forEach(d => {
            rows += `<tr>
                <td><span class="badge bg-secondary">${d.jenis_produk}</span></td>
                <td>${d.nama_produk}</td>
                <td>Rp ${fmtRpJ(d.harga_jual)}</td>
                <td>${d.jumlah}</td>
                <td>Rp ${fmtRpJ(d.subtotal)}</td>
            </tr>`;
        });

        $('#modalDetailJualBody').html(`
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>No. Transaksi:</strong> ${p.no_transaksi}</p>
                    <p class="mb-1"><strong>Customer:</strong> ${p.nama_customer ?? 'Umum'}</p>
                    <p class="mb-1"><strong>Keterangan:</strong> ${p.keterangan ?? '-'}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal:</strong> ${p.created_at}</p>
                    <p class="mb-1"><strong>Kasir:</strong> ${p.nama_pegawai ?? '-'}</p>
                    <p class="mb-1"><strong>Total:</strong> Rp ${fmtRpJ(p.total)}</p>
                    <p class="mb-1"><strong>Diskon:</strong> Rp ${fmtRpJ(p.diskon)}</p>
                    <p class="mb-1"><strong>Grand Total:</strong>
                        <span class="fw-bold text-success fs-5">Rp ${fmtRpJ(p.grand_total)}</span>
                    </p>
                </div>
            </div>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr><th>Jenis</th><th>Nama Produk</th><th>Harga Jual</th><th>Jumlah</th><th>Subtotal</th></tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        `);
    });
});

// ===== Hapus =====
$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus penjualan ini?',
        text: 'Stok akan di-rollback otomatis',
        icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
    }).then(result => {
        if (result.isConfirmed) {
            $.get(BASE_JUAL + 'penjualan/delete/' + id, function (res) {
                if (res.status === 'ok') {
                    tblPenjualan.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1500, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
