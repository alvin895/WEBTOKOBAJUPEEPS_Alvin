-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 05:51 AM
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
-- Database: `db_toko_alvin`
--

-- --------------------------------------------------------

--
-- Table structure for table `alvin_admin`
--

CREATE TABLE `alvin_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_telp` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alvin_admin`
--

INSERT INTO `alvin_admin` (`admin_id`, `admin_name`, `username`, `password`, `admin_telp`, `admin_email`, `admin_address`) VALUES
(1, 'alvin', 'alvinsatriaghaza', '$2a$12$vsPg4jcfSxtKQDgvVqcJPeQucu2C0l5ptykP.orVJ6KLF1C6ngvGq', '085381664788', 'alvinsatriaghaza@gmail.com', 'jl.limau manis,koto tuo');

-- --------------------------------------------------------

--
-- Table structure for table `alvin_category`
--

CREATE TABLE `alvin_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alvin_category`
--

INSERT INTO `alvin_category` (`category_id`, `category_name`) VALUES
(8, 'Kaos'),
(9, 'Jaket');

-- --------------------------------------------------------

--
-- Table structure for table `alvin_detail_pesanan`
--

CREATE TABLE `alvin_detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `ukuran` varchar(20) DEFAULT NULL,
  `warna` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alvin_detail_pesanan`
--

INSERT INTO `alvin_detail_pesanan` (`id_detail`, `id_pesanan`, `product_id`, `quantity`, `ukuran`, `warna`) VALUES
(5, 14, 19, 1, 'S', 'Hitam'),
(6, 15, 42, 1, 'L', 'Hitam'),
(7, 16, 32, 1, 'XL', 'Coklat'),
(8, 17, 20, 2, 'M', 'Putih'),
(9, 18, 42, 1, 'L', 'Hitam'),
(10, 19, 42, 1, 'L', 'Coklat');

-- --------------------------------------------------------

--
-- Table structure for table `alvin_keranjang`
--

CREATE TABLE `alvin_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `ukuran` varchar(20) DEFAULT NULL,
  `warna` varchar(20) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `waktu_ditambahkan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alvin_pesanan`
--

CREATE TABLE `alvin_pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pembeli` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `tanggal_beli` date DEFAULT NULL,
  `status_pesanan` varchar(20) DEFAULT 'pending',
  `ukuran` varchar(10) DEFAULT NULL,
  `warna` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alvin_pesanan`
--

INSERT INTO `alvin_pesanan` (`id_pesanan`, `nama_pembeli`, `no_hp`, `alamat`, `total_harga`, `metode_pembayaran`, `tanggal_beli`, `status_pesanan`, `ukuran`, `warna`) VALUES
(14, 'Hanif alzikri', '083367873635', 'Padang,Limau Manis', 90000, 'COD (Bayar Ditempat)', '2025-07-03', 'Pending', NULL, NULL),
(15, 'Alvin Satria Ghaza', '085265853736', 'Solok,Paninggahan', 200000, 'Transfer Bank', '2025-07-03', 'Pending', NULL, NULL),
(16, 'M Raihan P', '083367873632', 'Padang ', 90000, 'COD (Bayar Ditempat)', '2025-07-03', 'Pending', NULL, NULL),
(17, 'Hazadib Ardeva', '08546378637', 'Padang Timur', 150000, 'QRIS / E-wallet', '2025-07-03', 'Pending', NULL, NULL),
(18, 'Fulan', '085367853938', 'Padang', 200000, 'Transfer Bank', '2025-07-03', 'Pending', NULL, NULL),
(19, 'fitra', '0853686276', 'padang', 200000, 'COD (Bayar Ditempat)', '2025-07-06', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alvin_product`
--

