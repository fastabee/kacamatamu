<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Supplier</h5>
                    <button class="btn btn-primary btn-sm" id="btnTambah">
                        <i class="ti ti-plus me-1"></i> Tambah Supplier
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblSupplier" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Supplier</th>
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
<div class="modal fade" id="modalSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSupplierLabel">Tambah Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idsupplier">
                <div class="mb-3">
                    <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_supplier" placeholder="Nama supplier">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
const tblSupplier = $('#tblSupplier').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: "<?= base_url('supplier/datatable') ?>", type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'nama_supplier' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

$('#btnTambah').on('click', function () {
    $('#modalSupplierLabel').text('Tambah Supplier');
    $('#idsupplier, #nama_supplier').val('');
    $('#modalSupplier').modal('show');
});

$(document).on('click', '.btn-edit', function () {
    $('#modalSupplierLabel').text('Edit Supplier');
    $('#idsupplier').val($(this).data('id'));
    $('#nama_supplier').val($(this).data('nama'));
    $('#modalSupplier').modal('show');
});

$('#btnSimpan').on('click', function () {
    const nama = $('#nama_supplier').val().trim();
    if (!nama) { Swal.fire('Perhatian', 'Nama supplier wajib diisi!', 'warning'); return; }

    const id   = $('#idsupplier').val();
    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    $.ajax({
        url: id ? "<?= base_url('supplier/update') ?>/" + id : "<?= base_url('supplier/store') ?>",
        method: 'POST',
        data: { nama_supplier: nama },
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalSupplier').modal('hide');
                tblSupplier.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            }
        },
        complete: function () { $btn.prop('disabled', false).html('Simpan'); }
    });
});

$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus supplier ini?', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal', confirmButtonColor: '#d33',
    }).then(result => {
        if (result.isConfirmed) {
            $.get("<?= base_url('supplier/delete') ?>/" + id, function (res) {
                if (res.status === 'ok') {
                    tblSupplier.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1200, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
