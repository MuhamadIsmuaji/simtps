-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2016 at 06:08 PM
-- Server version: 5.5.47-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tps`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE IF NOT EXISTS `tb_anggota` (
  `thn_ajaran` char(4) NOT NULL,
  `smt` char(1) NOT NULL DEFAULT '1',
  `kode_kel` char(6) NOT NULL DEFAULT '0',
  `nbi` char(10) NOT NULL,
  `nilai_bimb` tinyint(1) DEFAULT '0',
  `nilai_11` tinyint(1) DEFAULT '0',
  `nilai_12` tinyint(1) DEFAULT '0',
  `nilai_13` tinyint(1) DEFAULT '0',
  `nilai_14` tinyint(1) DEFAULT '0',
  `nilai_21` tinyint(1) DEFAULT '0',
  `nilai_22` tinyint(1) DEFAULT '0',
  `nilai_23` tinyint(1) DEFAULT '0',
  `nilai_24` tinyint(1) DEFAULT '0',
  `nilai_31` tinyint(1) DEFAULT '0',
  `nilai_32` tinyint(1) DEFAULT '0',
  `nilai_33` tinyint(1) DEFAULT '0',
  `nilai_34` tinyint(1) DEFAULT '0',
  `nilai_akhir` double DEFAULT '0',
  `nilai_huruf` char(2) DEFAULT 'E',
  `konfirmasi` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`thn_ajaran`,`smt`,`kode_kel`,`nbi`),
  KEY `tb_anggota_ibfk_1` (`nbi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bimbingan`
--

CREATE TABLE IF NOT EXISTS `tb_bimbingan` (
  `thn_ajaran` char(4) NOT NULL,
  `smt` char(1) NOT NULL DEFAULT '1',
  `kode_kel` char(6) NOT NULL,
  `nou` tinyint(1) NOT NULL,
  `tgl` date NOT NULL,
  `uraian` text NOT NULL,
  `uraian_dosen` text,
  `validasi` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`thn_ajaran`,`smt`,`kode_kel`,`nou`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bimbingan`
--

