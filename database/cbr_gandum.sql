-- phpMyAdmin SQL Dump
-- version 5.0.1
-- http://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2020 at 10:29 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbr_gandum`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

CREATE TABLE `data_pengguna` (
  `id_user` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level_akses` enum('Petani','Admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pengguna`
--

INSERT INTO `data_pengguna` (`id_user`, `username`, `password`, `level_akses`) VALUES
(1, 'admin', 'test', 'Admin'),
(2, 'Tani', 'tani', 'Petani');

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` char(3) NOT NULL,
  `keterangan` text NOT NULL,
  `bobot` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `keterangan`, `bobot`) VALUES
('G01', 'Permukaan daun terdapat bercak - bercak berwarna coklat muda sampai coklat tua', 0.5),
('G02', 'Bentuk bercak memanjang tak beraturan ', 1),
('G03', 'Pada serangan berat seluruh permukaan daun terdapat  bercak coklat tua kehitaman', 1),
('G04', 'Jumlah biji per malai yang dihasilkan sedikit', 1),
('G05', 'Pada bagian batang tanaman terdapat bercak memanjang berwarna coklat kemerahan  bentuk tak beraturan', 1),
('G06', 'Pada serangan berat dapat menyerang malai ditandai biji gandum berwarna coklat tua kehitaman', 0.66),
('G07', 'Pada permukaan daun terdapat bercak kuning muda bergaris memanjang dengan dengan diameter 0,5 -1 mm', 1),
('G08', 'Penyakit karat bergaris juga dapat menyerang pada bagian batang dan malai gandum', 1),
('G09', 'Terdapat bercak kecil berwarna coklat muda dan bercak akan membesar berbentuk oval', 1),
('G10', 'Perkambangan penyakit mulai dari daun terbawah terdapat barcak kecil dan akan meluas ke bagian tanaman dengan warna coklat muda dan pada serangan berat cendawan akan menutupi seluruh permukaan daun', 0.5),
('G11', 'Serangan pada tanaman muda umur 4 minggu', 1),
('G12', 'Serangan awal pada pelepah daun bagian bawah ditemukan miselia cendawan berwarna coklat', 0.5),
('G13', 'Penyakit scab akan menyerang tanaman sesaat setelah fase pembungaan', 1),
('G14', 'Malai gandum yang terserang tampak tidak normal dan berwarna sedikit hitam dan berminyak', 1),
('G15', 'Biji gandum yang terinfeksi akan berwarna putih karena pada permukaan biji terbungkus mycelia cendawan', 1),
('G16', 'Pertumbuhan tanaman menjadi kerdil', 0.66),
('G17', 'Serangan pada saat fase pembungaan,malai yang terinfeksi menghasilkan eksudat berwarna kuning dan lengket', 1),
('G18', 'Malai dan biji Gandum  yang terinfeksi cendawan dan akan berwarna coklat tua atau coklat kehitaman', 1),
('G19', 'Tanaman  rebah karena perakaran yang terbentuk sedikit', 1),
('G20', 'Terdapat kumpulan miselium berwarna putih di permukaan tanaman', 1),
('G21', 'Penyakit ini dapat dilihat  pada permukaan daun bagian bawah', 1),
('G22', 'miselium berwarna putih akan berubah menjadi abu-abu kecoklatan.', 0),
('G23', 'Pada permukaan daun terdapat bercak bergaris berwarna coklat memanjang dan tembus cahaya\r\nPada serangan berat seluruh permukaan daun kering dan berwarna coklat', 1),
('G24', 'Daun Kering', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gejala_kasus`
--

CREATE TABLE `gejala_kasus` (
  `id_gejala_kasus` int(11) NOT NULL,
  `id_gejala` char(3) NOT NULL,
  `id_lokasi_kasus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gejala_kasus`
--

INSERT INTO `gejala_kasus` (`id_gejala_kasus`, `id_gejala`, `id_lokasi_kasus`) VALUES
(1, 'G01', 1),
(2, 'G02', 1),
(3, 'G03', 1),
(4, 'G04', 1),
(5, 'G02', 2),
(6, 'G03', 2),
(7, 'G04', 2),
(8, 'G03', 3),
(9, 'G05', 3),
(10, 'G03', 4),
(11, 'G05', 4),
(12, 'G07', 5),
(13, 'G08', 5),
(14, 'G07', 6),
(15, 'G08', 6),
(16, 'G07', 7),
(17, 'G08', 7),
(18, 'G09', 8),
(19, 'G10', 8),
(20, 'G09', 9),
(21, 'G12', 9),
(22, 'G09', 10),
(23, 'G11', 10),
(24, 'G09', 11),
(25, 'G11', 11),
(26, 'G12', 12),
(27, 'G13', 12),
(28, 'G14', 12),
(29, 'G13', 13),
(30, 'G14', 13),
(31, 'G15', 14),
(32, 'G16', 14),
(33, 'G19', 14),
(34, 'G15', 15),
(35, 'G16', 15),
(36, 'G19', 15),
(37, 'G16', 16),
(38, 'G20', 16),
(39, 'G21', 16),
(40, 'G20', 17),
(41, 'G21', 17),
(42, 'G16', 18),
(43, 'G20', 18),
(44, 'G21', 18),
(45, 'G17', 19),
(46, 'G18', 19),
(47, 'G17', 20),
(48, 'G18', 20),
(49, 'G23', 21),
(50, 'G24', 21),
(51, 'G23', 22),
(52, 'G24', 22),
(53, 'G06', 23),
(54, 'G10', 23),
(55, 'G16', 23),
(56, 'G10', 24),
(57, 'G16', 24),
(58, 'G06', 25),
(59, 'G10', 25),
(60, 'G16', 25);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_kasus`
--

CREATE TABLE `lokasi_kasus` (
  `id_lokasi_kasus` int(11) NOT NULL,
  `kecamatan` varchar(256) DEFAULT NULL,
  `desa` varchar(256) DEFAULT NULL,
  `id_penyakit` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasi_kasus`
--

INSERT INTO `lokasi_kasus` (`id_lokasi_kasus`, `kecamatan`, `desa`, `id_penyakit`) VALUES
(1, 'Tawangmangu', 'Ngeblak', 'P01'),
(2, 'Tawangmangu', 'Bandardawung', 'P01'),
(3, 'Tawangmangu', 'Nglebak', 'P02'),
(4, 'Tawangmangu', 'Bandardawung', 'P02'),
(5, 'Tawangmangu', 'Nglebak', 'P03'),
(6, 'Tawangmangu', 'Bandardawung', 'P03'),
(7, 'Tawangmangu', 'Karanglo', 'P03'),
(8, 'Tawangmangu', 'Nglebak', 'P04'),
(9, 'Tawangmangu', 'Bandardawung', 'P04'),
(10, 'Tawangmangu', 'Nglebak', 'P05'),
(11, 'Tawangmangu', 'Bandardawung', 'P05'),
(12, 'Tawangmangu', 'Karanglo', 'P06'),
(13, 'Tawangmangu', 'Nglebak', 'P06'),
(14, 'Tawangmangu', 'Bandardawung', 'P07'),
(15, 'Tawangmangu', 'Karanglo', 'P07'),
(16, 'Ngargoyoso', 'Segoro Gunung', 'P08'),
(17, 'Ngargoyoso', 'Puntuk Rejo', 'P08'),
(18, 'Ngargoyoso', 'Segoro Gunung', 'P08'),
(19, 'Ngargoyoso', 'Puntuk Rejo', 'P09'),
(20, 'Ngargoyoso', 'Segoro Gunung', 'P09'),
(21, 'Ngargoyoso', 'Puntuk Rejo', 'P10'),
(22, 'Ngargoyoso', 'Segoro Gunung', 'P10'),
(23, 'Ngargoyoso', 'Puntuk Rejo', 'P11'),
(24, 'Ngargoyoso', 'Gelang', 'P11'),
(25, 'Jenawi', 'Anggras Manis', 'P11');

-- --------------------------------------------------------

--
-- Table structure for table `penanganan`
--

CREATE TABLE `penanganan` (
  `id_penanganan` char(3) NOT NULL,
  `id_penyakit` char(3) NOT NULL,
  `penanganan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penanganan`
--

INSERT INTO `penanganan` (`id_penanganan`, `id_penyakit`, `penanganan`) VALUES
('X01', 'P01', 'Menanam Varietas yang tahan terhadap serangan karat daun seperti : Varietas Ganesha;Menjaga kelembapan disekitar tanaman dengan mengatur jarak tanam (25cm x 10cm);Penyemprotan dengan Fungisida'),
('X02', 'P02', 'Menanam Vrietas yang tahan terhadap serangan karat batang seperti :Varietas Ganesha;Menjaga kelembapan disekitar tanaman dengan mengatur jarak tanam (25cm X 10Cm);Penyemprotan dengan Fungisida'),
('X03', 'P03', 'Menanam Varietas yang tahan tahan terhadap serangan karat daun bergaris seperti :varietas Ganesha;Menjaga kelembapan tanaman dengan mengatur jarak tanam;Penyemprotan dengan Fungisida'),
('X04', 'P04', 'Menanam dengan Varietas tahan terhadap penyakit Hawar daun;Pergiliran tanaman;Penggunaan Benih bebas penyakit;Pemupukan berimbang dan tepat;Perlakuan benih dengan Fungisida'),
('X05', 'P05', 'Pengolahan tanah yang baik;Menanam dengan Varietas tahan ;Bertanam pada cuaca kering dengan kelembapan rendah;Perlakuan benih dengan Fungisida;Menghindari bertanam pada lahan bekas tanam gandum'),
('X06', 'P06', 'Pergiliran tanaman dengan tanaman lainnya selain gandum;Menanam varieta tahan penyakit;Pengolahan tanah yang sempurna;Memusnahkan sisa tanaman gandum;Penyemprotan Fungisida'),
('X07', 'P07', 'Menghindari bertanam gandum pada lahan basah;Pergiliran tanaman dengan tanaman leguminosa (kacang-kacangan);Pemupukan berimbang, (pupuk Urea,ZA,Sp36,Kcl)'),
('X08', 'P08', 'Menanam dengan varietas tahan Penyakit;Pemupukan berimbang Tidak menggunakan pupuk UREA berlebihan;Penyemprotan dengan Fungisida'),
('X09', 'P09', 'Pada saat panen memisahkan malai yang yang terserang cendawan kemudian di musnahkan;Pergiliran tanaman dengan tanaman selain gandum;Bertanam pada saat cuaca kering dan kelembapan rendah;Pengolahan tanah sempurna dan membakar sisa tanaman yang terkena cendawan'),
('X10', 'P10', 'Menghindari bertanam saat musim penghujan;Pergiliran tanaman dengan tanaman selain Gandum;Menghindari pengairan tergenang'),
('X11', 'P11', 'Pergiliran tanaman dengan tanaman selain gandum;Penggunaan benih bebas penyakit;Menghindari pengairan tergenang;Pemusnahan sisa tanaman yang terserang penyakit');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` char(3) NOT NULL,
  `nama_penyakit` varchar(256) NOT NULL,
  `bahasa_latin` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `nama_penyakit`, `bahasa_latin`) VALUES
('P01', 'Penyakit Karat Daun', 'Puccinia recondite'),
('P02', 'Penyakit Karat Batang', 'Puccinia graminis'),
('P03', 'Penyakit Karat Bergaris', 'Puccinia striiformis'),
('P04', 'Penyakit Hawar Daun', 'Helminthosporium sativum'),
('P05', 'Penyakit Hawar Daun', 'Alternaria triticina'),
('P06', 'Penyakit Scab', 'Fusarium sp'),
('P07', 'Penyakit Busuk Akar', 'Rhizoctonia solani'),
('P08', 'Penyakit Embun Tepung', 'Erysiphe graminis'),
('P09', 'Penyakit Ergot', 'Claviceps purpurea'),
('P10', 'Penyakit Bacteri Daun Bergaris', 'Xanthomonas Compestri'),
('P11', 'Penyakit Bacteri Hawar Daun', 'Pseudomonas Syringae');

-- --------------------------------------------------------

--
-- Table structure for table `relasi_gejala`
--

CREATE TABLE `relasi_gejala` (
  `id_relasi_gejala` int(11) NOT NULL,
  `id_penyakit` char(3) NOT NULL,
  `id_gejala` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relasi_gejala`
--

INSERT INTO `relasi_gejala` (`id_relasi_gejala`, `id_penyakit`, `id_gejala`) VALUES
(1, 'P01', 'G01'),
(2, 'P01', 'G02'),
(3, 'P01', 'G03'),
(4, 'P01', 'G04'),
(5, 'P02', 'G03'),
(6, 'P02', 'G05'),
(7, 'P03', 'G07'),
(8, 'P03', 'G08'),
(9, 'P04', 'G09'),
(10, 'P04', 'G10'),
(11, 'P04', 'G12'),
(12, 'P05', 'G09'),
(13, 'P05', 'G11'),
(14, 'P06', 'G12'),
(15, 'P06', 'G13'),
(16, 'P06', 'G14'),
(17, 'P07', 'G15'),
(18, 'P07', 'G16'),
(19, 'P07', 'G19'),
(20, 'P08', 'G16'),
(21, 'P08', 'G20'),
(22, 'P08', 'G21'),
(23, 'P09', 'G17'),
(24, 'P09', 'G18'),
(25, 'P10', 'G23'),
(26, 'P10', 'G24'),
(27, 'P11', 'G06'),
(28, 'P11', 'G10'),
(29, 'P11', 'G16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `gejala_kasus`
--
ALTER TABLE `gejala_kasus`
  ADD PRIMARY KEY (`id_gejala_kasus`),
  ADD KEY `fk_id_lokasi_kasus` (`id_lokasi_kasus`),
  ADD KEY `fk_id_gejala_kasus` (`id_gejala`);

--
-- Indexes for table `lokasi_kasus`
--
ALTER TABLE `lokasi_kasus`
  ADD PRIMARY KEY (`id_lokasi_kasus`),
  ADD KEY `fk_id_penyakit_lokasi_kasus` (`id_penyakit`);

--
-- Indexes for table `penanganan`
--
ALTER TABLE `penanganan`
  ADD PRIMARY KEY (`id_penanganan`),
  ADD KEY `fk_id_penyakit_penanganan` (`id_penyakit`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `relasi_gejala`
--
ALTER TABLE `relasi_gejala`
  ADD PRIMARY KEY (`id_relasi_gejala`),
  ADD KEY `fk_id_penyakit_relasi_gejala` (`id_penyakit`),
  ADD KEY `fk_id_gejala_relasi_gejala` (`id_gejala`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gejala_kasus`
--
ALTER TABLE `gejala_kasus`
  MODIFY `id_gejala_kasus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `lokasi_kasus`
--
ALTER TABLE `lokasi_kasus`
  MODIFY `id_lokasi_kasus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `relasi_gejala`
--
ALTER TABLE `relasi_gejala`
  MODIFY `id_relasi_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gejala_kasus`
--
ALTER TABLE `gejala_kasus`
  ADD CONSTRAINT `fk_id_gejala_kasus` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`),
  ADD CONSTRAINT `fk_id_lokasi_kasus` FOREIGN KEY (`id_lokasi_kasus`) REFERENCES `lokasi_kasus` (`id_lokasi_kasus`);

--
-- Constraints for table `lokasi_kasus`
--
ALTER TABLE `lokasi_kasus`
  ADD CONSTRAINT `fk_id_penyakit_lokasi_kasus` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`);

--
-- Constraints for table `penanganan`
--
ALTER TABLE `penanganan`
  ADD CONSTRAINT `fk_id_penyakit_penanganan` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`);

--
-- Constraints for table `relasi_gejala`
--
ALTER TABLE `relasi_gejala`
  ADD CONSTRAINT `fk_id_gejala_relasi_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`),
  ADD CONSTRAINT `fk_id_penyakit_relasi_gejala` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
