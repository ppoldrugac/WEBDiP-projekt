-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2022 at 06:12 AM
-- Server version: 8.0.29-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WebDiP2021x088`
--

-- --------------------------------------------------------

--
-- Table structure for table `Dnevnik_rada`
--

CREATE TABLE `Dnevnik_rada` (
  `id` int NOT NULL,
  `tip_radnje_id` int NOT NULL,
  `Korisnik_id` int NOT NULL,
  `opis_radnje` varchar(300) NOT NULL,
  `vrijeme` datetime NOT NULL,
  `upit` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Dnevnik_rada`
--

INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`) VALUES
(1, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-12 18:07:47', NULL),
(2, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-14 12:41:14', NULL),
(3, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-15 22:49:54', NULL),
(4, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-16 00:56:18', NULL),
(5, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-17 12:18:11', NULL),
(6, 2, 1, 'Odjava korisnika iz sustava.', '2022-06-17 12:23:03', NULL),
(7, 2, 12, 'Odjava korisnika iz sustava.', '2022-06-17 12:26:38', NULL),
(8, 2, 12, 'Odjava korisnika iz sustava.', '2022-06-17 12:27:21', NULL),
(9, 1, 1, 'Prijava korisnika u sustav.', '2022-06-19 22:29:30', NULL),
(10, 3, 17, 'Uspješna registracija.', '2022-06-19 12:33:03', NULL),
(11, 1, 24, 'Prijava korisnika u sustav.', '2022-06-20 21:07:32', NULL),
(12, 2, 24, 'Odjava korisnika iz sustava.', '2022-06-20 23:49:01', NULL),
(13, 1, 21, 'Prijava korisnika u sustav.', '2022-06-20 23:49:23', NULL),
(14, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 00:51:57', NULL),
(15, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-21 01:05:59', NULL),
(16, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 01:08:15', NULL),
(17, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 01:14:08', NULL),
(18, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 01:44:41', NULL),
(19, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-21 01:48:04', NULL),
(20, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 01:48:15', NULL),
(21, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-21 02:13:17', NULL),
(22, 1, 24, 'Prijava korisnika u sustav.', '2022-06-21 02:13:28', NULL),
(23, 1, 24, 'Prijava korisnika u sustav.', '2022-06-21 02:16:35', NULL),
(24, 2, 24, 'Odjava korisnika iz sustava.', '2022-06-21 02:24:21', NULL),
(25, 1, 24, 'Prijava korisnika u sustav.', '2022-06-21 02:25:01', NULL),
(26, 7, 24, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-21 02:25:14', NULL),
(27, 1, 24, 'Prijava korisnika u sustav.', '2022-06-21 02:28:17', NULL),
(28, 7, 24, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-21 02:28:26', NULL),
(29, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 03:37:57', NULL),
(30, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 11:40:21', NULL),
(31, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 15:06:51', NULL),
(32, 2, 12, 'Odjava korisnika iz sustava.', '2021-06-12 18:07:47', NULL),
(33, 2, 3, 'Odjava korisnika iz sustava.', '2021-06-12 18:07:47', NULL),
(34, 2, 15, 'Odjava korisnika iz sustava.\r\n', '2020-10-10 10:00:00', NULL),
(35, 2, 16, 'Odjava korisnika iz sustava.', '2020-10-02 10:00:00', NULL),
(36, 2, 21, 'Odjava korisnika iz sustava.', '2020-09-10 21:00:00', NULL),
(37, 1, 12, 'Prijava korisnika u sustav.\r\n', '2020-06-12 18:07:47', NULL),
(38, 1, 8, 'Prijava korisnika u sustav.\r\n', '2020-06-12 18:07:47', NULL),
(39, 1, 22, 'Prijava korisnika u sustav.\r\n', '2020-06-11 08:07:47', NULL),
(40, 1, 7, 'Prijava korisnika u sustav.\r\n', '2021-06-12 18:07:47', NULL),
(41, 1, 15, 'Prijava korisnika u sustav.\r\n', '2021-06-12 18:07:47', NULL),
(42, 1, 1, 'Prijava korisnika u sustav.', '2022-06-21 17:41:07', NULL),
(43, 1, 21, 'Prijava korisnika u sustav.', '2022-06-21 20:23:32', NULL),
(44, 1, 24, 'Prijava korisnika u sustav.', '2022-06-22 12:18:24', NULL),
(45, 1, 24, 'Prijava korisnika u sustav.', '2022-06-22 15:16:03', NULL),
(46, 2, 24, 'Odjava korisnika iz sustava.', '2022-06-22 16:38:05', NULL),
(47, 1, 21, 'Prijava korisnika u sustav.', '2022-06-22 16:38:11', NULL),
(48, 1, 21, 'Prijava korisnika u sustav.', '2022-06-22 18:41:53', NULL),
(49, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-22 18:47:29', NULL),
(50, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 18:47:52', NULL),
(51, 7, 2, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-22 18:48:16', NULL),
(52, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 18:48:26', NULL),
(53, 7, 2, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-22 18:48:29', NULL),
(54, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 18:49:02', NULL),
(55, 2, 2, 'Odjava korisnika iz sustava.', '2022-06-22 19:06:59', NULL),
(56, 1, 25, 'Prijava korisnika u sustav.', '2022-06-22 19:07:17', NULL),
(57, 7, 25, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-22 19:13:17', NULL),
(58, 1, 22, 'Prijava korisnika u sustav.', '2022-06-22 19:14:23', NULL),
(59, 2, 22, 'Odjava korisnika iz sustava.', '2022-06-22 20:10:38', NULL),
(60, 1, 21, 'Prijava korisnika u sustav.', '2022-06-22 20:10:45', NULL),
(61, 7, 21, 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '2022-06-22 20:46:55', NULL),
(62, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 20:47:43', NULL),
(63, 2, 2, 'Odjava korisnika iz sustava.', '2022-06-22 22:51:13', NULL),
(64, 1, 21, 'Prijava korisnika u sustav.', '2022-06-22 22:51:20', NULL),
(65, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-22 22:54:11', NULL),
(66, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 22:54:54', NULL),
(67, 2, 2, 'Odjava korisnika iz sustava.', '2022-06-22 23:24:47', NULL),
(68, 1, 21, 'Prijava korisnika u sustav.', '2022-06-22 23:24:54', NULL),
(69, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-22 23:26:47', NULL),
(70, 1, 2, 'Prijava korisnika u sustav.', '2022-06-22 23:26:58', NULL),
(71, 1, 2, 'Prijava korisnika u sustav.', '2022-06-23 01:13:56', NULL),
(72, 2, 2, 'Odjava korisnika iz sustava.', '2022-06-23 03:35:22', NULL),
(73, 1, 21, 'Prijava korisnika u sustav.', '2022-06-23 03:35:28', NULL),
(74, 2, 21, 'Odjava korisnika iz sustava.', '2022-06-23 03:35:55', NULL),
(75, 1, 21, 'Prijava korisnika u sustav.', '2022-06-23 03:36:14', NULL),
(76, 1, 5, 'Prijava korisnika u sustav.', '2022-06-23 05:06:41', NULL),
(77, 2, 5, 'Odjava korisnika iz sustava.', '2022-06-23 05:49:22', NULL),
(78, 1, 22, 'Prijava korisnika u sustav.', '2022-06-23 05:49:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Generator_brojeva`
--

