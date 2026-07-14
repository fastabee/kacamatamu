<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Stok Kacamata</h5>
                <div class="table-responsive">
                    <table id="tblStok" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kacamata</th>
                                <th width="120">Stok</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL TRANSAKSI ===== -->
<div class="modal fade" id="modalTransaksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Stok Kacamata — <span id="lblNamaItem"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txIdItem">
                <div class="mb-3">
                    <label class="form-label">Stok Saat Ini</label>
                    <input type="text" class="form-control" id="txStokSaatIni" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Transaksi <span class="text-danger">*</span></label>
                    <select class="form-select" id="txJenis">
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                        <option value="adjustment">Adjustment (Set Langsung)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="txJumlah" min="1" placeholder="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="txKeterangan" placeholder="Opsional">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanTransaksi">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL RIWAYAT ===== -->
<div class="modal fade" id="modalRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Riwayat Stok Kacamata — <span id="lblNamaRiwayat"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-sm table-striped mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Sebelum</th>
                            <th>Sesudah</th>
                            <th>Keterangan</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRiwayat"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const tblStok = $('#tblStok').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('stok/kacamata/datatable') ?>",
            type: 'GET'
        },
        columns: [{
                data: 'no',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_kacamata'
            },
            {
                data: 'jumlah',
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
    });

    $(document).on('click', '.btn-transaksi', function() {
        $('#txIdItem').val($(this).data('iditem'));
        $('#lblNamaItem').text($(this).data('nama'));
        $('#txStokSaatIni').val($(this).data('stok'));
        $('#txJenis').val('masuk');
        $('#txJumlah, #txKeterangan').val('');
        $('#modalTransaksi').modal('show');
    });

    $('#btnSimpanTransaksi').on('click', function() {
        const jumlah = parseInt($('#txJumlah').val());
        if (!jumlah || jumlah < 1) {
            Swal.fire('Perhatian', 'Jumlah harus diisi dan lebih dari 0', 'warning');
            return;
        }
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');
        $.ajax({
            url: "<?= base_url('stok/kacamata/transaksi') ?>",
            method: 'POST',
            data: {
                idkacamata: $('#txIdItem').val(),
                jenis: $('#txJenis').val(),
                jumlah,
                keterangan: $('#txKeterangan').val()
            },
            success: function(res) {
                if (res.status === 'ok') {
                    $('#modalTransaksi').modal('hide');
                    tblStok.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html('Simpan');
            }
        });
    });

    $(document).on('click', '.btn-riwayat', function() {
        const iditem = $(this).data('iditem');
        $('#lblNamaRiwayat').text($(this).data('nama'));
        $('#tbodyRiwayat').html('<tr><td colspan="7" class="text-center">Memuat...</td></tr>');
        $('#modalRiwayat').modal('show');
        $.get("<?= base_url('stok/kacamata/riwayat') ?>/" + iditem, function(res) {
            if (!res.data.length) {
                $('#tbodyRiwayat').html('<tr><td colspan="7" class="text-center text-muted">Belum ada riwayat</td></tr>');
                return;
            }
            let html = '';
            res.data.forEach(r => {
                const badge = r.jenis === 'masuk' ? '<span class="badge bg-success">Masuk</span>' :
                    (r.jenis === 'keluar' ? '<span class="badge bg-danger">Keluar</span>' :
                        '<span class="badge bg-warning text-dark">Adjustment</span>');
                html += `<tr><td>${r.created_at}</td><td>${badge}</td><td>${r.jumlah}</td>
                <td>${r.stok_sebelum}</td><td>${r.stok_sesudah}</td>
                <td>${r.keterangan ?? '-'}</td><td>${r.nama_pegawai ?? '-'}</td></tr>`;
            });
            $('#tbodyRiwayat').html(html);
        });
    });
</script>