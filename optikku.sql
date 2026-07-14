/*
 Navicat Premium Dump SQL

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB-log)
 Source Host           : localhost:3306
 Source Schema         : optikku

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB-log)
 File Encoding         : 65001

 Date: 12/07/2026 21:08:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bahan_frame
-- ----------------------------
DROP TABLE IF EXISTS `bahan_frame`;
CREATE TABLE `bahan_frame`  (
  `idbahan_frame` int NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idbahan_frame`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bahan_frame
-- ----------------------------

-- ----------------------------
-- Table structure for bahan_lensa
-- ----------------------------
DROP TABLE IF EXISTS `bahan_lensa`;
CREATE TABLE `bahan_lensa`  (
  `idbahan_lensa` int NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idbahan_lensa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bahan_lensa
-- ----------------------------
INSERT INTO `bahan_lensa` VALUES (1, 'Katun');

-- ----------------------------
-- Table structure for bentuk_frame
-- ----------------------------
DROP TABLE IF EXISTS `bentuk_frame`;
CREATE TABLE `bentuk_frame`  (
  `idbentuk_frame` int NOT NULL AUTO_INCREMENT,
  `nama_bentuk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idbentuk_frame`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bentuk_frame
-- ----------------------------

-- ----------------------------
-- Table structure for bentuk_lensa
-- ----------------------------
DROP TABLE IF EXISTS `bentuk_lensa`;
CREATE TABLE `bentuk_lensa`  (
  `idbentuk_lensa` int NOT NULL AUTO_INCREMENT,
  `nama_bentuk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idbentuk_lensa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bentuk_lensa
-- ----------------------------
INSERT INTO `bentuk_lensa` VALUES (1, 'Oval');
INSERT INTO `bentuk_lensa` VALUES (2, 'Bulat');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `idcustomer` int NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telepon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`idcustomer`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------

-- ----------------------------
-- Table structure for frame
-- ----------------------------
DROP TABLE IF EXISTS `frame`;
CREATE TABLE `frame`  (
  `idframe` int NOT NULL AUTO_INCREMENT,
  `nama_frame` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idbentuk_frame` int NULL DEFAULT NULL,
  `idbahan_frame` int NULL DEFAULT NULL,
  `harga_jual` int NULL DEFAULT NULL,
  `harga_beli` int NULL DEFAULT NULL,
  PRIMARY KEY (`idframe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of frame
-- ----------------------------

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `idjabatan` int NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted` int NULL DEFAULT NULL COMMENT '0 = ada 1= dihapus',
  PRIMARY KEY (`idjabatan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES (1, 'admin_root', 0);

-- ----------------------------
-- Table structure for kacamata
-- ----------------------------
DROP TABLE IF EXISTS `kacamata`;
CREATE TABLE `kacamata`  (
  `idkacamata` int NOT NULL AUTO_INCREMENT,
  `nama_kacamata` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idlensa` int NULL DEFAULT NULL,
  `idframe` int NULL DEFAULT NULL,
  `harga_jual` int NULL DEFAULT NULL,
  `harga_beli` int NULL DEFAULT NULL,
  `deleted` int NULL DEFAULT NULL COMMENT '0 ada 1 dihapus',
  PRIMARY KEY (`idkacamata`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kacamata
-- ----------------------------

-- ----------------------------
-- Table structure for lensa
-- ----------------------------
DROP TABLE IF EXISTS `lensa`;
CREATE TABLE `lensa`  (
  `idframe` int NOT NULL AUTO_INCREMENT,
  `nama_lensa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idbentuk_lensa` int NULL DEFAULT NULL,
  `idbahan_lensa` int NULL DEFAULT NULL,
  `harga_beli` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `harga_jual` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `deleted` int NULL DEFAULT NULL COMMENT '0 ada 1 dihapus',
  PRIMARY KEY (`idframe`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lensa
-- ----------------------------

-- ----------------------------
-- Table structure for pegawai
-- ----------------------------
DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai`  (
  `idpegawai` int NOT NULL AUTO_INCREMENT,
  `kode_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nik_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idprovinsi_pegawai` int NULL DEFAULT NULL,
  `idkabupaten_pegawai` int NULL DEFAULT NULL,
  `idkecamatan_pegawai` int NULL DEFAULT NULL,
  `iddesa_pegawai` int NULL DEFAULT NULL,
  `alamat_lengkap` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `idjabatan` int NULL DEFAULT NULL,
  `idunit` int NULL DEFAULT NULL,
  `status_aktif` int NULL DEFAULT NULL COMMENT '0 = aktif 1 = tidak aktif',
  `deleted` int NULL DEFAULT NULL COMMENT '0 = aktif 1 = tidak aktif',
  PRIMARY KEY (`idpegawai`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pegawai
-- ----------------------------
INSERT INTO `pegawai` VALUES (1, '0', 'admin root', 'admin@admin.com', '$2a$12$MMPdXIejE0nrIZIbi.jqW.Zz6CwYneBfoQO.ivmCAcY9haQKUDDte', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `idpembelian` int NOT NULL AUTO_INCREMENT,
  `no_pembelian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idsupplier` int NULL DEFAULT NULL,
  `total` bigint NULL DEFAULT 0,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT current_timestamp(),
  `input_by` int NULL DEFAULT 0 COMMENT 'id pegawai',
  PRIMARY KEY (`idpembelian`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembelian
-- ----------------------------

-- ----------------------------
-- Table structure for pembelian_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_detail`;
CREATE TABLE `pembelian_detail`  (
  `iddetail` int NOT NULL AUTO_INCREMENT,
  `idpembelian` int NOT NULL,
  `jenis_produk` enum('kacamata','lensa','frame','aksesoris') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idproduk` int NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_beli` bigint NULL DEFAULT 0,
  `jumlah` int NULL DEFAULT 1,
  `subtotal` bigint NULL DEFAULT 0,
  PRIMARY KEY (`iddetail`) USING BTREE,
  INDEX `idx_pembelian`(`idpembelian` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembelian_detail
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `idpenjualan` int NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idcustomer` int NULL DEFAULT NULL,
  `total` bigint NULL DEFAULT 0,
  `diskon` bigint NULL DEFAULT 0,
  `grand_total` bigint NULL DEFAULT 0,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT current_timestamp(),
  `input_by` int NOT NULL DEFAULT 0 COMMENT 'idpegawai',
  PRIMARY KEY (`idpenjualan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail`  (
  `iddetail` int NOT NULL AUTO_INCREMENT,
  `idpenjualan` int NOT NULL,
  `jenis_produk` enum('kacamata','lensa','frame','aksesoris') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idproduk` int NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_jual` bigint NULL DEFAULT 0,
  `jumlah` int NULL DEFAULT 1,
  `subtotal` bigint NULL DEFAULT 0,
  PRIMARY KEY (`iddetail`) USING BTREE,
  INDEX `idx_penjualan`(`idpenjualan` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_detail
-- ----------------------------

-- ----------------------------
-- Table structure for riwayat_stok_frame
-- ----------------------------
DROP TABLE IF EXISTS `riwayat_stok_frame`;
CREATE TABLE `riwayat_stok_frame`  (
  `idriwayat` int NOT NULL AUTO_INCREMENT,
  `idframe` int NOT NULL,
  `jenis` enum('masuk','keluar','adjustment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `stok_sebelum` int NOT NULL,
  `stok_sesudah` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`idriwayat`) USING BTREE,
  INDEX `idx_frame`(`idframe` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of riwayat_stok_frame
-- ----------------------------

-- ----------------------------
-- Table structure for riwayat_stok_kacamata
-- ----------------------------
DROP TABLE IF EXISTS `riwayat_stok_kacamata`;
CREATE TABLE `riwayat_stok_kacamata`  (
  `idriwayat` int NOT NULL AUTO_INCREMENT,
  `idkacamata` int NOT NULL,
  `jenis` enum('masuk','keluar','adjustment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `stok_sebelum` int NOT NULL,
  `stok_sesudah` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`idriwayat`) USING BTREE,
  INDEX `idx_kacamata`(`idkacamata` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of riwayat_stok_kacamata
-- ----------------------------

-- ----------------------------
-- Table structure for riwayat_stok_lensa
-- ----------------------------
DROP TABLE IF EXISTS `riwayat_stok_lensa`;
CREATE TABLE `riwayat_stok_lensa`  (
  `idriwayat` int NOT NULL AUTO_INCREMENT,
  `idlensa` int NOT NULL,
  `jenis` enum('masuk','keluar','adjustment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `stok_sebelum` int NOT NULL,
  `stok_sesudah` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`idriwayat`) USING BTREE,
  INDEX `idx_lensa`(`idlensa` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of riwayat_stok_lensa
-- ----------------------------

-- ----------------------------
-- Table structure for stok_frame
-- ----------------------------
DROP TABLE IF EXISTS `stok_frame`;
CREATE TABLE `stok_frame`  (
  `idstok_frame` int NOT NULL AUTO_INCREMENT,
  `idframe` int NULL DEFAULT NULL,
  `jumlah` int NULL DEFAULT NULL,
  PRIMARY KEY (`idstok_frame`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stok_frame
-- ----------------------------

-- ----------------------------
-- Table structure for stok_kacamata
-- ----------------------------
DROP TABLE IF EXISTS `stok_kacamata`;
CREATE TABLE `stok_kacamata`  (
  `idstok_kacamata` int NOT NULL AUTO_INCREMENT,
  `idkacamata` int NULL DEFAULT NULL,
  `jumlah` int NULL DEFAULT NULL,
  PRIMARY KEY (`idstok_kacamata`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stok_kacamata
-- ----------------------------

-- ----------------------------
-- Table structure for stok_lensa
-- ----------------------------
DROP TABLE IF EXISTS `stok_lensa`;
CREATE TABLE `stok_lensa`  (
  `idstok_lensa` int NOT NULL AUTO_INCREMENT,
  `idlensa` int NULL DEFAULT NULL,
  `jumlah` int NULL DEFAULT NULL,
  PRIMARY KEY (`idstok_lensa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stok_lensa
-- ----------------------------

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit`  (
  `idunit` int NOT NULL AUTO_INCREMENT,
  `nama_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idunit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES (1, 'pusat');

-- ----------------------------
-- Table structure for vendor
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor`  (
  `idsupplier` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted` int NULL DEFAULT NULL,
  PRIMARY KEY (`idsupplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendor
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