CREATE TABLE `Generator_brojeva` (
  `id` int NOT NULL,
  `Kolo_id` int DEFAULT NULL,
  `pocetni_broj` int NOT NULL,
  `zavrsni_broj` int NOT NULL,
  `dobitni_brojevi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Generator_brojeva`
--

INSERT INTO `Generator_brojeva` (`id`, `Kolo_id`, `pocetni_broj`, `zavrsni_broj`, `dobitni_brojevi`) VALUES
(1, 2, 1, 30, '5, 21, 2, 13, 1, 29'),
(2, 1, 1, 45, '43, 2, 14, 22, 38, 16, 30'),
(3, 3, 1, 45, '19, 32, 6, 44, 25, 6, 19'),
(4, 7, 1, 30, '20, 8, 11, 4, 29, 5'),
(5, 33, 1, 30, '21, 4, 24, 8, 11, 19, 29'),
(6, 32, 1, 35, '3, 7, 14, 28, 32, 21, 19'),
(7, 29, 1, 22, '3, 5, 22, 10, 4, 9'),
(8, 31, 1, 35, '4, 1, 10, 22, 34, 28, 15'),
(9, 17, 1, 22, '3, 4, 6, 1, 10, 22, 7, 21, 5 ,12, 16'),
(10, 18, 1, 45, '4, 6, 43, 22, 10, 29, 10'),
(11, 37, 1, 35, '5, 24, 10, 22, 10, 3, 11');

-- --------------------------------------------------------

--
-- Table structure for table `Igra_na_srecu`
--

CREATE TABLE `Igra_na_srecu` (
  `id` int NOT NULL,
  `Korisnik_id` int DEFAULT NULL,
  `naziv` varchar(100) NOT NULL,
  `broj_brojeva_za_izvlacenje` int NOT NULL,
  `cijena_listica` decimal(10,2) NOT NULL,
  `datumvrijeme_pocetka` varchar(45) NOT NULL,
  `datumvrijeme_zavrsetka` varchar(45) NOT NULL,
  `fond_dobitka` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Igra_na_srecu`
--

INSERT INTO `Igra_na_srecu` (`id`, `Korisnik_id`, `naziv`, `broj_brojeva_za_izvlacenje`, `cijena_listica`, `datumvrijeme_pocetka`, `datumvrijeme_zavrsetka`, `fond_dobitka`) VALUES
(1, 2, 'Loto 7', 7, '20.00', '2022-01-01 00:00:00', '2022-31-12 00:00:00', '750000'),
(2, 22, 'Loto 6', 6, '15.00', '2022-04-01 00:00:00', '2022-05-05 00:00:00', '3600000'),
(3, 3, 'Loto 5', 5, '10.00', '2022-04-01 00:00:00', '2022-05-01 00:00:00', '100000'),
(4, 2, 'Sve ili ništa', 11, '5.00', '2022-05-01 08:00:00', '2022-05-31 23:00:00', '600000'),
(5, 2, 'Loto 7', 7, '15.00', '2021-04-01 08:00:00', '2021-06-01 00:00:00', '8000000'),
(6, 22, 'Loto 6', 6, '10.00', '2021-01-01 08:00:00', '2021-03-15 08:00:00', '400000'),
(7, 25, 'Loto 6', 6, '14.99', '2021-04-01 80:00:00', '2021-06-01 80:00:00', '300000'),
(8, 3, 'Loto 7', 7, '15.99', '2020-04-01 08:00:00', '2020-05-01 08:00:00', '150000'),
(9, 1, 'Loto 7', 7, '19.99', '2020-05-01 08:00:00', '2020-06-01 08:00:00', '200000'),
(10, 22, 'Loto 7', 7, '24.99', '2020-07-01 08:00:00', '2020-11-01 08:00:00', '2000000'),
(11, 1, 'Loto 7', 7, '10.00', '2020-11-02 08:00:00', '2020-12-15 08:00:00', '100000'),
(12, 21, 'Loto 5', 5, '30.00', '2022-01-15 00:00:00', '2022-01-30 00:00:00', '500000'),
(13, 21, 'Loto 5', 5, '30.00', '2022-02-15 00:00:00', '2022-02-25 00:00:00', '500000'),
(14, 22, 'Loto 5', 5, '30.00', '2022-03-15 00:00:00', '2022-03-15 00:00:00', '400000'),
(15, 21, 'Loto 5', 5, '50.00', '2022-01-02 08:00:00', '2022-01-10 08:00:00', '750000'),
(16, 1, 'Sve ili ništa', 11, '15.00', '2020-04-01 00:00:00', '2020-05-01 00:00:00', '100000'),
(17, 22, 'Sve ili ništa', 11, '4.99', '2020-04-01 00:00:00', '2020-05-01 00:00:00', '100000'),
(18, 1, 'Sve ili ništa', 11, '5.00', '2021-04-01 00:00:00', '2021-04-01 00:00:00', '90000'),
(19, 1, 'Sve ili ništa', 11, '5.00', '2022-04-01 00:00:00', '2022-05-01 00:00:00', '88000'),
(20, 1, 'Sve ili ništa', 11, '10.00', '2022-04-01 00:00:00', '2022-04-01 00:00:00', '90000'),
(21, 1, 'Sve ili ništa', 11, '5.00', '2021-05-01 00:00:00', '2021-06-01 00:00:00', '80000'),
(34, 22, 'Loto 7', 7, '15.00', '2022-06-01 00:00:00', '2022-12-01 00:00:00', '2500000'),
(35, 21, 'Loto 6', 6, '20.00', '2022-06-01 00:00:00', '2022-12-01 00:00:00', '1500000'),
(36, 22, 'Sve ili ništa', 11, '5.00', '2022-06-10 00:00:00', '2022-06-17 00:00:00', '225000'),
(37, 21, 'Loto 5', 5, '50.00', '2022-06-01 00:00:00', '2022-12-01 00:00:00', '99000'),
(38, 2, 'Igra 10', 10, '10.00', '2020-10-10 00:00:00', '2021-10-10 00:00:00', '10000000'),
(42, 22, 'Loto 8', 8, '18.00', '2022-06-20 00:00:00', '2022-08-20 00:00:00', '80000');

-- --------------------------------------------------------

--
-- Table structure for table `Kolo`
--

CREATE TABLE `Kolo` (
  `id` int NOT NULL,
  `Igra_na_srecu_id` int DEFAULT NULL,
  `datum_i_vrijeme_isplate` datetime NOT NULL,
  `otvoreno` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Kolo`
--

INSERT INTO `Kolo` (`id`, `Igra_na_srecu_id`, `datum_i_vrijeme_isplate`, `otvoreno`) VALUES
(1, 1, '2021-07-01 08:00:00', 0),
(2, 2, '2022-05-20 00:00:00', 0),
(3, 34, '2022-09-15 09:00:00', 0),
(4, 34, '2022-06-15 09:00:00', 0),
(5, 35, '2022-10-25 09:00:00', 1),
(6, 34, '2022-11-15 09:00:00', 1),
(7, 35, '2022-06-15 09:00:00', 0),
(8, 35, '2022-07-15 09:00:00', 1),
(9, 35, '2022-10-15 09:00:00', 1),
(10, 5, '2022-11-15 09:00:00', 1),
(11, 36, '2022-06-20 09:00:00', 0),
(12, 36, '2022-07-15 09:00:00', 1),
(13, 36, '2022-01-15 09:00:00', 0),
(14, 6, '2022-02-15 09:00:00', 0),
(15, 36, '2022-03-15 09:00:00', 0),
(16, 36, '2022-04-15 09:00:00', 0),
(17, 36, '2022-05-15 09:00:00', 0),
(18, 36, '2022-06-15 09:00:00', 0),
(19, 36, '2022-07-15 09:00:00', 0),
(20, 36, '2022-08-15 09:00:00', 1),
(21, 6, '2022-09-15 09:00:00', 1),
(22, 36, '2022-10-15 09:00:00', 1),
(23, 36, '2022-11-15 09:00:00', 1),
(24, 36, '2022-12-15 09:00:00', 1),
(25, 13, '2022-05-10 00:00:00', 0),
(26, 14, '2022-07-15 09:00:00', 1),
(27, 37, '2022-10-25 09:00:00', 1),
(28, 37, '2022-02-15 09:00:00', 0),
(29, 8, '2020-03-15 09:00:00', 0),
(30, 16, '2021-01-02 09:00:00', 0),
(31, 6, '2021-10-10 14:00:00', 0),
(32, 10, '2020-12-15 08:00:00', 0),
(33, 8, '2020-05-21 08:00:00', 0),
(34, 13, '2020-05-21 08:00:00', 0),
(35, 19, '2020-05-01 08:00:00', 0),
(36, 37, '2022-06-30 10:00:00', 1),
(37, 8, '2020-05-05 10:00:00', 0),
(38, 4, '2022-05-15 09:00:00', 0),
(39, 5, '2021-04-20 10:00:00', 0),
(40, 38, '2020-10-24 08:00:00', 0),
(41, 4, '2022-05-25 00:00:00', 0),
(42, 38, '2022-10-10 10:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Konfiguracija`
--

CREATE TABLE `Konfiguracija` (
  `broj_neuspjesnih_prijava` int NOT NULL,
  `broj_redaka_za_stranicenje` int DEFAULT NULL,
  `trajanje_kolacica` int DEFAULT NULL,
  `trajanje_sesije` int DEFAULT NULL,
  `pomak_vremena` int DEFAULT NULL,
  `istek_verifikacije` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Konfiguracija`
--

INSERT INTO `Konfiguracija` (`broj_neuspjesnih_prijava`, `broj_redaka_za_stranicenje`, `trajanje_kolacica`, `trajanje_sesije`, `pomak_vremena`, `istek_verifikacije`) VALUES
(3, 5, 2, 1, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Korisnik`
--

CREATE TABLE `Korisnik` (
  `id` int NOT NULL,
  `tip_korisnika_id` int NOT NULL,
  `ime` varchar(100) DEFAULT NULL,
  `prezime` varchar(100) DEFAULT NULL,
  `korisnicko_ime` varchar(45) DEFAULT NULL,
  `datum_rodenja` date DEFAULT NULL,
  `lozinka` varchar(45) DEFAULT NULL,
  `lozinka_sha256` char(64) DEFAULT NULL,
  `datum_registracije` timestamp NULL DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `uvjeti_koristenja` date DEFAULT NULL,
  `broj_neuspjesnih_prijava` int DEFAULT NULL,
  `blokiran` tinyint(1) DEFAULT NULL,
  `aktiviran` tinyint(1) DEFAULT NULL,
  `aktivacijski_kod` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Korisnik`
--

INSERT INTO `Korisnik` (`id`, `tip_korisnika_id`, `ime`, `prezime`, `korisnicko_ime`, `datum_rodenja`, `lozinka`, `lozinka_sha256`, `datum_registracije`, `email`, `uvjeti_koristenja`, `broj_neuspjesnih_prijava`, `blokiran`, `aktiviran`, `aktivacijski_kod`) VALUES
(1, 4, 'Marko ', 'Horvat', 'marko.horvat', '1980-06-10', 'kodislonmarko1', 'e82a02a0b0bf60fdc52584181f6c17d427ee4e250572eadc3d3fefde3c79ebf2', '2022-08-09 22:00:00', 'marko.markic@gmail.com', NULL, 0, 0, 1, ''),
(2, 3, 'Dunja', 'Medvedev', 'dunja.medvedev', '1989-06-15', 'jagodaitresnja10', '6d34f3a09fb49bead8245591196996c457901794bd7d793d7e6a460253a3b572', '2022-09-22 22:00:00', 'dunja.medvedev@gmail.com', NULL, 0, 0, 1, ''),
(3, 3, 'Hrvoje', 'Golub', 'hrvoje.golub', '1991-06-14', 'veselagolubica123', 'cbbcce641867fb3415ce300a55c65f17c39b7a4e3d571c8a6344b711856ace66', '2022-08-09 22:00:00', 'hrvoje.golub@gmail.com', NULL, NULL, 0, 1, ''),
(4, 2, 'Ivona', 'Matovina', 'ivona.matovina', '2000-02-01', 'brunobanana11', '313e556a7d53d4f92e6163a722bbb3e916df583f358d811c682e7008a903bdd4', '2022-08-09 22:00:00', 'ivonica0201@gmail.com', NULL, 3, 1, 1, ''),
(5, 2, 'Luka', 'Šarac', 'luka.sarac', '1995-06-08', 'bubamarac99', 'be040b9faf0e2426b7eba4a5f2471feae3b01f327653912150fc8b3ab20f87c3', '2022-09-11 22:00:00', 'luka9sarac9@gmail.com', NULL, 0, 0, 1, ''),
(6, 2, 'Marko', 'Uhoda', 'marko.uhoda', '1997-02-05', 'NeboPlavo22', '9d7e444a372784cf555839df70b1472403bb31be0fbea2573c9cec3cfdacb470', '2022-05-31 22:00:00', 'marko.uhoda@gmail.com', NULL, 3, 1, 1, ''),
(7, 2, 'Josip', 'Antunovac', 'josip.antunovac', '1994-10-28', 'Ko1FXmdKUO', '4ae9664f97efc062387289be54667ed844ef72e47522b90c7765aa3e616079f1', '2022-02-01 23:00:00', 'josip.antunovac@gmail.com', NULL, NULL, 0, 1, ''),
(8, 2, 'Marijan', 'Kovaček', 'marijan.kovacek', '2000-06-08', 'selomojemalo', 'c72be94011e267452cce83cc105cb34b2fe3af5ddf6f5d170d6d34aac608453f', '2022-06-15 22:00:00', 'marijan.kovacek@gmail.com', NULL, NULL, 0, 1, ''),
(12, 2, 'Darko', 'Marčec', 'darko.marcec', '1999-10-09', '11111111', 'ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1', '2022-06-16 22:00:00', 'darko.marcec@gmail.com', NULL, 0, 0, 1, ''),
(13, 2, 'Biljana', 'Aleksić', 'biba.aleks', '1988-06-20', '88888888', '615ed7fb1504b0c724a296d7a69e6c7b2f9ea2c57c1d8206c5afdf392ebdfd25', '2022-06-16 22:00:00', 'biljana.aleksic@gmail.com', NULL, NULL, 0, 1, ''),
(15, 2, 'Dara', 'Bubamara', 'dara.bubamara', '1974-06-24', '55555555', '01c02776d7290e999c60af8413927df1d389690aab8cac12503066cf62e899f6', '2022-06-17 22:00:00', 'dara.bubamara@gmail.com', NULL, NULL, 0, 1, ''),
(16, 2, 'Petar', 'Marić', 'petar.maric', '2001-01-01', 'petar123', '6ca418f5a18c4dae615b3f92c91ce531064144c42c0319ca8fdfbef96a146845', '2022-06-18 21:38:05', 'petar.maric@gmail.com', NULL, NULL, 0, 1, ''),
(17, 2, 'Mirna', 'Škoro', 'mirna.skoro', '2002-10-22', '88888888', '615ed7fb1504b0c724a296d7a69e6c7b2f9ea2c57c1d8206c5afdf392ebdfd25', '2022-06-19 10:33:03', 'mirna.skoro@foi.hr', NULL, NULL, 0, 1, 'yGRplB'),
(21, 4, 'Admin', 'Admin', 'admin', '1990-04-12', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '2022-08-09 22:00:00', 'ppoldruga@foi.hr', NULL, 0, 0, 1, NULL),
(22, 3, 'Moderator', 'Moderator', 'moderator', '1983-04-02', 'moderator', 'cfde2ca5188afb7bdd0691c7bef887baba78b709aadde8e8c535329d5751e6fe', '2022-10-01 22:00:00', 'ppoldruga@foi.hr', NULL, 0, 0, 1, NULL),
(24, 2, 'Pero', 'Perić', 'pero.peric', '2000-06-15', 'peroperic', '13ba1f030dde3faf3f6f58501c87e1c78b7eee719a3fb69eb1fd68bfef75a87d', '2022-08-09 22:00:00', 'pero.peric@gmail.com', NULL, 0, 0, 1, NULL),
(25, 3, 'Ivan', 'Ivić', 'ivan.ivic', '2002-06-14', 'ivan12345', 'a270a7063cde66bd2d07e3cdc6d633e50ceaa5bb24e24081abf0a3ad6ca23428', '2022-08-09 22:00:00', 'ivan.ivic@gmail.com', NULL, 0, 0, 1, NULL),
(26, 2, 'Mia', 'Kovač', 'mia.kovac', '2000-06-10', 'mia12345', '75763a1a1e6cfb79deb6d9955c0db16471e6f14251ed68cb23d33b9ef095dd12', '2022-06-20 23:07:02', 'mia.kovac@yahoo.com', NULL, NULL, 0, 1, 'gwMN1m');

-- --------------------------------------------------------

--
-- Table structure for table `Listić`
--

CREATE TABLE `Listić` (
  `id` int NOT NULL,
  `Korisnik_id` int DEFAULT NULL,
  `Lutrija_id` int DEFAULT NULL,
  `Kolo_id` int DEFAULT NULL,
  `Igra_na_srecu_id` int DEFAULT NULL,
  `status` enum('uplacen','isplacen','dobitan','nije dobitan') NOT NULL,
  `odabrani_brojevi` varchar(100) NOT NULL,
  `telefon` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `adresa` varchar(45) NOT NULL,
  `slika` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Listić`
--

INSERT INTO `Listić` (`id`, `Korisnik_id`, `Lutrija_id`, `Kolo_id`, `Igra_na_srecu_id`, `status`, `odabrani_brojevi`, `telefon`, `email`, `adresa`, `slika`) VALUES
(1, 4, 1, 1, 1, 'nije dobitan', '1, 19, 6, 24, 3, 38, 29', '0919024923', 'ivonica0201@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic1.png'),
(2, 5, 1, 2, 2, 'isplacen', '5, 21, 2, 13, 1, 29', '0977834521', 'luka9sarac9@gmail.com', 'Ivanjska cesta 104, Čakovec', 'listic2.png'),
(3, 6, 2, 3, 34, 'nije dobitan', '3, 42, 19, 25, 12, 33, 38', '0989854678', 'marko.uhoda@gmail.com', 'Zagrebačka 4a, Varaždin', 'listic3.png'),
(4, 5, 1, 7, 35, 'nije dobitan', '4, 21, 2, 10, 29, 7', '09578747329', 'luka9sarac9@gmail.com', 'Ivanjska Cesta 104,Čakovec', 'listic4.png'),
(5, 5, 1, 33, 8, 'nije dobitan', '21, 4, 24, 8, 11, 19, 29', '0997654321', 'luka9sarac9@gmail.com', 'Ivanjska Cesta 104, Čakovec', 'listic5.png'),
(6, 5, 1, 20, 36, 'uplacen', '3, 5, 2, 15, 4, 19, 22, 16, 10, 16, 8', '0997654321', 'luka9sarac9@gmail.com', 'Ivanjska Cesta 104, Čakovec', 'listic6.png'),
(7, 16, 2, 19, 36, 'dobitan', '2, 14, 5, 19, 5, 4, 10, 11, 3, 8, 13', '0977834521', 'petar.maric', 'Ulica Miroslava Krleže 20, Koprivnica', 'listic7.png'),
(8, 13, 2, 36, 37, 'uplacen', '4, 13, 20, 1, 6', '09245738429', 'biba.aleks@gmail.com', 'Vinogradska 32, Kunovec Breg', 'listic8.png'),
(9, 13, 2, 32, 10, 'nije dobitan', '4, 6, 12, 23, 32, 28, 19', '09245738429', 'biba.aleks@gmail.com', 'Vinogradska 32, Kunovec Breg', 'listic10.png'),
(10, 8, 2, 32, 10, 'dobitan', '3, 7, 14, 28, 32, 21, 19', '0989854678', 'marijan.kovacek', 'Koprivnička 10c, Slatina', 'listic9.png'),
(11, 12, 2, 19, 36, 'uplacen', '4, 22, 1, 6, 7, 12, 18, 3, 17, 9, 5', '09193255873', 'darko.marcec', 'Vukovarska 100, Zagreb', 'listic3.png'),
(12, 7, 2, 11, 36, 'isplacen', '20, 22, 1, 6, 19, 12, 3, 7, 17, 13, 10', '09963928409', 'josip.antunovac@gmail.com', 'Ulica Julija Merlića 9, Varaždin', 'listic1.png'),
(13, 7, 1, 31, 16, 'nije dobitan', '4, 1, 10, 22, 34, 28, 15', '0989854678', 'josip.antunovac@gmail.com', 'Trg Kralja Tomislava 4, Koprivnica', 'listic5.png'),
(14, 7, 1, 1, 1, 'isplacen', '43, 2, 14, 22, 38, 16, 30', '0989854678', 'josip.antunovac@gmail.com', 'zagrebacka 4a, varazdin', 'listic4.png'),
(15, 13, 2, 37, 8, 'isplacen', '5, 24, 10, 22, 10, 3, 11', '0977834521', 'biba.aleks@gmail.com', 'ulica miroslava krleze 20, koprivnica', 'listic7.png'),
(16, 13, 3, 5, 10, 'uplacen', '9, 5, 32. 10, 2, 19, 8', '0989854678', 'biba.aleks@gmail.com', 'trg kralja tomislava 4, koprivnica', 'listic7.png'),
(17, 5, 3, 5, 10, 'uplacen', '9, 10, 22, 34, 30, 20, 8, 5', '0919024923', 'luka9sarac9@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic4.png'),
(18, 5, 2, 5, 10, 'uplacen', '9, 10, 22, 34, 30, 20, 8, 5', '09873482148', 'luka9sarac9@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic5.png'),
(19, 24, 1, 5, 35, 'uplacen', '4, 20, 11, 8, 3, 19', '0977834521', 'pero.peric@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic1.png'),
(20, 24, 1, 5, 37, 'uplacen', '4, 20, 11, 8, 3', '09873482148', 'pero.peric@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic8.png'),
(21, 4, 2, 8, 35, 'uplacen', '4, 1, 10, 22, 5, 9', '0977834521', 'ivonica0201@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic10.png'),
(22, 4, 2, 8, 37, 'uplacen', '4, 1, 10, 22, 5', '0989854678', 'ivonica0201@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic6.png'),
(23, 24, 1, 8, 10, 'uplacen', '4, 1, 11, 22, 5, 9', '0919024923', 'pero.peric@gmail.com', 'ivanjska cesta 104, cakovec', 'listic2.png'),
(24, 8, 3, 8, 10, 'uplacen', '4, 1, 10, 22, 5, 9, 28', '09245738429', 'marijan.kovacek@gmail.com', 'vinogradska 32, kunovec breg', 'listic9.png'),
(25, 5, 2, 7, 35, 'dobitan', '5, 8, 20, 3, 19, 21', '0989854678', 'luka9sarac9@gmail.com', 'Varaždinska cesta 10, Koprivnica', 'listic3.png');

-- --------------------------------------------------------

--
-- Table structure for table `Lutrija`
--

CREATE TABLE `Lutrija` (
  `id` int NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `temeljni_kapital` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Lutrija`
--

INSERT INTO `Lutrija` (`id`, `naziv`, `temeljni_kapital`) VALUES
(1, 'Hrvatska lutrija', '5000000.00'),
(2, 'Lutrija A', '1000000.00'),
(3, 'Lutrija B', '1100000.00'),
(4, 'Lutrija C', '200000.00'),
(5, 'Lutrija D', '400000.00'),
(6, 'Lutrija E', '700000.00'),
(7, 'Lutrija F', '600000.00'),
(8, 'Lutrija G', '1500000.00'),
(9, 'Lutrija H', '2000000.00'),
(10, 'Lutrija I', '550000.00');

-- --------------------------------------------------------

--
-- Table structure for table `moderatori_lutrija`
--

CREATE TABLE `moderatori_lutrija` (
  `Korisnik_id` int NOT NULL,
  `Lutrija_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `moderatori_lutrija`
--

INSERT INTO `moderatori_lutrija` (`Korisnik_id`, `Lutrija_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(3, 4),
(3, 5),
(3, 6),
(25, 7),
(25, 8),
(22, 9),
(22, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tip_korisnika`
--

CREATE TABLE `tip_korisnika` (
  `id` int NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`id`, `naziv`) VALUES
(2, 'registrirani korisnik'),
(3, 'moderator'),
(4, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tip_radnje`
--

CREATE TABLE `tip_radnje` (
  `id` int NOT NULL,
  `naziv` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tip_radnje`
--

INSERT INTO `tip_radnje` (`id`, `naziv`) VALUES
(1, 'prijava'),
(2, 'odjava'),
(3, 'registracija'),
(4, 'aktivacija računa'),
(5, 'blokiranje'),
(6, 'deblokiranje'),
(7, 'neovlašten pokušaj pristupa');

-- --------------------------------------------------------

--
-- Table structure for table `Zahtjev_za_isplatom`
--

CREATE TABLE `Zahtjev_za_isplatom` (
  `id` int NOT NULL,
  `Listić_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Zahtjev_za_isplatom`
--

INSERT INTO `Zahtjev_za_isplatom` (`id`, `Listić_id`) VALUES
(1, 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Dnevnik_rada`
--
ALTER TABLE `Dnevnik_rada`
  ADD PRIMARY KEY (`id`,`tip_radnje_id`,`Korisnik_id`),
  ADD KEY `fk_Dnevnik_rada_tip_radnje1_idx` (`tip_radnje_id`),
  ADD KEY `fk_Dnevnik_rada_korisnik1_idx` (`Korisnik_id`);

--
-- Indexes for table `Generator_brojeva`
--
ALTER TABLE `Generator_brojeva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Izvuceni_brojevi_Kolo1_idx` (`Kolo_id`);

--
-- Indexes for table `Igra_na_srecu`
--
ALTER TABLE `Igra_na_srecu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Igra_na_srecu_korisnik1_idx` (`Korisnik_id`);

--
-- Indexes for table `Kolo`
--
ALTER TABLE `Kolo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Kolo_Igra_na_srecu1_idx` (`Igra_na_srecu_id`);

--
-- Indexes for table `Konfiguracija`
--
ALTER TABLE `Konfiguracija`
  ADD PRIMARY KEY (`broj_neuspjesnih_prijava`);

--
-- Indexes for table `Korisnik`
--
ALTER TABLE `Korisnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_korisnik_uloga_idx` (`tip_korisnika_id`);

--
-- Indexes for table `Listić`
--
ALTER TABLE `Listić`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Listić_korisnik1_idx` (`Korisnik_id`),
  ADD KEY `fk_Listić_Lutrija1_idx` (`Lutrija_id`),
  ADD KEY `fk_Listić_Igra_na_srecu1_idx` (`Igra_na_srecu_id`),
  ADD KEY `fk_Listić_Kolo1_idx` (`Kolo_id`);

--
-- Indexes for table `Lutrija`
--
ALTER TABLE `Lutrija`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idLutrija_UNIQUE` (`id`);

--
-- Indexes for table `moderatori_lutrija`
--
ALTER TABLE `moderatori_lutrija`
  ADD PRIMARY KEY (`Lutrija_id`,`Korisnik_id`),
  ADD KEY `fk_moderatori_lutrija_Lutrija1_idx` (`Lutrija_id`),
  ADD KEY `fk_moderatori_lutrija_korisnik1` (`Korisnik_id`);

--
-- Indexes for table `tip_korisnika`
--
ALTER TABLE `tip_korisnika`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tip_radnje`
--
ALTER TABLE `tip_radnje`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Zahtjev_za_isplatom`
--
ALTER TABLE `Zahtjev_za_isplatom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Listić_id_UNIQUE` (`Listić_id`),
  ADD KEY `fk_Zahtjev_za_isplatom_Listić1_idx` (`Listić_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Dnevnik_rada`
--
ALTER TABLE `Dnevnik_rada`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `Generator_brojeva`
--
ALTER TABLE `Generator_brojeva`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Igra_na_srecu`
--
ALTER TABLE `Igra_na_srecu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `Kolo`
--
ALTER TABLE `Kolo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `Korisnik`
--
ALTER TABLE `Korisnik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `Listić`
--
ALTER TABLE `Listić`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Lutrija`
--
ALTER TABLE `Lutrija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tip_korisnika`
--
ALTER TABLE `tip_korisnika`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tip_radnje`
--
ALTER TABLE `tip_radnje`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Dnevnik_rada`
--
ALTER TABLE `Dnevnik_rada`
  ADD CONSTRAINT `fk_Dnevnik_rada_korisnik1` FOREIGN KEY (`Korisnik_id`) REFERENCES `Korisnik` (`id`),
  ADD CONSTRAINT `fk_Dnevnik_rada_tip_radnje1` FOREIGN KEY (`tip_radnje_id`) REFERENCES `tip_radnje` (`id`);

--
-- Constraints for table `Generator_brojeva`
--
ALTER TABLE `Generator_brojeva`
  ADD CONSTRAINT `fk_Izvuceni_brojevi_Kolo1` FOREIGN KEY (`Kolo_id`) REFERENCES `Kolo` (`id`);

--
-- Constraints for table `Igra_na_srecu`
--
ALTER TABLE `Igra_na_srecu`
  ADD CONSTRAINT `fk_Igra_na_srecu_korisnik1` FOREIGN KEY (`Korisnik_id`) REFERENCES `Korisnik` (`id`);

--
-- Constraints for table `Kolo`
--
ALTER TABLE `Kolo`
  ADD CONSTRAINT `fk_Kolo_Igra_na_srecu1` FOREIGN KEY (`Igra_na_srecu_id`) REFERENCES `Igra_na_srecu` (`id`);

--
-- Constraints for table `Korisnik`
--
ALTER TABLE `Korisnik`
  ADD CONSTRAINT `fk_korisnik_uloga` FOREIGN KEY (`tip_korisnika_id`) REFERENCES `tip_korisnika` (`id`);

--
-- Constraints for table `Listić`
--
ALTER TABLE `Listić`
  ADD CONSTRAINT `fk_Listić_Igra_na_srecu1` FOREIGN KEY (`Igra_na_srecu_id`) REFERENCES `Igra_na_srecu` (`id`),
  ADD CONSTRAINT `fk_Listić_Kolo1` FOREIGN KEY (`Kolo_id`) REFERENCES `Kolo` (`id`),
  ADD CONSTRAINT `fk_Listić_korisnik1` FOREIGN KEY (`Korisnik_id`) REFERENCES `Korisnik` (`id`),
  ADD CONSTRAINT `fk_Listić_Lutrija1` FOREIGN KEY (`Lutrija_id`) REFERENCES `Lutrija` (`id`);

--
-- Constraints for table `moderatori_lutrija`
--
ALTER TABLE `moderatori_lutrija`
  ADD CONSTRAINT `fk_moderatori_lutrija_korisnik1` FOREIGN KEY (`Korisnik_id`) REFERENCES `Korisnik` (`id`),
  ADD CONSTRAINT `fk_moderatori_lutrija_Lutrija1` FOREIGN KEY (`Lutrija_id`) REFERENCES `Lutrija` (`id`);

--
-- Constraints for table `Zahtjev_za_isplatom`
--
ALTER TABLE `Zahtjev_za_isplatom`
  ADD CONSTRAINT `fk_Zahtjev_za_isplatom_Listić1` FOREIGN KEY (`Listić_id`) REFERENCES `Listić` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
