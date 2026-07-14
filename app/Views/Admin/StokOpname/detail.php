<?php
$byJenis = ['frame' => [], 'lensa' => [], 'kacamata' => []];
foreach ($details as $d) {
    $byJenis[$d['jenis_produk']][] = $d;
}

// Hitung ringkasan
$totalItem   = count($details);
$totalSesuai = count(array_filter($details, fn($d) => (int)$d['selisih'] === 0));
$totalLebih  = count(array_filter($details, fn($d) => (int)$d['selisih'] > 0));
$totalKurang = count(array_filter($details, fn($d) => (int)$d['selisih'] < 0));
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Header -->
                <div class="d-flex align-items-center mb-1 gap-2">
                    <a href="<?= base_url('stok-opname') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-arrow-left"></i>
                    </a>
                    <h5 class="card-title fw-semibold mb-0">
                        Detail Stok Opname — <?= esc($opname['no_opname']) ?>
                    </h5>
                    <?php if ($opname['status'] === 'selesai'): ?>
                        <span class="badge bg-success ms-2">Selesai</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark ms-2">Draft</span>
                    <?php endif ?>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="140" class="text-muted">No. Opname</td>
                                <td>: <strong><?= esc($opname['no_opname']) ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal</td>
                                <td>: <?= date('d/m/Y', strtotime($opname['tanggal'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Keterangan</td>
                                <td>: <?= esc($opname['keterangan'] ?? '-') ?></td>
                            </tr>
                            <?php if ($opname['status'] === 'selesai' && $opname['selesai_at']): ?>
                                <tr>
                                    <td class="text-muted">Diselesaikan</td>
                                    <td>: <?= date('d/m/Y H:i', strtotime($opname['selesai_at'])) ?></td>
                                </tr>
                            <?php endif ?>
                        </table>
                    </div>
                    <!-- Ringkasan -->
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <div class="card text-center bg-light mb-0">
                                    <div class="card-body py-2 px-1">
                                        <h4 class="mb-0"><?= $totalItem ?></h4>
                                        <small class="text-muted">Total Item</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card text-center bg-success-subtle mb-0">
                                    <div class="card-body py-2 px-1">
                                        <h4 class="mb-0 text-success"><?= $totalSesuai ?></h4>
                                        <small class="text-muted">Sesuai</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card text-center bg-info-subtle mb-0">
                                    <div class="card-body py-2 px-1">
                                        <h4 class="mb-0 text-info"><?= $totalLebih ?></h4>
                                        <small class="text-muted">Lebih</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card text-center bg-danger-subtle mb-0">
                                    <div class="card-body py-2 px-1">
                                        <h4 class="mb-0 text-danger"><?= $totalKurang ?></h4>
                                        <small class="text-muted">Kurang</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab per jenis -->
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
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th width="130" class="text-center">Stok Sistem</th>
                                            <th width="130" class="text-center">Stok Fisik</th>
                                            <th width="120" class="text-center">Selisih</th>
                                            <th width="120" class="text-center">Kondisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($byJenis[$jenis] as $d): ?>
                                            <?php
                                            $sel    = $d['selisih'] !== null ? (int)$d['selisih'] : null;
                                            $kondisi = '';
                                            $rowCls  = '';
                                            if ($sel !== null) {
                                                if ($sel === 0) {
                                                    $kondisi = '<span class="badge bg-success">Sesuai</span>';
                                                } elseif ($sel > 0) {
                                                    $kondisi = '<span class="badge bg-info text-dark">Lebih</span>';
                                                    $rowCls  = 'table-info';
                                                } else {
                                                    $kondisi = '<span class="badge bg-danger">Kurang</span>';
                                                    $rowCls  = 'table-danger';
                                                }
                                            }
                                            ?>
                                            <tr class="<?= $rowCls ?>">
                                                <td><?= esc($d['nama_produk']) ?></td>
                                                <td class="text-center"><?= $d['stok_sistem'] ?></td>
                                                <td class="text-center">
                                                    <?= $d['stok_fisik'] !== null ? $d['stok_fisik'] : '<span class="text-muted">—</span>' ?>
                                                </td>
                                                <td class="text-center fw-bold">
                                                    <?php if ($sel !== null): ?>
                                                        <?php
                                                        $cls = $sel === 0 ? 'text-secondary' : ($sel > 0 ? 'text-info' : 'text-danger');
                                                        echo '<span class="' . $cls . '">' . ($sel > 0 ? '+' : '') . $sel . '</span>';
                                                        ?>
                                                        <?php else: ?>—<?php endif ?>
                                                </td>
                                                <td class="text-center"><?= $kondisi ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php $first = false; ?>
                    <?php endforeach ?>
                </div>

                <!-- Aksi -->
                <div class="mt-3 d-flex gap-2">
                    <?php if ($opname['status'] === 'draft'): ?>
                        <a href="<?= base_url('stok-opname/isi/' . $opname['idopname']) ?>"
                            class="btn btn-primary">
                            <i class="ti ti-pencil me-1"></i> Lanjut Isi Fisik
                        </a>
                    <?php endif ?>
                    <a href="<?= base_url('stok-opname') ?>" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>