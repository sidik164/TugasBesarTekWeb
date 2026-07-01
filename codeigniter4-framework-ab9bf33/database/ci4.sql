CREATE DATABASE IF NOT EXISTS `ci4` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ci4`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `sertifikat`;
DROP TABLE IF EXISTS `progress_karyawan`;
DROP TABLE IF EXISTS `soal_kuis`;
DROP TABLE IF EXISTS `anggota`;
DROP TABLE IF EXISTS `modul_pelatihan`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'karyawan',
  `created_at` text DEFAULT NULL,
  `updated_at` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `modul_pelatihan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(150) NOT NULL,
  `file_materi` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `soal_kuis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) unsigned NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `jawaban_benar` char(1) NOT NULL COMMENT 'a/b/c/d',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_soal_modul` (`modul_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `progress_karyawan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `modul_id` int(11) unsigned NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'belum_mulai',
  `nilai_kuis` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sertifikat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `modul_id` int(11) unsigned NOT NULL,
  `issued_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `anggota` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(30) NOT NULL,
  `peran` varchar(150) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Demo User', 'admin@elearning.local', 'admin', '$2y$10$CY5j4bUNqP.2XmsU4OMwoOZeR82BF5ilYvWHZSjRnmNwlsX5ip.yC', 'admin', '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(2, 'Karyawan Demo', 'karyawan@elearning.local', 'karyawan', '$2y$10$N1ORLN.tA95rSD/emMfsFucRL98YOvQkHiofMmLfSSb47hlCJ.Ryy', 'karyawan', '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(3, 'Admin HR', 'hr@elearning.local', 'hr', '$2y$10$46.JbLNGdTKZTVJpCQBgFeaLOzcdFyqOV.zydFPoDe1Js0ZoD9.p2', 'admin', '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(4, 'Sidik', 'sidik@gmail.com', 'sidik', '$2y$10$dr9/9QJ9LXD7u6RCv6ccwOnvFQ26zqvlOUWznN.6zLT9yJ0fqsRa2', 'karyawan', '2026-07-01 00:00:00', '2026-07-01 00:00:00');

INSERT INTO `modul_pelatihan` (`id`, `judul`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Keselamatan Kerja Industri 4.0', 1, '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(2, 'Dasar Digital Manufacturing', 2, '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(3, 'Pemanfaatan IoT di Pabrik', 3, '2026-07-01 00:00:00', '2026-07-01 00:00:00');

-- ============================================================
-- SOAL KUIS — Contoh soal pilihan ganda per modul
-- ============================================================

-- Soal untuk Modul 1: Keselamatan Kerja Industri 4.0
INSERT INTO `soal_kuis` (`modul_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`, `created_at`, `updated_at`) VALUES
(1, 'Apa tujuan utama K3 (Keselamatan dan Kesehatan Kerja)?', 'Meningkatkan profit perusahaan', 'Melindungi tenaga kerja dari kecelakaan dan penyakit akibat kerja', 'Mempercepat proses produksi', 'Mengurangi jumlah karyawan', 'b', NOW(), NOW()),
(1, 'APD singkatan dari?', 'Alat Penunjang Diri', 'Alat Pelindung Diri', 'Alat Pengaman Diri', 'Alat Pertahanan Diri', 'b', NOW(), NOW()),
(1, 'Warna helm safety KUNING biasanya digunakan oleh?', 'Tamu/visitor', 'Supervisor/mandor', 'Pekerja umum', 'Safety officer', 'b', NOW(), NOW()),
(1, 'Apa yang harus dilakukan pertama kali saat terjadi kecelakaan kerja?', 'Melanjutkan pekerjaan', 'Memberikan pertolongan pertama dan melaporkan ke atasan', 'Mengambil foto untuk dokumentasi', 'Menghubungi media', 'b', NOW(), NOW()),
(1, 'Industri 4.0 identik dengan penggunaan teknologi apa?', 'Mesin uap', 'Listrik konvensional', 'Internet of Things dan otomasi', 'Tenaga manusia', 'c', NOW(), NOW());

-- Soal untuk Modul 2: Dasar Digital Manufacturing
INSERT INTO `soal_kuis` (`modul_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`, `created_at`, `updated_at`) VALUES
(2, 'Digital Manufacturing adalah proses manufaktur yang memanfaatkan?', 'Tenaga hewan', 'Teknologi digital dan komputer', 'Bahan baku alami saja', 'Tenaga manual tradisional', 'b', NOW(), NOW()),
(2, 'Apa keuntungan utama dari Digital Twin dalam manufaktur?', 'Menggandakan produk fisik', 'Simulasi virtual sebelum produksi nyata', 'Memperbanyak karyawan', 'Mengurangi kualitas produk', 'b', NOW(), NOW()),
(2, 'CNC adalah singkatan dari?', 'Central Network Computer', 'Computer Numerical Control', 'Control Number Center', 'Cyber Network Connection', 'b', NOW(), NOW()),
(2, 'Apa fungsi CAD dalam Digital Manufacturing?', 'Mengontrol keuangan', 'Mendesain produk secara digital', 'Mengelola SDM', 'Menjual produk online', 'b', NOW(), NOW()),
(2, '3D Printing dalam manufaktur digital juga dikenal sebagai?', 'Additive Manufacturing', 'Subtractive Manufacturing', 'Traditional Manufacturing', 'Manual Manufacturing', 'a', NOW(), NOW());

-- Soal untuk Modul 3: Pemanfaatan IoT di Pabrik
INSERT INTO `soal_kuis` (`modul_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`, `created_at`, `updated_at`) VALUES
(3, 'IoT singkatan dari?', 'Internet of Technology', 'Internet of Things', 'Integration of Technology', 'Internal of Things', 'b', NOW(), NOW()),
(3, 'Sensor pada IoT berfungsi untuk?', 'Menggantikan manusia sepenuhnya', 'Mengumpulkan data dari lingkungan fisik', 'Memperlambat proses produksi', 'Mengurangi kualitas produk', 'b', NOW(), NOW()),
(3, 'Predictive Maintenance menggunakan IoT bertujuan untuk?', 'Merusak mesin secara terencana', 'Memprediksi kerusakan mesin sebelum terjadi', 'Menghentikan produksi total', 'Menambah biaya operasional', 'b', NOW(), NOW()),
(3, 'Protokol komunikasi IoT yang umum digunakan di pabrik adalah?', 'HTTP saja', 'MQTT', 'FTP', 'SMTP', 'b', NOW(), NOW()),
(3, 'Apa manfaat utama IoT di lantai produksi pabrik?', 'Menambah jumlah karyawan', 'Monitoring real-time dan efisiensi operasional', 'Memperlambat proses kerja', 'Menghilangkan semua mesin', 'b', NOW(), NOW());

INSERT INTO `anggota` (`id`, `nama`, `nim`, `peran`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Sidik Permana', '2350081027', 'Fullstack Developer & UI/UX Designer', 'assets/img/Sidik.jpeg', '2026-07-01 00:00:00', '2026-07-01 00:00:00');

INSERT INTO `progress_karyawan` (`id`, `user_id`, `modul_id`, `status`, `nilai_kuis`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'selesai', 90, '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(2, 2, 2, 'sedang_belajar', 75, '2026-07-01 00:00:00', '2026-07-01 00:00:00'),
(3, 2, 3, 'belum_mulai', NULL, '2026-07-01 00:00:00', '2026-07-01 00:00:00');

INSERT INTO `sertifikat` (`id`, `user_id`, `modul_id`, `issued_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-07-01 00:00:00', '2026-07-01 00:00:00', '2026-07-01 00:00:00');

SET FOREIGN_KEY_CHECKS = 1;