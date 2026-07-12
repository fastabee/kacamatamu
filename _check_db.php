<?php
$db = new mysqli('localhost', 'root', '', '88foundation');
if ($db->connect_error) die('Connect error: ' . $db->connect_error);

$r = $db->query('SELECT COUNT(*) as total FROM penduduk WHERE deleted=0 AND status=1');
echo 'Penduduk aktif: ' . $r->fetch_object()->total . PHP_EOL;

$r2 = $db->query('SHOW INDEX FROM penduduk');
echo 'Indexes penduduk:' . PHP_EOL;
while ($row = $r2->fetch_assoc()) {
    echo '  ' . $row['Key_name'] . ' -> ' . $row['Column_name'] . PHP_EOL;
}

$r3 = $db->query('SHOW INDEX FROM pelaksanaan_sumbangan');
echo 'Indexes pelaksanaan_sumbangan:' . PHP_EOL;
while ($row = $r3->fetch_assoc()) {
    echo '  ' . $row['Key_name'] . ' -> ' . $row['Column_name'] . PHP_EOL;
}

// EXPLAIN query tanpa filter
$explain = $db->query("EXPLAIN SELECT penduduk.idpenduduk, penduduk.nama, penduduk.nama_kecamatan
    FROM penduduk
    LEFT JOIN pelaksanaan_sumbangan ps ON ps.penduduk_idpenduduk = penduduk.idpenduduk
        AND ps.sumbangan_idjadwalsumbangan = 1
    WHERE penduduk.deleted = 0 AND penduduk.status = 1
    ORDER BY CASE WHEN ps.penduduk_idpenduduk IS NOT NULL THEN 0 ELSE 1 END ASC, penduduk.nama ASC");
echo PHP_EOL . 'EXPLAIN query:' . PHP_EOL;
while ($row = $explain->fetch_assoc()) {
    echo '  table=' . $row['table'] . ' type=' . $row['type'] . ' key=' . $row['key'] . ' rows=' . $row['rows'] . ' Extra=' . $row['Extra'] . PHP_EOL;
}
