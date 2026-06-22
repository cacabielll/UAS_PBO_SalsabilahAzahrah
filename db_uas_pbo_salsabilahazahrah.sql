-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2026 at 06:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_salsabilahazahrah`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_karyawan`
--

CREATE TABLE `tabel_karyawan` (
  `id_karyawan` int NOT NULL,
  `nama_karyawan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari_kerja_masuk` int NOT NULL,
  `gaji_dasar_per_hari` int NOT NULL,
  `jenis_karyawan` enum('Kontrak','Tetap','Magang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi_kontrak_bulan` int DEFAULT NULL,
  `agensi_penyalur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tunjangan_kesehatan` int DEFAULT NULL,
  `opsi_saham_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uang_saku_bulanan` int DEFAULT NULL,
  `sertifikat_kampus_merdeka` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabel_karyawan`
--

INSERT INTO `tabel_karyawan` (`id_karyawan`, `nama_karyawan`, `departemen`, `hari_kerja_masuk`, `gaji_dasar_per_hari`, `jenis_karyawan`, `durasi_kontrak_bulan`, `agensi_penyalur`, `tunjangan_kesehatan`, `opsi_saham_id`, `uang_saku_bulanan`, `sertifikat_kampus_merdeka`) VALUES
(1, 'Andi Firmansyah', 'Teknologi Informasi', 22, 180000, 'Kontrak', 12, 'PT Sinergi Mitra', NULL, NULL, NULL, NULL),
(2, 'Bella Oktaviani', 'Pemasaran', 20, 160000, 'Kontrak', 6, 'CV Karya Mandiri', NULL, NULL, NULL, NULL),
(3, 'Cahyo Nugroho', 'Keuangan', 21, 175000, 'Kontrak', 9, 'PT Talenta Nusantara', NULL, NULL, NULL, NULL),
(4, 'Dewi Rahmawati', 'Sumber Daya Manusia', 22, 165000, 'Kontrak', 12, 'PT Mitra Rekrut', NULL, NULL, NULL, NULL),
(5, 'Eko Prasetyo', 'Operasional', 18, 155000, 'Kontrak', 6, NULL, NULL, NULL, NULL, NULL),
(6, 'Fitria Handayani', 'Teknologi Informasi', 23, 185000, 'Kontrak', 12, 'PT Digital Talent', NULL, NULL, NULL, NULL),
(7, 'Galang Saputra', 'Logistik', 20, 158000, 'Kontrak', 9, 'CV Solusi Tenaga', NULL, NULL, NULL, NULL),
(8, 'Hani Sulistyowati', 'Pemasaran', 19, 162000, 'Kontrak', NULL, 'PT Prima Rekrutmen', NULL, NULL, NULL, NULL),
(9, 'Irwan Budiman', 'Teknologi Informasi', 22, 250000, 'Tetap', NULL, NULL, 750000, 'ESOP-2021-IT-001', NULL, NULL),
(10, 'Juwita Permatasari', 'Keuangan', 22, 270000, 'Tetap', NULL, NULL, 800000, 'ESOP-2021-FIN-002', NULL, NULL),
(11, 'Kurniawan Hadi', 'Manajemen', 22, 300000, 'Tetap', NULL, NULL, 900000, 'ESOP-2020-MGT-003', NULL, NULL),
(12, 'Laras Wulandari', 'Sumber Daya Manusia', 21, 240000, 'Tetap', NULL, NULL, 700000, NULL, NULL, NULL),
(13, 'Maulana Yusuf', 'Operasional', 22, 230000, 'Tetap', NULL, NULL, 680000, 'ESOP-2022-OPS-005', NULL, NULL),
(14, 'Nisa Amalia', 'Pemasaran', 20, 245000, 'Tetap', NULL, NULL, NULL, 'ESOP-2023-MKT-006', NULL, NULL),
(15, 'Oscar Wijaya', 'Teknologi Informasi', 22, 290000, 'Tetap', NULL, NULL, 850000, 'ESOP-2021-IT-007', NULL, NULL),
(16, 'Putri Azzahra', 'Teknologi Informasi', 20, 80000, 'Magang', NULL, NULL, NULL, NULL, 600000, 'KM-BATCH4-TI-001'),
(17, 'Rafi Alfarizi', 'Pemasaran', 18, 75000, 'Magang', NULL, NULL, NULL, NULL, 550000, 'KM-BATCH4-MKT-002'),
(18, 'Salma Nabila', 'Keuangan', 20, 78000, 'Magang', NULL, NULL, NULL, NULL, 575000, NULL),
(19, 'Taufik Hidayat', 'Sumber Daya Manusia', 17, 72000, 'Magang', NULL, NULL, NULL, NULL, 525000, 'KM-BATCH5-SDM-004'),
(20, 'Ulfa Maharani', 'Operasional', 19, 76000, 'Magang', NULL, NULL, NULL, NULL, 560000, 'KM-BATCH5-OPS-005');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
