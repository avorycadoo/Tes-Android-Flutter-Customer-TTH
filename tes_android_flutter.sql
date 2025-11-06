-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Nov 2025 pada 14.48
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes_android_flutter`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `CustID` varchar(11) DEFAULT NULL,
  `Name` varchar(17) DEFAULT NULL,
  `Address` varchar(37) DEFAULT NULL,
  `BranchCode` varchar(3) DEFAULT NULL,
  `PhoneNo` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`CustID`, `Name`, `Address`, `BranchCode`, `PhoneNo`) VALUES
('00A01090002', 'Mirza', 'Tengku Iskandar 5', '00A', '+6285277163045'),
('00A01090018', 'Bintang Mandiri', 'Tengku Iskandari (Blang Bintang Lama)', '00A', '+6281360084071'),
('00A01090021', 'Varia Muge Profil', 'T. Iskandar, Lam Glumpang', '00A', '+628126982982'),
('00A01090026', 'Puga Jaya', 'Kebun Raya Sp.4 Pineung Lamgugop', '00A', '+6285277273340'),
('00A01090033', 'Mandiri Baru', 'T Iskandar 4 Lamglumpang', '00A', '+6282367767579'),
('00A01090088', 'Valerin', 'Jl. Tenggilis Mejoyo', '00A', '08123456789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customertth`
--

CREATE TABLE `customertth` (
  `ID` tinyint(4) NOT NULL,
  `TTHNo` varchar(18) DEFAULT NULL,
  `SalesID` varchar(10) DEFAULT NULL,
  `TTOTTPNo` varchar(19) DEFAULT NULL,
  `CustID` varchar(11) DEFAULT NULL,
  `DocDate` varchar(19) DEFAULT NULL,
  `Received` tinyint(4) DEFAULT NULL,
  `ReceivedDate` datetime DEFAULT NULL,
  `FailedReason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customertth`
--

INSERT INTO `customertth` (`ID`, `TTHNo`, `SalesID`, `TTOTTPNo`, `CustID`, `DocDate`, `Received`, `ReceivedDate`, `FailedReason`) VALUES
(1, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90079', '00A01090002', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(2, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90084', '00A01090002', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(3, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90083', '00A01090002', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(4, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90081', '00A01090018', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(5, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90082', '00A01090018', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(6, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90158', '00A01090021', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(7, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90086', '00A01090033', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(8, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90159', '00A01090026', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(9, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90089', '00A01090026', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(10, 'TTH-00A-2306-50137', '00AC1A0103', 'TTOL-00A-2306-90087', '00A01090026', '2023-06-20 00:00:00', 1, '2025-11-06 09:55:30', NULL),
(11, 'TTH-00A-2306-50140', '00AC1A0108', 'TTOL-00A-2306-90088', '00A01090021', '2025-11-06 00:00:00', 0, '2025-11-06 09:54:25', 'masih pemantauan'),
(12, 'TTH-00A-2306-50188', '00AC1A0188', 'TTOL-00A-2306-90028', '00A01090088', '2025-11-06 00:00:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customertthdetail`
--

CREATE TABLE `customertthdetail` (
  `ID` tinyint(4) NOT NULL,
  `TTHNo` varchar(18) DEFAULT NULL,
  `TTOTTPNo` varchar(19) DEFAULT NULL,
  `Jenis` varchar(13) DEFAULT NULL,
  `Qty` tinyint(4) DEFAULT NULL,
  `Unit` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customertthdetail`
--

INSERT INTO `customertthdetail` (`ID`, `TTHNo`, `TTOTTPNo`, `Jenis`, `Qty`, `Unit`) VALUES
(1, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90079', 'Emas 100 Gr', 100, 'Buah'),
(2, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90081', 'Voucher 450rb', 1, 'Lembar'),
(3, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90082', 'Voucher 50rb', 5, 'Lembar'),
(4, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90083', 'Emas 1 Gr', 2, 'Buah'),
(5, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90084', 'Emas 5 Gr', 1, 'Buah'),
(6, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90086', 'Voucher 50rb', 1, 'Lembar'),
(7, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90087', 'Voucher 50rb', 5, 'Lembar'),
(8, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90089', 'Voucher 100rb', 1, 'Lembar'),
(9, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90158', 'Emas 0.5 Gr', 3, 'Buah'),
(10, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90159', 'Voucher 150rb', 1, 'Lembar'),
(11, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90079', 'Emas 1000 Gr', 1, 'Buah'),
(23, 'TTH-00A-2306-50137', 'TTOL-00A-2306-90079', 'Voucher 200rb', 1, 'Lembar'),
(24, 'TTH-00A-2306-50140', 'TTOL-00A-2306-90088', 'Emas 10 Gr', 1, 'Buah'),
(25, 'TTH-00A-2306-50140', 'TTOL-00A-2306-90088', 'Voucher 850rb', 2, 'Lembar'),
(26, 'TTH-00A-2306-50188', 'TTOL-00A-2306-90028', 'Emas 88 Gr', 88, 'Buah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobileconfig`
--

CREATE TABLE `mobileconfig` (
  `ID` tinyint(4) DEFAULT NULL,
  `BranchCode` varchar(3) DEFAULT NULL,
  `Name` varchar(11) DEFAULT NULL,
  `Description` varchar(11) DEFAULT NULL,
  `Value` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mobileconfig`
--

INSERT INTO `mobileconfig` (`ID`, `BranchCode`, `Name`, `Description`, `Value`) VALUES
(1, '00A', 'SUMMARY TTH', 'Summary TTH', 'Emas 0.5 Gr|Emas 1 Gr|Emas 5 Gr|Emas 100 Gr|Voucher 50rb|Voucher 100rb');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customertth`
--
ALTER TABLE `customertth`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `customertthdetail`
--
ALTER TABLE `customertthdetail`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT untuk tabel `customertth`
--
ALTER TABLE `customertth`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `customertthdetail`
--
ALTER TABLE `customertthdetail`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
