-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 10 feb 2024 om 14:19
-- Serverversie: 5.7.39-log
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoverhuur`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `autos`
--

CREATE TABLE `autos` (
  `Kenteken` char(8) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `Merk` char(20) COLLATE latin1_general_ci DEFAULT NULL,
  `Type` char(20) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumAPK` datetime DEFAULT NULL,
  `Kilometerstand` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `autos`
--

INSERT INTO `autos` (`Kenteken`, `Merk`, `Type`, `DatumAPK`, `Kilometerstand`) VALUES
('GF-NX-07', 'Volkswagen', 'Polo', '1999-07-12 00:00:00', 78000),
('GF-PD-34', 'Volkswagen', 'Polo', '1999-07-22 00:00:00', 57500),
('KR-RT-65', 'Volkswagen', 'Golf', '1999-08-08 00:00:00', 42000),
('PT-ER-45', 'Ford', 'Fiesta', '1999-03-02 00:00:00', 25000),
('TT-PR-73', 'Citroen', 'XM', NULL, 1200),
('15-60-VY', 'Rolls', 'Silver Shadow', '2024-02-10 00:00:00', 169043),
('22-52-DJ', 'Toyota', 'Corolla', '2024-02-10 00:00:00', 295153);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `login`, `password`) VALUES
(1, 'Admin', '$2y$10$zdorSlxX/AOFHO69tb5tOuqlC4cVfkWh64GujIGGA15oDY.a9RAYS');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `huurders`
--

