-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Okt 2025 pada 08.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event-upn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `category`, `image`, `created_by`, `created_at`) VALUES
(3, 'Dies Natalis 7 HIMASISFO', 'Dalam rangka memperingati Dies Natalis ke-7, HIMASISFO mengadakan berbagai kegiatan seperti lomba, seminar, dan malam puncak yang dihadiri oleh alumni serta dosen program studi Sistem Informasi.', '2025-11-29', 'HIMA', '69006da639546_roberto-rendon-nlotvqL7KoY-unsplash.jpg', 4, '2025-10-28 03:21:37'),
(8, 'Kerja Praktik Jurusan Informatika', 'Kerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan Informatika Kerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan InformatikaKerja Praktik Jurusan Informatika', '2025-11-25', 'Jurusan', '69006e4a32b95_israel-andrade-YI_9SivVt_s-unsplash.jpg', NULL, '2025-10-28 05:40:35'),
(9, 'Kuliah Kerja Nyata', 'Kegiatan Kuliah Kerja Nyata (KKN) Periode 1 merupakan program wajib bagi mahasiswa tingkat akhir untuk menerapkan ilmu di masyarakat. Peserta akan ditempatkan di berbagai desa dengan fokus pada pengembangan potensi lokal dan pemberdayaan masyarakat.', '2026-01-05', 'Kampus', '69006d11ef8ff_bruno-aguirre-CZMdCV_uooc-unsplash.jpg', NULL, '2025-10-28 07:13:21'),
(10, 'Wisuda Periode 1', 'Acara Wisuda Periode 1 tahun 2025 dilaksanakan di Auditorium Utama UPN \"Veteran\" Jawa Timur. Wisuda ini menjadi momen berharga bagi mahasiswa yang telah menyelesaikan studi dan siap menapaki dunia profesional.', '2025-11-23', 'Kampus', '69006d690b63b_pang-yuhao-_kd5cxwZOK4-unsplash.jpg', NULL, '2025-10-28 07:14:49'),
(11, 'Company Visit BEM FTI', 'Kegiatan Company Visit BEM FTI bertujuan untuk memberikan wawasan kepada mahasiswa mengenai dunia industri teknologi. Tahun ini, kunjungan dilaksanakan ke PT Telkom Indonesia dan Gojek HQ di Surabaya. Kegiatan Company Visit BEM FTI bertujuan untuk memberikan wawasan kepada mahasiswa mengenai dunia industri teknologi. Tahun ini, kunjungan dilaksanakan ke PT Telkom Indonesia dan Gojek HQ di Surabaya.', '2025-10-07', 'BEM FAKULTAS', '69006de43fdc2_Poster Seminar IIO 2026.jpg', NULL, '2025-10-28 07:16:52'),
(12, 'HUMANIS', 'anniversary prodi manajemen upnvyk, fakultas ilmu ekonomi dan bisnis (FEB) yang sangat meriah mendatangkan banyak guest star. Diadakan di lapangan softball dengan mengundang banyak delegasi diantara nya adalah Sabrina dan 2 keronco nya dari HIMASISFO dan delegasi lainnya seperti Pertambangan, Perminyakan, dan Pangea.', '2025-10-10', 'Jurusan', '690073aab745b_joy-memon-rdjAQGAbLT4-unsplash.jpg', NULL, '2025-10-28 07:41:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(4, 'admin', 'adminutama@gmail.com', '$2y$10$ksb4BfDpYfBpHKpSNOP1hOZ46UkIZcxJB6LIMVGLco32XTLe/jNnG', 'admin', '2025-10-26 21:47:07'),
(6, 'Nurul Izzah', 'izzaanrl@gmail.com', '$2y$10$83QX2iL9uhi.8wMzxLUyv.JUM4KypC7dHGoxCkOj.ins6Uzdvz5Yq', 'user', '2025-10-28 04:41:31'),
(7, 'adminadmin', 'adminadmin@admin.com', 'admin', 'admin', '2025-10-28 07:03:11'),
(10, 'Aulia Bunga', 'dewantara@gmail.com', '$2y$10$VRbFMw3IHzgICpMwYXPc6uUICQkjo2SNrP4gFDyTv2kokD5mngadm', 'user', '2025-10-28 07:55:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
