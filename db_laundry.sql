-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2025 pada 04.20
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
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rizal', '087831714546', 'Bogor', '2025-06-15 02:19:07', '2025-06-18 18:14:26', '2025-06-18 20:14:26'),
(2, 'Rizky', '6212345678', 'Depok', '2025-06-15 13:02:33', '2025-06-26 01:34:00', '2025-06-26 03:34:00'),
(3, 'Sulis', '087831714546', 'Bekasi', '2025-06-18 15:22:34', '2025-06-26 01:33:58', '2025-06-26 03:33:58'),
(8, 'Rey', '087831714546', 'Depok', '2025-06-18 17:56:25', '2025-06-26 01:33:57', '2025-06-26 03:33:57'),
(10, 'Putriana', '08123456789', 'Parung Panjang', '2025-06-21 12:13:51', '2025-06-26 01:33:56', '2025-06-26 03:33:56'),
(11, 'William', '08123456789', 'Matraman', '2025-06-22 09:37:06', '2025-06-26 01:33:54', '2025-06-26 03:33:54'),
(12, 'Aldo', '+62123456789', 'Bekasi', '2025-06-26 01:42:57', '2025-06-26 02:08:53', '2025-06-26 04:08:53'),
(13, 'Siddiq', '2147483647', 'Jaktim', '2025-06-26 01:45:59', '2025-06-26 02:08:53', '2025-06-26 04:08:53'),
(14, 'Wili', '+62123456789', 'Depok', '2025-06-26 02:03:58', '2025-06-26 02:08:52', '2025-06-26 04:08:52'),
(15, 'Sisil', '+62123456789', 'Depok', '2025-06-26 02:09:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id`, `level_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', '2025-06-13 16:22:42', '2025-06-15 01:48:17', NULL),
(2, 'Operator', '2025-06-15 01:46:06', '2025-06-15 01:47:39', NULL),
(3, 'Leader', '2025-06-26 02:17:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id`, `address`, `email`, `name`, `phone`, `create_at`, `update_at`) VALUES
(1, 'Grogolpetamburan, Jakarta Barat.', 'laundryabdullah@gmail.com', 'LA | Laundry Abdullah', '08123456789', '2025-06-22 07:28:46', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_laundry_pickup`
--

CREATE TABLE `trans_laundry_pickup` (
  `id` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `pickup_date` datetime NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trans_laundry_pickup`
--

INSERT INTO `trans_laundry_pickup` (`id`, `id_order`, `id_customer`, `pickup_date`, `notes`, `created_at`, `updated_at`) VALUES
(8, 21, 2, '2025-06-22 11:53:14', '', '2025-06-22 09:53:14', NULL),
(9, 20, 3, '2025-06-22 11:53:37', '', '2025-06-22 09:53:37', NULL),
(10, 19, 8, '2025-06-23 10:20:05', '', '2025-06-23 08:20:05', NULL),
(11, 18, 10, '2025-06-24 09:58:21', '', '2025-06-24 07:58:21', NULL),
(12, 22, 12, '2025-06-26 03:44:53', '', '2025-06-26 01:44:53', NULL),
(13, 23, 13, '2025-06-26 03:46:59', '', '2025-06-26 01:46:59', NULL),
(14, 24, 12, '2025-06-26 03:59:33', '', '2025-06-26 01:59:33', NULL),
(15, 25, 14, '2025-06-26 04:04:33', '', '2025-06-26 02:04:33', NULL),
(16, 26, 14, '2025-06-26 04:07:03', '', '2025-06-26 02:07:03', NULL),
(17, 27, 15, '2025-06-26 04:09:49', '', '2025-06-26 02:09:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_order`
--

CREATE TABLE `trans_order` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `order_code` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `order_end_date` date NOT NULL,
  `order_status` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `order_pay` int(11) NOT NULL,
  `order_change` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trans_order`
--

INSERT INTO `trans_order` (`id`, `id_customer`, `order_code`, `order_date`, `order_end_date`, `order_status`, `created_at`, `updated_at`, `deleted_at`, `order_pay`, `order_change`, `total`) VALUES
(17, 11, 'TR-220625-001', '2025-06-22', '2025-06-23', 0, '2025-06-22 09:50:27', '2025-06-26 01:42:00', '2025-06-26 03:42:00', 0, 0, 40000),
(18, 10, 'TR-220625-018', '2025-06-22', '2025-06-23', 1, '2025-06-22 09:50:55', '2025-06-26 01:42:04', '2025-06-26 03:42:04', 20000, 5000, 15000),
(19, 8, 'TR-220625-019', '2025-06-22', '2025-06-23', 1, '2025-06-22 09:51:44', '2025-06-26 01:42:03', '2025-06-26 03:42:03', 15000, 1500, 13500),
(20, 3, 'TR-220625-020', '2025-06-22', '2025-06-23', 1, '2025-06-22 09:52:12', '2025-06-26 01:41:48', '2025-06-26 03:41:48', 50000, 20000, 30000),
(21, 2, 'TR-220625-021', '2025-06-22', '2025-06-23', 1, '2025-06-22 09:52:55', '2025-06-26 01:41:45', '2025-06-26 03:41:45', 10000, 1000, 9000),
(22, 12, 'TR-260625-022', '2025-06-01', '2025-06-03', 1, '2025-06-26 01:44:02', '2025-06-26 01:54:09', '2025-06-26 03:54:09', 50000, 10000, 40000),
(23, 13, 'TR-260625-023', '2025-06-26', '2025-06-27', 1, '2025-06-26 01:46:46', '2025-06-26 02:09:02', '2025-06-26 04:09:02', 20000, 5000, 15000),
(24, 12, 'TR-260625-024', '2025-06-01', '2025-06-03', 1, '2025-06-26 01:59:25', '2025-06-26 02:09:01', '2025-06-26 04:09:01', 50000, 10000, 40000),
(25, 14, 'TR-260625-025', '2025-06-13', '2025-06-14', 1, '2025-06-26 02:04:24', '2025-06-26 02:09:01', '2025-06-26 04:09:01', 40000, 10000, 30000),
(26, 14, 'TR-260625-026', '2025-06-26', '2025-06-28', 1, '2025-06-26 02:06:52', '2025-06-26 02:09:00', '2025-06-26 04:09:00', 30000, 10000, 20000),
(27, 15, 'TR-260625-027', '2025-06-26', '2025-06-27', 1, '2025-06-26 02:09:40', '2025-06-26 02:09:49', NULL, 30000, 5000, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_order_detail`
--

CREATE TABLE `trans_order_detail` (
  `id` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `id_service` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` double(20,2) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trans_order_detail`
--

INSERT INTO `trans_order_detail` (`id`, `id_order`, `id_service`, `qty`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES
(14, 17, 6, 2000, 20000.00, '', '2025-06-22 09:50:27', NULL),
(15, 18, 3, 3000, 5000.00, '', '2025-06-22 09:50:55', NULL),
(16, 19, 2, 3000, 4500.00, '', '2025-06-22 09:51:44', NULL),
(17, 20, 1, 1000, 10000.00, '', '2025-06-22 09:52:12', NULL),
(18, 20, 6, 1000, 20000.00, '', '2025-06-22 09:52:12', NULL),
(19, 21, 2, 2000, 4500.00, '', '2025-06-22 09:52:55', NULL),
(20, 22, 6, 2000, 20000.00, '', '2025-06-26 01:44:02', NULL),
(21, 23, 3, 3000, 5000.00, '', '2025-06-26 01:46:46', NULL),
(22, 24, 6, 2000, 20000.00, '', '2025-06-26 01:59:25', NULL),
(23, 25, 6, 1000, 20000.00, '', '2025-06-26 02:04:25', NULL),
(24, 25, 3, 2000, 5000.00, '', '2025-06-26 02:04:25', NULL),
(25, 26, 1, 2000, 20000.00, '', '2025-06-26 02:06:52', NULL),
(26, 27, 6, 1000, 20000.00, '', '2025-06-26 02:09:40', NULL),
(27, 27, 3, 1000, 5000.00, '', '2025-06-26 02:09:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_of_service`
--

CREATE TABLE `type_of_service` (
  `id` int(11) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `type_of_service`
--

INSERT INTO `type_of_service` (`id`, `service_name`, `price`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cuci dan Gosok', 10000, 'Jasa Cuci dan gosok harganya Rp. 10.000 per Kg', '2025-06-15 03:03:52', '2025-06-22 09:14:56', NULL),
(2, 'Hanya Cuci', 4500, 'Hanya jasa cuci harganya Rp. 4.500 per Kg', '2025-06-15 03:06:16', NULL, NULL),
(3, 'Hanya Gosok', 5000, 'Hanya jasa gosok harganya Rp. 5.000 per Kg', '2025-06-15 03:07:40', '2025-06-15 03:07:50', NULL),
(6, 'Cuci dan gosok bahan besar', 20000, '(Sprei, karpet, bad cover, dll) harga Rp. 20.000 pek Kg', '2025-06-21 12:09:07', '2025-06-22 09:15:57', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `id_level`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Abdullah', 'admin@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '2025-06-13 16:30:48', NULL),
(5, 2, 'Diriansyah', 'diriansyah@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2025-06-24 01:20:55', NULL),
(8, 3, 'Reza', 'reza@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2025-06-26 02:18:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order_to_order_id` (`id_order`),
  ADD KEY `customer_id_to_id_customer` (`id_customer`);

--
-- Indeks untuk tabel `trans_order`
--
ALTER TABLE `trans_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_customer_to_customer_id` (`id_customer`);

--
-- Indeks untuk tabel `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id_to_id_order` (`id_order`),
  ADD KEY `id_service_to_service_id` (`id_service`);

--
-- Indeks untuk tabel `type_of_service`
--
ALTER TABLE `type_of_service`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level_to_ilevel_id` (`id_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `trans_order`
--
ALTER TABLE `trans_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `type_of_service`
--
ALTER TABLE `type_of_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  ADD CONSTRAINT `customer_id_to_id_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `id_order_to_order_id` FOREIGN KEY (`id_order`) REFERENCES `trans_order` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  ADD CONSTRAINT `id_service_to_service_id` FOREIGN KEY (`id_service`) REFERENCES `type_of_service` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_id_to_id_order` FOREIGN KEY (`id_order`) REFERENCES `trans_order` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `id_level_to_ilevel_id` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
