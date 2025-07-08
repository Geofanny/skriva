-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Jul 2025 pada 02.35
-- Versi server: 8.0.30
-- Versi PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skriva2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bimbingan_dosen`
--

CREATE TABLE `bimbingan_dosen` (
  `kd_bimbingan` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_pembimbing` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `komentar_penolakan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_sesi` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bimbingan_dosen`
--

INSERT INTO `bimbingan_dosen` (`kd_bimbingan`, `kd_pembimbing`, `komentar_penolakan`, `status`, `kd_sesi`) VALUES
('BIM001', 'PB15100601', '-', 'Disetujui', 'SSI001'),
('BIM002', 'PB08102014', '-', 'Menunggu', 'SSI002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `nip` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kd_prodi` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`nip`, `nama`, `password`, `foto`, `kd_prodi`) VALUES
('177105202013041006', 'Rudi Palevi', '$2y$12$YX2Lvu9biURRHRVNeB0ZyemdtZtbbXvy7gvqpjbt0jhOQdqKbyukK', NULL, 'MIPA01'),
('187105202013041006', 'Kemal Palevi', '$2y$12$VZzDcR09h2YpOWJBh18rHeSZuvkc6xqcLloOg.nkAsBoFaqwNSYOW', '', 'MIPA02'),
('197007231972042002', 'Dimaz Rajata, S.E., M.M.', '$2y$12$.fagHg5Lp2ng3TU79YHCuuOJrHkn86mSqDcK6PYi7ynMuOjAEjG5W', NULL, 'IPPS05'),
('197305031976071010', 'Mustika Pranowo, S.T., M.T.', '$2y$12$4Ow3dolllHRbBrAs/InmnuYHLKaZo3l1h1lSzbWXQ3EfwCr0V1oAW', NULL, 'TIK01'),
('197602211995072004', 'Elma Jane Yulianti S.Psi, S.Pd., M.Pd.', '$2y$12$zRUeGWp/9Vqd30o5riwPzex/Hn6ncVK2veNRlSX0qmyH1XncywOBK', NULL, 'BS02'),
('198408032000082017', 'Tomi Putra, S.Kom., M.Kom.', '$2y$12$MZb0p90vLiKVB.EDuALufuuXiUBERA0lCD.ENiQCTDDX558.i91ta', NULL, 'TIK04'),
('198710091987052018', 'Bakijan Upik Natsir M.Farm, S.Pd., M.Pd.', '$2y$12$uF3bvrd3vGM8U2JOii4oFOdjf5h4Rl9h58eM.rQMwYxLNKZaPEgcW', NULL, 'MIPA03'),
('199002032019121014', 'Saiful Hasta Halim, S.Pd., M.Pd.', '$2y$12$QknI2skodZWydN7cltQ/MunBOqHSDTAMJ8WXSFyK2bNiO1FyIiLBa', NULL, 'BS02'),
('199106261972111008', 'Aisyah Wirda Usada, S.Sn., M.Sn.', '$2y$12$euFC7tzAVMPgs4xKUW2kT.O1eZz/RTIVJJAlu4I238Y4xvXRd.PQC', NULL, 'BS03'),
('199111061971012019', 'Wulan Yulianti, S.Sn., M.Sn.', '$2y$12$6y8WXayGfBGxLzzeAjju7.rcJCb3DFMfy9D42oZ2Hr2WbUhqwSGsS', NULL, 'BS03'),
('199404201995042007', 'Melinda Mulyani S.Sos, S.Pd., M.Pd.', '$2y$12$V1FYgoezdyjz2qaukqAVgOJpYAM3mOzXa7lL5QqtecYNNrWVEddvW', NULL, 'BS01'),
('199609072023011003', 'Balapati Suwarno S.E.I, S.Pd., M.Pd.', '$2y$12$dDCtD5qRHzZEa54FFXbu4.yS.vfQdPOtowjToUxtQu4W2k/9rYAim', NULL, 'IPPS01'),
('200107291999042013', 'Kamaria Almira Purwanti S.E., S.Pd., M.Pd.', '$2y$12$5sScE64swA1GwFjuK1t/eeBfG9/YbUr8HM5eNrAiEb8uncsVzi7K.', NULL, 'MIPA01'),
('200110171987121005', 'Cahyadi Najmudin, S.T., M.T.', '$2y$12$BHyTlqzASliluBWyiqThCOMxyTTeRbuRHTIZBzASvMFuUXU1nXm2q', NULL, 'TIK01'),
('200304202000101012', 'Vivi Chelsea Farida, S.Pd., M.Pd.', '$2y$12$MYoe8Sue3oPUxYUUi0Zu4eR2MaQzwRztiGsWfgd9uM0CftqLA.v6i', NULL, 'IPPS03'),
('200707252014021015', 'Sabri Hutapea, S.Pd., M.Pd.', '$2y$12$DcqA0GVFAXMBexjoiCU4Qu4bUc.bZsy1f/XYdkwCfosexbFi0utO.', NULL, 'MIPA01'),
('200804281993081020', 'Artanto Vero Nashiruddin M.M., S.Pd., M.Pd.', '$2y$12$usBgsvhQxoyGoLShyltOb.TWwAKf9Y2fRsddAXelSst/d3bBA8KBO', NULL, 'MIPA02'),
('200905061990111011', 'Rahmi Hasanah, S.Kom., M.Kom.', '$2y$12$bL5MEksQ4At/Vq.l.EarIOvTL8Ir4G3Tz0EqSdYy6vnmX0sR6SM0y', NULL, 'TIK04'),
('201007071995052009', 'Aurora Suartini M.Pd, S.Pd., M.M.', '$2y$12$M4t5x5rfotFcjR1T9ij.pObF2Bg/H4rqsih2kne44sQ5RyMb/BN2S', NULL, 'IPPS02'),
('201108111971112006', 'Oni Kusmawati M.Pd, S.Pd., M.Pd.', '$2y$12$gEgkSq/7HLrx3KlXgAaQOuBnQHbwTuACUIXdviDxrPClzrwTZZQaO', NULL, 'BS01'),
('201203102010092001', 'Bella Elma Andriani, S.Pd., M.Pd.', '$2y$12$yQjA9P83kH9AMKfjLFgP/eHeT9VZ1lRojLgIeqE6fDwGpEWgtNzQe', NULL, 'BS02'),
('202207292012012016', 'Balapati Ramadan, S.Pd., M.Pd.', '$2y$12$iITh0zgg8S23qwlo3d0NJudGBFhpPIsx2/sR4kYa/2ET2dl81NG/e', NULL, 'BS02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_bimbingan`
--

CREATE TABLE `file_bimbingan` (
  `kd_file` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_upload` date NOT NULL,
  `kd_sesi` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `judul_ajuan`
--

CREATE TABLE `judul_ajuan` (
  `kd_judul` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_pengajuan` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `judul_skripsi`
--

CREATE TABLE `judul_skripsi` (
  `kd_skripsi` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_judul` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_penerimaan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_judul`
--

CREATE TABLE `kategori_judul` (
  `kd_kategori` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_bimbingan`
--

CREATE TABLE `komentar_bimbingan` (
  `kd_komentar` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_sesi` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_pengguna` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_komentar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `koordinasi_ta`
--

CREATE TABLE `koordinasi_ta` (
  `kd_koordinasi` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_prodi` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `koordinasi_ta`
--

INSERT INTO `koordinasi_ta` (`kd_koordinasi`, `kd_prodi`, `nip`) VALUES
('KR012016', 'BS02', '202207292012012016'),
('KR021015', 'MIPA01', '200707252014021015'),
('KR041006', 'MIPA01', '177105202013041006'),
('KR042002', 'IPPS05', '197007231972042002'),
('KR042013', 'MIPA01', '200107291999042013'),
('KR071010', 'TIK01', '197305031976071010'),
('KR072004', 'BS02', '197602211995072004'),
('KR082017', 'TIK04', '198408032000082017'),
('KR092001', 'BS02', '201203102010092001'),
('KR112006', 'BS01', '201108111971112006'),
('KR121005', 'MIPA01', '177105202013041006');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `npm` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kd_prodi` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `nama`, `password`, `foto`, `kd_prodi`) VALUES
('202333500007', 'Natalia Yuniar', '$2y$12$sz.lr5ktiMvAFWVl6/KJe.WaLDAJQhazLqxL5KSwSJO7glqmynl/e', NULL, 'MIPA03'),
('202333500011', 'Galiono Pangestu', '$2y$12$YhUTuKs/7ilFtothV6xhfea4AYYpK/4zIaoBPHVoeyR.WJ4LT0Gbe', NULL, 'IPPS04'),
('202333500016', 'Pia Siti Hartati', '$2y$12$0qd1oV8YL1SLofE16d7Re.xOvs1dLi68H1BnR/ks/sU280Ocq5Vs6', NULL, 'IPPS05'),
('202333500025', 'Atma Marbun', '$2y$12$jXiFyp2Z8CBtZGL30njT7eqYPRVKOPhXWxukEjEgxDDY.BMkHVDau', NULL, 'MIPA02'),
('202333500037', 'Ilsa Kartika Wulandari M.Kom.', '$2y$12$7M.KAKG/s67ckA0noYaPOu/65ZEGUPOwe7dNE3AqNE2HcgnyfGQ6G', NULL, 'BS01'),
('202333500044', 'Kamidin Nyana Wahyudin S.T.', '$2y$12$a6CpQqY5si/a7hGlJf5eX.8xD7js3X9wyLDewCRubPTr3v7e4lSfG', NULL, 'BS02'),
('202333500052', 'Damu Uwais', '$2y$12$QyBtcrIAvcnWw4GFO1xGLukpNrjYs8bWeE.peEJaGhG/Dj2woRDKa', NULL, 'IPPS04'),
('202333500053', 'Wasis Hutagalung', '$2y$12$DoQk9N4rA1nGDjqET09MXeBJK12nmUrd1/jBCXpHVJeUliaErbGAG', NULL, 'MIPA04'),
('202333500054', 'Warta Aswani Nainggolan', '$2y$12$jMXEbKztOwMGCmgCDIVoueGJqaNbe2PNgHvvEiv.3kHOXAWbOckFO', NULL, 'TIK03'),
('202333500059', 'Ibrahim Hutapea', '$2y$12$SiuCcZLJau/VQCu24Ll7ieKh9opmVPWFY/wPjs0a..rbPFrbqDMT2', NULL, 'BS02'),
('202333500061', 'Prabu Siregar', '$2y$12$VGA4lEw//RZa4gACNPUWDOKXWLjtYUg6Fm96q58D9lRhT9dtRDTR2', NULL, 'TIK04'),
('202333500079', 'Cahyo Situmorang', '$2y$12$SymabpSF05gs6lXXQfcXnexBbr6cfco6woXDaKYhSs9A0HHN0zUwu', NULL, 'TIK04'),
('202333500085', 'Raisa Iriana Hastuti S.Pd', '$2y$12$VaxTZJYeXJY8KNiKMYlJvur3QYvqAEX3daAghBz8pX9fjixWEBAT6', NULL, 'IPPS03'),
('202333500089', 'Eka Winarsih', '$2y$12$a0k7tdUnNJCsGOhyepxj2.y3GCfK3MxngKpFXc6xxUo3EaDU6/R8C', NULL, 'TIK01'),
('202333500093', 'Gina Haryanti', '$2y$12$s1M2CfCxhxliOWeLjZmt/ezs.5n0xYTPoonb.117P8hbuDTLcZMl.', NULL, 'BS01'),
('202333500094', 'Sabrina Lestari', '$2y$12$EwqtOVGM4px09cc5trVJzepZXEDGs7qdAFuePqCK/CY7rvrgXaynq', NULL, 'BS03'),
('202333500111', 'Alexander', '$2y$12$xq4SXfXKtqu1C.gPPw46Hemz9IRt0dRKcm/g.PyFo1RhufrKyDX2S', '', 'MIPA02'),
('202333500112', 'Hana Pertiwi S.E.', '$2y$12$N/1R7d3Cc7ed4M6dybYJ7el/ow1y3.BhYFIeXZua6oavZskJQof6W', NULL, 'MIPA01'),
('202333500117', 'Opan Cemani Gunarto', '$2y$12$iqJB/LRvpT0w5.Rw7E5JO.vovl77/kMme4/4hPQxRK2dDtD9QzZB.', NULL, 'TIK04'),
('202333500121', 'Gading Najmudin', '$2y$12$tzziS8NVdNWOlEgtYbBS2e2AAJHvjiwHjrUni2P8PoSqne2BPuWiW', NULL, 'IPPS05'),
('202333500123', 'Irwan Nababan', '$2y$12$bgV7ThJ0IW81.ZKlVxz/v.p5A.bCAMz99Ki44e4NXa3lNLPkf5m7.', NULL, 'TIK02'),
('202333500124', 'Suci Laksita', '$2y$12$faSyhfJ9RbwWSKfDY96XfOjlLY7xpYdhTbfyFeV6fa8ViXT264eSe', NULL, 'IPPS05'),
('202333500129', 'Betania Andriani', '$2y$12$A6Gde8tAA5HB1E2hPiZiHOCy5dlD365I9Z5vpsqIoaWkrsMpEhfCK', NULL, 'MIPA02'),
('202333500130', 'Gilang Artanto Tampubolon', '$2y$12$piEHw5Ahp5wxWgosUmxNuueZRrjFFepjjcrk6yiMIroVizK0s/6XS', NULL, 'IPPS03'),
('202333500139', 'Julia Fujiati S.Psi', '$2y$12$DzGdzkrI/JpLsP/b2Hi/PuNvctwZpYN1U5UPteRg6PSFOohLcZgO6', NULL, 'IPPS02'),
('202333500144', 'Ade Aryani S.E.', '$2y$12$/soP8OELh/rx64FGfqb2eek406W48vNL2xJyxsvZxu5nT9AaUiGvW', NULL, 'BS03'),
('202333500148', 'Michelle Sudiati', '$2y$12$J6Xe34JDAuqDowLpE2MnJOjsZV.gyTLs1UW5E9seFuwm.MbpJL4xy', NULL, 'BS01'),
('202333500150', 'Mitra Habibi M.Pd', '$2y$12$JIkA1fw6gM2PDQYiUZim2.7s4yD0NraaHPlCzo65JHiY0/OkKIIhy', NULL, 'MIPA04'),
('202333500151', 'Asmianto Lulut Siregar S.Pt', '$2y$12$gFQemQM9Q6NhZ4R9CM0iK.AjCdD0m7Jl9EAtHLNyhrl8tpRhGHyiG', NULL, 'IPPS02'),
('202333500154', 'Ella Purnawati', '$2y$12$tK3HIDQ8jQPgOgjQ6YLtze/JjHRbWtdKauMoQyzMKjLl4/87SrO86', NULL, 'IPPS01'),
('202333500155', 'Victoria Safitri', '$2y$12$IetXQ68onYEq8nqXJem5..WpMAfvrZX.a5PIFgeFLYAd/0oRHSQpu', NULL, 'TIK01'),
('202333500157', 'Halim Jailani', '$2y$12$KihFomw3fFKWCCh8X93Hf.1.6kHOpBCbN5LLkNnVRQZRQECbn/coa', NULL, 'BS03'),
('202333500161', 'Belinda Lidya Winarsih S.Pt', '$2y$12$zjFI8ciNbHuUPiDNSOopfekzPmay94OL/jxCPf.zp2AAJXKLvVurm', NULL, 'TIK03'),
('202333500162', 'Makara Saptono', '$2y$12$71FYx.1Ku/INeM7AwBEFjOfLDg6vbMrdMZwoQH6rGdP9/zdwru/iy', NULL, 'IPPS01'),
('202333500164', 'Mulyono Mulyono Habibi', '$2y$12$vNv.boqYBtIIsGhHj6pl/Ox0dsFARu5MmHn7.p7FjFknweVhFwY56', NULL, 'MIPA02'),
('202333500170', 'Hesti Puspita', '$2y$12$/peBsJIZfluFNDeUqdn0auesH6csCIkbWnEe/yAow5pxebK6kNr0K', NULL, 'MIPA04'),
('202333500171', 'Gasti Umi Kusmawati', '$2y$12$cGEo1IrpfxV2y.i0RNZisuWFC46cU7.c2ZGJ.0EQxOP4fzt/rPK1y', NULL, 'BS02'),
('202333500173', 'Qori Farida', '$2y$12$4/RxtflHyGQ5j7eXCJ8/SeqYDqEXrokviIuPk8P29tGMEaOZzcttG', NULL, 'IPPS02'),
('202333500189', 'Sadina Safitri S.Sos', '$2y$12$JIS7ZCAMjwTKSe5iDA36QeF3xnztOyOSLBSI9bwBFTGCATr0zKLp2', NULL, 'IPPS05'),
('202333500190', 'Gawati Uyainah', '$2y$12$wwt.IwHD3ELhaTsE9.2q2uNRH.bUV.bmq100/QqhHm.mqIqURFDty', NULL, 'IPPS04'),
('202333500191', 'Ida Aryani', '$2y$12$ZJbUBOmqwV4X5ut6d0i.SOsqtUkJCcx4fqWDiHYZguwVdoVTIJt6.', NULL, 'IPPS01'),
('202333500198', 'Saiful Prabowo', '$2y$12$jLT7v8XyCvFmOs.lvPpeK.1oN1aXVLqfkmcreH7HVOYyun8n82o9a', NULL, 'MIPA03'),
('202333500215', 'Kamal Jailani M.Farm', '$2y$12$.4e6x4rhlWCWUkm2zbhru.vUhD1rxtSQtm.UHSUIFKdhrbL0WS9by', NULL, 'BS02'),
('202333500216', 'Galuh Gadang Latupono', '$2y$12$5bQVUdEfHSy8RiiltglCpeDKoC3Yr8IE3TqEoxVBpWIqodOrqHN4S', NULL, 'TIK02'),
('202333500217', 'Banawi Maulana', '$2y$12$XCb3vkfwd9C.es5Gq4AhT.ZlPHHefQHhQEbtuq30D7GMctl5i7s7m', NULL, 'TIK01'),
('202333500221', 'Pangeran Murti Rajata S.Ked', '$2y$12$/5ssKD.od2EEMt/nlaMc6OtvV9x99p0HiK2raJbcZciq/Sxl5BJaK', NULL, 'IPPS03'),
('202333500222', 'Suci Sudiati', '$2y$12$WwNIp/5umiLMy4AZiNxjPuLz4FMo50Msa7HJnwWAgOq6vqTWTCtpO', NULL, 'IPPS05'),
('202333500225', 'Zulaikha Violet Pudjiastuti', '$2y$12$JGau9g6Y19aJmewril8C3.z1Ms39xXIDOCyMF2rXkmzg/I69NxQtu', NULL, 'MIPA03'),
('202333500228', 'Nilam Laksmiwati M.TI.', '$2y$12$hRyWuWAsXn1VjDtd6zUtsOjvigXk9hg05quRAbx7irwF67U5EsEay', NULL, 'TIK02'),
('202333500229', 'Mulyono Mustofa', '$2y$12$zNMiV7CWVxSkj5u56N1gNubziCTvJZweLFrH63Tufl2VdOuanu5KG', NULL, 'TIK02'),
('202333500232', 'Iriana Anastasia Agustina S.I.Kom', '$2y$12$8RZ7WNiuTUzuTpVpdSEnZesvAxCYLfJMFwULLPjf.LoGOdCHiZouy', NULL, 'MIPA02'),
('202333500235', 'Karen Usada M.M.', '$2y$12$3DgXtrniaP9wXqWywu6xzOw740l.O6svsz5wR4drLy1OUKL4DPpJ.', NULL, 'TIK01'),
('202333500241', 'Edi Maulana', '$2y$12$limHYm/WlKviPabaFpIahuwxchKC65ZEsmwUkGy3Ka.NIQ7RmR9jO', NULL, 'IPPS05'),
('202333500245', 'Cakrajiya Narpati M.Pd', '$2y$12$6JtH8uaDRel/Lkjr90Cbd.gnEbxXbowjxDyX0z5YJbDDgoZvBUH1m', NULL, 'IPPS03'),
('202333500247', 'Balangga Nyoman Sitorus', '$2y$12$mbwqf5AlhN7IoZhj7jYv4.7aYH9MpsDaxQApO6B1aj6FOjYrxhJt.', NULL, 'BS01'),
('202333500248', 'Prima Banawi Iswahyudi S.E.I', '$2y$12$12yKTOeTKR9M.lDeCFf8wulfMTjCf6UuBBIwRDlOEYBFp7eDlaL/e', NULL, 'BS03'),
('202333500258', 'Taufik Tugiman Salahudin M.Kom.', '$2y$12$MLArPwH7xGN/exIB6LCAOenn69QKBgm5M9tK/6y3kMC7sKdWnNYje', NULL, 'IPPS01'),
('202333500280', 'Dalima Oktaviani', '$2y$12$Cz7EeXMBUmX.CZzvTOrHwewPzxIntidEgfb0Clfa1gHZGiKYXtJOi', NULL, 'IPPS04'),
('202333500281', 'Luthfi Wasita', '$2y$12$xiL9nlkNtIiSxH.ixjccyuWWjG0OAfnlaQBK13ojkwKdzSnXBFxau', NULL, 'IPPS01'),
('202333500284', 'Lurhur Cawisono Napitupulu', '$2y$12$UDZ3DyGBHvuQVVsCD7Kc6OWMOEytDMzJ24WGiyuj44gOMTceVLdmO', NULL, 'IPPS03'),
('202333500286', 'Safina Uyainah', '$2y$12$fQgvumGaQwRLKR97c5lF3ecuF/mbg78Gdp6O9zqgix77wxgOc0JMS', NULL, 'TIK04'),
('202333500288', 'Harjaya Ajiman Najmudin S.E.I', '$2y$12$mDPN3K9hjsK7X2QVfDkBj.lw5QVT5zFHOfDfRWv0EcFIPhvmSqxva', NULL, 'IPPS05'),
('202333500298', 'Vicky Vera Nuraini S.IP', '$2y$12$/NyYwM8pZ.PmWoIBWzMaoOJ6w019hxZTZsWnFY5oTgOAIcqhmqTt6', NULL, 'IPPS02'),
('202333500299', 'Yulia Permata', '$2y$12$GCDRWs2T7Fbq4vis4zsEW.zxYr/WiiSUClNW8yYjkss3Px39gFYTW', NULL, 'TIK01'),
('202333500306', 'Jagaraga Natsir', '$2y$12$fJ01/apX.6/ILhUVXXU5Yu8VVztiYTaHapIWaaXBww2PCeqBL3GzC', NULL, 'MIPA04'),
('202333500318', 'Chandra Baktiono Permadi', '$2y$12$wWZzV28jzcR.zknqAtxNROevnQ7k.O57OY8kAMaj1FHGsPLCqrJZu', NULL, 'BS02'),
('202333500324', 'Darman Budiyanto', '$2y$12$fKo2bYfNsBK4ctVUX5WBEetGUFxB31KrjPUVYidmqPTpdaA8E6X3y', NULL, 'MIPA03'),
('202333500325', 'Victoria Hariyah', '$2y$12$Esty5LX9YsK/buXIc5gX0uT4Q.RHO9FBo/qVTy9sP0qaWCZtHZv.e', NULL, 'TIK02'),
('202333500330', 'Hendri Wahyudin', '$2y$12$QqIg48I0.4yhJUUWfhNnO.TEWorxmeDmdCOIPImcV4U8ZFFKnGydy', NULL, 'BS03'),
('202333500334', 'Febi Zulaika', '$2y$12$tgvEV4tBzyq8CNzEExBA0uW88lddMC36NJLH2JObbEh6NkgBWtPOm', NULL, 'TIK03'),
('202333500335', 'Bakidin Tomi Suryono', '$2y$12$2bgnQBA4QA.Yt3CPpnBPa.sA9McXx8F4NE2C/9tWcviOgqTRnZSOu', NULL, 'TIK01'),
('202333500349', 'Bakda Salahudin S.Psi', '$2y$12$KtqWCcx5g/5vUjENngS17.TEQRCzfdFym5wCQgBlGN0xSIxLVlUE.', NULL, 'IPPS04'),
('202333500355', 'Cahyo Paiman Wasita', '$2y$12$p45Ho7KShW8KAg014ojnGOEDt4fOP5otH059Y51HG6yMq1yr1K9Ha', NULL, 'TIK04'),
('202333500359', 'Cahyono Hidayat S.T.', '$2y$12$8AF5NJ1ur8AA2apB9Stt4usQoPkqxnxveeeIJga6Da5fzSMtDlJ2K', NULL, 'MIPA04'),
('202333500362', 'Rendy Siregar', '$2y$12$mBrdKRzm2qONXPo66OdgJO74EYOEXqwKGfBCqng9vjsI1FdXprBi2', NULL, 'BS01'),
('202333500366', 'Cinthia Cici Safitri S.Gz', '$2y$12$/zV6uXyuAz2IdyKx3Ehtoupn1Wp9VaumuEMLXc9sQeW94bSayAzcS', NULL, 'BS01'),
('202333500369', 'Muhammad Saefullah', '$2y$12$/SKjJG/ao7pJV.Rc3a/ttOnId9S./B6CaEm7IqNmMuq3YvIn3n4A2', NULL, 'TIK03'),
('202333500374', 'Oman Tamba', '$2y$12$tyuZZc7lLB7rFbYhaXineuVdjWjtd3ZfaugeAmzlcHczCqlMP3ZC.', NULL, 'MIPA02'),
('202333500378', 'Zaenab Putri Fujiati M.Ak', '$2y$12$pHRjzeqovh1B5C1yjWYZ9.6oVHagWVUtWLx7JiNwRdveFMVBHOmb6', NULL, 'BS01'),
('202333500381', 'Fitriani Agustina', '$2y$12$kof.z5LD1L90/VWbY9UAiutwMDQkodxeFPkpstI/SfRTBjT4duzUa', NULL, 'MIPA03'),
('202333500382', 'Dacin Dabukke', '$2y$12$/3a/ude0FP8w01R3NRG7eeCtfuAkdiSOSsmFnTcL3au/bq6FGLSoO', NULL, 'IPPS03'),
('202333500396', 'Taswir Widodo', '$2y$12$0NwmJqIyDee1OdiTHlsEu.k9.gn6hHyYgXgWLR1DZAKpfuNKYCq.m', NULL, 'MIPA04'),
('202333500408', 'Mila Mardhiyah', '$2y$12$PlW93NaN9FdoHO8qWUXZ2uhBi.nw.RgFGc1jFwsWm3aC520p2g.ey', NULL, 'TIK04'),
('202333500415', 'Kasusra Drajat Siregar', '$2y$12$fT5IVX8F.rZ.HARPj9PsOuW4cqCA/.OylPA75b.SdihPMdlyGEkfe', NULL, 'BS03'),
('202333500422', 'Gamblang Mahendra', '$2y$12$QBch9v/SmPdtocvRpcXthuBYtwVhgRpoTVifaPy21r8feI2p5kSdG', NULL, 'IPPS02'),
('202333500423', 'Budi Gandi Winarno M.Ak', '$2y$12$REj/tnA9mhBP7EvuUezCX.RY8A5/hDLKNa0vpjUHe4qw/NBsRvGyG', NULL, 'MIPA03'),
('202333500435', 'Jarwi Adika Tarihoran S.Pd', '$2y$12$r7P6KwVJ6eIMaGRBGC7uVuHg/XBCwLjbGpK.wfnAmwtrFYznA7U5i', NULL, 'TIK03'),
('202333500436', 'Elisa Hasanah', '$2y$12$oF8wim1HXGHCpO0WeqBuyuEb9x13UnHg1ajemPHbbW4LX9wRw9o1.', NULL, 'BS03'),
('202333500440', 'Kartika Yance Sudiati S.Pt', '$2y$12$3zSSyIjTom1O2Yh/.0jQLecinD6yJksIphfHtfogmLSo8SWUl8OWa', NULL, 'TIK01'),
('202333500441', 'Bancar Cecep Kuswoyo', '$2y$12$8cScMhD8228DY0pvSyjyheWlxqAZNHtwUSGFd7qZ0Sa9o6g4Trwn2', NULL, 'MIPA04'),
('202333500444', 'Pardi Simon Nugroho', '$2y$12$bj4ItL4lzGFVCxk1fY1EJuHJpc9LymQ7hwlnRDvk8ad1WVxSbWOIe', NULL, 'IPPS01'),
('202333500446', 'Eman Mandala', '$2y$12$5TdDkQcu4QGN.bWPuiZIbulp9kLfPtnGMF13BuOG8lcN3aM8SNnM.', NULL, 'BS02'),
('202333500447', 'Arta Mansur S.Sos', '$2y$12$gXiwO06mqx923/Yove8yiumXTtSIbD4zR4WdNsWlMAleh7x6V/mKq', NULL, 'IPPS05'),
('202333500449', 'Dinda Laksmiwati', '$2y$12$.XYqsExbvImk/apbe0sOQOQe6NdYn7WpPCMF8v7l8vE/tlVW.8Vna', NULL, 'IPPS04'),
('202333500455', 'Putri Padmasari', '$2y$12$O39X/FOYSJ8A2lwmJyGHIeC1H1CeeKMPfsK/ubbnjvmiKtdu22zjm', NULL, 'IPPS02'),
('202333500460', 'Jefri Oskar Santoso', '$2y$12$hyXw46tZZve1V/YBk0m0RubkxU/Ad/HJbffGNkVs5W.1l.w5t4uay', NULL, 'TIK04'),
('202333500463', 'Bakiman Prima Napitupulu S.IP', '$2y$12$2gRJ8yJrlCbC5U7gw2JFEeAahsRXMSChgrD6mccoujb8I/MouvQTS', NULL, 'IPPS02'),
('202333500467', 'Bagya Daniswara Winarno M.Pd', '$2y$12$Uq3WsEaBaOSIbAQYju4u/uZ9lG0QoRgP.zBDduISCnx8LNMsM37V6', NULL, 'IPPS02'),
('202333500473', 'Aisyah Namaga', '$2y$12$FwZq1V5bGcK4fgXeoMjcTefgUQQn7jr/kTfGTJkPufzOnG5nOsthK', NULL, 'TIK04'),
('202333500477', 'Asirwanda Latupono', '$2y$12$F1OQf1DJtubSl1yEqwULl.2sfnb1QoYUa.GrQptbYVebd9kgpOTLC', NULL, 'MIPA04'),
('202333500487', 'Hani Zizi Uyainah', '$2y$12$JEsjkO31x6zaYIIK74dWruhmmzZQR/uGtWMjkX.S8E32CD9ZoJzua', NULL, 'IPPS02'),
('202333500495', 'Ayu Belinda Yolanda', '$2y$12$Cae4LXIySXB9ITQj8/kaQ.GGCzhG9SvruLPGTCQAnx8mf61tdAH4a', NULL, 'TIK04'),
('202333500517', 'Ivan Wibowo S.H.', '$2y$12$mGobbvRYmDbAzs6t7HHyHu9pGQqm85uCGzOypTTFOOr1vx87oKe66', NULL, 'IPPS02'),
('202333500526', 'Malika Fujiati', '$2y$12$P7/s2gKCJxe7JXyrPPnNLOfI3Jz2fSxHrHgnTKgBqejuHxt5NfXAW', NULL, 'BS01'),
('202333500527', 'Yuliana Hafshah Yuliarti', '$2y$12$v4J5UZWAy5hnkgCd9pbBueRbPib9wmWKJfKMhe8siTytNvE0f5qg.', NULL, 'MIPA04'),
('202333500542', 'Diana Yuniar', '$2y$12$fGLpOv2MkqvBB2xPm2PhXeO2k7KxK0U37rzyQhPY1piPm9yOYYvHS', NULL, 'MIPA02'),
('202333500544', 'Lalita Ina Purnawati', '$2y$12$aJYO/ZrpaSR5GEvTRuJZxu7PRHNj5EmGwMJrVzXE6KJ2lFnq1RjBe', NULL, 'TIK01'),
('202333500547', 'Olivia Dalima Hasanah S.Sos', '$2y$12$3TobdneVKRc3YPRZLW9WHutzkfCuIECN2EOG3cSOfxv0F4BJ4udnm', NULL, 'IPPS02'),
('202333500552', 'Rosman Pradana', '$2y$12$oRnIc3WdeSYmMJehN0HQfuXnPIFGt9OBO9ilCh2.339ON0ZGSxUX6', NULL, 'BS01'),
('202333500554', 'Kenzie Kusumo', '$2y$12$VEgXIPMUUv0HQLecP46nQueKMo/w9gt.1l2ZBFrLsu2EhsaaIW0Xm', NULL, 'MIPA02'),
('202333500556', 'Cahyono Dipa Damanik', '$2y$12$EnMnx6dASTwSJ51ftOpxbeqss3AM68Ukrt.0m1WvZ415JcvaA3aKO', NULL, 'TIK03'),
('202333500557', 'Belinda Suartini', '$2y$12$heXWfFIbv7B1iFzo9k4EI.11l394SblAqKNSxOPYX8EBnP52Ybfzy', NULL, 'IPPS05'),
('202333500564', 'Farah Sarah Sudiati', '$2y$12$wFKb.TomRd87dTDWqZSVD.XAFxJpfLoVjJd6/BK6At59GO5TctIXa', NULL, 'TIK01'),
('202333500569', 'Cahyono Cengkal Lazuardi', '$2y$12$zYmA.PHVxJyCDS9cyj3kPumsCZXprXBx6pW6gF9pVzlOOFe5IYLHm', NULL, 'IPPS01'),
('202333500586', 'Adhiarja Sihotang', '$2y$12$Vj7UNXxuSgAZqi.U/8CflOs8bHK8DOgiBMaIC7TreMzUZzh/Nkjpa', NULL, 'BS01'),
('202333500590', 'Olivia Karimah Hastuti', '$2y$12$gWjhATBEnMbLIfZRqdhGseOx9vux.xQl/gTSuvHQZJeH.QEi7snqC', NULL, 'BS03'),
('202333500595', 'Martaka Situmorang', '$2y$12$OxHdkvUs3htCfBLeydls6OuHede5jt0YS/Lf7HjWYtQpkC7GcVsF2', NULL, 'IPPS01'),
('202333500598', 'Elisa Purnawati', '$2y$12$YrPiD.aqrZJwuGKWXnP2R.dmx2UuBcAdCq4pb3oMn64zGcuSnnhHC', NULL, 'MIPA03'),
('202333500599', 'Kasiyah Betania Usamah S.Farm', '$2y$12$tsKDl8iKbpZUCBlCm94X4u9iedkD6tT0kEohJ3ZztqVFfV39agNfe', NULL, 'TIK02'),
('202333500608', 'Mahdi Marbun', '$2y$12$vVeusYxLfHGLJQVhzCiWQ.yfx9aVeXe0atOzPHn1fsSFLzHQP9bea', NULL, 'BS02'),
('202333500611', 'Clara Ani Yolanda', '$2y$12$JW3jsLYkxLz0BN5x64ktGuIcRvHwx6GJrCmlBI3sEnxCWrNb07UXq', NULL, 'BS03'),
('202333500612', 'Lili Nasyidah S.Pd', '$2y$12$BQA8cfGLW.U9IFcjiE/RAOrj0cOLvXEp25YzbVc1ub..c6GDz38Ae', NULL, 'BS03'),
('202333500613', 'Yessi Yessi Aryani M.M.', '$2y$12$uNxAikF48SgpGEvK59IRCehVX47.KOFfLecrLCkLF9WMw/yyS9jGK', NULL, 'TIK02'),
('202333500615', 'Galang Prabowo', '$2y$12$4GvPkSG4ZlsQqx7Mh2qXDe7PkylywpaxC9nBW47pF87VrsWLA7Luy', NULL, 'IPPS01'),
('202333500617', 'Darsirah Pranowo', '$2y$12$Jydwmf8wseoRUh.EYKjwCeGXhRK7NNCNZ6Ue6Q.GutRg24jCA5sti', NULL, 'MIPA04'),
('202333500623', 'Endah Zelda Hariyah S.Gz', '$2y$12$kPuOUddE.6qSBrXzCS4vcOYyCtdW57Eu3FK7WBrlS4bg8mlXquWlq', NULL, 'MIPA04'),
('202333500625', 'Saiful Natsir', '$2y$12$1eoR/27TZ.Bu3rOfeO4yHuo9SHa9t95Yzb8mLZLJY9HD5jYoX7dSS', NULL, 'BS03'),
('202333500628', 'Zelaya Nuraini', '$2y$12$nt/e71I90/XO5UrBBQAd3u4258LWXY4bUetnX6fxU14OKQ5NSLkOK', NULL, 'IPPS03'),
('202333500630', 'Paiman Sitompul', '$2y$12$whbkaRenW1bj2MM8Hc4pQeKg3n1Fv8GkwVmrnbTKD54YBMFQB5Vea', NULL, 'BS03'),
('202333500631', 'Kamila Andriani', '$2y$12$vidRu0AoZeKPgmE0r0Lp5ej7cy3A4oihySDMVLWZYepmQRcBN7qYu', NULL, 'BS01'),
('202333500634', 'Kawaca Budiman', '$2y$12$AKSZ8FuI7ab1teTYhnzQ2OV3pr.6bq2b0ok5KrR2B5j/tMP7a/Flm', NULL, 'TIK02'),
('202333500637', 'Labuh Halim Prasasta M.Kom.', '$2y$12$bTGs.12JMGb.QBBXkAyEnOYkiaUvULji8T6BESQnGUZ55lusf5K.C', NULL, 'TIK02'),
('202333500642', 'Aurora Oktaviani M.Pd', '$2y$12$mtkGKDKbG8jWT0pftpirT.niNIyT36hz7yXA6xnPb3pivYsPoc9zS', NULL, 'BS02'),
('202333500643', 'Dono Darijan Simanjuntak', '$2y$12$Tsp9.1oC7yul3HhoRQIEX.xcJ5GRAN2geEgMeQXM6vF5hVppDi3My', NULL, 'MIPA04'),
('202333500649', 'Tania Winarsih', '$2y$12$BIK.UTVVxvRF14WgDDqqmunDdOGCPPAZz0FXfCejmOhX7ZHJuS30G', NULL, 'IPPS05'),
('202333500672', 'Harsana Gunawan', '$2y$12$crA0xt7NTBB0ZHBeMEdyt.QVQB69Zp.XWGm6WB.caJPWorT1SKxsW', NULL, 'TIK03'),
('202333500679', 'Ana Prastuti', '$2y$12$oi2bnylddPgzf5ifv8CMP.NY1lhxYqmSDM/wLrjRoXn/7Hl9TqynG', NULL, 'BS02'),
('202333500687', 'Pia Laksmiwati S.Pd', '$2y$12$Pgv/VzNxwCF8eU24464QZeAcKcx6EAXDoYzw2dHy2Yfe8YZix.LNG', NULL, 'BS03'),
('202333500690', 'Siti Titi Maryati S.I.Kom', '$2y$12$0Z8VEWfuc4b7H/2w2ch8WuPqt/wyGQ1J8ieiIW9giHawpuo5UBjoe', NULL, 'IPPS05'),
('202333500691', 'Queen Prastuti', '$2y$12$dmFKiFLi0hVLnl0ZC3548.XN2nSPlUI2iJvknyCIJJtgC4A.SwKEW', NULL, 'BS03'),
('202333500713', 'Ade Prayoga S.Pd', '$2y$12$AEp3m0aQ0d2TjSgUMdGK4uXzFsFBIYm4n4P3MCPlDywb7FbMVAsFm', NULL, 'MIPA01'),
('202333500716', 'Mala Winda Nuraini M.Ak', '$2y$12$PZYGgQhjm4hKEnuhV5d9m.Q8X5eQm9HQOHl01SJjTdbofjFeN6AuG', NULL, 'IPPS03'),
('202333500719', 'Vivi Novitasari', '$2y$12$H732QrRCcxpoWW25I/1T1uPFnQoM.3tNIgamN1GNyfVYQpVJLMWJi', NULL, 'MIPA01'),
('202333500727', 'Hesti Susanti', '$2y$12$q4RTWPjARa2REdqnjslur.VkseXsW45WAqkvWdsPL0UVxrO5tgi3C', NULL, 'MIPA01'),
('202333500729', 'Galur Pradana', '$2y$12$D28.40qFG1WHOfR5XwsNWOp931BbYVdjgo1TqYbdrfaPpPgbzPF2G', NULL, 'BS03'),
('202333500743', 'Bakti Kalim Tampubolon M.TI.', '$2y$12$ArbAa.rGdoSFmSt2fIczL.1J/u43XQ0G7OerdR01Pjj3oOx876r5W', NULL, 'BS01'),
('202333500747', 'Eli Yance Laksita', '$2y$12$oQAg6S7/59s6jR3dkL6Wk.ONSrIts7U0MhrKKkXA8/uRnShBw8vTm', NULL, 'BS01'),
('202333500755', 'Jayeng Santoso', '$2y$12$3y6FH33gkEzw2btf1AqQLu9VvAMQeAn240wAiIMTbX4x4r3vNfiR2', NULL, 'MIPA03'),
('202333500756', 'Suci Mandasari S.IP', '$2y$12$RY7J.CP1pM2KWDodak011erdKDrKtxM9RLiBePJBjcDfMI3iqgmmG', NULL, 'IPPS04'),
('202333500770', 'Luwes Harsanto Irawan', '$2y$12$hcN79NojyFQA4Q9ad8OU6.lgz0/bu29VqAwUnluGTFGcfC7s/8z3W', NULL, 'TIK02'),
('202333500772', 'Puspa Kezia Aryani', '$2y$12$6nvnlX85/oiEgmcGAS7IvOU4Bmw0elNemmd/8D76T/09k/31GVHAy', NULL, 'IPPS03'),
('202333500779', 'Adika Reksa Gunawan', '$2y$12$gttppDjD14QUUpR1QnCiCurLGG3437JY8nSuh3rGXp4fxia9vUhjK', NULL, 'MIPA03'),
('202333500782', 'Darman Ian Waluyo', '$2y$12$qaydrVdl.Ho7Mzt6bk5lOOXBMIwUBh4keydeYZ.2j6/jJ93gB3.jy', NULL, 'MIPA03'),
('202333500786', 'Raharja Sirait', '$2y$12$Oto/bpJQvSFaDHzCTBmnoeOX5IiCNivLoUxFZaSq6miGmvVcWYNqS', NULL, 'MIPA02'),
('202333500789', 'Zelaya Usada', '$2y$12$rtvNPYDbDCxldxHM9BfwWu1z3vw5pp02fetR7lypYVAISHfHFeXs.', NULL, 'TIK03'),
('202333500790', 'Anita Nasyidah', '$2y$12$Yvxy67MBzedaepzRWDpqHOGeoOPQ0mZga4g8jSwyHu2bqhyQX8lGu', NULL, 'TIK02'),
('202333500791', 'Hairyanto Waluyo', '$2y$12$ds/R04qXI2fAVM82dfp5WeECzIfOjUKSm99tu0EWAT2w4NNCktOVO', NULL, 'TIK02'),
('202333500792', 'Warsa Prasetyo', '$2y$12$PN4dCyz06fHlj/jgkHWNw.jv8Vks/mHxuux1xqYhUXlw3jkMsTkf.', NULL, 'TIK02'),
('202333500807', 'Wirda Purwanti', '$2y$12$tbtvjsJY.3/4aY1II.mEse0XhsZ7/BZPE42dsi8/r917wyyfA55ce', NULL, 'BS02'),
('202333500813', 'Galih Ardianto', '$2y$12$.6Q.DKQ24/k6jY/l3UmxLeM5w6GSnEkf2Djh/Zp3dzrdqTfDMLlMq', NULL, 'MIPA02'),
('202333500821', 'Gilda Halimah M.Pd', '$2y$12$5rJFR.Cs/rWNI5Rk4UnF4ejaSvZfU4urlyxk.gIVBrnZ5nQiGU4lK', NULL, 'TIK03'),
('202333500824', 'Aisyah Betania Rahmawati', '$2y$12$35c5Qb9vhFxv4W0byFSG3OB3rhARpFK023i1hP7y0qKYN4FSeptNK', NULL, 'IPPS01'),
('202333500825', 'Intan Mardhiyah S.Farm', '$2y$12$4DPWM4AIjbjZQ0iwQEw2uuUV65.Tb1MgC.lRzUUI9duFLWz1aY8/S', NULL, 'MIPA04'),
('202333500828', 'Danuja Aswani Maryadi', '$2y$12$NzWUNaiZ7Q5JiSXOe5FREOLoQIWzTRzWQl9ZwTp.cRZHC5olXaC3q', NULL, 'IPPS04'),
('202333500829', 'Hamzah Adriansyah', '$2y$12$qREVoVtf7mYYcUXAhm9tSe81GmKtK6MbkDEpDdN0dpt0taC5G5ZF2', NULL, 'TIK01'),
('202333500848', 'Aisyah Zahra Pertiwi', '$2y$12$g53pz4rvsshU8k0nzGFG1.S0bTREIdhbBWHkT6Zbd6DeiqH/B/YVK', NULL, 'BS02'),
('202333500858', 'Zaenab Iriana Mardhiyah M.Kom.', '$2y$12$ScOgpbJlFq0YcZGOh8cNs.ryW9WPhB4ZiLuBrzZ34CBpYHIX2sL5a', NULL, 'TIK01'),
('202333500864', 'Lidya Hassanah', '$2y$12$RkIA695J.lRYNTYCbYDZKeVy4DdQnz2J9osMA.lNmQyVB/sndJfmi', NULL, 'MIPA01'),
('202333500868', 'Bella Handayani', '$2y$12$LrpjMFyGt4E8GBr6/iGlluL9lOywNe4HdsxHEKwTBwqR4tcsaxfcq', NULL, 'MIPA03'),
('202333500870', 'Karsa Darmanto Adriansyah S.Farm', '$2y$12$UYbqezBwJ6aQfgYVCvssAeAhx6pBlaYQaGderELcgPOS18OImzMam', NULL, 'IPPS01'),
('202333500872', 'Hesti Hani Purwanti S.E.', '$2y$12$38IPFs7TCeh2zgafrrg/vu537f5hAOFmwSyHUa41bFeSu53K0bZt6', NULL, 'IPPS05'),
('202333500876', 'Galiono Nashiruddin', '$2y$12$AdCxD7ASgZcm3z2tCCBHY.in96Vnb0k.ZWUePs3.W4ALS7ULQL9nq', NULL, 'BS03'),
('202333500886', 'Taufik Nashiruddin', '$2y$12$dEfAqe6JV4dDCCKouAkPWeLbvXr1jIJodYS2dbpJHABfUtw5aHtFi', NULL, 'TIK02'),
('202333500887', 'Rosman Galang Tarihoran S.Psi', '$2y$12$CnUaXT2hPtilXmunDVUnnORDgnMIfdt.tX.xMkGhj6.uplB2Q5XiS', NULL, 'TIK03'),
('202333500894', 'Cemani Waluyo', '$2y$12$CBLw6kMY2i/oVX96aa4TZe73eT1qcJBA1F4dXiZyK1dMAwA/ZCqm.', NULL, 'MIPA01'),
('202333500896', 'Ifa Rahayu', '$2y$12$g9q4VYnJoDmWfE3V7LRcm.9QCQFORzy0Afchu9Qpasqr06sD68SxW', NULL, 'IPPS02'),
('202333500898', 'Nadine Wijayanti', '$2y$12$KZq2aE7qwjs0czDbZKxRc.MOFFz47hL3hHI1FXIYaoHs./b0lrMv6', NULL, 'IPPS03'),
('202333500899', 'Gasti Mulyani S.Sos', '$2y$12$JzN2KlgvyhscO6lwLMH/Qe12f6ptFcU.ECgUBOnGFasS63vtPWS8O', NULL, 'IPPS02'),
('202333500900', 'Narji Tampubolon', '$2y$12$GBevSsoLDIhWvtXy.wxMwO1FpT6k9peDA4iV5rI5EIAu35rjst4JK', NULL, 'IPPS05'),
('202333500903', 'Carub Manullang', '$2y$12$mSfpQMYvturoQyM7MVWmm.N.RMRqZw5upCvzltDdWcjqcTKVhNmca', NULL, 'IPPS02'),
('202333500907', 'Aisyah Sari Kusmawati', '$2y$12$U/3rORUd/X3g57RaSXHXSew9HTHEpWdKUKtD1gAOmsQ.7DCOlJ14S', NULL, 'IPPS05'),
('202333500908', 'Mustika Firmansyah', '$2y$12$hY2qRf25ic9p0Masga2TceXXFbtYqRrNGiPG.EKe7JnmAp3To0iMu', NULL, 'TIK03'),
('202333500909', 'Hana Maryati', '$2y$12$ul7T1.oXzzR9NyhA6TNXjuaSIGF.IX4u1Tg.OioD0.WTLCE55Itau', NULL, 'MIPA04'),
('202333500913', 'Ami Mardhiyah', '$2y$12$303yOMlcDCYuSlfjQGgIluogds/9hok34JInGBek7NkfZphGB6aea', NULL, 'TIK03'),
('202333500917', 'Ophelia Laila Laksita', '$2y$12$I4/iRQvexVTpYcAtv.B76O7jqugm9tQNT4orXteJDgRzjiGMtoY.6', NULL, 'TIK02'),
('202333500918', 'Hairyanto Manullang', '$2y$12$xnVqfNfj1.qeHKw9bpp5VuSdQDcLSKbgkXEFYSsr.mzTJ9dNyFtg2', NULL, 'MIPA02'),
('202333500919', 'Cahyanto Suryono M.Kom.', '$2y$12$J0Q3tYWrh3PHNGc04UiGDOInlAopUyQy7coVm4CTbwrJb2wWfBAv6', NULL, 'BS02'),
('202333500920', 'Jayeng Dabukke', '$2y$12$33WMGkS0m3LbUYiyQRax0eWh4.ZMPzYXPlAe/Bui7bnzWVgx.x77W', NULL, 'BS02'),
('202333500925', 'Drajat Edward Saptono', '$2y$12$sSWKBqv5Tx0lZZ8nPUEV7ugKy3hQRc.AtiDbLxp6BZBAsw6W/1cHW', NULL, 'MIPA03'),
('202333500933', 'Shakila Usada', '$2y$12$Dr9JNDhF3htq4iw.iQNo8uUuKddr0n2Vgy6y25s5WNss8SOqjgHE6', NULL, 'MIPA02'),
('202333500934', 'Rendy Mandala M.TI.', '$2y$12$xAzsNkcHscxsy4jEHbkN8OuZhraxqV5LQewEuxKQ6UD/LH8xnsGPC', NULL, 'TIK02'),
('202333500959', 'Paulin Cinthia Puspasari', '$2y$12$2FMGPNCpJo.R5EvqG6veWOe.V8Kp2VuGpOwjmM4nmMd6vmZUzVSLW', NULL, 'BS03'),
('202333500965', 'Jaka Wijaya M.Farm', '$2y$12$NI.TEySqYZ7ijUiIZUptIezBai9M8gnULiANtaLTD03cY9FzF1Sai', NULL, 'TIK02'),
('202333500966', 'Hani Wulandari', '$2y$12$udJnKDiODr9IsNUN2I1li.ixMfVeUtPPXIDk3RULetBZrhpIg5SQW', NULL, 'IPPS02'),
('202333500970', 'Jaya Gantar Lazuardi S.Pt', '$2y$12$I1IGkFJ7AmIpHckf4PmCp..9X0dsLOGe9RrSN9E0mCJ6EZ0i3wGw6', NULL, 'MIPA02'),
('202333500975', 'Nurul Anggraini', '$2y$12$wdcjuo7MsaFPmkkwsHm15.K85q7tRKWfuMmY224zx5OpWX0sYVxWy', NULL, 'IPPS02'),
('202333500979', 'Wasis Haryanto', '$2y$12$UGJyOrBZKbrtQvX4oNH6oOTFJa9i0DzzaYifp0emLW6DMTRaCp4dy', NULL, 'MIPA02'),
('202333500981', 'Lembah Bagiya Suwarno S.Gz', '$2y$12$I8KQCWteontZZXmWTQ2T2uva11ZC7NVvwy.fcokpRJDDJNt8P2J6W', NULL, 'TIK03'),
('202333500983', 'Citra Purnawati', '$2y$12$nwfrBYo3SFiyjGSJ2Zt87OzSGxfg.B/SWa6eoaNqWlr98oxtAlZxO', NULL, 'MIPA02'),
('202333500984', 'Catur Pranowo S.E.I', '$2y$12$ZbPiZIFBAEWKq6gP1uvXF.kVkHfeC0hZJOejJntisT/RBh8vun/m6', NULL, 'IPPS02'),
('202333500992', 'Mulya Maheswara', '$2y$12$4R8Txf0GL.cLEZN68YMxLejzSqFt/hHLgqaANQ/yd7Jw6/3omP9yG', NULL, 'IPPS04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_06_125222_create_prodi_table', 1),
(5, '2025_06_06_125240_create_mahasiswa_table', 1),
(6, '2025_06_06_125301_create_dosen_table', 1),
(7, '2025_06_06_125450_create_pembimbing_table', 1),
(8, '2025_06_06_125544_create_koordinasi_ta_table', 1),
(9, '2025_06_06_125711_create_kategori_judul_table', 1),
(10, '2025_06_06_125730_create_pengajuan_judul_table', 1),
(11, '2025_06_06_125752_create_judul_ajuan_table', 1),
(12, '2025_06_06_125904_create_sesi_bimbingan_table', 1),
(13, '2025_06_06_130058_create_bimbingan_dosen_table', 1),
(14, '2025_06_06_130127_create_file_bimbingan_table', 1),
(15, '2025_06_06_130145_create_komentar_bimbingan_table', 1),
(16, '2025_06_06_130334_create_pembimbing_mahasiswa_table', 1),
(17, '2025_06_06_130421_create_penilaian_judul_table', 1),
(18, '2025_06_06_130437_create_judul_skripsi_table', 1),
(19, '2025_06_18_102238_create_skripsi_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembimbing`
--

CREATE TABLE `pembimbing` (
  `kd_pembimbing` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posisi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembimbing`
--

INSERT INTO `pembimbing` (`kd_pembimbing`, `nip`, `posisi`) VALUES
('PB01100308', '199609072023011003', 'Pembimbing 1'),
('PB01201906', '199111061971012019', 'Pembimbing 1'),
('PB04100602', '187105202013041006', 'Pembimbing 2'),
('PB04200707', '199404201995042007', 'Pembimbing 1'),
('PB05200913', '201007071995052009', 'Pembimbing 1'),
('PB05201803', '198710091987052018', 'Pembimbing 1'),
('PB08102011', '200804281993081020', 'Pembimbing 1'),
('PB08102014', '200804281993081020', 'Pembimbing 2'),
('PB10101210', '200304202000101012', 'Pembimbing 1'),
('PB11100805', '199106261972111008', 'Pembimbing 1'),
('PB11101112', '200905061990111011', 'Pembimbing 1'),
('PB12100509', '200110171987121005', 'Pembimbing 1'),
('PB12101404', '199002032019121014', 'Pembimbing 1'),
('PB15100601', '187105202013041006', 'Pembimbing 1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembimbing_mahasiswa`
--

CREATE TABLE `pembimbing_mahasiswa` (
  `kd_pembimbing` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembimbing_mahasiswa`
--

INSERT INTO `pembimbing_mahasiswa` (`kd_pembimbing`, `npm`) VALUES
('PB15100601', '202333500111'),
('PB08102014', '202333500111'),
('PB05201803', '202333500324'),
('PB15100601', '202333500542'),
('PB08102014', '202333500542');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_judul`
--

CREATE TABLE `pengajuan_judul` (
  `kd_pengajuan` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_ajuan` date NOT NULL,
  `npm` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_kategori` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_judul`
--

CREATE TABLE `penilaian_judul` (
  `kd_pembimbing` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_judul` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `kd_prodi` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`kd_prodi`, `nama_prodi`, `fakultas`) VALUES
('BS01', 'Pendidikan Bahasa dan Sastra Indonesia', 'Bahasa dan Seni'),
('BS02', 'Pendidikan Bahasa Inggris', 'Bahasa dan Seni'),
('BS03', 'Desain Komunikasi Visual', 'Bahasa dan Seni'),
('IPPS01', 'Bimbingan dan Konseling', 'Ilmu Pendidikan dan Pengetahuan Sosial'),
('IPPS02', 'Pendidikan Ekonomi', 'Ilmu Pendidikan dan Pengetahuan Sosial'),
('IPPS03', 'Pendidikan Sejarah', 'Ilmu Pendidikan dan Pengetahuan Sosial'),
('IPPS04', 'Bisnis Digital', 'Ilmu Pendidikan dan Pengetahuan Sosial'),
('IPPS05', 'Manajemen Ritel', 'Ilmu Pendidikan dan Pengetahuan Sosial'),
('MIPA01', 'Pendidikan Matematika', 'Matematika dan Ilmu Pengetahuan Alam'),
('MIPA02', 'Pendidikan Biologi', 'Matematika dan Ilmu Pengetahuan Alam'),
('MIPA03', 'Pendidikan Fisika', 'Matematika dan Ilmu Pengetahuan Alam'),
('MIPA04', 'Sains Data', 'Matematika dan Ilmu Pengetahuan Alam'),
('TIK01', 'Arsitektur', 'Teknik dan Ilmu Komputer'),
('TIK02', 'Teknik Industri', 'Teknik dan Ilmu Komputer'),
('TIK03', 'Teknik Informatika', 'Teknik dan Ilmu Komputer'),
('TIK04', 'Sistem Informasi', 'Teknik dan Ilmu Komputer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi_bimbingan`
--

CREATE TABLE `sesi_bimbingan` (
  `kd_sesi` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topik` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_mulai` time NOT NULL,
  `tgl_ajuan` date NOT NULL,
  `waktu_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sesi_bimbingan`
--

INSERT INTO `sesi_bimbingan` (`kd_sesi`, `npm`, `topik`, `waktu_mulai`, `tgl_ajuan`, `waktu_selesai`) VALUES
('SSI001', '202333500111', 'BSS', '00:24:00', '2025-06-20', '03:21:00'),
('SSI002', '202333500111', '3', '00:25:00', '2025-06-18', '00:25:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CgSf8J727wUZRuzdUzawgCQ7I6E4snNQ5auRb0aD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieFE3TXpYV09MVjczdHhOSGpZZ0tEcUpoalpFOUI4ZXQwMHZmR3FIaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9za3JpdmEyLnRlc3QvbG9naW4iO319', 1751266344),
('cNZWyDGYmPMmuMok7XEtYBWmGy2e8fZNVOobIQIP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibkhhTHVJZ01hNHZrODlPeFRhYmRHRVFTZlhlMFJnNnJJeWtjQU1rbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9za3JpdmEyLnRlc3Qvc3lzLWFkbWluL3N0YXRpc3RpayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2Rvc2VuXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MTg6IjE3NzEwNTIwMjAxMzA0MTAwNiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1751129328),
('EfVb3JQZso6yDBZzmw1MWY5hlilgyAtOtAdYzRXX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjZSM2k5NUZzSmxKWGExRDg3TloxWXlyS3N3ZU12Rlc3cGE2eUF6aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9za3JpdmEyLnRlc3QvbG9naW4iO319', 1751137590),
('KhYMjKFTNezkOXIRvQU2O3mMqa86R4TTJbmlrKbA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUTJjdlZnVUhxVWZib0FvTXZTU1NNODZNSENxaEc1SnZBUUpnZWZXbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751266343);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skripsi`
--

CREATE TABLE `skripsi` (
  `kd_skripsi` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `skripsi`
--

INSERT INTO `skripsi` (`kd_skripsi`, `npm`, `kategori`, `judul`, `tgl_upload`) VALUES
('KS11101', '202333500111', 'analisis dan perancangan', 'Rancang Bangun Sistem Informasi Pemesanan Tiket Wisata', '2025-06-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Jamal Komarudin', 'admin@gmail.com', '$2y$12$9clml6Q5Z5zfsZAGFgpv3e8v54Zu0h2coSQrWt9CiPrb8WNBpngaW');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bimbingan_dosen`
--
ALTER TABLE `bimbingan_dosen`
  ADD PRIMARY KEY (`kd_bimbingan`),
  ADD KEY `bimbingan_dosen_kd_pembimbing_foreign` (`kd_pembimbing`),
  ADD KEY `bimbingan_dosen_kd_sesi_foreign` (`kd_sesi`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `dosen_kd_prodi_foreign` (`kd_prodi`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `file_bimbingan`
--
ALTER TABLE `file_bimbingan`
  ADD PRIMARY KEY (`kd_file`),
  ADD KEY `file_bimbingan_kd_sesi_foreign` (`kd_sesi`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `judul_ajuan`
--
ALTER TABLE `judul_ajuan`
  ADD PRIMARY KEY (`kd_judul`),
  ADD KEY `judul_ajuan_kd_pengajuan_foreign` (`kd_pengajuan`);

--
-- Indeks untuk tabel `judul_skripsi`
--
ALTER TABLE `judul_skripsi`
  ADD PRIMARY KEY (`kd_skripsi`),
  ADD KEY `judul_skripsi_kd_judul_foreign` (`kd_judul`);

--
-- Indeks untuk tabel `kategori_judul`
--
ALTER TABLE `kategori_judul`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indeks untuk tabel `komentar_bimbingan`
--
ALTER TABLE `komentar_bimbingan`
  ADD PRIMARY KEY (`kd_komentar`),
  ADD KEY `komentar_bimbingan_kd_sesi_foreign` (`kd_sesi`);

--
-- Indeks untuk tabel `koordinasi_ta`
--
ALTER TABLE `koordinasi_ta`
  ADD PRIMARY KEY (`kd_koordinasi`),
  ADD KEY `koordinasi_ta_kd_prodi_foreign` (`kd_prodi`),
  ADD KEY `koordinasi_ta_nip_foreign` (`nip`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`npm`),
  ADD KEY `mahasiswa_kd_prodi_foreign` (`kd_prodi`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD PRIMARY KEY (`kd_pembimbing`),
  ADD KEY `pembimbing_nip_foreign` (`nip`);

--
-- Indeks untuk tabel `pembimbing_mahasiswa`
--
ALTER TABLE `pembimbing_mahasiswa`
  ADD KEY `pembimbing_mahasiswa_kd_pembimbing_foreign` (`kd_pembimbing`),
  ADD KEY `pembimbing_mahasiswa_npm_foreign` (`npm`);

--
-- Indeks untuk tabel `pengajuan_judul`
--
ALTER TABLE `pengajuan_judul`
  ADD PRIMARY KEY (`kd_pengajuan`),
  ADD KEY `pengajuan_judul_npm_foreign` (`npm`),
  ADD KEY `pengajuan_judul_kd_kategori_foreign` (`kd_kategori`);

--
-- Indeks untuk tabel `penilaian_judul`
--
ALTER TABLE `penilaian_judul`
  ADD PRIMARY KEY (`kd_judul`),
  ADD KEY `penilaian_judul_kd_pembimbing_foreign` (`kd_pembimbing`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`kd_prodi`);

--
-- Indeks untuk tabel `sesi_bimbingan`
--
ALTER TABLE `sesi_bimbingan`
  ADD PRIMARY KEY (`kd_sesi`),
  ADD KEY `sesi_bimbingan_npm_foreign` (`npm`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  ADD PRIMARY KEY (`kd_skripsi`),
  ADD KEY `skripsi_npm_foreign` (`npm`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bimbingan_dosen`
--
ALTER TABLE `bimbingan_dosen`
  ADD CONSTRAINT `bimbingan_dosen_kd_pembimbing_foreign` FOREIGN KEY (`kd_pembimbing`) REFERENCES `pembimbing` (`kd_pembimbing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bimbingan_dosen_kd_sesi_foreign` FOREIGN KEY (`kd_sesi`) REFERENCES `sesi_bimbingan` (`kd_sesi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_kd_prodi_foreign` FOREIGN KEY (`kd_prodi`) REFERENCES `prodi` (`kd_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `file_bimbingan`
--
ALTER TABLE `file_bimbingan`
  ADD CONSTRAINT `file_bimbingan_kd_sesi_foreign` FOREIGN KEY (`kd_sesi`) REFERENCES `sesi_bimbingan` (`kd_sesi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `judul_ajuan`
--
ALTER TABLE `judul_ajuan`
  ADD CONSTRAINT `judul_ajuan_kd_pengajuan_foreign` FOREIGN KEY (`kd_pengajuan`) REFERENCES `pengajuan_judul` (`kd_pengajuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `judul_skripsi`
--
ALTER TABLE `judul_skripsi`
  ADD CONSTRAINT `judul_skripsi_kd_judul_foreign` FOREIGN KEY (`kd_judul`) REFERENCES `judul_ajuan` (`kd_judul`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_bimbingan`
--
ALTER TABLE `komentar_bimbingan`
  ADD CONSTRAINT `komentar_bimbingan_kd_sesi_foreign` FOREIGN KEY (`kd_sesi`) REFERENCES `sesi_bimbingan` (`kd_sesi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `koordinasi_ta`
--
ALTER TABLE `koordinasi_ta`
  ADD CONSTRAINT `koordinasi_ta_kd_prodi_foreign` FOREIGN KEY (`kd_prodi`) REFERENCES `prodi` (`kd_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `koordinasi_ta_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_kd_prodi_foreign` FOREIGN KEY (`kd_prodi`) REFERENCES `prodi` (`kd_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD CONSTRAINT `pembimbing_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembimbing_mahasiswa`
--
ALTER TABLE `pembimbing_mahasiswa`
  ADD CONSTRAINT `pembimbing_mahasiswa_kd_pembimbing_foreign` FOREIGN KEY (`kd_pembimbing`) REFERENCES `pembimbing` (`kd_pembimbing`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembimbing_mahasiswa_npm_foreign` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengajuan_judul`
--
ALTER TABLE `pengajuan_judul`
  ADD CONSTRAINT `pengajuan_judul_kd_kategori_foreign` FOREIGN KEY (`kd_kategori`) REFERENCES `kategori_judul` (`kd_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengajuan_judul_npm_foreign` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian_judul`
--
ALTER TABLE `penilaian_judul`
  ADD CONSTRAINT `penilaian_judul_kd_judul_foreign` FOREIGN KEY (`kd_judul`) REFERENCES `judul_ajuan` (`kd_judul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_judul_kd_pembimbing_foreign` FOREIGN KEY (`kd_pembimbing`) REFERENCES `pembimbing` (`kd_pembimbing`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sesi_bimbingan`
--
ALTER TABLE `sesi_bimbingan`
  ADD CONSTRAINT `sesi_bimbingan_npm_foreign` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `skripsi`
--
ALTER TABLE `skripsi`
  ADD CONSTRAINT `skripsi_npm_foreign` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
