<?php
$byJenis = ['frame' => [], 'lensa' => [], 'kacamata' => []];
foreach ($details as $d) {
    $byJenis[$d['jenis_produk']][] = $d;
}
$jenisBadge = [
    'frame'    => '<span class="badge bg-primary">Frame</span>',
    'lensa'    => '<span class="badge bg-info text-dark">Lensa</span>',
    'kacamata' => '<span class="badge bg-secondary">Kacamata</span>',
];
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1 gap-2">
                    <a href="<?= base_url('stok-opname') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-arrow-left"></i>
                    </a>
                    <h5 class="card-title fw-semibold mb-0">
                        Isi Stok Fisik — <?= esc($opname['no_opname']) ?>
                    </h5>
                </div>
                <p class="text-muted mb-3">
                    Tanggal: <strong><?= date('d/m/Y', strtotime($opname['tanggal'])) ?></strong>
                    <?php if ($opname['keterangan']): ?>
                        &nbsp;|&nbsp; <?= esc($opname['keterangan']) ?>
                    <?php endif ?>
                </p>

                <div class="alert alert-info d-flex align-items-center gap-2">
                    <i class="ti ti-info-circle fs-5"></i>
                    <div>Isi jumlah stok fisik hasil penghitungan nyata di gudang.
                        Klik <strong>Simpan Draft</strong> untuk menyimpan sementara,
                        atau <strong>Selesaikan</strong> untuk mengupdate stok sistem secara permanen.</div>
                </div>

                <!-- Tab jenis produk -->
                <?php if (count($byJenis['frame']) + count($byJenis['lensa']) + count($byJenis['kacamata']) > 0): ?>
                    <ul class="nav nav-tabs mb-3" id="tabJenis">
                        <?php $first = true; ?>
                        <?php foreach (['frame', 'lensa', 'kacamata'] as $jenis): ?>
                            <?php if (empty($byJenis[$jenis])) continue; ?>
                            <li class="nav-item">
                                <button class="nav-link <?= $first ? 'active' : '' ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-<?= $jenis ?>">
                                    <?= ucfirst($jenis) ?>
                                    <span class="badge bg-secondary ms-1"><?= count($byJenis[$jenis]) ?></span>
                                </button>
                            </li>
                            <?php $first = false; ?>
                        <?php endforeach ?>
                    </ul>

                    <div class="tab-content">
                        <?php $first = true; ?>
                        <?php foreach (['frame', 'lensa', 'kacamata'] as $jenis): ?>
                            <?php if (empty($byJenis[$jenis])) continue; ?>
                            <div class="tab-pane fade <?= $first ? 'show active' : '' ?>" id="tab-<?= $jenis ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th width="120" class="text-center">Stok Sistem</th>
                                                <th width="160" class="text-center">Stok Fisik</th>
                                                <th width="120" class="text-center">Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($byJenis[$jenis] as $d): ?>
                                                <tr>
                                                    <td><?= esc($d['nama_produk']) ?></td>
                                                    <td class="text-center"><?= $d['stok_sistem'] ?></td>
                                                    <td class="text-center">
                                                        <input type="number"
                                                            class="form-control form-control-sm text-center input-fisik"
                                                            data-id="<?= $d['iddetail'] ?>"
                                                            data-sistem="<?= $d['stok_sistem'] ?>"
                                                            value="<?= $d['stok_fisik'] ?? '' ?>"
                                                            min="0" placeholder="—">
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge-selisih" data-id="<?= $d['iddetail'] ?>">
                                                            <?php if ($d['stok_fisik'] !== null): ?>
                                                                <?php
                                                                $sel = (int)$d['selisih'];
                                                                $cls = $sel === 0 ? 'bg-secondary' : ($sel > 0 ? 'bg-success' : 'bg-danger');
                                                                echo '<span class="badge ' . $cls . '">' . ($sel > 0 ? '+' : '') . $sel . '</span>';
                                                                ?>
                                                                <?php else: ?>—<?php endif ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php $first = false; ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <div class="mt-3 d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary" id="btnSimpanDraft">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Draft
                    </button>
                    <button type="button" class="btn btn-success" id="btnSelesaikan">
                        <i class="ti ti-check me-1"></i> Selesaikan & Update Stok
                    </button>
                    <a href="<?= base_url('stok-opname') ?>" class="btn btn-secondary ms-auto">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const IDOPNAME = <?= $opname['idopname'] ?>;

    // Hitung selisih real-time
    $(document).on('input', '.input-fisik', function() {
        const sistem = parseInt($(this).data('sistem'));
        const fisik = parseInt($(this).val());
        const id = $(this).data('id');
        const $badge = $(`.badge-selisih[data-id="${id}"]`);

        if (isNaN(fisik)) {
            $badge.html('—');
            return;
        }

        const sel = fisik - sistem;
        const cls = sel === 0 ? 'bg-secondary' : (sel > 0 ? 'bg-success' : 'bg-danger');
        const txt = (sel > 0 ? '+' : '') + sel;
        $badge.html(`<span class="badge ${cls}">${txt}</span>`);
    });

    // Kumpulkan data fisik
    function getFisikData() {
        const data = {};
        $('.input-fisik').each(function() {
            const val = $(this).val();
            if (val !== '') data[$(this).data('id')] = val;
        });
        return data;
    }

    // Simpan draft
    $('#btnSimpanDraft').on('click', function() {
        const fisik = getFisikData();
        if (!Object.keys(fisik).length) {
            Swal.fire('Perhatian', 'Belum ada data stok fisik yang diisi', 'warning');
            return;
        }
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');
        $.post("<?= base_url('stok-opname/simpan-fisik') ?>/" + IDOPNAME, {
            fisik
        }, function(res) {
            if (res.status === 'ok') {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersimpan',
                    timer: 1200,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        }).always(() => $btn.prop('disabled', false).html('<i class="ti ti-device-floppy me-1"></i> Simpan Draft'));
    });

    // Selesaikan opname
    $('#btnSelesaikan').on('click', function() {
        // Dulu simpan draft supaya input terbaru ikut tersimpan
        const fisik = getFisikData();
        const allFilled = document.querySelectorAll('.input-fisik').length === Object.keys(fisik).length;

        if (!allFilled) {
            Swal.fire('Perhatian', 'Semua item harus diisi stok fisik sebelum diselesaikan', 'warning');
            return;
        }

        Swal.fire({
            title: 'Selesaikan Opname?',
            html: 'Stok sistem akan diupdate sesuai stok fisik.<br><strong>Tindakan ini tidak dapat dibatalkan.</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Ya, Selesaikan',
            cancelButtonText: 'Batal',
        }).then(async result => {
            if (!result.isConfirmed) return;

            // Simpan draft dulu
            await $.post("<?= base_url('stok-opname/simpan-fisik') ?>/" + IDOPNAME, {
                fisik
            });

            // Lalu selesaikan
            $.post("<?= base_url('stok-opname/selesaikan') ?>/" + IDOPNAME, {}, function(res) {
                if (res.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Opname Selesai',
                        text: 'Stok sistem telah diperbarui.',
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => window.location.href = "<?= base_url('stok-opname') ?>");
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            });
        });
    });
</script>