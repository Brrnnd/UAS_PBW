-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 07:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdiary`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `judul` text DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(3, 'Pelatihan di SMPN 3 Demak', 'Implementasi tugas akhir keterampilan interpersonal di SMPN 3 Demak. Implementasinya yaitu membuat pelatihan tentang canva untuk membuat poster kebersihan lingkungan.', '20250110074646.jpg', '2025-01-10 07:46:46', 'admin'),
(5, 'Matrikulasi', 'Hari terakhir kegiatan matrikulasi.', '20250110074657.jpg', '2025-01-10 07:46:57', 'admin'),
(6, 'Kuliah', 'Keseharian saya sebagai mahasiswa.', '20250110074636.jpg', '2025-01-10 07:46:36', 'admin'),
(7, 'Menunggu waktu kuliah', 'Terdapat jarak waktu yang cukup banyak antara matkul 1 dan lainnya menyebabkan saya bosan menunggu dan sampailah saya di rooftop kampus Udinus.', '20250110074622.jpg', '2025-01-10 07:46:22', 'admin'),
(8, 'Healing', 'Mencari kebahagian biar tidak stress muda.', '20250110074610.jpg', '2025-01-10 07:46:10', 'admin'),
(9, 'Game', 'Kenapa main game, karena UG G nya gaming.', '20250110074602.jpg', '2025-01-10 07:46:02', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `nama`, `deskripsi`, `gambar`, `tanggal`) VALUES
(7, 'Udinus', 'Gabut', '2.jpg', '2025-01-04 06:46:36'),
(8, 'Curug Lawe', 'Healing', '3.jpg', '2025-01-04 06:47:04'),
(9, 'Game', 'Gaming', '4.jpg', '2025-01-04 06:47:27'),
(11, 'Udinus', 'Selesai', '6.jpg', '2025-01-04 06:50:45'),
(12, 'SMP N 3 Demak', 'Ketrampilan Interpersonal', '7.jpg', '2025-01-04 06:50:45'),
(15, 'Kelas', 'Probstat', '9.jpg', '2025-01-04 07:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `photo`) VALUES
(29, 'user1', '$2y$10$86KsDGfNW5zJ2Cp7B7cSnu/Gq5GJrcJAmG2msAH2qhuvvRGXdUJR2', 'user', 'foto/CBC.png'),
(30, 'user2', '$2y$10$D556jMb/jK7PqK15042MfOpFzZM4rmcApw7bXr7two6.OSjyMHHTS', 'user', 'foto/CFB .png'),
(34, 'tes', '$2y$10$U0QyrvuO0QgUqIwGTggqlOUEUtrFhCqixZZNnRNMURLnFuVKPdwC2', 'user', 'foto/Screenshot 2024-12-24 202205.png'),
(37, 'danny', '$2y$10$3m.OzYST/JdK47dkW1P9L.h0mjhg5Y4Db.WD2i.Hil8NW6zXF.MDO', 'admin', 'foto/dataset.png'),
(38, 'admin', '$2y$10$aF4udlUVGQHbb.Ao0g94jeSirvJUXq1bpTpebsvv6rmFooQrc5qkK', 'admin', 'foto/login.png'),
(39, 'user', '$2y$10$eBqtswhttU9Y0A2lFGM.Ye10d/WdnArWCtCqaKvWY4wMtSht5OA76', 'user', 'foto/login.png'),
(40, 'user7', '$2y$10$ISKEl1gcCJZgHXWxOAXy7.7CKeiAvgNLtDETm3snapnKSkoRKmLmO', 'user', 'foto/login.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
