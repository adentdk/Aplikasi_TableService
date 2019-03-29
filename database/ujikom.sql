-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2019 at 03:45 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujikom`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` int(11) NOT NULL,
  `id_pesanan` char(32) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `keterangan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail_pesanan`, `id_pesanan`, `id_menu`, `qty`, `subtotal`, `keterangan`) VALUES
(1, 'P265824', 15, 2, 82000, '-'),
(2, 'P265824', 9, 1, 51000, '-'),
(3, 'P265824', 8, 12, 384000, '-');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'administrator'),
(2, 'pelayan'),
(3, 'kasir'),
(4, 'pemilik'),
(5, 'pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `no_meja` char(5) NOT NULL,
  `status_meja` enum('penuh','kosong') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`no_meja`, `status_meja`) VALUES
('A0001', 'kosong'),
('A0002', 'kosong'),
('B0001', 'kosong'),
('B0002', 'kosong'),
('C0001', 'kosong'),
('C0002', 'kosong'),
('D0001', 'kosong'),
('D0002', 'kosong');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(32) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(32) NOT NULL,
  `foto` varchar(150) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `qty`, `keterangan`, `foto`) VALUES
(8, 'Pizza Mozatakrela', 32000, 88, 'pizza dengan keju', 'pizza.jpg'),
(9, 'Ayam golek luar biasa', 51000, 99, 'ayam enak buatan opah', 'ayam-golek-luar-biasa.jpg'),
(11, 'Es Doger', 12500, 200, 'beda dengan doger monyet', 'es-doger.jpg'),
(12, 'Bakakak Ayam', 48000, 100, 'ayam bakar kereta api, cakep.', 'bakakak_hayam.jpg'),
(13, 'Geco', 37000, 100, 'makanan enak dari kuningan', 'geco.jpg'),
(14, 'Sushi isi nasi :o', 300, 200, 'ini sushi bukan siswi', 'sushi-sayur.jpg'),
(15, 'Seblak Lobster', 41000, 98, 'inget, Logster itu bukan udang', 'seblak-lobster.jpg'),
(16, 'Pepes ikan kerapu', 43000, 100, 'Enak sekaleh bro', 'pepes-ikan-kerapu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` char(32) NOT NULL,
  `waktu` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_meja` char(5) NOT NULL,
  `keterangan` varchar(64) NOT NULL,
  `status_pesanan` enum('memilih menu','terkirim','diantrikan','disajikan','selesai') NOT NULL DEFAULT 'memilih menu'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `waktu`, `id_user`, `no_meja`, `keterangan`, `status_pesanan`) VALUES
('P101568', '2019-03-28', 5, 'A0001', 'jangan lama lama', 'selesai'),
('P172644', '2019-03-28', 2, 'A0001', '', 'terkirim'),
('P192772', '2019-03-21', 5, 'A0001', '', 'selesai'),
('P233720', '2019-03-21', 2, 'D0002', '', 'selesai'),
('P265824', '2019-03-28', 2, 'D0002', 'cepat, saya lapar', 'selesai'),
('P476703', '2019-03-22', 2, 'A0001', '', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pesanan` char(32) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `waktu` date NOT NULL,
  `status_transaksi` enum('belum bayar','sudah bayar') NOT NULL DEFAULT 'belum bayar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pesanan`, `id_user`, `total_bayar`, `bayar`, `kembalian`, `waktu`, `status_transaksi`) VALUES
(3, 'P233720', 2, 352000, 400000, 48000, '2019-03-21', 'sudah bayar'),
(4, 'P192772', 5, 248000, 250000, 2000, '2019-03-21', 'sudah bayar'),
(5, 'P476703', 2, 400000, 400000, 0, '2019-03-22', 'sudah bayar'),
(6, 'P101568', 5, 236000, 250000, 14000, '2019-03-28', 'sudah bayar'),
(7, 'P265824', 2, 517000, 550000, 33000, '2019-03-28', 'sudah bayar');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(150) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `id_level` int(11) NOT NULL,
  `foto` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `id_level`, `foto`) VALUES
(1, 'administrator', '$2y$10$dsZ.fPj18/8p/p86g0zC9e4j/LNGdNPSblmHBm2WrdlpTfjrfMGMm', 'aden', 1, 'default.jpg'),
(2, 'pelanggan1', '$2y$10$4eDN9dvzd2tpjsbXd3p.p.afdoHWYwiWU6VOpyWawKI0A9DPtD2vy', 'Rizki Zulfihadi', 5, 'default.jpg'),
(3, 'pelayan1', '$2y$10$pUV1xw5ivP9Sjr2ImgiA.OcBWrO4RORG47Cf6MG3wKcfsX8.tTlk6', 'hapid', 2, 'default.jpg'),
(5, 'pelanggan2', '$2y$10$urXhFaZfCp9H7JTHYCPkOeJKSv1EPpcq1El.xuR8dROi6XCXizDLi', 'Fathur', 5, 'default.jpg'),
(6, 'kasir1', '$2y$10$9fxNYMvOF.p2gsrXGojVSO3VR62Ijuy5EsKs9ZAbC8zek9dlBURxe', 'Citra', 3, 'default.jpg'),
(7, 'adentrisnadk', '$2y$10$1N7kg9CI0eFCDReG7LKrCerJ.baPuyJuHRwHRhi704clYdR74U8nO', 'aden trisna daud kurnia', 4, 'default.jpg'),
(8, 'pelayan2', '$2y$10$WTbTe3fhJGzwIx.eoDS7oukT.PS0MeD/hzWFmJ6oQ.88FzDx1o9WG', 'Fadjar', 2, 'default.jpg'),
(9, 'pelayan3', '$2y$10$7eVi1VYamr8ysd3B6e2i4OqaMH8lCo/DxA3U33DHWBs9anaTOkjVq', 'Bayu', 2, 'default.jpg'),
(10, 'kasir2', '$2y$10$SAFwZexsQCaArypnF/2qieY.3dL6oIc.r7iAwOB033srpYEt0uEtK', 'Syahla', 3, 'default.jpg'),
(11, 'adentdk_pelanggan', '$2y$10$dCua.LQaYAozoD5UkyETlustnptiJ/CEKAb8okD2pND1a/jly1En6', 'Aden Trisna Daud Kurnia', 5, 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `id_masakan` (`id_menu`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`no_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `no_meja` (`no_meja`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_order` (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`no_meja`) REFERENCES `meja` (`no_meja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
