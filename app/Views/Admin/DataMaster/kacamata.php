<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Kacamata</h5>
                    <button class="btn btn-primary btn-sm" id="btnTambah">
                        <i class="ti ti-plus me-1"></i> Tambah Kacamata
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblKacamata" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kacamata</th>
                                <th>Lensa</th>
                                <th>Frame</th>
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

<!-- ===== MODAL ===== -->
<div class="modal fade" id="modalKacamata" tabindex="-1" aria-labelledby="modalKacamataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKacamataLabel">Tambah Kacamata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idkacamata">

                <div class="mb-3">
                    <label class="form-label">Nama Kacamata <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_kacamata" placeholder="Nama kacamata">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lensa</label>
                    <select class="form-select" id="idlensa">
                        <option value="">-- Pilih Lensa --</option>
                        <?php foreach ($lensa_list as $l): ?>
                            <option value="<?= $l['idframe'] ?>"><?= esc($l['nama_lensa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Frame</label>
                    <select class="form-select" id="idframe">
                        <option value="">-- Pilih Frame --</option>
                        <?php foreach ($frame_list as $f): ?>
                            <option value="<?= $f['idframe'] ?>"><?= esc($f['nama_frame']) ?></option>
                        <?php endforeach; ?>
                    </select>
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
                <button type="button" class="btn btn-primary" id="btnSimpanKacamata">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL_KM = "<?= base_url() ?>";

// ===== DataTable =====
const tblKacamata = $('#tblKacamata').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: BASE_URL_KM + 'kacamata/datatable', type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'nama_kacamata' },
        { data: 'nama_lensa' },
        { data: 'nama_frame' },
        { data: 'harga_beli' },
        { data: 'harga_jual' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

// ===== Format Rupiah =====
function fmtRp(val) {
    return val.toString().replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function stripRp(val) { return val.replace(/\./g, ''); }

$(document).on('input', '#modalKacamata .harga-input', function () {
    $(this).val(fmtRp($(this).val()));
});

// ===== Select2 =====
function initSelect2KM() {
    $('#idlensa').select2({ dropdownParent: $('#modalKacamata'), width: '100%', theme: 'bootstrap-5' });
    $('#idframe').select2({ dropdownParent: $('#modalKacamata'), width: '100%', theme: 'bootstrap-5' });
}
$('#modalKacamata').on('shown.bs.modal', function () { initSelect2KM(); });

// ===== Buka Modal Tambah =====
$('#btnTambah').on('click', function () {
    $('#modalKacamataLabel').text('Tambah Kacamata');
    $('#idkacamata').val('');
    $('#nama_kacamata, #harga_beli, #harga_jual').val('');
    $('#idlensa, #idframe').val('').trigger('change');
    $('#modalKacamata').modal('show');
});

// ===== Edit =====
$(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');
    $.get(BASE_URL_KM + 'kacamata/get/' + id, function (res) {
        if (res.status !== 'ok') return;
        const d = res.data;
        $('#modalKacamataLabel').text('Edit Kacamata');
        $('#idkacamata').val(d.idkacamata);
        $('#nama_kacamata').val(d.nama_kacamata);
        $('#harga_beli').val(fmtRp(d.harga_beli));
        $('#harga_jual').val(fmtRp(d.harga_jual));
        $('#modalKacamata').modal('show');
        $('#modalKacamata').one('shown.bs.modal', function () {
            $('#idlensa').val(d.idlensa).trigger('change');
            $('#idframe').val(d.idframe).trigger('change');
        });
    });
});

// ===== Simpan =====
$('#btnSimpanKacamata').on('click', function () {
    const id = $('#idkacamata').val();
    const payload = {
        nama_kacamata: $('#nama_kacamata').val().trim(),
        idlensa:       $('#idlensa').val(),
        idframe:       $('#idframe').val(),
        harga_beli:    stripRp($('#harga_beli').val()),
        harga_jual:    stripRp($('#harga_jual').val()),
    };

    if (!payload.nama_kacamata) {
        Swal.fire('Perhatian', 'Nama kacamata wajib diisi!', 'warning');
        return;
    }

    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    const url = id ? BASE_URL_KM + 'kacamata/update/' + id : BASE_URL_KM + 'kacamata/store';
    $.ajax({
        url, method: 'POST', data: payload,
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalKacamata').modal('hide');
                tblKacamata.ajax.reload(null, false);
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
            $.get(BASE_URL_KM + 'kacamata/delete/' + id, function (res) {
                if (res.status === 'ok') {
                    tblKacamata.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1200, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
