<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Lensa</h5>
                    <button class="btn btn-primary btn-sm" id="btnTambah">
                        <i class="ti ti-plus me-1"></i> Tambah Lensa
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblLensa" class="table table-bordered table-hover align-middle w-100">
                        <thead >
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Lensa</th>
                                <th>Bentuk Lensa</th>
                                <th>Bahan Lensa</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL TAMBAH / EDIT LENSA ===== -->
<div class="modal fade" id="modalLensa" tabindex="-1" aria-labelledby="modalLensaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLensaLabel">Tambah Lensa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idframe">
                <div class="mb-3">
                    <label class="form-label">Nama Lensa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_lensa" placeholder="Nama lensa">
                </div>

                <!-- Bentuk Lensa -->
                <div class="mb-3">
                    <label class="form-label">Bentuk Lensa</label>
                    <div class="input-group">
                        <select class="form-select select2-bentuk" id="idbentuk_lensa" style="flex:1">
                            <option value="">-- Pilih Bentuk --</option>
                            <?php foreach ($bentuk_list as $b): ?>
                                <option value="<?= $b['idbentuk_lensa'] ?>"><?= esc($b['nama_bentuk']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-outline-success" type="button" id="btnTambahBentuk" title="Tambah Bentuk Baru">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                    <!-- inline add bentuk -->
                    <div id="formTambahBentuk" class="mt-2 d-none">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="inputNamaBentuk" placeholder="Nama bentuk baru">
                            <button class="btn btn-success" type="button" id="btnSimpanBentuk">Simpan</button>
                            <button class="btn btn-secondary" type="button" id="btnBatalBentuk">Batal</button>
                        </div>
                    </div>
                </div>

                <!-- Bahan Lensa -->
                <div class="mb-3">
                    <label class="form-label">Bahan Lensa</label>
                    <div class="input-group">
                        <select class="form-select select2-bahan" id="idbahan_lensa" style="flex:1">
                            <option value="">-- Pilih Bahan --</option>
                            <?php foreach ($bahan_list as $bh): ?>
                                <option value="<?= $bh['idbahan_lensa'] ?>"><?= esc($bh['nama_bahan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-outline-success" type="button" id="btnTambahBahan" title="Tambah Bahan Baru">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                    <!-- inline add bahan -->
                    <div id="formTambahBahan" class="mt-2 d-none">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="inputNamaBahan" placeholder="Nama bahan baru">
                            <button class="btn btn-success" type="button" id="btnSimpanBahan">Simpan</button>
                            <button class="btn btn-secondary" type="button" id="btnBatalBahan">Batal</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control harga-input" id="harga_beli" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control harga-input" id="harga_jual" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanLensa">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
const BASE_URL = "<?= base_url() ?>";

// ===== Inisialisasi DataTable =====
const tblLensa = $('#tblLensa').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: BASE_URL + 'lensa/datatable', type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'nama_lensa' },
        { data: 'nama_bentuk' },
        { data: 'nama_bahan' },
        { data: 'harga_beli' },
        { data: 'harga_jual' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

// ===== Format Rupiah =====
function formatRupiah(val) {
    let num = val.toString().replace(/[^0-9]/g, '');
    return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function stripRupiah(val) {
    return val.replace(/\./g, '');
}

$(document).on('input', '.harga-input', function () {
    let raw = stripRupiah($(this).val());
    $(this).val(formatRupiah(raw));
});

// ===== Inisialisasi Select2 =====
function initSelect2() {
    $('#idbentuk_lensa').select2({ dropdownParent: $('#modalLensa'), width: '100%', theme: 'bootstrap-5' });
    $('#idbahan_lensa').select2({ dropdownParent: $('#modalLensa'), width: '100%', theme: 'bootstrap-5' });
}

// ===== Buka Modal Tambah =====
$('#btnTambah').on('click', function () {
    $('#modalLensaLabel').text('Tambah Lensa');
    $('#idframe').val('');
    $('#nama_lensa').val('');
    $('#idbentuk_lensa').val('').trigger('change');
    $('#idbahan_lensa').val('').trigger('change');
    $('#harga_beli').val('');
    $('#harga_jual').val('');
    $('#modalLensa').modal('show');
});

$('#modalLensa').on('shown.bs.modal', function () { initSelect2(); });

// ===== Tombol Edit =====
$(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');
    $.get(BASE_URL + 'lensa/get/' + id, function (res) {
        if (res.status !== 'ok') return;
        const d = res.data;
        $('#modalLensaLabel').text('Edit Lensa');
        $('#idframe').val(d.idframe);
        $('#nama_lensa').val(d.nama_lensa);
        $('#harga_beli').val(formatRupiah(d.harga_beli));
        $('#harga_jual').val(formatRupiah(d.harga_jual));
        $('#modalLensa').modal('show');
        // set select2 setelah modal terbuka
        $('#modalLensa').one('shown.bs.modal', function () {
            $('#idbentuk_lensa').val(d.idbentuk_lensa).trigger('change');
            $('#idbahan_lensa').val(d.idbahan_lensa).trigger('change');
        });
    });
});

// ===== Simpan Lensa =====
$('#btnSimpanLensa').on('click', function () {
    const id = $('#idframe').val();
    const payload = {
        nama_lensa:     $('#nama_lensa').val().trim(),
        idbentuk_lensa: $('#idbentuk_lensa').val(),
        idbahan_lensa:  $('#idbahan_lensa').val(),
        harga_beli:     stripRupiah($('#harga_beli').val()),
        harga_jual:     stripRupiah($('#harga_jual').val()),
    };

    if (!payload.nama_lensa) {
        Swal.fire('Perhatian', 'Nama lensa wajib diisi!', 'warning');
        return;
    }

    const url    = id ? BASE_URL + 'lensa/update/' + id : BASE_URL + 'lensa/store';
    const method = 'POST';

    $.ajax({
        url, method, data: payload,
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalLensa').modal('hide');
                tblLensa.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }
    });
});

// ===== Hapus =====
$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
    }).then(result => {
        if (result.isConfirmed) {
            $.get(BASE_URL + 'lensa/delete/' + id, function (res) {
                if (res.status === 'ok') {
                    tblLensa.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1200, showConfirmButton: false });
                }
            });
        }
    });
});

