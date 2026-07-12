<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Pembelian</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPembelian">
                        <i class="ti ti-plus me-1"></i> Tambah Pembelian
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblPembelian" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>No. Pembelian</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Input By</th>
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

<!-- ===== MODAL TAMBAH PEMBELIAN ===== -->
<div class="modal fade" id="modalTambahPembelian" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Header -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select class="form-select" id="idsupplier">
                            <option value="">-- Pilih Supplier --</option>
                            <?php foreach ($supplier_list as $s): ?>
                                <option value="<?= $s['idsupplier'] ?>"><?= esc($s['nama_supplier']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Opsional">
                    </div>
                </div>

                <!-- Tambah Item -->
                <div class="card border mb-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Tambah Item</h6>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Jenis Produk</label>
                                <select class="form-select" id="jenisProduk">
                                    <option value="lensa">Lensa</option>
                                    <option value="frame">Frame</option>
                                    <option value="kacamata">Kacamata</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Produk</label>
                                <select class="form-select" id="selectProduk" style="width:100%">
                                    <option value="">-- Cari Produk --</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Harga Beli</label>
                                <input type="text" class="form-control" id="hargaBeli" placeholder="0">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlahItem" min="1" value="1">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success w-100" id="btnTambahItem">
                                    <i class="ti ti-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Item -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle" id="tblItem">
                        <thead class="table-secondary">
                            <tr>
                                <th>Jenis</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th width="60"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyItem">
                            <tr id="trEmpty"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="4" class="text-end">Total</td>
                                <td id="grandTotal" colspan="2">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanPembelian">
                    <i class="ti ti-device-floppy me-1"></i> Simpan Pembelian
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL DETAIL ===== -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDetailBody">
                <div class="text-center py-4"><span class="spinner-border"></span></div>
            </div>
        </div>
    </div>
</div>

<script>
const BASE = "<?= base_url() ?>";

// ===== DataTable =====
const tblPembelian = $('#tblPembelian').DataTable({
    processing: true, serverSide: true,
    ajax: { url: BASE + 'pembelian/datatable', type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'no_pembelian' },
        { data: 'nama_supplier' },
        { data: 'total' },
        { data: 'created_at' },
        { data: 'input_by' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

// ===== Format Rupiah =====
function fmtRp(val) {
    return parseInt(val || 0).toLocaleString('id-ID');
}
function stripRp(val) {
    return String(val).replace(/\./g, '').replace(/[^0-9]/g, '');
}

$('#hargaBeli').on('input', function () {
    let raw = stripRp($(this).val());
    $(this).val(raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
});

// ===== Select2 produk dengan AJAX =====
function initSelectProduk() {
    $('#selectProduk').select2({
        dropdownParent: $('#modalTambahPembelian'),
        width: '100%',
        theme: 'bootstrap-5',
        placeholder: '-- Cari Produk --',
        allowClear: true,
        ajax: {
            url: BASE + 'pembelian/search-produk',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return { jenis: $('#jenisProduk').val(), q: params.term };
            },
            processResults: function (data) { return data; },
        },
    }).on('select2:select', function (e) {
        const harga = e.params.data.harga ?? 0;
        $('#hargaBeli').val(fmtRp(harga));
    });
}

$('#modalTambahPembelian').on('shown.bs.modal', function () {
    initSelectProduk();
    $('#idsupplier').select2({ dropdownParent: $('#modalTambahPembelian'), width: '100%', theme: 'bootstrap-5' });
});

// Reset produk select saat jenis berubah
$('#jenisProduk').on('change', function () {
    $('#selectProduk').val(null).trigger('change');
    $('#hargaBeli').val('');
});

// Reset modal saat tutup
$('#modalTambahPembelian').on('hidden.bs.modal', function () {
    $('#idsupplier').val('').trigger('change');
    $('#keterangan').val('');
    $('#tbodyItem').html('<tr id="trEmpty"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>');
    $('#grandTotal').text('Rp 0');
    itemList = [];
});

// ===== State item list =====
let itemList = [];

function renderItems() {
    if (!itemList.length) {
        $('#tbodyItem').html('<tr id="trEmpty"><td colspan="6" class="text-center text-muted">Belum ada item</td></tr>');
        $('#grandTotal').text('Rp 0');
        return;
    }
    let html = '';
    let total = 0;
    itemList.forEach((item, i) => {
        total += item.subtotal;
        html += `<tr>
            <td><span class="badge bg-secondary">${item.jenis_produk}</span></td>
            <td>${item.nama_produk}</td>
            <td>Rp ${fmtRp(item.harga_beli)}</td>
            <td>${item.jumlah}</td>
            <td>Rp ${fmtRp(item.subtotal)}</td>
            <td><button class="btn btn-sm btn-danger btn-hapus-item" data-idx="${i}"><i class="ti ti-x"></i></button></td>
        </tr>`;
    });
    $('#tbodyItem').html(html);
    $('#grandTotal').text('Rp ' + fmtRp(total));
}

// ===== Tambah Item =====
$('#btnTambahItem').on('click', function () {
    const produkOpt = $('#selectProduk').select2('data')[0];
    if (!produkOpt || !produkOpt.id) { Swal.fire('Perhatian', 'Pilih produk terlebih dahulu', 'warning'); return; }
    const jumlah   = parseInt($('#jumlahItem').val()) || 1;
    const harga    = parseInt(stripRp($('#hargaBeli').val())) || 0;
    const subtotal = harga * jumlah;

    itemList.push({
        jenis_produk: $('#jenisProduk').val(),
        idproduk:     produkOpt.id,
        nama_produk:  produkOpt.text,
        harga_beli:   harga,
        jumlah,
        subtotal,
    });

    renderItems();
    $('#selectProduk').val(null).trigger('change');
    $('#hargaBeli').val('');
    $('#jumlahItem').val(1);
});

// ===== Hapus item dari list =====
$(document).on('click', '.btn-hapus-item', function () {
    itemList.splice($(this).data('idx'), 1);
    renderItems();
});

// ===== Simpan Pembelian =====
$('#btnSimpanPembelian').on('click', function () {
    if (!$('#idsupplier').val()) { Swal.fire('Perhatian', 'Pilih supplier!', 'warning'); return; }
    if (!itemList.length) { Swal.fire('Perhatian', 'Tambahkan minimal 1 item!', 'warning'); return; }

    const total = itemList.reduce((s, i) => s + i.subtotal, 0);
    const $btn  = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    $.ajax({
        url: BASE + 'pembelian/store', method: 'POST',
        data: {
            idsupplier:  $('#idsupplier').val(),
            keterangan:  $('#keterangan').val(),
            total,
            items: JSON.stringify(itemList),
        },
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalTambahPembelian').modal('hide');
                tblPembelian.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        complete: function () { $btn.prop('disabled', false).html('<i class="ti ti-device-floppy me-1"></i> Simpan Pembelian'); }
    });
});

// ===== Lihat Detail =====
$(document).on('click', '.btn-detail', function () {
    const id = $(this).data('id');
    $('#modalDetailBody').html('<div class="text-center py-4"><span class="spinner-border"></span></div>');
    $('#modalDetail').modal('show');

    $.get(BASE + 'pembelian/detail/' + id, function (res) {
        const p = res.pembelian;
        let detailHtml = '';
        res.details.forEach(d => {
            detailHtml += `<tr>
                <td><span class="badge bg-secondary">${d.jenis_produk}</span></td>
                <td>${d.nama_produk}</td>
                <td>Rp ${fmtRp(d.harga_beli)}</td>
                <td>${d.jumlah}</td>
                <td>Rp ${fmtRp(d.subtotal)}</td>
            </tr>`;
        });

        $('#modalDetailBody').html(`
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>No. Pembelian:</strong> ${p.no_pembelian}</p>
                    <p class="mb-1"><strong>Supplier:</strong> ${p.nama_supplier ?? '-'}</p>
                    <p class="mb-1"><strong>Keterangan:</strong> ${p.keterangan ?? '-'}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal:</strong> ${p.created_at}</p>
                    <p class="mb-1"><strong>Input By:</strong> ${p.nama_pegawai ?? '-'}</p>
                    <p class="mb-1"><strong>Total:</strong> <span class="fw-bold text-primary">Rp ${fmtRp(p.total)}</span></p>
                </div>
            </div>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr><th>Jenis</th><th>Nama Produk</th><th>Harga Beli</th><th>Jumlah</th><th>Subtotal</th></tr>
                </thead>
                <tbody>${detailHtml}</tbody>
            </table>
        `);
    });
});

// ===== Hapus =====
$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus pembelian ini?',
        text: 'Stok akan di-rollback otomatis',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
    }).then(result => {
        if (result.isConfirmed) {
            $.get(BASE + 'pembelian/delete/' + id, function (res) {
                if (res.status === 'ok') {
                    tblPembelian.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1500, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
