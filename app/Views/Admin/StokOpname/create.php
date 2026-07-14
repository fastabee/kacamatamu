<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 gap-2">
                    <a href="<?= base_url('stok-opname') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-arrow-left"></i>
                    </a>
                    <h5 class="card-title fw-semibold mb-0">Buat Stok Opname Baru</h5>
                </div>

                <?php if (session()->getFlashdata('gagal')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('gagal') ?></div>
                <?php endif ?>

                <form action="<?= base_url('stok-opname/store') ?>" method="POST" id="frmCreate">
                    <?= csrf_field() ?>

                    <!-- Header -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Opname <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control"
                                placeholder="Opsional, misal: Opname bulanan Juli 2026">
                        </div>
                    </div>

                    <!-- Filter jenis produk -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tampilkan Produk</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input filter-jenis" type="checkbox"
                                    id="chkFrame" value="frame" checked>
                                <label class="form-check-label" for="chkFrame">Frame</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-jenis" type="checkbox"
                                    id="chkLensa" value="lensa" checked>
                                <label class="form-check-label" for="chkLensa">Lensa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-jenis" type="checkbox"
                                    id="chkKacamata" value="kacamata" checked>
                                <label class="form-check-label" for="chkKacamata">Kacamata</label>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih semua -->
                    <div class="mb-2 d-flex gap-2 align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnPilihSemua">
                            Pilih Semua
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnBatalSemua">
                            Batal Semua
                        </button>
                        <span class="text-muted ms-2" id="lblTerpilih">0 item terpilih</span>
                    </div>

                    <!-- Tabel produk -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tblProduk">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="chkAll" class="form-check-input">
                                    </th>
                                    <th>Nama Produk</th>
                                    <th width="80">Jenis</th>
                                    <th width="120">Stok Sistem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($frames as $f): ?>
                                    <tr data-jenis="frame">
                                        <td>
                                            <input type="checkbox" class="form-check-input chk-item"
                                                name="jenis[]" value="frame"
                                                data-jenis="frame"
                                                data-id="<?= $f['idproduk'] ?>"
                                                data-nama="<?= esc($f['nama_produk']) ?>"
                                                data-sistem="<?= $f['stok_sistem'] ?>">
                                            <input type="hidden" name="idproduk[]" value="<?= $f['idproduk'] ?>" disabled>
                                            <input type="hidden" name="nama[]" value="<?= esc($f['nama_produk']) ?>" disabled>
                                            <input type="hidden" name="stok_sistem[]" value="<?= $f['stok_sistem'] ?>" disabled>
                                        </td>
                                        <td><?= esc($f['nama_produk']) ?></td>
                                        <td><span class="badge bg-primary">Frame</span></td>
                                        <td><?= $f['stok_sistem'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($lensas as $l): ?>
                                    <tr data-jenis="lensa">
                                        <td>
                                            <input type="checkbox" class="form-check-input chk-item"
                                                name="jenis[]" value="lensa"
                                                data-jenis="lensa"
                                                data-id="<?= $l['idproduk'] ?>"
                                                data-nama="<?= esc($l['nama_produk']) ?>"
                                                data-sistem="<?= $l['stok_sistem'] ?>">
                                            <input type="hidden" name="idproduk[]" value="<?= $l['idproduk'] ?>" disabled>
                                            <input type="hidden" name="nama[]" value="<?= esc($l['nama_produk']) ?>" disabled>
                                            <input type="hidden" name="stok_sistem[]" value="<?= $l['stok_sistem'] ?>" disabled>
                                        </td>
                                        <td><?= esc($l['nama_produk']) ?></td>
                                        <td><span class="badge bg-info text-dark">Lensa</span></td>
                                        <td><?= $l['stok_sistem'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($kacamatas as $k): ?>
                                    <tr data-jenis="kacamata">
                                        <td>
                                            <input type="checkbox" class="form-check-input chk-item"
                                                name="jenis[]" value="kacamata"
                                                data-jenis="kacamata"
                                                data-id="<?= $k['idproduk'] ?>"
                                                data-nama="<?= esc($k['nama_produk']) ?>"
                                                data-sistem="<?= $k['stok_sistem'] ?>">
                                            <input type="hidden" name="idproduk[]" value="<?= $k['idproduk'] ?>" disabled>
                                            <input type="hidden" name="nama[]" value="<?= esc($k['nama_produk']) ?>" disabled>
                                            <input type="hidden" name="stok_sistem[]" value="<?= $k['stok_sistem'] ?>" disabled>
                                        </td>
                                        <td><?= esc($k['nama_produk']) ?></td>
                                        <td><span class="badge bg-secondary">Kacamata</span></td>
                                        <td><?= $k['stok_sistem'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="ti ti-device-floppy me-1"></i> Buat Opname
                        </button>
                        <a href="<?= base_url('stok-opname') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Update hidden inputs saat checkbox berubah
    function syncHidden(chk) {
        const enabled = chk.checked;
        const td = chk.closest('td');
        td.querySelectorAll('input[type=hidden]').forEach(h => h.disabled = !enabled);
        updateCounter();
    }

    function updateCounter() {
        const n = document.querySelectorAll('.chk-item:checked').length;
        document.getElementById('lblTerpilih').textContent = n + ' item terpilih';
    }

    document.querySelectorAll('.chk-item').forEach(chk => {
        chk.addEventListener('change', () => syncHidden(chk));
    });

    // Pilih semua / batal
    document.getElementById('chkAll').addEventListener('change', function() {
        document.querySelectorAll('.chk-item:not(:disabled)').forEach(chk => {
            if (chk.closest('tr').style.display !== 'none') {
                chk.checked = this.checked;
                syncHidden(chk);
            }
        });
    });
    document.getElementById('btnPilihSemua').addEventListener('click', function() {
        document.querySelectorAll('.chk-item').forEach(chk => {
            if (chk.closest('tr').style.display !== 'none') {
                chk.checked = true;
                syncHidden(chk);
            }
        });
        document.getElementById('chkAll').checked = true;
    });
    document.getElementById('btnBatalSemua').addEventListener('click', function() {
        document.querySelectorAll('.chk-item').forEach(chk => {
            chk.checked = false;
            syncHidden(chk);
        });
        document.getElementById('chkAll').checked = false;
    });

    // Filter jenis
    document.querySelectorAll('.filter-jenis').forEach(chk => {
        chk.addEventListener('change', function() {
            const jenis = this.value;
            document.querySelectorAll(`tr[data-jenis="${jenis}"]`).forEach(tr => {
                tr.style.display = this.checked ? '' : 'none';
            });
        });
    });

    // Validasi sebelum submit
    document.getElementById('frmCreate').addEventListener('submit', function(e) {
        const terpilih = document.querySelectorAll('.chk-item:checked').length;
        if (!terpilih) {
            e.preventDefault();
            Swal.fire('Perhatian', 'Pilih minimal satu produk untuk opname', 'warning');
        }
    });
</script>