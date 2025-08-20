-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2025 at 06:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_himpunan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `qty` int NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `jenis_id` int DEFAULT NULL,
  `sumber_id` int DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `qty`, `satuan`, `jenis_id`, `sumber_id`, `keterangan`, `created_at`) VALUES
(87, 'Galon', 5, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(88, 'Lemari Besar Belakang', 1, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(89, 'Meja', 4, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(90, 'Gas', 2, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(91, 'Kompor', 1, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(92, 'Dispenser', 1, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(93, 'Loker Ruang Utama', 1, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(94, 'Kulkas', 1, 'Unit', 15, 4, '', '2025-07-05 23:04:57'),
(95, 'Cermin', 2, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(96, 'PC, Keyboard, Mouse', 1, 'Set', 15, 3, '', '2025-07-05 23:04:57'),
(97, 'Rak', 1, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(98, 'Papan Tulis', 1, 'Unit', 12, 3, '', '2025-07-05 23:04:57'),
(99, 'Router', 2, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(100, 'Jam Dinding', 1, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(101, 'Monitor', 2, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(102, 'Kasur', 0, 'Unit', 16, 3, '', '2025-07-05 23:04:57'),
(103, 'Terminal', 7, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(104, 'Selimut', 7, 'Unit', 16, 3, '', '2025-07-05 23:04:57'),
(105, 'Bantal & Guling', 8, 'Unit', 16, 3, '', '2025-07-05 23:04:57'),
(106, 'Lampu', 0, 'Unit', 15, 3, '', '2025-07-05 23:04:57'),
(107, 'Papan Tulis Kecil', 1, 'Unit', 12, 3, '', '2025-07-05 23:04:57'),
(108, 'Papan Mading', 1, 'Unit', 12, 3, '', '2025-07-05 23:04:57'),
(109, 'Kursi', 4, 'Unit', 14, 3, '', '2025-07-05 23:04:57'),
(110, 'Gelas', 7, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(111, 'Piring', 0, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(112, 'Peso', 0, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(113, 'Garpu', 0, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(114, 'Speaker', 1, 'Set', 15, 3, '', '2025-07-05 23:04:57'),
(115, 'Figura Foto', 5, 'Unit', 12, 3, '', '2025-07-05 23:04:57'),
(116, 'Karpet', 2, 'Unit', 16, 3, '', '2025-07-05 23:04:57'),
(117, 'Gunting', 1, 'Unit', 12, 3, '', '2025-07-05 23:04:57'),
(118, 'Obeng', 1, 'Set', 12, 3, '', '2025-07-05 23:04:57'),
(119, 'Magic Com', 1, 'Unit', 13, 3, '', '2025-07-05 23:04:57'),
(120, 'Panci', 2, 'Unit', 13, 3, 'Kata Arkan', '2025-07-05 23:04:57'),
(121, 'Lakban', 2, 'Unit', 12, 5, '', '2025-07-05 23:04:57'),
(122, 'Layar Proyektor', 1, 'Unit', 12, 3, '', '2025-07-05 23:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int NOT NULL,
  `nama_jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `nama_jenis`) VALUES
(12, 'Alat Tulis Percetakan & Perlengkapan'),
(13, 'Alat Dapur'),
(14, 'Furniture'),
(15, 'Elektronik'),
(16, 'Perlengkapan Istirahat');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `aksi` varchar(50) DEFAULT NULL,
  `tabel` varchar(50) DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `aksi`, `tabel`, `keterangan`, `created_at`) VALUES
(12, 2, 'TAMBAH', 'sumber_barang', 'Menambah sumber baru: Hibah', '2025-07-04 18:49:39'),
(13, 2, 'TAMBAH', 'sumber_barang', 'Menambah sumber baru: Sponsor', '2025-07-04 18:49:44'),
(14, 2, 'TAMBAH', 'sumber_barang', 'Menambah sumber baru: Beli', '2025-07-04 18:49:48'),
(15, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Alat Dapur', '2025-07-04 18:50:05'),
(16, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Furniture', '2025-07-04 18:50:10'),
(17, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Elektronik', '2025-07-04 18:50:16'),
(18, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Alat Tulis Percetakan &amp; Perlengkapan', '2025-07-04 18:50:34'),
(19, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Perlengkapan Istirahat', '2025-07-04 18:50:44'),
(20, 2, 'HAPUS', 'barang', 'Menghapus barang: Monitor', '2025-07-04 18:51:56'),
(21, 2, 'HAPUS', 'barang', 'Menghapus barang: Jam Dinding', '2025-07-04 18:51:58'),
(22, 2, 'HAPUS', 'barang', 'Menghapus barang: Router', '2025-07-04 18:51:59'),
(23, 2, 'HAPUS', 'barang', 'Menghapus barang: Papan Tulis', '2025-07-04 18:52:00'),
(24, 2, 'HAPUS', 'barang', 'Menghapus barang: Rak', '2025-07-04 18:52:03'),
(25, 2, 'HAPUS', 'barang', 'Menghapus barang: PC, Keyboard, Mouse', '2025-07-04 18:52:04'),
(26, 2, 'HAPUS', 'barang', 'Menghapus barang: Cermin', '2025-07-04 18:52:06'),
(27, 2, 'HAPUS', 'barang', 'Menghapus barang: Kulkas', '2025-07-04 18:52:06'),
(28, 2, 'HAPUS', 'barang', 'Menghapus barang: Loker Ruang Utama', '2025-07-04 18:52:07'),
(29, 2, 'HAPUS', 'barang', 'Menghapus barang: Dispenser', '2025-07-04 18:52:08'),
(30, 2, 'HAPUS', 'barang', 'Menghapus barang: Kompor', '2025-07-04 18:52:09'),
(31, 2, 'HAPUS', 'barang', 'Menghapus barang: Gas', '2025-07-04 18:52:10'),
(32, 2, 'HAPUS', 'barang', 'Menghapus barang: Meja', '2025-07-04 18:52:11'),
(33, 2, 'HAPUS', 'barang', 'Menghapus barang: Lemari Besar Belakang', '2025-07-04 18:52:11'),
(34, 2, 'HAPUS', 'barang', 'Menghapus barang: Galon', '2025-07-04 18:52:12'),
(35, 2, 'HAPUS', 'barang', 'Menghapus barang: Monitor', '2025-07-04 18:53:32'),
(36, 2, 'HAPUS', 'barang', 'Menghapus barang: Jam Dinding', '2025-07-04 18:53:33'),
(37, 2, 'HAPUS', 'barang', 'Menghapus barang: Router', '2025-07-04 18:53:34'),
(38, 2, 'HAPUS', 'barang', 'Menghapus barang: Papan Tulis', '2025-07-04 18:53:35'),
(39, 2, 'HAPUS', 'barang', 'Menghapus barang: Rak', '2025-07-04 18:53:36'),
(40, 2, 'HAPUS', 'barang', 'Menghapus barang: PC, Keyboard, Mouse', '2025-07-04 18:53:37'),
(41, 2, 'HAPUS', 'barang', 'Menghapus barang: Cermin', '2025-07-04 18:53:38'),
(42, 2, 'HAPUS', 'barang', 'Menghapus barang: Kulkas', '2025-07-04 18:53:39'),
(43, 2, 'HAPUS', 'barang', 'Menghapus barang: Loker Ruang Utama', '2025-07-04 18:53:40'),
(44, 2, 'HAPUS', 'barang', 'Menghapus barang: Dispenser', '2025-07-04 18:53:40'),
(45, 2, 'HAPUS', 'barang', 'Menghapus barang: Kompor', '2025-07-04 18:53:41'),
(46, 2, 'HAPUS', 'barang', 'Menghapus barang: Gas', '2025-07-04 18:53:42'),
(47, 2, 'HAPUS', 'barang', 'Menghapus barang: Meja', '2025-07-04 18:53:43'),
(48, 2, 'HAPUS', 'barang', 'Menghapus barang: Lemari Besar Belakang', '2025-07-04 18:53:44'),
(49, 2, 'HAPUS', 'barang', 'Menghapus barang: Galon', '2025-07-04 18:53:45'),
(50, 2, 'HAPUS', 'barang', 'Menghapus barang: Monitor', '2025-07-04 18:55:08'),
(51, 2, 'HAPUS', 'barang', 'Menghapus barang: Jam Dinding', '2025-07-04 18:55:09'),
(52, 2, 'HAPUS', 'barang', 'Menghapus barang: Router', '2025-07-04 18:55:11'),
(53, 2, 'HAPUS', 'barang', 'Menghapus barang: Papan Tulis', '2025-07-04 18:55:12'),
(54, 2, 'HAPUS', 'barang', 'Menghapus barang: Rak', '2025-07-04 18:55:13'),
(55, 2, 'HAPUS', 'barang', 'Menghapus barang: PC, Keyboard, Mouse', '2025-07-04 18:55:14'),
(56, 2, 'HAPUS', 'barang', 'Menghapus barang: Cermin', '2025-07-04 18:55:15'),
(57, 2, 'HAPUS', 'barang', 'Menghapus barang: Kulkas', '2025-07-04 18:55:16'),
(58, 2, 'HAPUS', 'barang', 'Menghapus barang: Loker Ruang Utama', '2025-07-04 18:55:17'),
(59, 2, 'HAPUS', 'barang', 'Menghapus barang: Dispenser', '2025-07-04 18:55:18'),
(60, 2, 'HAPUS', 'barang', 'Menghapus barang: Kompor', '2025-07-04 18:55:19'),
(61, 2, 'HAPUS', 'barang', 'Menghapus barang: Gas', '2025-07-04 18:55:20'),
(62, 2, 'HAPUS', 'barang', 'Menghapus barang: Meja', '2025-07-04 18:55:21'),
(63, 2, 'HAPUS', 'barang', 'Menghapus barang: Lemari Besar Belakang', '2025-07-04 18:55:22'),
(64, 2, 'IMPORT', 'barang', 'Mengimpor data dari file CSV.', '2025-07-04 18:55:29'),
(65, 2, 'HAPUS', 'sumber_barang', 'Menghapus sumber: Alat Dapur', '2025-07-05 22:59:28'),
(66, 2, 'HAPUS', 'sumber_barang', 'Menghapus sumber: Furniture', '2025-07-05 22:59:31'),
(67, 2, 'HAPUS', 'sumber_barang', 'Menghapus sumber: Elektronik', '2025-07-05 22:59:32'),
(68, 2, 'HAPUS', 'sumber_barang', 'Menghapus sumber: Alat Tulis Percetakan &amp; Perlengkapan', '2025-07-05 22:59:34'),
(69, 2, 'HAPUS', 'sumber_barang', 'Menghapus sumber: Perlengkapan Istirahat', '2025-07-05 22:59:35'),
(70, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Alat Tulis Percetakan &amp; Perlengkapan', '2025-07-05 23:00:10'),
(71, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Alat Dapur', '2025-07-05 23:00:16'),
(72, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Furniture', '2025-07-05 23:00:20'),
(73, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Elektronik', '2025-07-05 23:00:24'),
(74, 2, 'TAMBAH', 'jenis_barang', 'Menambah jenis baru: Perlengkapan Istirahat', '2025-07-05 23:00:40'),
(75, 2, 'IMPORT', 'barang', 'Mengimpor data dari file CSV.', '2025-07-05 23:04:57'),
(76, 2, 'PINJAM', 'peminjaman', 'Mencatat peminjaman \'Magic Com\' oleh suryadi', '2025-07-06 14:46:35'),
(77, 2, 'KEMBALI', 'peminjaman', 'Mencatat pengembalian \'Magic Com\' oleh suryadi', '2025-07-06 14:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `log_barang`
--

CREATE TABLE `log_barang` (
  `id` int NOT NULL,
  `barang_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `aksi` enum('tambah','edit','hapus','pinjam','kembali') DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `barang_id` int DEFAULT NULL,
  `peminjam` varchar(100) NOT NULL,
  `qty_dipinjam` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `barang_id`, `peminjam`, `qty_dipinjam`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `keterangan`, `created_at`) VALUES
(5, 119, 'suryadi', 1, '2025-07-06', '2025-07-06', 'dikembalikan', 'as', '2025-07-06 14:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sumber_barang`
--

CREATE TABLE `sumber_barang` (
  `id` int NOT NULL,
  `nama_sumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sumber_barang`
--

INSERT INTO `sumber_barang` (`id`, `nama_sumber`) VALUES
(3, 'Hibah'),
(4, 'Sponsor'),
(5, 'Beli');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_at`) VALUES
(2, 'admin', '$2y$10$OKpgW8p/PLxsvYQ89JVnyeY4XPG88tx0tZT1cpcBd8seEP8K4lbsO', 1, '2025-07-04 17:11:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_id` (`jenis_id`),
  ADD KEY `sumber_id` (`sumber_id`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `log_barang`
--
ALTER TABLE `log_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sumber_barang`
--
ALTER TABLE `sumber_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `log_barang`
--
ALTER TABLE `log_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sumber_barang`
--
ALTER TABLE `sumber_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`jenis_id`) REFERENCES `jenis_barang` (`id`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`sumber_id`) REFERENCES `sumber_barang` (`id`);

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `log_barang`
--
ALTER TABLE `log_barang`
  ADD CONSTRAINT `log_barang_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `log_barang_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