INSERT INTO `tb_bimbingan` (`thn_ajaran`, `smt`, `kode_kel`, `nou`, `tgl`, `uraian`, `uraian_dosen`, `validasi`) VALUES
('2015', '2', 'TPS01', 1, '2016-05-28', '<p>Ini uraian bimbingan ke 1 :</p><ul><li>Uraian 1</li><li>uraian 2</li><li>uraian 3</li><li>uraian 4</li></ul>', '<p>Daftar perbaikan :</p><ol><li>perbaikan 1</li><li>perbaikan 2</li><li>perbaikan 3</li><li>perbaikan 4</li></ol><p>asdadajsdhasdbahsdbahsbdhasbdahsbdhasdasdahsdbhasdbasdasd</p>', 1),
('2015', '2', 'TPS01', 2, '2016-05-28', '<p>ini bimbingan kedua</p>', 'Ini perbaikan bimbingan ke 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE IF NOT EXISTS `tb_dosen` (
  `npp` char(15) NOT NULL,
  `nama` char(35) NOT NULL,
  `pwd` char(64) NOT NULL,
  `akses` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`npp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`npp`, `nama`, `pwd`, `akses`) VALUES
('11111', 'Muhamad Ismuaji', 'ismuaji', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE IF NOT EXISTS `tb_jadwal` (
  `thn_ajaran` char(4) NOT NULL,
  `smt` char(1) NOT NULL DEFAULT '1',
  `kode_kel` char(6) NOT NULL,
  `ruang` char(5) DEFAULT NULL,
  `moderator` char(10) DEFAULT NULL,
  `penguji1` char(10) DEFAULT NULL,
  `penguji2` char(10) DEFAULT NULL,
  `validasi` tinyint(1) DEFAULT '0',
  `tgl` date DEFAULT NULL,
  `mulai` int(2) NOT NULL,
  `akhir` int(2) NOT NULL,
  PRIMARY KEY (`thn_ajaran`,`smt`,`kode_kel`),
  KEY `moderator` (`moderator`),
  KEY `penguji1` (`penguji1`),
  KEY `penguji2` (`penguji2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelompok`
--

CREATE TABLE IF NOT EXISTS `tb_kelompok` (
  `thn_ajaran` char(4) NOT NULL,
  `smt` char(1) NOT NULL DEFAULT '1',
  `kode_kel` char(6) NOT NULL,
  `npp` char(15) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `proposal` varchar(255) DEFAULT NULL,
  `revisi` varchar(255) DEFAULT NULL,
  `validasi` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`thn_ajaran`,`smt`,`kode_kel`),
  KEY `tb_kelompok_ibfk_1` (`npp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mhs`
--

CREATE TABLE IF NOT EXISTS `tb_mhs` (
  `nbi` char(10) NOT NULL,
  `nama` char(30) NOT NULL,
  `pwd` char(64) NOT NULL,
  `email` char(64) DEFAULT NULL,
  `akses` tinyint(1) NOT NULL DEFAULT '9',
  PRIMARY KEY (`nbi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_mhs`
--

INSERT INTO `tb_mhs` (`nbi`, `nama`, `pwd`, `email`, `akses`) VALUES
('1461416014', 'RIYAN GITA PRATAMA', '1461416014', NULL, 0),
('1461426032', 'AYI SOPIANDI', '1461426032', NULL, 0),
('460903034', 'RENSI EKA PRATIWI', '460903034', NULL, 0),
('461003193', 'Rizko Nurfadilah', '461003193', NULL, 0),
('461003254', 'SAMOEDRA RIDZKY NAJ''MUDDIN', '461003254', NULL, 0),
('461003267', 'ANDREAS ARDY SUMANIK', '461003267', NULL, 0),
('461103337', 'Dewa Putu Satya W', '461103337', NULL, 0),
('461103340', 'Hendrik Firmansyah', '461103340', NULL, 0),
('461103346', 'MOH FARID ASSIDIK', '461103346', NULL, 0),
('461103381', 'ALFIN BAGAS ARWANDA', '461103381', NULL, 0),
('461103382', 'ATA''UR RAHMAN', '461103382', NULL, 0),
('461103553', 'M. Mardan Zahiduz Zakka', '461103553', NULL, 0),
('461103627', 'LICGA RIZE AGUS W.', '461103627', NULL, 0),
('461203680', 'Masrifah', '461203680', NULL, 0),
('461203689', 'Devita Marvika Putri', '461203689', NULL, 0),
('461203691', 'Elisa Charisma Balubun', '461203691', NULL, 0),
('461203718', 'Hans Paul Christofer Mahag', '461203718', NULL, 0),
('461203746', 'Redy Trianto', '461203746', NULL, 0),
('461203757', 'Salafudin Nasuha', '461203757', NULL, 0),
('461203761', 'Nanda Valencia Afifuddin', '461203761', NULL, 0),
('461203763', 'Lancong Soarubun', '461203763', NULL, 0),
('461203768', 'Khoirul Rozikin', '461203768', NULL, 0),
('461203774', 'Etwien Tribudianto', '461203774', NULL, 0),
('461203784', 'Agus Sutrisno', '461203784', NULL, 0),
('461203785', 'Taufiqur Rohman', '461203785', NULL, 0),
('461203801', 'Andri Krisna Ardiansyah', '461203801', NULL, 0),
('461203814', 'Angga Bagus Saputra', '461203814', NULL, 0),
('461203825', 'ALVIAN ANTON SUSENO', '461203825', NULL, 0),
('461203832', 'Samsun Niam', '461203832', NULL, 0),
('461203847', 'Imam Fatkhur Rozi', '461203847', NULL, 0),
('461203862', 'M. Fariz Firmansyah', '461203862', NULL, 0),
('461203865', 'Ari Putra Sakti', '461203865', NULL, 0),
('461203866', 'M. Majid Efendi', '461203866', NULL, 0),
('461203870', 'Romy Vergyano Surya Arifka', '461203870', NULL, 0),
('461203880', 'Catur Putro Pamungkas', '461203880', NULL, 0),
('461203889', 'Adrian Danan Pratama', '461203889', NULL, 0),
('461203894', 'Moch. Firdaus', '461203894', NULL, 0),
('461203900', 'Andreas Romario Kurniawan', '461203900', NULL, 0),
('461203904', 'Triaswaty Amelia Limbong', '461203904', NULL, 0),
('461203906', 'Octavia Hutagalung', '461203906', NULL, 0),
('461203914', 'MUHAMMAD ILHAM ARFAH', '461203914', NULL, 0),
('461203948', 'Gerdy Prahendra Arifin', '461203948', NULL, 0),
('461203990', 'TRI APRIYANTO', '461203990', NULL, 0),
('461203992', 'Moch.Bachrum Firdaus Wibis', '461203992', NULL, 0),
('461204014', 'Febrian Ramadani', '461204014', NULL, 0),
('461304081', 'ANDHIKA SATRIA PRATAMA', '461304081', NULL, 0),
('461304087', 'Avin Bastian', '461304087', NULL, 0),
('461304099', 'Andhitama Ruspriaji', '461304099', NULL, 0),
('461304117', 'Faizal Ardi Pratama Putra', '461304117', NULL, 0),
('461304133', 'Ahmad Saiful Hanip', '461304133', NULL, 0),
('461304146', 'Novan Nevo Navyando', '461304146', NULL, 0),
('461304155', 'Himawan Fawzul Dewangga', '461304155', NULL, 0),
('461304163', 'Bangkit Prismadani', '461304163', NULL, 0),
('461304165', 'Novita Segar Tanjung', '461304165', NULL, 0),
('461304176', 'Galuh Ady Saputra', '461304176', NULL, 0),
('461304179', 'Liztrianto Pujo Hardhiko', '461304179', NULL, 0),
('461304180', 'Kus Hendrat Moko', '461304180', NULL, 0),
('461304184', 'Jaenal Rudini', '461304184', NULL, 0),
('461304187', 'David Granity', '461304187', NULL, 0),
('461304188', 'WAHYU SETYA BUDI', '461304188', NULL, 0),
('461304189', 'Badirun', '461304189', NULL, 0),
('461304190', 'Titis Prihardini', '461304190', NULL, 0),
('461304192', 'Aris Setiawan', '461304192', NULL, 0),
('461304194', 'Daud Yudistira', '461304194', NULL, 0),
('461304195', 'Miftakhul Khoiri', '461304195', NULL, 0),
('461304196', 'Dayu Mahendra PS', '461304196', NULL, 0),
('461304204', 'Tri Efendi', '461304204', NULL, 0),
('461304210', 'VINCENTIO JORDY RUDYANTO', '461304210', NULL, 0),
('461304211', 'Yoga Setya Pribadi', '461304211', NULL, 0),
('461304212', 'Pangga Aji Sanca', '461304212', NULL, 0),
('461304216', 'Moh. Sholihudin', '461304216', NULL, 0),
('461304219', 'Geri Afrianto', '461304219', NULL, 0),
('461304223', 'Moch Reza Causar', '461304223', NULL, 0),
('461304226', 'Taufiqurrahman', '461304226', NULL, 0),
('461304227', 'Eggy Yuli Winanto', 'ismuaji', 'eggy@gmail.com', 0),
('461304237', 'Leo Adi Wibowo', '461304237', NULL, 0),
('461304238', 'Yacob Christian Boling', '461304238', NULL, 0),
('461304240', 'Nuruddin', '461304240', NULL, 0),
('461304241', 'Elinda Dwi Pratiwi', '461304241', NULL, 0),
('461304243', 'Rihvan Adimulyo', '461304243', NULL, 0),
('461304244', 'Yoga Setiya', '461304244', NULL, 0),
('461304246', 'Rizal Aditya Widiarto', '461304246', NULL, 0),
('461304250', 'Andy Tiek Han Sagita', '461304250', NULL, 0),
('461304252', 'Fida Eka Rukmayanti', '461304252', NULL, 0),
('461304256', 'Ismaul Nur Malini', '461304256', NULL, 0),
('461304265', 'Silvia Kusuma Dewi', '461304265', NULL, 0),
('461304268', 'Chantika Primadani', '461304268', NULL, 0),
('461304273', 'Hadi Sopyan Alimun Toha', '461304273', NULL, 0),
('461304274', 'Achmad Munawir', '461304274', NULL, 0),
('461304278', 'Ari Setyawan', '461304278', NULL, 0),
('461304280', 'Hanif Aziz Elfin', '461304280', NULL, 0),
('461304282', 'Herni Indahwati', '461304282', NULL, 0),
('461304283', 'Raden Decio Yustito S', '461304283', NULL, 0),
('461304286', 'FIRAS ANOM RAMADHAN', '461304286', NULL, 0),
('461304307', 'Ilham Januar Rahman', '461304307', NULL, 0),
('461304313', 'David Subroto', '461304313', NULL, 0),
('461304316', 'Hani Tiyasto Prasetyo Utomo', '461304316', NULL, 0),
('461304317', 'Billy Septian Wijaya', '461304317', NULL, 0),
('461304319', 'Dodik Sepdian Jaya', '461304319', NULL, 0),
('461304328', 'Bagus Bintang Permana', '461304328', NULL, 0),
('461304346', 'Rahmat Wijayanto', '461304346', NULL, 0),
('461304349', 'Ali Muhid', '461304349', NULL, 0),
('461304370', 'Lely Suciyani', '461304370', NULL, 0),
('461304375', 'Djarwo Eko Prasojo', '461304375', NULL, 0),
('461304376', 'Gerry Rama Andika', '461304376', NULL, 0),
('461304382', 'HENDRIKUS WAJON KOTEN', '461304382', NULL, 0),
('461304388', 'Ali Imron', '461304388', NULL, 0),
('461304398', 'Aldanis Lucky Rindjiandana', '461304398', NULL, 0),
('461304399', 'Ichsan Ahmad Tazidin', '461304399', NULL, 0),
('461304415', 'ARRYANGGA ALIEV PRATAMAPUTRA', '461304415', NULL, 0),
('461304422', 'Laxmi Rani Rebekah Ronaldo', '461304422', NULL, 0),
('461304424', 'Muhammad Lutfi', '461304424', NULL, 0),
('461304425', 'Dessy Santika Tanrobak', '461304425', NULL, 0),
('461304429', 'Bekti Hari Wibowo', '461304429', NULL, 0),
('461304430', 'Sita Arindra Putri', '461304430', NULL, 0),
('461304433', 'Edo Katon Setiawan', 'ismuaji', 'edo@gmail.com', 0),
('461304438', 'Moh. Rofi''ul Anam', '461304438', NULL, 0),
('461304444', 'Eka Dian Ariezal Perdana Putra', '461304444', NULL, 0),
('461304446', 'Ahmad Abdianto', '461304446', NULL, 0),
('461304448', 'Lilyanto Sam', '461304448', NULL, 0),
('461304454', 'Dimas Arung Samudra', '461304454', NULL, 0),
('461304458', 'Alfan Khabibi', 'ismuaji', 'habibi@gmail.com', 0),
('461304460', 'Ayu Kusumaningtyas', '461304460', NULL, 0),
('461304468', 'Rudiyanto', '461304468', NULL, 0),
('461304469', 'Ahmad Debi Pramudi', '461304469', NULL, 0),
('461304470', 'Dimas Bagus Ginta Permana', '461304470', NULL, 0),
('461304473', 'Fitjrian Danung Mei Wiratama', '461304473', NULL, 0),
('461304496', 'Eqza Mahetza Gemilang', '461304496', NULL, 0),
('461304497', 'Abdi Santoso', '461304497', NULL, 0),
('461304504', 'Rizky Pambudi', '461304504', NULL, 0),
('461304510', 'Alfa Fikri Avicenna', '461304510', NULL, 0),
('461304511', 'Wildan Aunur Rohim', '461304511', NULL, 0),
('461304513', 'Eko Sugiarsa', '461304513', NULL, 0),
('461304514', 'RIZKY MAULIDA WIRATASA', 'ismuaji', 'wiratasa@gmail.com', 0),
('461304519', 'Friska Setya Pratiwi', '461304519', NULL, 0),
('461304521', 'Abdul Rozaq Muchtarom', '461304521', NULL, 0),
('461304528', 'Febrian Tyahastu', '461304528', NULL, 0),
('461304533', 'Junaidi Habibatul Rohman', '461304533', NULL, 0),
('461304534', 'Bayu Gannesa Putra', '461304534', NULL, 0),
('461304535', 'Muhamad Ismuaji Prajitno', 'ismuaji', 'muhamadismuaji@gmail.com', 0),
('461304536', 'Prajitno Ismuaji Muhamad', 'prajitno', 'ajiismu@gmail.com', 0),
('461304537', 'Agung Suprayogi', '461304537', 'bagong@gmail.com', 0),
('461304539', 'M. Fajrin Sidik', 'ismuaji', 'sidik@gmail.com', 0),
('461304542', 'QOEYUMMUS SA''ADAH', 'ismuaji', 'sadah@gmail.com', 0),
('461304545', 'Mohamad Arif Ainurochim', '461304545', NULL, 0),
('461304548', 'Siswanto Dedik', 'dedik', 'dedik1@gmail.com', 0),
('461304554', 'FIRMAN TRIONO', '461304554', NULL, 0),
('461304556', 'AFIF ALI IMRAN', '461304556', NULL, 0),
('461304559', 'JACKSON HAPOSAN S.', '461304559', NULL, 0),
('461304562', 'JONATHAN KRISNA SUCI', '461304562', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman`
--

CREATE TABLE IF NOT EXISTS `tb_pengumuman` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `judul` char(64) NOT NULL,
  `isi` text NOT NULL,
  `tgl_exp` date NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `validasi` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting`
--

CREATE TABLE IF NOT EXISTS `tb_setting` (
  `thn_ajaran` char(4) NOT NULL,
  `smt` char(1) NOT NULL DEFAULT '1',
  `bts_judul` date DEFAULT NULL,
  `bts_kelompok` date DEFAULT NULL,
  `bts_proposal` date DEFAULT NULL,
  `bts_revisi` date DEFAULT NULL,
  `npp_kalab` char(15) DEFAULT NULL,
  `nama_kalab` char(30) DEFAULT NULL,
  `npp_dekan` char(15) DEFAULT NULL,
  `nama_dekan` char(30) DEFAULT NULL,
  `no_surattgs` char(20) DEFAULT NULL,
  `tgl_surattgs` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `bobot_bimbingan` int(3) NOT NULL DEFAULT '0',
  `bobot_moderator` int(3) NOT NULL DEFAULT '0',
  `bobot_penguji1` int(3) NOT NULL DEFAULT '0',
  `bobot_penguji2` int(3) NOT NULL DEFAULT '0',
  `kom_a` int(3) NOT NULL DEFAULT '0',
  `kom_b` int(3) NOT NULL DEFAULT '0',
  `kom_c` int(3) NOT NULL DEFAULT '0',
  `kom_d` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`thn_ajaran`,`smt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_setting`
--

INSERT INTO `tb_setting` (`thn_ajaran`, `smt`, `bts_judul`, `bts_kelompok`, `bts_proposal`, `bts_revisi`, `npp_kalab`, `nama_kalab`, `npp_dekan`, `nama_dekan`, `no_surattgs`, `tgl_surattgs`, `status`, `bobot_bimbingan`, `bobot_moderator`, `bobot_penguji1`, `bobot_penguji2`, `kom_a`, `kom_b`, `kom_c`, `kom_d`) VALUES
('2015', '2', '2016-06-25', '2016-06-25', '2016-06-25', '2016-06-25', '204609605020', 'Ir. Sugiono MT.', '204500005150', 'Dr. Ir. Muaffaq A. Jani, M.Eng', '..../K/FT/X/2016', '2016-04-19', 1, 25, 25, 25, 25, 25, 25, 25, 25);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD CONSTRAINT `tb_anggota_ibfk_1` FOREIGN KEY (`nbi`) REFERENCES `tb_mhs` (`nbi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `tb_jadwal_ibfk_1` FOREIGN KEY (`moderator`) REFERENCES `tb_dosen` (`npp`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jadwal_ibfk_2` FOREIGN KEY (`penguji1`) REFERENCES `tb_dosen` (`npp`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jadwal_ibfk_3` FOREIGN KEY (`penguji2`) REFERENCES `tb_dosen` (`npp`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
