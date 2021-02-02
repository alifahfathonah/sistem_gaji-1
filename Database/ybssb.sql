-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2021 at 01:12 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ybssb`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alfa') NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bonus_kinerja`
--

CREATE TABLE `bonus_kinerja` (
  `id` int(11) NOT NULL,
  `id_karyawan` text NOT NULL,
  `tanggal` date NOT NULL,
  `nilai_kpi` text NOT NULL,
  `jumlah_bonus` text NOT NULL,
  `total_gaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus_kinerja`
--

INSERT INTO `bonus_kinerja` (`id`, `id_karyawan`, `tanggal`, `nilai_kpi`, `jumlah_bonus`, `total_gaji`) VALUES
(1, '39', '2021-01-07', '20', '160000', '960000'),
(2, '30', '2021-01-06', '15', '210000', '1610000'),
(4, '37', '2021-01-07', '10', '80000', '880000');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_lebaran`
--

CREATE TABLE `bonus_lebaran` (
  `id` int(11) NOT NULL,
  `id_karyawan` text NOT NULL,
  `tanggal` date NOT NULL,
  `total_gaji_bonus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus_lebaran`
--

INSERT INTO `bonus_lebaran` (`id`, `id_karyawan`, `tanggal`, `total_gaji_bonus`) VALUES
(17, '39', '2021-01-06', '800000');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_bulanan`
--

CREATE TABLE `gaji_bulanan` (
  `id` int(11) NOT NULL,
  `id_karyawan` text NOT NULL,
  `tanggal` date NOT NULL,
  `uang_transport` text NOT NULL,
  `tunjangan_kinerja` text NOT NULL,
  `tunjangan_jabatan` text NOT NULL,
  `uang_extra_kurikuler` text NOT NULL,
  `uang_lembur` text NOT NULL,
  `bonus_lain` text NOT NULL,
  `total_gaji` text NOT NULL,
  `total_potongan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji_bulanan`
--

INSERT INTO `gaji_bulanan` (`id`, `id_karyawan`, `tanggal`, `uang_transport`, `tunjangan_kinerja`, `tunjangan_jabatan`, `uang_extra_kurikuler`, `uang_lembur`, `bonus_lain`, `total_gaji`, `total_potongan`) VALUES
(2, '11', '2021-01-07', '0', '50000', '0', '0', '0', '0', '1450000', '0'),
(3, '14', '2021-01-07', '0', '0', '0', '0', '0', '100000', '1500000', '0'),
(4, '17', '2021-01-07', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(5, '19', '2021-01-07', '0', '0', '0', '0', '0', '100000', '1500000', '0'),
(6, '20', '2021-01-29', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(7, '22', '2021-01-07', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(8, '23', '2021-01-07', '0', '0', '0', '0', '0', '0', '1000000', '0'),
(10, '25', '2021-01-07', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(11, '26', '2021-01-07', '0', '0', '0', '0', '0', '100000', '200000', '0'),
(12, '27', '2021-01-07', '0', '0', '0', '0', '0', '0', '100000', '0'),
(13, '28', '2021-01-07', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(14, '29', '2021-01-07', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(15, '30', '2021-01-07', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(16, '31', '2021-01-07', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(17, '32', '2021-01-01', '0', '0', '0', '0', '0', '50000', '1450000', '0'),
(18, '33', '2021-01-07', '0', '0', '0', '0', '0', '45000', '1445000', '0'),
(25, '39', '2021-01-07', '0', '0', '0', '0', '0', '0', '800000', '0'),
(26, '38', '2021-01-07', '0', '0', '0', '0', '0', '0', '800000', '0'),
(27, '37', '2021-01-07', '0', '0', '0', '0', '0', '0', '800000', '0'),
(29, '35', '2021-01-07', '0', '0', '0', '0', '0', '0', '800000', '0'),
(30, '34', '2021-01-07', '0', '0', '0', '0', '0', '0', '800000', '0'),
(31, '18', '2021-01-07', '0', '0', '0', '0', '0', '0', '100000', '0'),
(32, '18', '2021-01-07', '0', '0', '0', '0', '0', '0', '100000', '0'),
(33, '16', '2021-01-07', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(34, '15', '2021-01-07', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(35, '13', '2021-01-07', '0', '0', '0', '0', '0', '0', '2000000', '0'),
(36, '31', '2021-01-12', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(39, '39', '2021-02-24', '0', '0', '0', '0', '0', '0', '800000', '0'),
(40, '38', '2021-02-24', '0', '0', '0', '0', '0', '0', '800000', '0'),
(41, '37', '2021-02-24', '0', '0', '0', '0', '0', '0', '800000', '0'),
(42, '35', '2021-02-24', '0', '0', '0', '0', '0', '0', '800000', '0'),
(43, '34', '2021-02-24', '0', '0', '0', '0', '0', '0', '800000', '0'),
(44, '33', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(45, '32', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(46, '31', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(47, '30', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(48, '29', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(49, '28', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(50, '27', '2021-02-24', '0', '0', '0', '0', '0', '0', '100000', '0'),
(51, '26', '2021-02-24', '0', '0', '0', '0', '0', '0', '100000', '0'),
(52, '25', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(53, '24', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(54, '23', '2021-02-24', '0', '0', '0', '0', '0', '0', '1000000', '0'),
(55, '22', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(56, '21', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(57, '20', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(58, '19', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(59, '18', '2021-02-24', '0', '0', '0', '0', '0', '0', '100000', '0'),
(60, '17', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(61, '16', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(62, '15', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(63, '14', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0'),
(64, '13', '2021-02-24', '0', '0', '0', '0', '0', '0', '2000000', '0'),
(65, '11', '2021-02-24', '0', '0', '0', '0', '0', '0', '1400000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_tambahan`
--

CREATE TABLE `gaji_tambahan` (
  `id` int(11) NOT NULL,
  `jenis_kegiatan` text NOT NULL,
  `jumlah_gaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji_tambahan`
--

INSERT INTO `gaji_tambahan` (`id`, `jenis_kegiatan`, `jumlah_gaji`) VALUES
(1, 'Lembur', '555'),
(2, 'Eskul', '6666');

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `jumlah_gaji_pokok` text NOT NULL,
  `t_jalan_jalan` text NOT NULL,
  `t_kesehatan` text NOT NULL,
  `t_pelatihan` text NOT NULL,
  `t_cuti_tahunan` text NOT NULL,
  `t_study_banding` text NOT NULL,
  `t_umroh` text NOT NULL,
  `kenaikan_gaji_20_persen` text NOT NULL,
  `total_gaji` text NOT NULL,
  `id_tingkat_jabatan` text NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `create_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id`, `level`, `jumlah_gaji_pokok`, `t_jalan_jalan`, `t_kesehatan`, `t_pelatihan`, `t_cuti_tahunan`, `t_study_banding`, `t_umroh`, `kenaikan_gaji_20_persen`, `total_gaji`, `id_tingkat_jabatan`, `id_jabatan`, `create_date`) VALUES
(13, 1, '1400000', '0', '0', '0', '0', '0', '0', '0', '1400000', '6', 8, '2020-12-14'),
(18, 1, '2000000', '0', '0', '0', '0', '0', '0', '0', '2000000', '8', 8, '2021-01-06'),
(20, 1, '1000000', '0', '0', '0', '0', '0', '0', '0', '1000000', '5', 16, '2021-01-06'),
(21, 1, '100000', '0', '0', '0', '0', '0', '0', '0', '100000', '4', 17, '2021-01-06'),
(22, 1, '800000', '0', '0', '0', '0', '0', '0', '0', '800000', '3', 18, '2021-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `guru_terbaik`
--

CREATE TABLE `guru_terbaik` (
  `id` int(11) NOT NULL,
  `id_karyawan` text NOT NULL,
  `tanggal` date NOT NULL,
  `upload_portofolio` text NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah_bonus` text NOT NULL,
  `total_gaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru_terbaik`
--

INSERT INTO `guru_terbaik` (`id`, `id_karyawan`, `tanggal`, `upload_portofolio`, `keterangan`, `jumlah_bonus`, `total_gaji`) VALUES
(12, '39', '2021-01-06', 'gntg.jpg', 'Menjadi Guru SD Terbaik se-pekanbaru', '50000', '850000');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` text NOT NULL,
  `id_tingkat_jabatan` text NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `id_tingkat_jabatan`, `create_date`) VALUES
(6, 'Kepala Sekolah', '8', '2020-12-11'),
(8, 'Guru Kelas', '6', '2020-12-12'),
(9, 'Guru PAI', '6', '2021-01-06'),
(10, 'Guru Bahasa Inggris', '6', '2021-01-06'),
(11, 'Tata Usaha', '4', '2021-01-06'),
(12, 'Guru Tahfiz', '6', '2021-01-06'),
(13, 'Guru PJOK', '6', '2021-01-06'),
(14, 'Bendahara', '5', '2021-01-06'),
(15, 'Guru Bahasa Arab', '6', '2021-01-06'),
(16, 'Operator', '4', '2021-01-06'),
(17, 'Kebersihan Sekolah', '3', '2021-01-06'),
(18, 'Penjaga Sekolah', '3', '2021-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `role` enum('1','2','3','4','5','6') NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `id_jabatan` varchar(100) NOT NULL,
  `id_tingkat_jabatan` int(11) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `universitas` varchar(100) NOT NULL,
  `pendidikan_terakhir` varchar(100) NOT NULL,
  `tahun_masuk` varchar(100) NOT NULL,
  `status` enum('Aktif','Tidak Aktif','Pindah') NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_golongan` text NOT NULL,
  `gaji_pokok` text NOT NULL,
  `total_gaji` text NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `role`, `nama_karyawan`, `tgl_lahir`, `jk`, `email`, `no_hp`, `alamat`, `id_jabatan`, `id_tingkat_jabatan`, `jurusan`, `universitas`, `pendidikan_terakhir`, `tahun_masuk`, `status`, `gambar`, `id_golongan`, `gaji_pokok`, `total_gaji`, `create_date`) VALUES
(11, '1', 'MUHAMMAD DAHRIL, S.Pd', '1994-08-28', 'LK', '', '', 'jl. Suka Karya', '8', 6, 'PAI', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(13, '1', 'WAHYU ISKANDAR,S.Pd.I', '1990-12-25', 'LK', '', '', 'jl. Kubang Raya', '6', 8, 'PGMI', 'UIN SUSKA', 'S1', '', 'Tidak Aktif', '', '18', '2000000', '2000000', '2021-01-06'),
(14, '1', 'RAJA WITRI YUANA VIKA,S.Pd', '1995-01-12', 'PR', '', '', 'Perum Tarai Gading 2', '10', 6, 'PBI', 'UIN SUSKA', 'S1', '', 'Aktif', 'tidak ada', '13', '1400000', '1400000', '2021-01-06'),
(15, '1', 'SYAROH RATNA DEWI,S,Pd', '1995-03-21', 'PR', '', '', 'Perum Mahkota Riau 3', '8', 6, 'Pendidikan Kimia', 'UIN SUSKA', 'S1', '', 'Tidak Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(16, '1', 'SINTA WAHDINI,S.Pd', '1995-09-01', 'PR', '', '', 'Balam Jaya,RT 02,RW 01', '8', 6, 'PGSD', 'UBH Padang', 'S1', '', 'Tidak Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(17, '1', 'NADYATUL RAHMAH,S.Si', '1994-09-25', 'PR', '', '', 'Griya Setia Nusa A6-15', '8', 6, 'MTK Terapan', 'UIN SUSKA', 'S1', '', 'Aktif', 'tidak ada', '13', '1400000', '1400000', '2021-01-06'),
(18, '1', 'IMRA ATUL USWAH, S.Si', '1995-09-05', 'PR', '', '', 'Kubang Raya, Perum WTL D.11', '11', 4, 'Biologi', 'Universitas Riau', 'S1', '', 'Tidak Aktif', '', '21', '100000', '100000', '2021-01-06'),
(19, '1', 'ELVI KASARI, S.Pd', '1995-07-18', 'PR', '', '', 'Perum. Bina Bangun Kencana Blok E.6', '8', 6, 'P.B.Konseling', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(20, '1', 'BETRI GUSMELTA, S.Pd', '1988-08-12', 'PR', '', '', 'Perum. Pucuk Bunga Merah Kualu', '8', 6, 'PGSD', 'UT-Padang', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(21, '1', 'YULIANA ROITO Hsb, S.Pd', '1995-07-17', 'PR', '', '', 'Jl. Garuda Sakti Km.01 Gg.Ros Pekanbaru', '12', 6, 'P.B.Arab', 'UIN SUSKA', 'S1', '', 'Tidak Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(22, '1', 'ISMUL HIKMAH, S.Pd', '1993-07-14', 'LK', '', '', 'Perum.Manunggal Rimbo Panjang', '13', 6, 'PJOK', 'UNP', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(23, '1', 'JUSNITA, SE', '1990-07-06', 'PR', '', '', 'Perum. Pucuk Bunga Merah Kualu', '14', 5, 'Akuntansi', 'UIN SUSKA', 'S1', '', 'Aktif', '', '20', '1000000', '1000000', '2021-01-06'),
(24, '1', 'DESI SURYA TUTI, S.Pd', '1990-12-12', 'PR', '', '', 'Jl. Sukajadi, Blok G.14', '8', 6, 'Pend. Matematika', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(25, '1', 'AMI SABRINA', '1995-05-12', 'PR', '', '', 'Jl. Soebrantas Perum.Villa Pesona Panam. B. 09', '8', 6, 'Pend. Kimia', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-06'),
(26, '1', 'DEDE KURNIA ISLAMI,S.Pi', '1995-06-10', 'LK', '', '', 'Jl. Pepaya Gg. Tanjung', '16', 4, 'Perikanan', 'Universitas Riau', 'S1', '', 'Aktif', '', '21', '100000', '100000', '2021-01-06'),
(27, '1', 'MULYATI,A.Md', '0000-00-00', 'PR', '', '', 'JL. Taman Karya', '11', 4, '', '', '', '', 'Aktif', '', '21', '100000', '100000', '2021-01-07'),
(28, '1', 'NUH ASEP SATRIA,S.Pd', '1995-10-12', 'LK', '', '', 'Rimbo Panjang, Kampar', '15', 6, 'P.B.Arab', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(29, '1', 'MASDA GUSTINAH HSB,M.Pd', '1995-08-17', 'PR', '', '', 'Perum Grentari Blok G NO.2', '8', 6, 'Agama Islam', 'UIN SUSKA', 'S2', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(30, '1', 'MAYANG SARI NAINGGOLAN,S.Pd', '1996-07-12', 'PR', '', '', 'Jl. Bangun Karya Gg. Bangun III', '8', 6, 'Pend. Matematika', 'Universitas Riau', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(31, '1', 'SIDON SAPUTRA', '1996-09-06', 'LK', '', '', 'JL. Suka Karya', '12', 6, 'Manajemen Dakwah', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(32, '1', 'TRI WIRATNA DEWI,S.Pd', '1993-12-18', 'PR', '', '', 'Jl. Cemara Ujung Perum Permata 3 ', '8', 6, 'PBI', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(33, '1', 'RAHMADANI,S.Pd', '1990-09-04', 'LK', '', '', 'Jl. Kutilang Sakti', '8', 6, 'PBI', 'UIN SUSKA', 'S1', '', 'Aktif', '', '13', '1400000', '1400000', '2021-01-07'),
(34, '1', 'HASAN BASRI', '0000-00-00', 'LK', '', '', '', '17', 3, '', '', '', '', 'Aktif', '', '22', '800000', '800000', '2021-01-07'),
(35, '1', 'ANDI SANAFIYAH', '0000-00-00', 'LK', '', '', '', '18', 3, '', '', '', '', 'Aktif', '', '22', '800000', '800000', '2021-01-07'),
(37, '1', 'SOEKARNO PONIMIN', '0000-00-00', 'LK', '', '', '', '18', 3, '', '', '', '', 'Tidak Aktif', '', '22', '800000', '800000', '2021-01-07'),
(38, '1', 'AHMAD', '0000-00-00', 'LK', '', '', '', '17', 3, '', '', '', '', 'Tidak Aktif', '', '22', '800000', '800000', '2021-01-07'),
(39, '1', 'RULI UWIR LIANTO', '0000-00-00', 'LK', '', '', '', '17', 3, '', '', '', '', 'Tidak Aktif', '', '22', '800000', '800000', '2021-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `kenaikan_gaji`
--

CREATE TABLE `kenaikan_gaji` (
  `id` int(11) NOT NULL,
  `id_karyawan` text NOT NULL,
  `persentase` text NOT NULL,
  `jumlah_kenaikan` text NOT NULL,
  `total_gaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tingkat_jabatan`
--

CREATE TABLE `tingkat_jabatan` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tingkat_jabatan`
--

INSERT INTO `tingkat_jabatan` (`id`, `nama`, `create_date`) VALUES
(3, 'Keamanan dan Kebersihan', '2020-11-22'),
(4, 'Administrasi', '2020-11-22'),
(5, 'Keuangan', '2020-11-22'),
(6, 'Guru', '2020-11-22'),
(8, 'Manajemen', '2020-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_gaji_tambahan`
--

CREATE TABLE `transaksi_gaji_tambahan` (
  `id` int(11) NOT NULL,
  `id_gaji_tambahan` text NOT NULL,
  `id_gaji_bulanan` text NOT NULL,
  `jumlah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('administrator','yayasan','pegawai','keuangan') COLLATE utf8_unicode_ci DEFAULT NULL,
  `block_status` int(3) NOT NULL,
  `online_status` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `time_online` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_offline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `role`, `block_status`, `online_status`, `time_online`, `time_offline`) VALUES
(54, 'DEDE KURNIA ISLAMI,S.Pi', '', 'superadmin', '9c1d9390a6bde8e38e32775521d7c406', '', 'administrator', 0, 'offline', '2021-01-14 15:57:47', '2021-01-14 15:57:47'),
(55, 'JUSNITA, SE', '', 'keuangan', '707f2ab2fe96b61ea294097eaddb3af3', '', 'keuangan', 0, 'offline', '2021-01-21 20:09:36', '2021-01-21 20:09:36'),
(56, 'WAHYU ISKANDAR,S.Pd.I', '', 'yayasan', 'aa8257f900dee375589637d4fa89b08f', '', 'yayasan', 0, 'online', '2021-01-27 00:01:57', '2021-01-27 00:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `users1`
--

CREATE TABLE `users1` (
  `id_users` int(255) NOT NULL,
  `role` enum('1','2','3','4','5','6') NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `poto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users1`
--

INSERT INTO `users1` (`id_users`, `role`, `name`, `email`, `password`, `jabatan`, `poto`) VALUES
(16, '1', 'Supervisor', 'supervisor@gmail.com', 'supervisor', 'Supervisor', 'LogoAsr.png'),
(22, '2', 'Asmarini', 'asmarini@gmail.com', '12345678', 'Karyawan Tata Usaha', 'IMG-20191008-WA0009.jpg'),
(23, '3', 'Junita,SE', 'junita@gmail.com', 'junita', 'Bendahara', 'download.png'),
(24, '4', 'Nadyatul Rahmah, S.Si', 'nadiatul@gmail.com', 'kepsek', 'Kepala Sekolah SDIT Insan Teladan', 'Hijab.jpg'),
(25, '5', 'Dirpend', 'dirpend@gmail.com', 'dirpend', 'Direktur Pendidikan', 'admin.jpg'),
(26, '6', 'Yayasan', 'yayasan@gmail.com', 'yayasan', 'Yayasan', 'e.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `bonus_kinerja`
--
ALTER TABLE `bonus_kinerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_lebaran`
--
ALTER TABLE `bonus_lebaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gaji_bulanan`
--
ALTER TABLE `gaji_bulanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gaji_tambahan`
--
ALTER TABLE `gaji_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru_terbaik`
--
ALTER TABLE `guru_terbaik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `kenaikan_gaji`
--
ALTER TABLE `kenaikan_gaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tingkat_jabatan`
--
ALTER TABLE `tingkat_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_gaji_tambahan`
--
ALTER TABLE `transaksi_gaji_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users1`
--
ALTER TABLE `users1`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bonus_kinerja`
--
ALTER TABLE `bonus_kinerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bonus_lebaran`
--
ALTER TABLE `bonus_lebaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `gaji_bulanan`
--
ALTER TABLE `gaji_bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `gaji_tambahan`
--
ALTER TABLE `gaji_tambahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `guru_terbaik`
--
ALTER TABLE `guru_terbaik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `kenaikan_gaji`
--
ALTER TABLE `kenaikan_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tingkat_jabatan`
--
ALTER TABLE `tingkat_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `transaksi_gaji_tambahan`
--
ALTER TABLE `transaksi_gaji_tambahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `users1`
--
ALTER TABLE `users1`
  MODIFY `id_users` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