CREATE TABLE `alvin_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `product_status` tinyint(1) NOT NULL,
  `product_created` datetime NOT NULL,
  `product_size` varchar(50) NOT NULL,
  `product_color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alvin_product`
--

INSERT INTO `alvin_product` (`product_id`, `category_id`, `product_name`, `product_price`, `product_description`, `product_image`, `product_status`, `product_created`, `product_size`, `product_color`) VALUES
(19, 9, 'Switer List', 75000, 'jaket polos ', 'prod_1751524403.jpg', 1, '2025-07-03 12:05:34', '', ''),
(20, 9, 'Switer List', 75000, 'jaket polos', 'prod_1751524435.jpg', 1, '2025-07-03 13:05:26', '', ''),
(21, 9, 'Switer List', 75000, 'jaket polos', 'prod_1751524467.jpg', 1, '2025-07-03 13:27:28', '', ''),
(22, 9, 'Switer Kupluk', 65000, 'jaket polos', 'prod_1751524534.jpg', 1, '2025-07-03 13:28:43', '', ''),
(23, 9, 'Switer Kupluk', 65000, 'jaket polos', 'prod_1751524564.jpg', 1, '2025-07-03 13:29:25', '', ''),
(24, 9, 'Switer Kupluk', 65000, 'jaket polos', 'prod_1751524596.jpg', 1, '2025-07-03 13:30:07', '', ''),
(25, 8, 'Kaos Saku Lengan Pendek', 70000, 'kaos polos', 'prod_1751524251.jpg', 1, '2025-07-03 13:30:51', '', ''),
(26, 8, 'Kaos Saku Lengan Pendek', 70000, 'kaos polos', 'prod_1751524295.jpg', 1, '2025-07-03 13:31:35', '', ''),
(27, 8, 'Kaos Saku Lengan Pendek', 70000, 'kaos polos', 'prod_1751524770.jpg', 1, '2025-07-03 13:39:30', '', ''),
(28, 9, 'Jaket Parasut', 88000, 'jaket polos', 'prod_1751524825.jpg', 1, '2025-07-03 13:40:25', '', ''),
(29, 9, 'Jaket Parasut', 88000, 'jaket polos', 'prod_1751524904.jpg', 1, '2025-07-03 13:40:54', '', ''),
(30, 9, 'Jaket Parasut', 88000, 'jaket polos', 'prod_1751524892.jpg', 1, '2025-07-03 13:41:32', '', ''),
(31, 9, 'Jaket Parasut', 90000, 'jaket polos', 'prod_1751524937.jpg', 1, '2025-07-03 13:42:17', '', ''),
(32, 9, 'Jaket Parasut', 90000, 'jaket polos', 'prod_1751524971.jpg', 1, '2025-07-03 13:42:51', '', ''),
(33, 9, 'Jaket Parasut', 90000, 'jaket polos', 'prod_1751524994.jpg', 1, '2025-07-03 13:43:14', '', ''),
(34, 8, 'Kaos Polos Lengan Panjang', 100000, 'kaos polos', 'prod_1751525063.jpg', 1, '2025-07-03 13:44:23', '', ''),
(35, 8, 'Kaos Polos Lengan Panjang', 100000, 'kaos polos', 'prod_1751525092.jpg', 1, '2025-07-03 13:44:52', '', ''),
(36, 8, 'Kaos Uniqlo Polos Lengan Pendek', 150000, 'kaos polos', 'prod_1751525131.jpg', 1, '2025-07-03 13:45:31', '', ''),
(37, 8, 'Kaos Uniqlo Polos Lengan Pendek', 150000, 'kaos polos', 'prod_1751525161.jpg', 1, '2025-07-03 13:46:01', '', ''),
(38, 8, 'Kaos Uniqlo Polos Lengan Pendek', 150000, 'kaos polos', 'prod_1751525189.jpg', 1, '2025-07-03 13:46:29', '', ''),
(39, 8, 'Kaos Uniqlo Polos Lengan Pendek', 150000, 'kaos polos', 'prod_1751525217.jpg', 1, '2025-07-03 13:46:57', '', ''),
(40, 8, 'Kaos Uniqlo Polos Lengan Pendek', 150000, 'kaos polos', 'prod_1751525271.jpg', 1, '2025-07-03 13:47:51', '', ''),
(41, 8, 'Kaos Uniqlo List', 200000, 'kaos polos', 'prod_1751525307.jpg', 1, '2025-07-03 13:48:27', '', ''),
(42, 8, 'Kaos Uniqlo List', 200000, 'kaos ', 'prod_1751810765.jpg', 1, '2025-07-03 13:48:57', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alvin_admin`
--
ALTER TABLE `alvin_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `alvin_category`
--
ALTER TABLE `alvin_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `alvin_detail_pesanan`
--
ALTER TABLE `alvin_detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `alvin_keranjang`
--
ALTER TABLE `alvin_keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `alvin_pesanan`
--
ALTER TABLE `alvin_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `alvin_product`
--
ALTER TABLE `alvin_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alvin_admin`
--
ALTER TABLE `alvin_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alvin_category`
--
ALTER TABLE `alvin_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `alvin_detail_pesanan`
--
ALTER TABLE `alvin_detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `alvin_keranjang`
--
ALTER TABLE `alvin_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alvin_pesanan`
--
ALTER TABLE `alvin_pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `alvin_product`
--
ALTER TABLE `alvin_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alvin_detail_pesanan`
--
ALTER TABLE `alvin_detail_pesanan`
  ADD CONSTRAINT `alvin_detail_pesanan_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `alvin_product` (`product_id`),
  ADD CONSTRAINT `alvin_detail_pesanan_ibfk_3` FOREIGN KEY (`id_pesanan`) REFERENCES `alvin_pesanan` (`id_pesanan`);

--
-- Constraints for table `alvin_keranjang`
--
ALTER TABLE `alvin_keranjang`
  ADD CONSTRAINT `alvin_keranjang_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `alvin_product` (`product_id`);

--
-- Constraints for table `alvin_product`
--
ALTER TABLE `alvin_product`
  ADD CONSTRAINT `alvin_product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `alvin_category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
