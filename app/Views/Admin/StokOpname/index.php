<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Stok Opname</h5>
                    <a href="<?= base_url('stok-opname/create') ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Buat Opname Baru
                    </a>
                </div>

                <?php if (session()->getFlashdata('sukses')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session()->getFlashdata('sukses') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif ?>
                <?php if (session()->getFlashdata('gagal')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= session()->getFlashdata('gagal') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif ?>

                <div class="table-responsive">
                    <table id="tblOpname" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>No. Opname</th>
                                <th width="110">Tanggal</th>
                                <th>Keterangan</th>
                                <th>Dibuat Oleh</th>
                                <th width="100">Status</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const tblOpname = $('#tblOpname').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('stok-opname/datatable') ?>",
            type: 'GET'
        },
        columns: [{
                data: 'no',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_opname'
            },
            {
                data: 'tanggal'
            },
            {
                data: 'keterangan'
            },
            {
                data: 'nama_pembuat'
            },
            {
                data: 'status',
                orderable: false
            },
            {
                data: 'aksi',
                orderable: false,
                searchable: false
            },
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        order: [
            [0, 'desc']
        ],
    });

    $(document).on('click', '.btn-hapus', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Opname?',
            text: 'Opname draft ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (!result.isConfirmed) return;
            $.post("<?= base_url('stok-opname/hapus') ?>/" + id, {}, function(res) {
                if (res.status === 'ok') {
                    tblOpname.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus',
                        timer: 1200,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            });
        });
    });
</script>