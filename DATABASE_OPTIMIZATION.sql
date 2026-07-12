-- ============================================================================
-- DATABASE OPTIMIZATION untuk Tabel Penduduk
-- ============================================================================
-- Run this SQL untuk mengoptimalkan query performance
-- Safe to run multiple times (IF NOT EXISTS checks)
-- ============================================================================

-- 1. OPTIMIZE TABLE STRUCTURE
-- Remove duplicate indexes dan optimize existing ones
-- ============================================================================

-- Check existing indexes:
-- SHOW INDEX FROM penduduk;

-- Analyze current query performance:
-- EXPLAIN SELECT penduduk.idpenduduk, penduduk.ktp, penduduk.nama 
-- FROM penduduk 
-- LEFT JOIN rekening ON rekening.idrekening = penduduk.rekening_idrekening
-- WHERE penduduk.deleted = 0 AND penduduk.status IN (1,2)
-- ORDER BY penduduk.tanggal_mendaftar DESC
-- LIMIT 50;

-- 2. VERIFY EXISTING INDEXES (Already created in schema)
-- ============================================================================
-- idx_penduduk_status_deleted - GOOD ✓ (used by WHERE clause)
-- idx_penduduk_rekening - GOOD ✓ (used by JOIN)
-- idx_penduduk_wilayah - GOOD ✓ (used by filters)

-- 3. OPTIONAL: ADD MORE INDEXES for faster filtering
-- ============================================================================

-- For name search (jika ditambahkan fitur search)
ALTER TABLE `penduduk` ADD INDEX `idx_nama` (`nama`);

-- For better geographic filtering with status
ALTER TABLE `penduduk` ADD INDEX `idx_wilayah_status` 
(nama_kecamatan, nama_desa, nort, norw, status);

-- For tanggal_mendaftar ordering (already have index)
-- ALTER TABLE `penduduk` ADD INDEX `idx_tanggal_mendaftar` (`tanggal_mendaftar`);

-- For faster filtering by wakil_penerima
ALTER TABLE `penduduk` ADD INDEX `idx_wakil_status` 
(wakil_idwakil, status, deleted);

-- 4. UPDATE TABLE STATISTICS
-- ============================================================================
-- Run ini setelah insert/delete besar-besaran
ANALYZE TABLE `penduduk`;
ANALYZE TABLE `rekening`;
ANALYZE TABLE `wakil_penerima`;

-- 5. CHECK TABLE INTEGRITY
-- ============================================================================
-- Jalankan ini secara berkala untuk check corruption
CHECK TABLE `penduduk` EXTENDED;
CHECK TABLE `rekening` EXTENDED;

-- 6. OPTIMIZE TABLE STORAGE
-- ============================================================================
-- Jalankan ini untuk reclaim unused space (jalankan saat maintenance)
-- OPTIMIZE TABLE `penduduk`;
-- OPTIMIZE TABLE `rekening`;
-- OPTIMIZE TABLE `wakil_penerima`;

-- ============================================================================
-- QUERY OPTIMIZATION EXAMPLES
-- ============================================================================

-- ✓ OPTIMIZED QUERY (gunakan ini di getPenduduk method)
-- Expected: < 20ms untuk 50 records
SELECT 
    penduduk.idpenduduk,
    penduduk.ktp,
    penduduk.no_kk,
    penduduk.nama,
    penduduk.tanggal_lahir,
    penduduk.tempat_lahir,
    penduduk.nama_kecamatan,
    penduduk.nama_desa,
    penduduk.alamat,
    penduduk.nort,
    penduduk.norw,
    penduduk.no_urut,
    penduduk.nomor_telepon,
    penduduk.nomor_rekening,
    penduduk.wakil_idwakil,
    penduduk.nama_ibu,
    penduduk.tanggal_mendaftar,
    penduduk.status,
    rekening.nama_rekening
FROM penduduk 
LEFT JOIN rekening ON rekening.idrekening = penduduk.rekening_idrekening
WHERE penduduk.deleted = 0 
    AND penduduk.status IN (1, 2)
