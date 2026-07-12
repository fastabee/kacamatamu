<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; font-size: 10px; color: #222; }
    .center { text-align: center; }
    .bold { font-weight: bold; }
    .toko-nama { font-size: 13px; font-weight: bold; }
    .toko-sub { font-size: 9px; color: #555; }
    hr { border: none; border-top: 1px dashed #999; margin: 5px 0; }
    hr.solid { border-top: 1px solid #333; }
    table { width: 100%; border-collapse: collapse; }
    .item-table td { padding: 2px 0; vertical-align: top; font-size: 9.5px; }
    .item-table .nama { width: 55%; }
    .item-table .qty  { width: 10%; text-align: center; }
    .item-table .harga{ width: 35%; text-align: right; }
    .total-row td { padding: 1px 0; font-size: 10px; }
    .total-row .lbl { text-align: right; padding-right: 8px; }
    .total-row .val { text-align: right; font-weight: bold; }
    .grand { font-size: 11px; }
    .footer { margin-top: 8px; font-size: 9px; color: #666; }
    .badge { display: inline-block; background: #eee; border-radius: 3px; padding: 0 3px; font-size: 8px; }
</style>
</head>
<body>

<div class="center">
    <div class="toko-nama">E-Kacamatamu</div>
    <div class="toko-sub">Nota Pembelian</div>
</div>

<hr>

<table>
    <tr>
        <td style="width:40%">No. PO</td>
        <td>: <strong><?= esc($pembelian['no_pembelian']) ?></strong></td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td>: <?= esc($pembelian['nama_supplier'] ?? '-') ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: <?= date('d/m/Y H:i', strtotime($pembelian['created_at'])) ?></td>
    </tr>
    <tr>
        <td>Input By</td>
        <td>: <?= esc($pembelian['nama_pegawai'] ?? '-') ?></td>
    </tr>
    <?php if (!empty($pembelian['keterangan'])): ?>
    <tr>
        <td>Keterangan</td>
        <td>: <?= esc($pembelian['keterangan']) ?></td>
    </tr>
    <?php endif; ?>
</table>

<hr>

<table class="item-table">
    <thead>
        <tr>
            <td class="nama bold">Item</td>
            <td class="qty bold">Qty</td>
            <td class="harga bold">Subtotal</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $d): ?>
        <tr>
            <td class="nama">
                <?= esc($d['nama_produk']) ?><br>
                <span class="badge"><?= esc($d['jenis_produk']) ?></span>
                <span style="color:#888"> Rp <?= number_format($d['harga_beli'], 0, ',', '.') ?></span>
            </td>
            <td class="qty"><?= $d['jumlah'] ?></td>
            <td class="harga">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr class="solid">

<table class="total-row">
    <tr class="grand">
        <td class="lbl">Total</td>
        <td class="val">Rp <?= number_format($pembelian['total'], 0, ',', '.') ?></td>
    </tr>
</table>

<hr>

<div class="center footer">
    Terima kasih atas transaksinya<br>
    Dicetak: <?= date('d/m/Y H:i') ?>
</div>

</body>
</html>
