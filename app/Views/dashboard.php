<!-- ══════════════════════════════════════════════
     WELCOME BANNER
═══════════════════════════════════════════════ -->
<div class="row">
    <div class="col-12">
        <div class="card bg-primary text-white overflow-hidden mb-4">
            <div class="card-body py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-white">
                        Selamat datang, <?= esc(session('nama_pegawai')) ?>!
                    </h4>
                    <p class="mb-0 opacity-75">
                        <?= date('l, d F Y') ?> &nbsp;|&nbsp; <?= esc(session('nama_jabatan')) ?>
                    </p>
                </div>
                <iconify-icon icon="solar:glasses-linear" class="fs-1 opacity-50"></iconify-icon>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════
     KARTU STATISTIK
═══════════════════════════════════════════════ -->
<div class="row g-3 mb-4">

    <!-- Penjualan bulan ini -->
    <div class="col-6 col-md-3">
        <div class="card h-100 mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success-subtle rounded-2">
                        <iconify-icon icon="solar:tag-price-linear" class="fs-5 text-success"></iconify-icon>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small">Penjualan Bulan Ini</p>
                        <h5 class="mb-0 fw-bold">
                            Rp <?= number_format($totalPenjualan, 0, ',', '.') ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pembelian bulan ini -->
    <div class="col-6 col-md-3">
        <div class="card h-100 mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning-subtle rounded-2">
                        <iconify-icon icon="solar:cart-linear" class="fs-5 text-warning"></iconify-icon>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small">Pembelian Bulan Ini</p>
                        <h5 class="mb-0 fw-bold">
                            Rp <?= number_format($totalPembelian, 0, ',', '.') ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total customer -->
    <div class="col-6 col-md-3">
        <div class="card h-100 mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-info-subtle rounded-2">
                        <iconify-icon icon="solar:users-group-two-rounded-linear" class="fs-5 text-info"></iconify-icon>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small">Customer</p>
                        <h5 class="mb-0 fw-bold"><?= $totalCustomer ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total supplier -->
    <div class="col-6 col-md-3">
        <div class="card h-100 mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary-subtle rounded-2">
                        <iconify-icon icon="solar:truck-linear" class="fs-5 text-primary"></iconify-icon>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small">Supplier</p>
                        <h5 class="mb-0 fw-bold"><?= $totalSupplier ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ══════════════════════════════════════════════
     PRODUK STATS + CHART
═══════════════════════════════════════════════ -->
<div class="row g-3 mb-4">

    <!-- Produk cards -->
    <div class="col-md-4">
        <div class="row g-3 h-100">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <h6 class="card-title fw-semibold mb-3">Katalog Produk</h6>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="solar:glasses-linear" class="text-primary fs-5"></iconify-icon>
                                <span>Frame</span>
                            </div>
                            <span class="badge bg-primary-subtle text-primary fs-6"><?= $totalFrame ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="solar:eye-linear" class="text-info fs-5"></iconify-icon>
                                <span>Lensa</span>
                            </div>
                            <span class="badge bg-info-subtle text-info fs-6"><?= $totalLensa ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="solar:eye-scan-linear" class="text-secondary fs-5"></iconify-icon>
                                <span>Kacamata (Paket)</span>
                            </div>
                            <span class="badge bg-secondary-subtle text-secondary fs-6"><?= $totalKacamata ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart penjualan 7 hari -->
    <div class="col-md-8">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <h6 class="card-title fw-semibold mb-1">Penjualan 7 Hari Terakhir</h6>
                <div id="chartPenjualan" style="min-height:200px"></div>
            </div>
        </div>
    </div>

</div>

<!-- ══════════════════════════════════════════════
     STOK MENIPIS + TRANSAKSI TERAKHIR
═══════════════════════════════════════════════ -->
<div class="row g-3">

    <!-- Stok menipis -->
    <div class="col-md-5">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title fw-semibold mb-0">
                        <iconify-icon icon="solar:box-minimalistic-linear" class="text-danger me-1"></iconify-icon>
                        Stok Menipis (≤ 5)
                    </h6>
                    <a href="<?= base_url('stok/frame') ?>" class="btn btn-sm btn-outline-primary">Lihat Stok</a>
                </div>

                <?php
                $semuaStokMenipis = array_merge(
                    array_map(fn($r) => array_merge($r, ['jenis' => 'Frame']),    $stokMenipisFrame),
                    array_map(fn($r) => array_merge($r, ['jenis' => 'Lensa']),    $stokMenipisLensa),
                    array_map(fn($r) => array_merge($r, ['jenis' => 'Kacamata']), $stokMenipisKacamata)
                );
                usort($semuaStokMenipis, fn($a, $b) => $a['jumlah'] <=> $b['jumlah']);
                ?>

                <?php if (empty($semuaStokMenipis)): ?>
                    <div class="text-center text-muted py-4">
                        <iconify-icon icon="solar:check-circle-linear" class="fs-1 text-success"></iconify-icon>
                        <p class="mb-0 mt-2">Semua stok aman</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th width="80">Jenis</th>
                                    <th width="60" class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($semuaStokMenipis as $s): ?>
                                    <tr>
                                        <td class="text-truncate" style="max-width:160px">
                                            <?= esc($s['nama']) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <?= $s['jenis'] ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php $cls = $s['jumlah'] == 0 ? 'bg-danger' : 'bg-warning text-dark'; ?>
                                            <span class="badge <?= $cls ?>"><?= $s['jumlah'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Transaksi penjualan terakhir -->
    <div class="col-md-7">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title fw-semibold mb-0">
                        <iconify-icon icon="solar:receipt-linear" class="text-success me-1"></iconify-icon>
                        Transaksi Penjualan Terakhir
                    </h6>
                    <a href="<?= base_url('penjualan') ?>" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>

                <?php if (empty($penjualanTerakhir)): ?>
                    <div class="text-center text-muted py-4">
                        <iconify-icon icon="solar:document-linear" class="fs-1"></iconify-icon>
                        <p class="mb-0 mt-2">Belum ada transaksi</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Transaksi</th>
                                    <th>Customer</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penjualanTerakhir as $p): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('penjualan/detail/' . $p['idpenjualan'] ?? '#') ?>"
                                                class="text-primary fw-semibold">
                                                <?= esc($p['no_transaksi']) ?>
                                            </a>
                                        </td>
                                        <td><?= esc($p['nama_customer'] ?? 'Umum') ?></td>
                                        <td class="text-nowrap">
                                            <?= date('d/m/Y', strtotime($p['created_at'])) ?>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp <?= number_format($p['grand_total'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

</div>

<!-- ══════════════════════════════════════════════
     CHART SCRIPT (ApexCharts)
═══════════════════════════════════════════════ -->
<script>
    (function() {
        const chartData = <?= json_encode($chartData) ?>;
        const labels = chartData.map(d => d.label);
        const totals = chartData.map(d => d.total);

        const options = {
            series: [{
                name: 'Penjualan',
                data: totals
            }],
            chart: {
                type: 'area',
                height: 200,
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0,
                    stops: [0, 100]
                }
            },
            xaxis: {
                categories: labels
            },
            yaxis: {
                labels: {
                    formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                }
            },
            tooltip: {
                y: {
                    formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                }
            },
            colors: ['#1976d2'],
            grid: {
                borderColor: '#f0f0f0'
            },
        };

        new ApexCharts(document.querySelector('#chartPenjualan'), options).render();
    })();
</script>