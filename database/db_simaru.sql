-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2019 at 01:11 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simaru`
--

-- --------------------------------------------------------

--
-- Table structure for table `otp_user`
--

CREATE TABLE `otp_user` (
  `id_otp` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expired_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dokumen`
--

CREATE TABLE `tbl_dokumen` (
  `id_document` int(11) NOT NULL,
  `no_document` varchar(50) NOT NULL,
  `name_document` varchar(100) NOT NULL,
  `upload_date` datetime NOT NULL,
  `document_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Aktif',
  `document_label` varchar(100) NOT NULL,
  `upload_by` varchar(100) NOT NULL,
  `file` varchar(255) NOT NULL,
  `versi` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history_document`
--

CREATE TABLE `tbl_history_document` (
  `id_history` int(11) NOT NULL,
  `id_document` int(11) NOT NULL,
  `no_document` varchar(50) NOT NULL,
  `name_document` varchar(100) NOT NULL,
  `upload_date` datetime NOT NULL,
  `document_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Aktif',
  `document_label` varchar(100) NOT NULL,
  `upload_by` varchar(100) NOT NULL,
  `file` varchar(255) NOT NULL,
  `versi` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp`
--

CREATE TABLE `tbl_otp` (
  `id_otp` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `otp_expired` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

CREATE TABLE `tbl_units` (
  `id_unit` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_units`
--

INSERT INTO `tbl_units` (`id_unit`, `nama_unit`) VALUES
(1, 'Arnet'),
(2, 'Amo'),
(3, 'CME');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units_member`
--

CREATE TABLE `tbl_units_member` (
  `id_unit_member` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit_document`
--

CREATE TABLE `tbl_unit_document` (
  `id_unit_document` int(11) NOT NULL,
  `id_document` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_attachment_perizinan`
--

CREATE TABLE `tb_attachment_perizinan` (
  `id_attachment` int(11) NOT NULL,
  `id_perizinan` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_izin_org`
--

CREATE TABLE `tb_izin_org` (
  `id_org_izin` int(11) NOT NULL,
  `id_izin` int(11) NOT NULL,
  `id_org` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Accepted',
  `tipe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_izin_org`
--

INSERT INTO `tb_izin_org` (`id_org_izin`, `id_izin`, `id_org`, `status`, `tipe`) VALUES
(67, 47, 25, 'Accepted', 'Non Member'),
(68, 48, 26, 'Accepted', 'Non Member'),
(72, 48, 53, 'Accepted', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `tb_izin_ruangan`
--

CREATE TABLE `tb_izin_ruangan` (
  `id_izin_ruangan` int(11) NOT NULL,
  `id_perizinan` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_participant`
--

CREATE TABLE `tb_participant` (
  `id_user` int(11) NOT NULL,
  `no_ktp` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `instansi` varchar(50) NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `foto_karpeg` varchar(30) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `status` varchar(13) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_participant`
--

INSERT INTO `tb_participant` (`id_user`, `no_ktp`, `nama`, `instansi`, `posisi`, `foto_ktp`, `foto_karpeg`, `nik`, `no_hp`, `status`) VALUES
(14, '6216', 'Malik', 'Politeknik Tanah Laut', 'Mahasiswa', '1546391089-292948.jpg', '1546391099-600020.jpg', '873263', '08352536', 'Active'),
(17, '926326', 'Mahdi', 'Politeknik Tanah Laut', 'Mahasiswa', '1546418091-325425.jpg', '1546418102-656277.jpg', '72638', '086352732', 'Active'),
(18, '738273', 'Maulana Muhammad', 'Politeknik Tanah Laut', 'Mahasiswa', '1546504506-496658.jpg', '1546504518-354034.jpg', '37283', '085251241175', 'Active'),
(20, '630103030198000', 'Maulana Muhammad', 'Politeknik Tanah Laut', 'Mahasiswa', '1546569562-842248.jpg', '1546569574-325555.jpg', '99030198', '085389306776', 'Active'),
(21, '6301030301980001', 'Maulana Muhammad', 'Politeknik Pelaihari', 'Mahasiswa', '1546843162-356270.jpg', '1546843172-472400.jpg', '998765', '182736452632', 'Active'),
(22, '1234567891011126', 'Novaris', 'Poltek', 'Mahasiswa', '1546843191-571264.jpg', '1546843219-742783.jpg', '8873', '172637161526', 'Active'),
(23, '6271635787382647', '72627', 'Poltek', 'Mahasiswa', '1546844182-444874.jpg', '1546844200-582410.jpg', '72617', '085123556277', 'Active'),
(24, '6371536374635173', 'Maulana', 'Poltek', 'Mahasiswa', '1546844252-265575.jpg', '1546844272-684106.jpg', '7361', '085167879987', 'Active'),
(25, '6152417363562565', 'Maulana', 'Maulana', 'Mahasiswa', '1546845790-754814.jpg', '1546845804-247942.jpg', '71627', '085378667617', 'Active'),
(26, '6152536768367656', 'Novaris', 'Poltek', 'Mahasiswa', '1546845846-614781.jpg', '1546845857-880229.jpg', '73627', '085867667262', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `kode_izin` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `nama_org` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pendaftaran`
--

INSERT INTO `tb_pendaftaran` (`id_pendaftaran`, `kode_izin`, `user_id`, `jumlah_orang`, `nama_org`, `file`, `status`) VALUES
(1, 102931, '4', 3, 'Muhammad Maulana, Rama Novaris, Arief Mahdi', 'bukti.pdf', 'Pending'),
(2, 827328, '3', 2, 'Arief Mahdi, Rama Novaris', 'bukti.jpg', 'Proceed'),
(3, 83728, '2', 2, 'Muhammad Maulana, Rama Novaris', 'bukti.pdf', 'Proceed'),
(4, 83278, '2', 3, 'Muhammad Maulana, Rama Novaris, Arief Mahdi', 'bukti.pdf', 'Proceed');

-- --------------------------------------------------------

--
-- Table structure for table `tb_perizinan`
--

CREATE TABLE `tb_perizinan` (
  `id_perizinan` int(11) NOT NULL,
  `kode_izin` int(11) NOT NULL,
  `judul_izin` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jumlah_org` int(11) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_perizinan`
--

INSERT INTO `tb_perizinan` (`id_perizinan`, `kode_izin`, `judul_izin`, `user_id`, `jumlah_org`, `start`, `end`, `modified_by_id`, `last_modified`, `status`, `file`) VALUES
(47, 5240, 'Ini izin maulana', 1, 2, '2019-01-08 13:36:00', '2019-01-22 13:36:00', 52, '2019-01-08 05:37:06', 'Pending', '1546845609-966887.jpg'),
(48, 5579, 'Ini izin rama', 53, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 52, '2019-01-09 02:16:53', 'Pending', '1546845649-626962.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `id_tempat` int(11) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ruangan`
--

INSERT INTO `tb_ruangan` (`id_ruangan`, `id_tempat`, `nama_ruangan`) VALUES
(2, 1, 'R. NGN'),
(3, 7, 'TOWER'),
(8, 9, 'TOWER'),
(9, 1, 'R. NGN 2'),
(10, 1, 'R. NGN 3');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tempat`
--

CREATE TABLE `tb_tempat` (
  `id_tempat` int(11) NOT NULL,
  `nama_tempat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tempat`
--

INSERT INTO `tb_tempat` (`id_tempat`, `nama_tempat`) VALUES
(1, 'STO2 ULIN 1'),
(7, 'STO1 CENTRUM'),
(9, 'TELKOM BANJARBARU 2'),
(11, 'STO1 CENTRUM 1');

-- --------------------------------------------------------

--
-- Table structure for table `telegram`
--

CREATE TABLE `telegram` (
  `id_telegram` int(11) NOT NULL,
  `telegram` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `telegram`
--

INSERT INTO `telegram` (`id_telegram`, `telegram`) VALUES
(1, 632141910),
(2, 674976106);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `no_ktp` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `instansi` varchar(50) NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `foto_karpeg` varchar(255) NOT NULL,
  `nik` varchar(12) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `id_telegram` varchar(20) DEFAULT NULL,
  `level` varchar(50) NOT NULL DEFAULT 'User',
  `status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `no_ktp`, `nama`, `instansi`, `posisi`, `foto_ktp`, `foto_karpeg`, `nik`, `no_hp`, `id_telegram`, `level`, `status`) VALUES
(1, '6301030301980001', 'Muhammad Maulana', 'Teknik Informatika', 'Mahasiswa', 'Untitled.png', 'admin.jpg', '108930', '085389306776', '', 'Admin', 'Active'),
(51, '2147483647', 'hafiz', 'daman', 'karyawan', '1544430269-484419.jpg', '1544430288-167998.jpg', '101180', '085326362', '198205822', 'User', 'Active'),
(52, '13', 'Super Admin', 'Administrator', 'Super', 'unknown.jpg', 'unknown.jpg', '13', '13', '632141910', 'SuperAdmin', 'Active'),
(53, '6301030301980002', 'Rama Novaris', 'Teknik Informatika', 'Mahasiswa', '1545293895-379388.jpg', '1545293915-884508.jpg', '2018', '08121818', '674976106', 'Admin', 'Active'),
(54, '3123123', 'Mike', 'Poltek', 'Mahasiswa', '02012019_101327.jpg', '02012019_1013271.jpg', '1231231', '2313123', '12312', 'Admin', 'Inactive'),
(55, '14', 'Leniansah', 'Poltekes', 'Mahasiswi', '02012019_102032.jpg', '02012019_1020321.jpg', '13', '12', '13', 'Admin', 'Inactive'),
(56, '630103030198000', 'Maulana', 'Politeknik', 'Mahasiswa', '1546586069-567415.jpg', '1546586075-149474.jpg', '713182', '08538930', '332', 'User', 'Active'),
(57, '4343', 'tes user new', 'fd', 'fd', '10012019_090612.jpg', '10012019_0906121.jpg', '434', '3434', '444', 'User', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `otp_user`
--
ALTER TABLE `otp_user`
  ADD PRIMARY KEY (`id_otp`);

--
-- Indexes for table `tbl_dokumen`
--
ALTER TABLE `tbl_dokumen`
  ADD PRIMARY KEY (`id_document`);

--
-- Indexes for table `tbl_history_document`
--
ALTER TABLE `tbl_history_document`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_document` (`id_document`);

--
-- Indexes for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD PRIMARY KEY (`id_otp`),
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tbl_units`
--
ALTER TABLE `tbl_units`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `tbl_units_member`
--
ALTER TABLE `tbl_units_member`
  ADD PRIMARY KEY (`id_unit_member`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `tbl_unit_document`
--
ALTER TABLE `tbl_unit_document`
  ADD PRIMARY KEY (`id_unit_document`),
  ADD KEY `id_document` (`id_document`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `tb_attachment_perizinan`
--
ALTER TABLE `tb_attachment_perizinan`
  ADD PRIMARY KEY (`id_attachment`);

--
-- Indexes for table `tb_izin_org`
--
ALTER TABLE `tb_izin_org`
  ADD PRIMARY KEY (`id_org_izin`);

--
-- Indexes for table `tb_izin_ruangan`
--
ALTER TABLE `tb_izin_ruangan`
  ADD PRIMARY KEY (`id_izin_ruangan`);

--
-- Indexes for table `tb_participant`
--
ALTER TABLE `tb_participant`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  ADD PRIMARY KEY (`id_perizinan`),
  ADD UNIQUE KEY `kode_izin` (`kode_izin`);

--
-- Indexes for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `tb_tempat`
--
ALTER TABLE `tb_tempat`
  ADD PRIMARY KEY (`id_tempat`);

--
-- Indexes for table `telegram`
--
ALTER TABLE `telegram`
  ADD PRIMARY KEY (`id_telegram`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `no_ktp` (`no_ktp`),
  ADD UNIQUE KEY `no_hp` (`no_hp`),
  ADD UNIQUE KEY `id_telegram` (`id_telegram`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `otp_user`
--
ALTER TABLE `otp_user`
  MODIFY `id_otp` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_dokumen`
--
ALTER TABLE `tbl_dokumen`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_history_document`
--
ALTER TABLE `tbl_history_document`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `id_otp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_units`
--
ALTER TABLE `tbl_units`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_units_member`
--
ALTER TABLE `tbl_units_member`
  MODIFY `id_unit_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tbl_unit_document`
--
ALTER TABLE `tbl_unit_document`
  MODIFY `id_unit_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_attachment_perizinan`
--
ALTER TABLE `tb_attachment_perizinan`
  MODIFY `id_attachment` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_izin_org`
--
ALTER TABLE `tb_izin_org`
  MODIFY `id_org_izin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `tb_izin_ruangan`
--
ALTER TABLE `tb_izin_ruangan`
  MODIFY `id_izin_ruangan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_participant`
--
ALTER TABLE `tb_participant`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  MODIFY `id_perizinan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tb_tempat`
--
ALTER TABLE `tb_tempat`
  MODIFY `id_tempat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `telegram`
--
ALTER TABLE `telegram`
  MODIFY `id_telegram` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_history_document`
--
ALTER TABLE `tbl_history_document`
  ADD CONSTRAINT `tbl_history_document_ibfk_1` FOREIGN KEY (`id_document`) REFERENCES `tbl_dokumen` (`id_document`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD CONSTRAINT `tbl_otp_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `tbl_units_member`
--
ALTER TABLE `tbl_units_member`
  ADD CONSTRAINT `tbl_units_member_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `tbl_units_member_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `tbl_units` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_unit_document`
--
ALTER TABLE `tbl_unit_document`
  ADD CONSTRAINT `tbl_unit_document_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `tbl_units` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_unit_document_ibfk_2` FOREIGN KEY (`id_document`) REFERENCES `tbl_dokumen` (`id_document`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
