<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Frame</h5>
                    <button class="btn btn-primary btn-sm" id="btnTambah">
                        <i class="ti ti-plus me-1"></i> Tambah Frame
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblFrame" class="table table-bordered table-hover align-middle w-100">
                        <thead >
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Frame</th>
                                <th>Bentuk Frame</th>
                                <th>Bahan Frame</th>
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

<!-- ===== MODAL TAMBAH / EDIT FRAME ===== -->
<div class="modal fade" id="modalFrame" tabindex="-1" aria-labelledby="modalFrameLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFrameLabel">Tambah Frame</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idframe">
                <div class="mb-3">
                    <label class="form-label">Nama Frame <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_frame" placeholder="Nama frame">
                </div>

                <!-- Bentuk Frame -->
                <div class="mb-3">
                    <label class="form-label">Bentuk Frame</label>
                    <div class="input-group">
                        <select class="form-select" id="idbentuk_frame" style="flex:1">
                            <option value="">-- Pilih Bentuk --</option>
                            <?php foreach ($bentuk_list as $b): ?>
                                <option value="<?= $b['idbentuk_frame'] ?>"><?= esc($b['nama_bentuk']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-outline-success" type="button" id="btnTambahBentuk" title="Tambah Bentuk Baru">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                    <div id="formTambahBentuk" class="mt-2 d-none">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="inputNamaBentuk" placeholder="Nama bentuk baru">
                            <button class="btn btn-success" type="button" id="btnSimpanBentuk">Simpan</button>
                            <button class="btn btn-secondary" type="button" id="btnBatalBentuk">Batal</button>
                        </div>
                    </div>
                </div>

                <!-- Bahan Frame -->
                <div class="mb-3">
                    <label class="form-label">Bahan Frame</label>
                    <div class="input-group">
                        <select class="form-select" id="idbahan_frame" style="flex:1">
                            <option value="">-- Pilih Bahan --</option>
                            <?php foreach ($bahan_list as $bh): ?>
                                <option value="<?= $bh['idbahan_frame'] ?>"><?= esc($bh['nama_bahan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-outline-success" type="button" id="btnTambahBahan" title="Tambah Bahan Baru">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
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
                <button type="button" class="btn btn-primary" id="btnSimpanFrame">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL_FRAME = "<?= base_url() ?>";

// ===== DataTable =====
const tblFrame = $('#tblFrame').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: BASE_URL_FRAME + 'frame/datatable', type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'nama_frame' },
        { data: 'nama_bentuk' },
        { data: 'nama_bahan' },
        { data: 'harga_beli' },
        { data: 'harga_jual' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

// ===== Format Rupiah =====
function formatRupiahFrame(val) {
    return val.toString().replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function stripRupiahFrame(val) {
    return val.replace(/\./g, '');
}
$(document).on('input', '#modalFrame .harga-input', function () {
    $(this).val(formatRupiahFrame($(this).val()));
});

// ===== Select2 =====
function initSelect2Frame() {
    $('#idbentuk_frame').select2({ dropdownParent: $('#modalFrame'), width: '100%', theme: 'bootstrap-5' });
    $('#idbahan_frame').select2({ dropdownParent: $('#modalFrame'), width: '100%', theme: 'bootstrap-5' });
}

// ===== Buka Modal Tambah =====
$('#btnTambah').on('click', function () {
    $('#modalFrameLabel').text('Tambah Frame');
    $('#idframe').val('');
    $('#nama_frame, #harga_beli, #harga_jual').val('');
    $('#idbentuk_frame, #idbahan_frame').val('').trigger('change');
    $('#modalFrame').modal('show');
});

$('#modalFrame').on('shown.bs.modal', function () { initSelect2Frame(); });

// ===== Edit =====
$(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');
    $.get(BASE_URL_FRAME + 'frame/get/' + id, function (res) {
        if (res.status !== 'ok') return;
        const d = res.data;
        $('#modalFrameLabel').text('Edit Frame');
        $('#idframe').val(d.idframe);
        $('#nama_frame').val(d.nama_frame);
        $('#harga_beli').val(formatRupiahFrame(d.harga_beli));
        $('#harga_jual').val(formatRupiahFrame(d.harga_jual));
        $('#modalFrame').modal('show');
        $('#modalFrame').one('shown.bs.modal', function () {
            $('#idbentuk_frame').val(d.idbentuk_frame).trigger('change');
            $('#idbahan_frame').val(d.idbahan_frame).trigger('change');
        });
    });
});

// ===== Simpan =====
$('#btnSimpanFrame').on('click', function () {
    const id = $('#idframe').val();
    const payload = {
        nama_frame:     $('#nama_frame').val().trim(),
        idbentuk_frame: $('#idbentuk_frame').val(),
        idbahan_frame:  $('#idbahan_frame').val(),
        harga_beli:     stripRupiahFrame($('#harga_beli').val()),
        harga_jual:     stripRupiahFrame($('#harga_jual').val()),
    };

    if (!payload.nama_frame) {
        Swal.fire('Perhatian', 'Nama frame wajib diisi!', 'warning');
        return;
    }

    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    const url = id ? BASE_URL_FRAME + 'frame/update/' + id : BASE_URL_FRAME + 'frame/store';
    $.ajax({
        url, method: 'POST', data: payload,
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalFrame').modal('hide');
                tblFrame.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            }
        },
        complete: function () {
            $btn.prop('disabled', false).html('Simpan');
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
            $.get(BASE_URL_FRAME + 'frame/delete/' + id, function (res) {
                if (res.status === 'ok') {
                    tblFrame.ajax.reload(null, false);
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
    $.post(BASE_URL_FRAME + 'frame/bentuk/store', { nama_bentuk: nama }, function (res) {
        if (res.status === 'ok') {
            $('#idbentuk_frame').append(new Option(res.nama, res.id, true, true)).trigger('change');
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
    $.post(BASE_URL_FRAME + 'frame/bahan/store', { nama_bahan: nama }, function (res) {
        if (res.status === 'ok') {
            $('#idbahan_frame').append(new Option(res.nama, res.id, true, true)).trigger('change');
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
