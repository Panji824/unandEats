-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 04:58 PM
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
-- Database: `db_kantin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_kantin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_kantin`, `username`, `password`, `email`, `created_at`) VALUES
(13, 1, 'admin_kantin_bunda', 'password123', 'admin_bunda@example.com', '2024-12-16 12:25:25'),
(14, 2, 'admin_kantin_nice', 'password123', 'admin_nice@example.com', '2024-12-16 12:25:25'),
(15, 3, 'admin_kantin_raziq', 'password123', 'admin_raziq@example.com', '2024-12-16 12:25:25'),
(16, 4, 'admin_kantin_queen', 'password123', 'admin_queen@example.com', '2024-12-16 12:25:25'),
(17, 5, 'admin_kantin_galaxy', 'password123', 'admin_galaxy@example.com', '2024-12-16 12:25:25'),
(18, 6, 'admin_kantin_harmoni', 'password123', 'admin_harmoni@example.com', '2024-12-16 12:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `kantin`
--

CREATE TABLE `kantin` (
  `id_kantin` int(11) NOT NULL,
  `nama_kantin` varchar(100) NOT NULL,
  `lokasi` text NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kantin`
--

INSERT INTO `kantin` (`id_kantin`, `nama_kantin`, `lokasi`, `deskripsi`, `rating`, `created_at`) VALUES
(1, 'Kantin Bunda', 'Lokasi 1', 'Deskripsi untuk Kantin Bunda', 4.5, '2024-12-16 12:25:14'),
(2, 'Kantin Nice', 'Lokasi 2', 'Deskripsi untuk Kantin Nice', 4.4, '2024-12-16 12:25:14'),
(3, 'Kantin Raziq', 'Lokasi 3', 'Deskripsi untuk Kantin Raziq', 4.7, '2024-12-16 12:25:14'),
(4, 'Kantin Queen', 'Lokasi 4', 'Deskripsi untuk Kantin Queen', 4.5, '2024-12-16 12:25:14'),
(5, 'Kantin Galaxy', 'Lokasi 5', 'Deskripsi untuk Kantin Galaxy', 4.6, '2024-12-16 12:25:14'),
(6, 'Kantin Harmoni', 'Lokasi 6', 'Deskripsi untuk Kantin Harmoni', 4.8, '2024-12-16 12:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `menu_makanan`
--

CREATE TABLE `menu_makanan` (
  `id_menu` int(11) NOT NULL,
  `id_kantin` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_menu` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_makanan`
--

INSERT INTO `menu_makanan` (`id_menu`, `id_kantin`, `nama_menu`, `harga`, `kategori`, `deskripsi`, `gambar_menu`, `created_at`) VALUES
(1, 1, 'burger bunda', 40000.00, 'fastfood', 'saingan utama big mac bos (harganya doang)', 'images/menu/fastfood1_1.png', '2024-12-16 12:25:44'),
(2, 1, 'Ayam Gulai Bunda', 20000.00, 'ayam', 'Menu ayam gulai khas Kantin Bunda', 'images/menu/ayam1_1.png', '2024-12-16 12:25:44'),
(3, 1, 'Ikan Bakar Bunda', 30000.00, 'ikan', 'Menu ikan bakar spesial Kantin Bunda', 'images/menu/ikan1_1.png', '2024-12-16 12:25:44'),
(4, 1, 'Es Teh Manis Bunda', 15000.00, 'minuman', 'Minuman segar khas Kantin Bunda', 'images/menu/minuman1_1.png', '2024-12-16 12:25:44'),
(5, 1, 'Ramen Jepang Bunda', 35000.00, 'japanese', 'Menu ramen Jepang lezat Kantin Bunda', 'images/menu/japanese1_1.png', '2024-12-16 12:25:44'),
(6, 1, 'Kimchi Korea Bunda', 40000.00, 'korean', 'Menu kimchi otentik Kantin Bunda', 'images/menu/korean1_1.png', '2024-12-16 12:25:44'),
(7, 2, 'Pizza Nice', 25000.00, 'fastfood', 'Menu pizza favorit Kantin Nice', 'images/menu/fastfood2_1.png', '2024-12-16 12:25:44'),
(8, 2, 'Ayam Panggang Nice', 20000.00, 'ayam', 'Menu ayam panggang khas Kantin Nice', 'images/menu/ayam2_1.png', '2024-12-16 12:25:44'),
(9, 2, 'Ikan Goreng Nice', 30000.00, 'ikan', 'Menu ikan goreng spesial Kantin Nice', 'images/menu/ikan2_1.png', '2024-12-16 12:25:44'),
(10, 2, 'Es Kopi Susu Nice', 15000.00, 'minuman', 'Minuman kopi susu segar Kantin Nice', 'images/menu/minuman2_1.png', '2024-12-16 12:25:44'),
(11, 2, 'Sushi Nice', 35000.00, 'japanese', 'Menu sushi istimewa Kantin Nice', 'images/menu/japanese2_1.png', '2024-12-16 12:25:44'),
(12, 2, 'Bibimbap Nice', 40000.00, 'korean', 'Menu bibimbap klasik Kantin Nice', 'images/menu/korean2_1.png', '2024-12-16 12:25:44'),
(13, 3, 'Burger Raziq', 25000.00, 'fastfood', 'Menu burger lezat Kantin Raziq', 'images/menu/fastfood3_1.png', '2024-12-16 12:25:44'),
(14, 3, 'Ayam Geprek Raziq', 20000.00, 'ayam', 'Menu ayam geprek pedas Kantin Raziq', 'images/menu/ayam3_1.png', '2024-12-16 12:25:44'),
(15, 3, 'Ikan Rica-Rica Raziq', 30000.00, 'ikan', 'Menu ikan rica-rica khas Kantin Raziq', 'images/menu/ikan3_1.png', '2024-12-16 12:25:44'),
(16, 3, 'Teh Tarik Raziq', 15000.00, 'minuman', 'Minuman teh tarik istimewa Kantin Raziq', 'images/menu/minuman3_1.png', '2024-12-16 12:25:44'),
(17, 3, 'Tempura Jepang Raziq', 35000.00, 'japanese', 'Menu tempura Jepang klasik Kantin Raziq', 'images/menu/japanese3_1.png', '2024-12-16 12:25:44'),
(18, 3, 'Tteokbokki Raziq', 40000.00, 'korean', 'Menu tteokbokki pedas Kantin Raziq', 'images/menu/korean3_1.png', '2024-12-16 12:25:44'),
(19, 4, 'Hotdog Queen', 25000.00, 'fastfood', 'Menu hotdog nikmat Kantin Queen', 'images/menu/fastfood4_1.png', '2024-12-16 12:25:44'),
(20, 4, 'Ayam Goreng Queen', 20000.00, 'ayam', 'Menu ayam goreng renyah Kantin Queen', 'images/menu/ayam4_1.png', '2024-12-16 12:25:44'),
(21, 4, 'Ikan Panggang Queen', 30000.00, 'ikan', 'Menu ikan panggang lezat Kantin Queen', 'images/menu/ikan4_1.png', '2024-12-16 12:25:44'),
(22, 4, 'Smoothie Queen', 15000.00, 'minuman', 'Minuman smoothie segar Kantin Queen', 'images/menu/minuman4_1.png', '2024-12-16 12:25:44'),
(23, 4, 'Soba Jepang Queen', 35000.00, 'japanese', 'Menu soba Jepang tradisional Kantin Queen', 'images/menu/japanese4_1.png', '2024-12-16 12:25:44'),
(24, 4, 'Kimchi Queen', 40000.00, 'korean', 'Menu kimchi istimewa Kantin Queen', 'images/menu/korean4_1.png', '2024-12-16 12:25:44'),
(25, 5, 'Chicken Wings Galaxy', 25000.00, 'fastfood', 'Menu chicken wings Kantin Galaxy', 'images/menu/fastfood5_1.png', '2024-12-16 12:25:44'),
(26, 5, 'Ayam Kalasan Galaxy', 20000.00, 'ayam', 'Menu ayam kalasan spesial Kantin Galaxy', 'images/menu/ayam5_1.png', '2024-12-16 12:25:44'),
(27, 5, 'Ikan Kakap Galaxy', 30000.00, 'ikan', 'Menu ikan kakap goreng Kantin Galaxy', 'images/menu/ikan5_1.png', '2024-12-16 12:25:44'),
(28, 5, 'Es Jeruk Galaxy', 15000.00, 'minuman', 'Minuman es jeruk segar Kantin Galaxy', 'images/menu/minuman5_1.png', '2024-12-16 12:25:44'),
(29, 5, 'Teriyaki Galaxy', 35000.00, 'japanese', 'Menu teriyaki spesial Kantin Galaxy', 'images/menu/japanese5_1.png', '2024-12-16 12:25:44'),
(30, 5, 'Kimbap Galaxy', 40000.00, 'korean', 'Menu kimbap istimewa Kantin Galaxy', 'images/menu/korean5_1.png', '2024-12-16 12:25:44'),
(31, 6, 'Fries Harmoni', 25000.00, 'fastfood', 'Menu kentang goreng nikmat Kantin Harmoni', 'images/menu/fastfood6_1.png', '2024-12-16 12:25:44'),
(32, 6, 'Ayam Taliwang Harmoni', 20000.00, 'ayam', 'Menu ayam taliwang pedas Kantin Harmoni', 'images/menu/ayam6_1.png', '2024-12-16 12:25:44'),
(33, 6, 'Ikan Tuna Harmoni', 30000.00, 'ikan', 'Menu ikan tuna bakar Kantin Harmoni', 'images/menu/ikan6_1.png', '2024-12-16 12:25:44'),
(34, 6, 'Jus Alpukat Harmoni', 15000.00, 'minuman', 'Minuman jus alpukat segar Kantin Harmoni', 'images/menu/minuman6_1.png', '2024-12-16 12:25:44'),
(35, 6, 'Katsu Jepang Harmoni', 35000.00, 'japanese', 'Menu katsu Jepang spesial Kantin Harmoni', 'images/menu/japanese6_1.png', '2024-12-16 12:25:44'),
(36, 6, 'Korean BBQ Harmoni', 40000.00, 'korean', 'Menu Korean BBQ otentik Kantin Harmoni', 'images/menu/korean6_1.png', '2024-12-16 12:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_kantin`
--

CREATE TABLE `ulasan_kantin` (
  `id_ulasan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kantin` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan_kantin`
--

INSERT INTO `ulasan_kantin` (`id_ulasan`, `id_user`, `id_kantin`, `rating`, `komentar`, `created_at`) VALUES
(1, 1, 1, 5, 'Makanannya enak dan harganya terjangkau!', '2024-12-16 14:44:13'),
(2, 2, 1, 4, 'Tempatnya nyaman tetapi agak ramai.', '2024-12-16 14:44:13'),
(3, 3, 1, 5, 'Pelayanan cepat dan ramah.', '2024-12-16 14:44:13'),
(4, 4, 2, 4, 'Lokasi strategis, tapi menu kurang beragam', '2024-12-16 14:44:13'),
(5, 5, 2, 3, 'Harga cukup tinggi dibandingkan kantin lain.', '2024-12-16 14:44:13'),
(6, 6, 2, 4, 'Tempatnya bersih dan terorganisir dengan baik.', '2024-12-16 14:44:13'),
(7, 1, 3, 5, 'Pelayanan sangat ramah!', '2024-12-16 14:44:13'),
(8, 2, 3, 4, 'Menu menarik, tetapi waktu penyajiannya lama.', '2024-12-16 14:44:13'),
(9, 3, 3, 5, 'Kualitas makanan sangat baik!', '2024-12-16 14:44:13'),
(10, 4, 4, 4, 'Menu cukup enak, tapi porsinya kecil', '2024-12-16 14:44:13'),
(11, 5, 4, 4, 'Tempatnya cukup nyaman untuk makan.', '2024-12-16 14:44:13'),
(12, 6, 4, 5, 'Pelayanan baik dan makanan sesuai ekspektasi.', '2024-12-16 14:44:13'),
(13, 1, 5, 5, 'Tempatnya nyaman untuk bersantai', '2024-12-16 14:44:13'),
(14, 2, 5, 4, 'Harga terjangkau untuk mahasiswa.', '2024-12-16 14:44:13'),
(15, 3, 5, 5, 'Makanannya sangat lezat!', '2024-12-16 14:44:13'),
(16, 4, 6, 4, 'Harga sedikit mahal, tetapi kualitas oke.', '2024-12-16 14:44:13'),
(17, 5, 6, 5, 'Menu baru sangat menarik dan lezat.', '2024-12-16 14:44:13'),
(18, 6, 6, 5, 'Pelayanan cepat dan efisien.', '2024-12-16 14:44:13'),
(19, 3, 6, 4, 'Beberapa menu kadang habis terlalu cepat.', '2024-12-16 14:44:13'),
(24, 1, 1, 5, 'ssfdsfds', '2024-12-16 19:43:35'),
(25, 1, 1, 2, 'burger mahal doang, enak kaga bjir', '2024-12-16 19:44:13'),
(26, 1, 2, 3, 'kantin mahal gamnatap', '2024-12-16 20:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'adit', 'userpass1', 'user1@example.com', '2024-12-16 12:28:35'),
(2, 'fikri', 'userpass2', 'user2@example.com', '2024-12-16 12:28:35'),
(3, 'ebid', 'userpass3', 'user3@example.com', '2024-12-16 12:28:35'),
(4, 'elvi', 'userpass4', 'user4@example.com', '2024-12-16 12:28:35'),
(5, 'abil', 'userpass5', 'user5@example.com', '2024-12-16 12:28:35'),
(6, 'panji', 'userpass6', 'user6@example.com', '2024-12-16 12:28:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `admin_ibfk_1` (`id_kantin`);

--
-- Indexes for table `kantin`
--
ALTER TABLE `kantin`
  ADD PRIMARY KEY (`id_kantin`);

--
-- Indexes for table `menu_makanan`
--
ALTER TABLE `menu_makanan`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kantin` (`id_kantin`);

--
-- Indexes for table `ulasan_kantin`
--
ALTER TABLE `ulasan_kantin`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kantin` (`id_kantin`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kantin`
--
ALTER TABLE `kantin`
  MODIFY `id_kantin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_makanan`
--
ALTER TABLE `menu_makanan`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ulasan_kantin`
--
ALTER TABLE `ulasan_kantin`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_kantin`) REFERENCES `kantin` (`id_kantin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_makanan`
--
ALTER TABLE `menu_makanan`
  ADD CONSTRAINT `menu_makanan_ibfk_1` FOREIGN KEY (`id_kantin`) REFERENCES `kantin` (`id_kantin`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan_kantin`
--
ALTER TABLE `ulasan_kantin`
  ADD CONSTRAINT `ulasan_kantin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_kantin_ibfk_2` FOREIGN KEY (`id_kantin`) REFERENCES `kantin` (`id_kantin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
