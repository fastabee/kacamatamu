<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Data Customer</h5>
                    <button class="btn btn-primary btn-sm" id="btnTambah">
                        <i class="ti ti-plus me-1"></i> Tambah Customer
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tblCustomer" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Customer</th>
                                <th>No. Telepon</th>
                                <th>Tgl Daftar</th>
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
<div class="modal fade" id="modalCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCustomerLabel">Tambah Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idcustomer">
                <div class="mb-3">
                    <label class="form-label">Nama Customer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_customer" placeholder="Nama customer">
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" placeholder="08xxxxxxxxxx">
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
const tblCustomer = $('#tblCustomer').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: "<?= base_url('customer/datatable') ?>", type: 'GET' },
    columns: [
        { data: 'no', orderable: false, searchable: false },
        { data: 'nama_customer' },
        { data: 'no_telepon' },
        { data: 'created_at' },
        { data: 'aksi', orderable: false, searchable: false },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
});

$('#btnTambah').on('click', function () {
    $('#modalCustomerLabel').text('Tambah Customer');
    $('#idcustomer, #nama_customer, #no_telepon').val('');
    $('#modalCustomer').modal('show');
});

$(document).on('click', '.btn-edit', function () {
    $('#modalCustomerLabel').text('Edit Customer');
    $('#idcustomer').val($(this).data('id'));
    $('#nama_customer').val($(this).data('nama'));
    $('#no_telepon').val($(this).data('telepon'));
    $('#modalCustomer').modal('show');
});

$('#btnSimpan').on('click', function () {
    const nama = $('#nama_customer').val().trim();
    if (!nama) { Swal.fire('Perhatian', 'Nama customer wajib diisi!', 'warning'); return; }

    const id   = $('#idcustomer').val();
    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

    $.ajax({
        url: id ? "<?= base_url('customer/update') ?>/" + id : "<?= base_url('customer/store') ?>",
        method: 'POST',
        data: { nama_customer: nama, no_telepon: $('#no_telepon').val() },
        success: function (res) {
            if (res.status === 'ok') {
                $('#modalCustomer').modal('hide');
                tblCustomer.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            }
        },
        complete: function () { $btn.prop('disabled', false).html('Simpan'); }
    });
});

$(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Hapus customer ini?', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal', confirmButtonColor: '#d33',
    }).then(result => {
        if (result.isConfirmed) {
            $.get("<?= base_url('customer/delete') ?>/" + id, function (res) {
                if (res.status === 'ok') {
                    tblCustomer.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Dihapus', timer: 1200, showConfirmButton: false });
                }
            });
        }
    });
});
</script>