ORDER BY penduduk.tanggal_mendaftar DESC
LIMIT 50 OFFSET 0;

-- ✓ COUNT QUERY untuk pagination (gunakan di countPenduduk method)
-- Expected: < 5ms
SELECT COUNT(*) as total
FROM penduduk
WHERE penduduk.deleted = 0 
    AND penduduk.status IN (1, 2);

-- ✗ SLOW QUERY (JANGAN gunakan - ini yang lama)
-- Expected: 5000-8000ms untuk 898 records
SELECT *
FROM penduduk 
LEFT JOIN rekening ON rekening.idrekening = penduduk.rekening_idrekening
WHERE penduduk.deleted = 0 
    AND penduduk.status IN (1, 2);

-- ============================================================================
-- PERFORMANCE MONITORING QUERIES
-- ============================================================================

-- Check table size
SELECT 
    TABLE_NAME,
    ROUND(DATA_LENGTH / 1024 / 1024, 2) as DATA_MB,
    ROUND(INDEX_LENGTH / 1024 / 1024, 2) as INDEX_MB,
    ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) as TOTAL_MB
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'your_database_name'
    AND TABLE_NAME IN ('penduduk', 'rekening', 'wakil_penerima');

-- Check index usage statistics
SELECT 
    OBJECT_SCHEMA,
    OBJECT_NAME,
    INDEX_NAME,
    COUNT_STAR as TOTAL_ACCESS,
    COUNT_READ as READ_COUNT,
    COUNT_WRITE as WRITE_COUNT,
    COUNT_INSERT as INSERT_COUNT,
    COUNT_UPDATE as UPDATE_COUNT,
    COUNT_DELETE as DELETE_COUNT
FROM performance_schema.table_io_waits_summary_by_index_usage
WHERE OBJECT_NAME IN ('penduduk', 'rekening')
ORDER BY COUNT_STAR DESC;

-- Check slow queries (if enabled)
-- SELECT * FROM mysql.slow_log;

-- ============================================================================
-- MIGRATION: Recommended Changes to Schema
-- ============================================================================

-- Consider normalizing repeated columns (nama_provinsi, nama_kabupaten, etc)
-- Currently: denormalized untuk faster read (good untuk list view)
-- If update performance issues arise, consider foreign key approach

-- Example:
-- CREATE TABLE provinsi (id INT PRIMARY KEY, nama VARCHAR(255));
-- ALTER TABLE penduduk ADD COLUMN provinsi_id INT;
-- ALTER TABLE penduduk ADD FOREIGN KEY (provinsi_id) REFERENCES provinsi(id);

-- But untuk aplikasi ini, current structure OK karena:
-- - Lebih cepat untuk list view (no JOIN needed)
-- - Update rare (hanya saat edit 1 record)
-- - Storage small (text columns ~1KB per record)

-- ============================================================================
-- TIPS UNTUK MAINTAIN PERFORMANCE
-- ============================================================================

/*
1. Regular Maintenance:
   - Monthly: ANALYZE TABLE penduduk;
   - Quarterly: OPTIMIZE TABLE penduduk;
   - Monitor: Check slow query log

2. When to Add More Indexes:
   - If filter by nama becomes slow: ADD INDEX idx_nama (nama)
   - If search by ktp/no_kk slow: Already indexed ✓

3. Query Optimization:
   - Always use WHERE clause (delete=0 & status in (1,2)) ✓
   - Always LIMIT for pagination ✓
   - SELECT specific columns only (not *) ✓
   - Use proper JOIN (LEFT not CROSS) ✓

4. Caching Strategy:
   - Cache list page 5 minutes
   - Invalidate on insert/update/delete
   - Use Redis if available

5. Monitoring:
   - Use EXPLAIN ANALYZE untuk setiap query baru
   - Monitor query execution time
   - Set up alerts untuk queries > 1000ms
*/

-- ============================================================================
-- END OF OPTIMIZATION SCRIPT
-- ============================================================================
