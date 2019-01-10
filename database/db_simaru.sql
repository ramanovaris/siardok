-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2019 at 01:13 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Error reading structure for table db_simaru.tbl_otp: #1932 - Table 'db_simaru.tbl_otp' doesn't exist in engine
-- Error reading data for table db_simaru.tbl_otp: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_simaru`.`tbl_otp`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

CREATE TABLE `tbl_units` (
  `id_unit` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units_member`
--
-- Error reading structure for table db_simaru.tbl_units_member: #1932 - Table 'db_simaru.tbl_units_member' doesn't exist in engine
-- Error reading data for table db_simaru.tbl_units_member: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_simaru`.`tbl_units_member`' at line 1

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

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `id_tempat` int(11) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tempat`
--

CREATE TABLE `tb_tempat` (
  `id_tempat` int(11) NOT NULL,
  `nama_tempat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telegram`
--

CREATE TABLE `telegram` (
  `id_telegram` int(11) NOT NULL,
  `telegram` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `tbl_units`
--
ALTER TABLE `tbl_units`
  ADD PRIMARY KEY (`id_unit`);

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
  ADD UNIQUE KEY `no_ktp` (`no_ktp`);

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
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_history_document`
--
ALTER TABLE `tbl_history_document`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_units`
--
ALTER TABLE `tbl_units`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_unit_document`
--
ALTER TABLE `tbl_unit_document`
  MODIFY `id_unit_document` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_attachment_perizinan`
--
ALTER TABLE `tb_attachment_perizinan`
  MODIFY `id_attachment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_izin_org`
--
ALTER TABLE `tb_izin_org`
  MODIFY `id_org_izin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_izin_ruangan`
--
ALTER TABLE `tb_izin_ruangan`
  MODIFY `id_izin_ruangan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_participant`
--
ALTER TABLE `tb_participant`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  MODIFY `id_perizinan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tempat`
--
ALTER TABLE `tb_tempat`
  MODIFY `id_tempat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telegram`
--
ALTER TABLE `telegram`
  MODIFY `id_telegram` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_history_document`
--
ALTER TABLE `tbl_history_document`
  ADD CONSTRAINT `tbl_history_document_ibfk_1` FOREIGN KEY (`id_document`) REFERENCES `tbl_dokumen` (`id_document`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_unit_document`
--
ALTER TABLE `tbl_unit_document`
  ADD CONSTRAINT `tbl_unit_document_ibfk_1` FOREIGN KEY (`id_document`) REFERENCES `tbl_dokumen` (`id_document`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_unit_document_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `tbl_units` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