// ===== Tambah Bentuk Inline =====
$('#btnTambahBentuk').on('click', function () {
    $('#formTambahBentuk').toggleClass('d-none');
    $('#inputNamaBentuk').val('').focus();
});
$('#btnBatalBentuk').on('click', function () { $('#formTambahBentuk').addClass('d-none'); });

$('#btnSimpanBentuk').on('click', function () {
    const nama = $('#inputNamaBentuk').val().trim();
    if (!nama) return;
    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');
    $.post(BASE_URL + 'lensa/bentuk/store', { nama_bentuk: nama }, function (res) {
        if (res.status === 'ok') {
            const opt = new Option(res.nama, res.id, true, true);
            $('#idbentuk_lensa').append(opt).trigger('change');
            $('#formTambahBentuk').addClass('d-none');
            $('#inputNamaBentuk').val('');
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    }).always(function () {
        $btn.prop('disabled', false).html('Simpan');
    });
});

// ===== Tambah Bahan Inline =====
$('#btnTambahBahan').on('click', function () {
    $('#formTambahBahan').toggleClass('d-none');
    $('#inputNamaBahan').val('').focus();
});
$('#btnBatalBahan').on('click', function () { $('#formTambahBahan').addClass('d-none'); });

$('#btnSimpanBahan').on('click', function () {
    const nama = $('#inputNamaBahan').val().trim();
    if (!nama) return;
    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');
    $.post(BASE_URL + 'lensa/bahan/store', { nama_bahan: nama }, function (res) {
        if (res.status === 'ok') {
            const opt = new Option(res.nama, res.id, true, true);
            $('#idbahan_lensa').append(opt).trigger('change');
            $('#formTambahBahan').addClass('d-none');
            $('#inputNamaBahan').val('');
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    }).always(function () {
        $btn.prop('disabled', false).html('Simpan');
    });
});
</script>
