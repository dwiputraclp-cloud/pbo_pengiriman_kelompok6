-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2026 at 04:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengiriman`
--

-- --------------------------------------------------------

--
-- Table structure for table `kargo`
--

CREATE TABLE `kargo` (
  `id_resi` varchar(20) NOT NULL,
  `pengirim` varchar(100) NOT NULL,
  `kota_tujuan` varchar(100) NOT NULL,
  `berat_barang` decimal(10,2) NOT NULL,
  `tarif_dasar_perkg` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kargo`
--

INSERT INTO `kargo` (`id_resi`, `pengirim`, `kota_tujuan`, `berat_barang`, `tarif_dasar_perkg`, `created_at`) VALUES
('RES001', 'PT Maju Jaya', 'Jakarta', '12.50', '5000.00', '2026-06-09 04:49:31'),
('RES002', 'CV Berkah Abadi', 'Bandung', '8.20', '5000.00', '2026-06-09 04:49:31'),
('RES003', 'PT Logistik Nusantara', 'Surabaya', '15.70', '5000.00', '2026-06-09 04:49:31'),
('RES004', 'PT Sumber Rejeki', 'Semarang', '10.40', '5000.00', '2026-06-09 04:49:31'),
('RES005', 'CV Mitra Usaha', 'Yogyakarta', '22.10', '5000.00', '2026-06-09 04:49:31'),
('RES006', 'PT Kimia Jaya', 'Medan', '18.60', '7000.00', '2026-06-09 04:49:31'),
('RES007', 'PT Kimia Makmur', 'Palembang', '14.20', '7000.00', '2026-06-09 04:49:31'),
('RES008', 'PT Laboratorium Sentosa', 'Makassar', '11.50', '7000.00', '2026-06-09 04:49:31'),
('RES009', 'PT B3 Indonesia', 'Batam', '20.30', '7000.00', '2026-06-09 04:49:31'),
('RES010', 'CV Chemical Abadi', 'Pekanbaru', '16.70', '7000.00', '2026-06-09 04:49:31'),
('RES011', 'PT Kaca Indah', 'Malang', '9.80', '6000.00', '2026-06-09 04:49:31'),
('RES012', 'CV Keramik Jaya', 'Solo', '13.40', '6000.00', '2026-06-09 04:49:31'),
('RES013', 'PT Elektronik Aman', 'Denpasar', '17.10', '6000.00', '2026-06-09 04:49:31'),
('RES014', 'PT Crystal Nusantara', 'Bogor', '21.50', '6000.00', '2026-06-09 04:49:31'),
('RES015', 'CV Gelas Cantik', 'Bekasi', '8.90', '6000.00', '2026-06-09 04:49:31'),
('RES016', 'PT Pengiriman Cepat', 'Tangerang', '19.30', '5000.00', '2026-06-09 04:49:31'),
('RES017', 'CV Angkasa Logistik', 'Depok', '24.70', '5000.00', '2026-06-09 04:49:31'),
('RES018', 'PT Nusantara Cargo', 'Cirebon', '12.20', '5000.00', '2026-06-09 04:49:31'),
('RES019', 'PT Sentosa Express', 'Tasikmalaya', '11.10', '5000.00', '2026-06-09 04:49:31'),
('RES020', 'CV Prima Logistik', 'Purwokerto', '15.90', '5000.00', '2026-06-09 04:49:31'),
('RES021', 'PT Kargo Mandiri', 'Kediri', '18.40', '5000.00', '2026-06-09 04:49:31'),
('RES022', 'CV Amanah Cargo', 'Madiun', '13.60', '5000.00', '2026-06-09 04:49:31'),
('RES023', 'PT Trans Jawa', 'Jember', '20.50', '5000.00', '2026-06-09 04:49:31'),
('RES024', 'PT Sinar Kargo', 'Banyuwangi', '9.30', '5000.00', '2026-06-09 04:49:31'),
('RES025', 'CV Maju Bersama', 'Balikpapan', '14.80', '5000.00', '2026-06-09 04:49:31'),
('RES026', 'PT Bahan Kimia Nasional', 'Banjarmasin', '17.20', '7000.00', '2026-06-09 04:49:31'),
('RES027', 'PT Kimia Aman', 'Pontianak', '12.90', '7000.00', '2026-06-09 04:49:31'),
('RES028', 'CV Industri Kimia', 'Samarinda', '15.60', '7000.00', '2026-06-09 04:49:31'),
('RES029', 'PT Chemical Indonesia', 'Manado', '22.70', '7000.00', '2026-06-09 04:49:31'),
('RES030', 'PT Kimia Sejahtera', 'Kupang', '11.80', '7000.00', '2026-06-09 04:49:31'),
('RES031', 'PT Aman Glass', 'Serang', '18.50', '6000.00', '2026-06-09 04:49:31'),
('RES032', 'CV Keramik Abadi', 'Cilegon', '13.20', '6000.00', '2026-06-09 04:49:31'),
('RES033', 'PT Pecah Belah Jaya', 'Sukabumi', '10.70', '6000.00', '2026-06-09 04:49:31'),
('RES034', 'PT Crystal Aman', 'Garut', '16.90', '6000.00', '2026-06-09 04:49:31'),
('RES035', 'CV Gelas Nusantara', 'Banjar', '8.50', '6000.00', '2026-06-09 04:49:31'),
('RES036', 'PT Cargo Express', 'Jakarta', '25.10', '5000.00', '2026-06-09 04:49:31'),
('RES037', 'CV Logistik Mandiri', 'Bandung', '19.40', '5000.00', '2026-06-09 04:49:31'),
('RES038', 'PT Cepat Sampai', 'Surabaya', '21.30', '5000.00', '2026-06-09 04:49:31'),
('RES039', 'PT Kargo Hebat', 'Semarang', '17.60', '5000.00', '2026-06-09 04:49:31'),
('RES040', 'CV Transindo', 'Yogyakarta', '12.70', '5000.00', '2026-06-09 04:49:31'),
('RES041', 'PT Kimia B3', 'Medan', '23.80', '7000.00', '2026-06-09 04:49:31'),
('RES042', 'CV Chemical Aman', 'Palembang', '14.10', '7000.00', '2026-06-09 04:49:31'),
('RES043', 'PT Kimia Global', 'Makassar', '18.70', '7000.00', '2026-06-09 04:49:31'),
('RES044', 'PT Industri B3', 'Batam', '20.90', '7000.00', '2026-06-09 04:49:31'),
('RES045', 'CV Laboratorium Kimia', 'Pekanbaru', '16.40', '7000.00', '2026-06-09 04:49:31'),
('RES046', 'PT Kaca Modern', 'Malang', '11.90', '6000.00', '2026-06-09 04:49:31'),
('RES047', 'CV Keramik Modern', 'Solo', '14.60', '6000.00', '2026-06-09 04:49:31'),
('RES048', 'PT Elektronik Amanah', 'Denpasar', '19.50', '6000.00', '2026-06-09 04:49:31'),
('RES049', 'PT Crystal Modern', 'Bogor', '15.30', '6000.00', '2026-06-09 04:49:31'),
('RES050', 'CV Gelas Aman', 'Bekasi', '10.20', '6000.00', '2026-06-09 04:49:31'),
('RES051', 'PT Cargo Nusantara', 'Jakarta', '22.50', '5000.00', '2026-06-09 04:49:31'),
('RES052', 'CV Angkut Cepat', 'Bandung', '18.30', '5000.00', '2026-06-09 04:49:31'),
('RES053', 'PT Logistik Prima', 'Surabaya', '13.80', '5000.00', '2026-06-09 04:49:31'),
('RES054', 'PT Sumber Cargo', 'Semarang', '16.20', '5000.00', '2026-06-09 04:49:31'),
('RES055', 'CV Aman Sentosa', 'Yogyakarta', '24.10', '5000.00', '2026-06-09 04:49:31'),
('RES056', 'PT B3 Sentosa', 'Medan', '21.70', '7000.00', '2026-06-09 04:49:31'),
('RES057', 'CV Kimia Prima', 'Palembang', '15.50', '7000.00', '2026-06-09 04:49:31'),
('RES058', 'PT Chemical Mandiri', 'Makassar', '12.40', '7000.00', '2026-06-09 04:49:31'),
('RES059', 'PT Kimia Jaya Abadi', 'Batam', '17.80', '7000.00', '2026-06-09 04:49:31'),
('RES060', 'CV Bahan Aman', 'Pekanbaru', '14.90', '7000.00', '2026-06-09 04:49:31'),
('RES061', 'PT Glass Indonesia', 'Malang', '18.80', '6000.00', '2026-06-09 04:49:31'),
('RES062', 'CV Pecah Belah Aman', 'Solo', '9.70', '6000.00', '2026-06-09 04:49:31'),
('RES063', 'PT Keramik Nusantara', 'Denpasar', '20.10', '6000.00', '2026-06-09 04:49:31'),
('RES064', 'PT Crystal Sejahtera', 'Bogor', '13.50', '6000.00', '2026-06-09 04:49:31'),
('RES065', 'CV Gelas Prima', 'Bekasi', '11.40', '6000.00', '2026-06-09 04:49:31'),
('RES066', 'PT Ekspedisi Jaya', 'Jakarta', '23.20', '5000.00', '2026-06-09 04:49:31'),
('RES067', 'CV Cargo Indonesia', 'Bandung', '17.30', '5000.00', '2026-06-09 04:49:31'),
('RES068', 'PT Angkut Nusantara', 'Surabaya', '15.10', '5000.00', '2026-06-09 04:49:31'),
('RES069', 'PT Pengiriman Mandiri', 'Semarang', '21.80', '5000.00', '2026-06-09 04:49:31'),
('RES070', 'CV Trans Logistik', 'Yogyakarta', '14.20', '5000.00', '2026-06-09 04:49:31'),
('RES071', 'PT Kimia Global Indonesia', 'Medan', '19.60', '7000.00', '2026-06-09 04:49:31'),
('RES072', 'CV Chemical Nusantara', 'Palembang', '13.70', '7000.00', '2026-06-09 04:49:31'),
('RES073', 'PT B3 Mandiri', 'Makassar', '22.30', '7000.00', '2026-06-09 04:49:31'),
('RES074', 'PT Kimia Prima Indonesia', 'Batam', '16.50', '7000.00', '2026-06-09 04:49:31'),
('RES075', 'CV Industri B3', 'Pekanbaru', '12.80', '7000.00', '2026-06-09 04:49:31'),
('RES076', 'PT Kaca Sejahtera', 'Malang', '18.10', '6000.00', '2026-06-09 04:49:31'),
('RES077', 'CV Keramik Prima', 'Solo', '14.40', '6000.00', '2026-06-09 04:49:31'),
('RES078', 'PT Crystal Amanah', 'Denpasar', '20.70', '6000.00', '2026-06-09 04:49:31'),
('RES079', 'PT Pecah Belah Nusantara', 'Bogor', '11.60', '6000.00', '2026-06-09 04:49:31'),
('RES080', 'CV Gelas Indonesia', 'Bekasi', '15.80', '6000.00', '2026-06-09 04:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `kargo_bahan_kimia`
--

CREATE TABLE `kargo_bahan_kimia` (
  `id_resi` varchar(20) NOT NULL,
  `tingkat_bahaya` tinyint NOT NULL,
  `jenis_sertifikasi_sandi` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `kargo_bahan_kimia`
--

INSERT INTO `kargo_bahan_kimia` (`id_resi`, `tingkat_bahaya`, `jenis_sertifikasi_sandi`) VALUES
('RES021', 1, 'SERT-B3-001'),
('RES022', 2, 'SERT-B3-002'),
('RES023', 3, 'SERT-B3-003'),
('RES024', 4, 'SERT-B3-004'),
('RES025', 5, 'SERT-B3-005'),
('RES026', 6, 'SERT-B3-006'),
('RES027', 7, 'SERT-B3-007'),
('RES028', 8, 'SERT-B3-008'),
('RES029', 9, 'SERT-B3-009'),
('RES030', 1, 'SERT-B3-010'),
('RES031', 2, 'SERT-B3-011'),
('RES032', 3, 'SERT-B3-012'),
('RES033', 4, 'SERT-B3-013'),
('RES034', 5, 'SERT-B3-014'),
('RES035', 6, 'SERT-B3-015'),
('RES036', 7, 'SERT-B3-016'),
('RES037', 8, 'SERT-B3-017'),
('RES038', 9, 'SERT-B3-018'),
('RES039', 1, 'SERT-B3-019'),
('RES040', 2, 'SERT-B3-020'),
('RES041', 3, 'SERT-B3-021'),
('RES042', 4, 'SERT-B3-022'),
('RES043', 5, 'SERT-B3-023'),
('RES044', 6, 'SERT-B3-024'),
('RES045', 7, 'SERT-B3-025'),
('RES046', 8, 'SERT-B3-026'),
('RES047', 9, 'SERT-B3-027'),
('RES048', 1, 'SERT-B3-028'),
('RES049', 2, 'SERT-B3-029'),
('RES050', 3, 'SERT-B3-030');

-- --------------------------------------------------------

--
-- Table structure for table `kargo_pecah_belah`
--

CREATE TABLE `kargo_pecah_belah` (
  `id_resi` varchar(20) NOT NULL,
  `ketebalan_bubble_wrap` decimal(5,2) NOT NULL,
  `biaya_asuransi_wajib` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kargo_pecah_belah`
--

INSERT INTO `kargo_pecah_belah` (`id_resi`, `ketebalan_bubble_wrap`, `biaya_asuransi_wajib`) VALUES
('RES051', '1.50', '25000.00'),
('RES052', '2.00', '30000.00'),
('RES053', '2.50', '35000.00'),
('RES054', '3.00', '40000.00'),
('RES055', '3.50', '45000.00'),
('RES056', '4.00', '50000.00'),
('RES057', '1.50', '25000.00'),
('RES058', '2.00', '30000.00'),
('RES059', '2.50', '35000.00'),
('RES060', '3.00', '40000.00'),
('RES061', '3.50', '45000.00'),
('RES062', '4.00', '50000.00'),
('RES063', '1.50', '25000.00'),
('RES064', '2.00', '30000.00'),
('RES065', '2.50', '35000.00'),
('RES066', '3.00', '40000.00'),
('RES067', '3.50', '45000.00'),
('RES068', '4.00', '50000.00'),
('RES069', '1.50', '25000.00'),
('RES070', '2.00', '30000.00'),
('RES071', '2.50', '35000.00'),
('RES072', '3.00', '40000.00'),
('RES073', '3.50', '45000.00'),
('RES074', '4.00', '50000.00'),
('RES075', '1.50', '25000.00'),
('RES076', '2.00', '30000.00'),
('RES077', '2.50', '35000.00'),
('RES078', '3.00', '40000.00'),
('RES079', '3.50', '45000.00'),
('RES080', '4.00', '50000.00');

-- --------------------------------------------------------

--
-- Table structure for table `kargo_reguler`
--

CREATE TABLE `kargo_reguler` (
  `id_resi` varchar(20) NOT NULL,
  `jenis_paket` enum('Koli','Dus') NOT NULL,
  `estimasi_hari` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kargo_reguler`
--

INSERT INTO `kargo_reguler` (`id_resi`, `jenis_paket`, `estimasi_hari`) VALUES
('RES001', 'Koli', 2),
('RES002', 'Dus', 3),
('RES003', 'Koli', 4),
('RES004', 'Dus', 2),
('RES005', 'Koli', 5),
('RES006', 'Dus', 3),
('RES007', 'Koli', 2),
('RES008', 'Dus', 4),
('RES009', 'Koli', 3),
('RES010', 'Dus', 5),
('RES011', 'Koli', 2),
('RES012', 'Dus', 3),
('RES013', 'Koli', 4),
('RES014', 'Dus', 2),
('RES015', 'Koli', 5),
('RES016', 'Dus', 3),
('RES017', 'Koli', 2),
('RES018', 'Dus', 4),
('RES019', 'Koli', 3),
('RES020', 'Dus', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kargo`
--
ALTER TABLE `kargo`
  ADD PRIMARY KEY (`id_resi`);

--
-- Indexes for table `kargo_bahan_kimia`
--
ALTER TABLE `kargo_bahan_kimia`
  ADD PRIMARY KEY (`id_resi`);

--
-- Indexes for table `kargo_pecah_belah`
--
ALTER TABLE `kargo_pecah_belah`
  ADD PRIMARY KEY (`id_resi`);

--
-- Indexes for table `kargo_reguler`
--
ALTER TABLE `kargo_reguler`
  ADD PRIMARY KEY (`id_resi`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kargo_bahan_kimia`
--
ALTER TABLE `kargo_bahan_kimia`
  ADD CONSTRAINT `fk_kimia_kargo` FOREIGN KEY (`id_resi`) REFERENCES `kargo` (`id_resi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kargo_pecah_belah`
--
ALTER TABLE `kargo_pecah_belah`
  ADD CONSTRAINT `fk_pecahbelah_kargo` FOREIGN KEY (`id_resi`) REFERENCES `kargo` (`id_resi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kargo_reguler`
--
ALTER TABLE `kargo_reguler`
  ADD CONSTRAINT `fk_reguler_kargo` FOREIGN KEY (`id_resi`) REFERENCES `kargo` (`id_resi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