CREATE TABLE `huurders` (
  `Huurdernr` int(11) DEFAULT '0',
  `Naam` char(25) COLLATE latin1_general_ci DEFAULT NULL,
  `Adres` char(25) COLLATE latin1_general_ci DEFAULT NULL,
  `Postcode` char(7) COLLATE latin1_general_ci DEFAULT NULL,
  `Plaats` char(25) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `huurders`
--

INSERT INTO `huurders` (`Huurdernr`, `Naam`, `Adres`, `Postcode`, `Plaats`) VALUES
(12563, 'De Gier', 'Lokkerlandsdijk 23', '3234 KN', 'Tinte'),
(13876, 'Plomp Acc', 'Fuutstraat 28', '1121 BN', 'Landsmeer'),
(20036, 'Jos Francke', 'Mathernesserlaan 437', '3081 FV', 'Rotterdam'),
(23135, 'Gekroonden', 'Lange haven 72', '3111 CH', 'Schiedam'),
(48212, 'Medina BV', 'Erfdijk 38', '3079 TR', 'Rotterdam'),
(51884, 'Wendel', 'Weteringlaan 149', '5032 XX', 'Tilburg'),
(53441, 'Van Aal / De Graaf', 'Duifstraat 12', '3136 XH', 'Vlaardingen'),
(59067, 'Van Waveren', 'Churchillstraat 40', '1411 XD', 'Naarden'),
(73775, 'Paardekoper BV', 'Sluisjesdijk 103', '3087 AE', 'Rotterdam'),
(84930, 'Van Aalst', 'Coolhaven 128 a', '3024 AK', 'Rotterdam'),
(93323, 'Strijbosch', 'Houtvester 46', '3834 CX', 'Leusden'),
(95201, 'Pieters', 'Gouwsingel 26', '1566 XB', 'Assendelft');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `prijzen`
--

CREATE TABLE `prijzen` (
  `Merk` char(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `Type` char(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `PrijsPerDag` double DEFAULT '0',
  `PrijsPerDagDeel` double DEFAULT '0',
  `PrijsPerWeek` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `prijzen`
--

INSERT INTO `prijzen` (`Merk`, `Type`, `PrijsPerDag`, `PrijsPerDagDeel`, `PrijsPerWeek`) VALUES
('Citroen', 'XM', 93, 67.5, 525.7),
('Ford', 'Fiesta', 67, 43, 325),
('Volkswagen', 'Golf', 82, 44, 475),
('Volkswagen', 'Polo', 72.5, 45.9, 396);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tokens`
--

CREATE TABLE `tokens` (
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `tokens`
--

INSERT INTO `tokens` (`user_id`, `token`, `created_at`) VALUES
(1, '65c6480282fb1', '2024-02-09 16:46:53'),
(1, '65c648028ffca', '2024-02-09 16:46:53'),
(1, '65c648858ad17', '2024-02-09 16:46:53'),
(1, '65c6488597ba9', '2024-02-09 16:46:53'),
(1, '65c64887a371c', '2024-02-09 16:46:53'),
(1, '65c64887b0734', '2024-02-09 16:46:53'),
(1, '65c64888efc18', '2024-02-09 16:46:53'),
(1, '65c64889089ef', '2024-02-09 16:46:53'),
(1, '65c6488a1a39c', '2024-02-09 16:46:53'),
(1, '65c6488a2702b', '2024-02-09 16:46:53'),
(1, '65c64957b2847', '2024-02-09 16:48:39'),
(1, '65c6495a28f6e', '2024-02-09 16:48:42'),
(1, '65c649726715f', '2024-02-09 16:49:06'),
(1, '65c64974697b9', '2024-02-09 16:49:08'),
(1, '65c64b1d7584d', '2024-02-09 16:56:13'),
(1, '65c64b2010b1d', '2024-02-09 16:56:16'),
(1, '65c64b214ac4d', '2024-02-09 16:56:17'),
(1, '65c64b3826642', '2024-02-09 16:56:40'),
(1, '65c64bb129d17', '2024-02-09 16:58:41'),
(1, '65c64bd4dd6c3', '2024-02-09 16:59:16'),
(1, '65c7394d50782', '2024-02-10 09:52:29'),
(1, '65c73d20bf45f', '2024-02-10 10:08:48'),
(1, '65c73d3eb56c0', '2024-02-10 10:09:18'),
(1, '65c73df4007c9', '2024-02-10 10:12:20'),
(1, '65c73fd982234', '2024-02-10 10:20:25'),
(1, '65c740239a000', '2024-02-10 10:21:39'),
(1, '65c7416c50659', '2024-02-10 10:27:08'),
(1, '65c7434d4033b', '2024-02-10 10:35:09'),
(1, '65c74b39755b3', '2024-02-10 11:08:57'),
(1, '65c75027894e2', '2024-02-10 11:29:59'),
(1, '65c75b1b1ebef', '2024-02-10 12:16:43'),
(1, '65c75b7c43d09', '2024-02-10 12:18:20'),
(1, '65c75b7fd629c', '2024-02-10 12:18:23'),
(1, '65c75c4c49a7a', '2024-02-10 12:21:48'),
(1, '65c75e4dbb14e', '2024-02-10 12:30:21'),
(1, '65c760f22fe18', '2024-02-10 12:41:38'),
(1, '65c761162800a', '2024-02-10 12:42:14'),
(1, '65c7724ce2db3', '2024-02-10 13:55:40'),
(1, '65c77278d2d26', '2024-02-10 13:56:24'),
(1, '65c7729d708c0', '2024-02-10 13:57:01'),
(1, '65c772f87513a', '2024-02-10 13:58:32'),
(1, '65c77498ba84a', '2024-02-10 14:05:28'),
(1, '65c774dd3a195', '2024-02-10 14:06:37'),
(1, '65c774fd5ea72', '2024-02-10 14:07:09'),
(1, '65c774feca6da', '2024-02-10 14:07:10'),
(1, '65c7761f17a50', '2024-02-10 14:11:59'),
(1, '65c780ab7179c', '2024-02-10 14:56:59'),
(1, '65c781ac1817e', '2024-02-10 15:01:16'),
(1, '65c78249596e8', '2024-02-10 15:03:53');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verhuur`
--

CREATE TABLE `verhuur` (
  `Kenteken` char(8) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumVerhuur` datetime DEFAULT NULL,
  `Huurdernr` int(11) DEFAULT '0',
  `Identificatie` char(15) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumRetour` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `verhuur`
--

INSERT INTO `verhuur` (`Kenteken`, `DatumVerhuur`, `Huurdernr`, `Identificatie`, `DatumRetour`) VALUES
('DT-LT-87', '1999-11-10 00:00:00', 20036, 'P 78JKD', '1999-11-11 00:00:00'),
('DT-LT-87', '1999-11-12 00:00:00', 51884, 'A 3644-33', '1999-11-12 00:00:00'),
('DT-LT-87', '1999-11-12 00:00:00', 95201, 'A 7373893', '1999-11-18 00:00:00'),
('DT-LT-87', '1999-11-15 00:00:00', 53441, 'L 66336', '1999-11-16 00:00:00'),
('GF-NX-07', '1999-11-10 00:00:00', 12563, 'R 8844944l', '1999-11-11 00:00:00'),
('GF-NX-07', '1999-11-11 00:00:00', 93323, 'P 83390', '1999-11-11 00:00:00'),
('GF-NX-07', '1999-11-13 00:00:00', 12563, 'R 8844944l', '1999-11-14 00:00:00'),
('GF-NX-07', '1999-11-14 00:00:00', 59067, 'P 89833K', '1999-11-14 00:00:00'),
('GF-PD-34', '1999-11-15 00:00:00', 23135, 'R 883733G', '1999-11-15 00:00:00'),
('KR-RT-65', '1999-11-10 00:00:00', 59067, 'A 9933KP8', '1999-11-13 00:00:00'),
('KR-RT-65', '1999-11-14 00:00:00', 48212, 'R 88333GH', NULL),
('PT-ER-45', '1999-11-10 00:00:00', 48212, 'R 88333GH', '1999-11-10 00:00:00'),
('PT-ER-45', '1999-11-11 00:00:00', 23135, 'R 88333GH', '1999-11-11 00:00:00'),
('PT-ER-45', '1999-11-13 00:00:00', 53441, 'L 66336', '1999-11-14 00:00:00'),
('PT-ER-45', '1999-11-14 00:00:00', 93323, 'P 83390', '1999-11-14 00:00:00'),
('tt-rw-01', '1999-03-01 00:00:00', 84930, 'sadas', '1999-05-01 00:00:00'),
('TT-RW-01', '1999-11-11 00:00:00', 93323, 'P 83390', '1999-11-12 00:00:00'),
('TT-RW-01', '1999-11-12 00:00:00', 73775, 'P 744478', '1999-11-12 00:00:00'),
('TT-RW-01', '1999-11-13 00:00:00', 84930, 'P J773HJ', '1999-11-13 00:00:00'),
('TT-RW-01', '1999-11-14 00:00:00', 84930, 'P J773HJ', '1999-11-27 00:00:00');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
