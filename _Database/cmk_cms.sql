-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 07. 10 2016 kl. 13:13:24
-- Serverversion: 10.1.10-MariaDB
-- PHP-version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmk_cms`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `comments`
--

CREATE TABLE `comments` (
  `comment_id` mediumint(8) UNSIGNED NOT NULL,
  `comment_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` varchar(255) NOT NULL,
  `fk_user_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_post_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `events`
--

CREATE TABLE `events` (
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `event_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_description` text NOT NULL,
  `event_access_level_required` smallint(4) UNSIGNED NOT NULL,
  `fk_user_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_event_type_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `events`
--

INSERT INTO `events` (`event_id`, `event_time`, `event_description`, `event_access_level_required`, `fk_user_id`, `fk_event_type_id`) VALUES
(1, '2016-09-29 12:49:29', 'af brugeren <a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Bjarke</a>', 100, 6, 1),
(2, '2016-09-29 12:52:26', 'af brugeren <a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a>', 100, 6, 2),
(3, '2016-09-29 12:58:44', 'af brugeren Bjarke', 100, 6, 3),
(4, '2016-09-29 13:08:51', 'Kasper Madsen loggede ind', 100, 6, 4),
(5, '2016-09-30 07:17:47', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(6, '2016-09-30 07:50:10', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(7, '2016-09-30 07:51:19', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(8, '2016-09-30 08:57:22', 'af brugeren <a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Kasper Madsen</a>', 100, 6, 1),
(9, '2016-09-30 09:52:21', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(10, '2016-09-30 11:56:00', 'af brugeren Kasper Madsen', 100, 6, 3),
(17, '2016-10-03 08:10:58', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(18, '2016-10-03 11:59:40', 'af brugeren <a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Test</a>', 100, 6, 1),
(19, '2016-10-03 11:59:54', 'af brugeren Test', 100, 6, 3),
(21, '2016-10-03 12:27:44', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(22, '2016-10-03 12:40:11', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(23, '2016-10-03 12:59:44', 'af brugeren <a href="index.php?page=user-edit&id=3" data-page="user-edit" data-params="id=3">Børge Mogensen</a>', 100, 6, 2),
(24, '2016-10-03 13:04:39', '<a href="index.php?page=user-edit&id=3" data-page="user-edit" data-params="id=3">Børge Mogensen</a> loggede ind', 100, 3, 4),
(25, '2016-10-04 06:13:21', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(26, '2016-10-04 06:44:51', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(27, '2016-10-04 06:45:14', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(28, '2016-10-04 06:56:08', 'af brugeren <a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Bjarke Rubeksen</a>', 100, 6, 1),
(29, '2016-10-04 06:59:17', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 6, 1),
(30, '2016-10-04 06:59:38', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, 8, 4),
(31, '2016-10-04 07:04:00', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(32, '2016-10-04 07:06:19', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, 8, 4),
(33, '2016-10-04 07:06:56', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(34, '2016-10-04 07:28:01', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, 8, 4),
(35, '2016-10-04 08:47:02', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(36, '2016-10-04 09:12:16', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 6, 2),
(37, '2016-10-04 09:12:36', '<a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Bjarke Rubeksen</a> loggede ind', 100, 7, 4),
(38, '2016-10-04 09:13:10', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(39, '2016-10-04 09:13:19', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 2, 2),
(40, '2016-10-04 09:13:29', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 2, 2),
(41, '2016-10-04 09:13:46', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 2, 2),
(42, '2016-10-04 09:13:56', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 2, 2),
(43, '2016-10-04 09:14:09', 'af brugeren <a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a>', 100, 2, 2),
(44, '2016-10-04 09:30:45', 'af brugeren <a href="index.php?page=user-edit&id=9" data-page="user-edit" data-params="id=9">Test ny</a>', 100, 2, 1),
(45, '2016-10-04 09:31:16', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(46, '2016-10-04 09:31:41', 'af brugeren <a href="index.php?page=user-edit&id=10" data-page="user-edit" data-params="id=10">Ny Kasper</a>', 100, 6, 1),
(47, '2016-10-04 09:31:53', 'af brugeren Ny Kasper', 100, 6, 3),
(48, '2016-10-04 09:31:57', 'af brugeren Test ny', 100, 6, 3),
(49, '2016-10-04 10:23:07', '<a href="index.php?page=user-edit&id=3" data-page="user-edit" data-params="id=3">Børge Mogensen</a> loggede ind', 100, 3, 4),
(50, '2016-10-04 10:45:51', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(51, '2016-10-04 10:47:17', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(52, '2016-10-04 10:49:06', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(53, '2016-10-04 10:50:17', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(54, '2016-10-04 10:51:10', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(55, '2016-10-04 11:05:02', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(56, '2016-10-04 11:07:21', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(57, '2016-10-04 11:10:48', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(58, '2016-10-05 07:08:42', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(59, '2016-10-05 07:09:06', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(60, '2016-10-05 07:32:08', 'af siden Blog oversigt', 100, 6, 3),
(61, '2016-10-05 08:27:42', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(62, '2016-10-05 08:53:02', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(63, '2016-10-05 08:53:11', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog1</a>', 100, 6, 2),
(64, '2016-10-05 08:53:22', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(65, '2016-10-05 08:56:28', 'af siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(66, '2016-10-06 09:14:01', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(67, '2016-10-06 12:42:51', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 4" data-page="page-content-edit" data-params="page-id=1&id= 4">''wg''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1"></a>', 100, 6, 1),
(68, '2016-10-06 12:48:11', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 5" data-page="page-content-edit" data-params="page-id=1&id= 5">''w''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1"></a>', 100, 6, 1),
(69, '2016-10-06 12:52:02', 'af inholdet w på Velkommen', 100, 6, 3),
(70, '2016-10-06 12:52:37', 'af inholdet wg på Velkommen', 100, 6, 3),
(71, '2016-10-06 12:58:15', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 6" data-page="page-content-edit" data-params="page-id=1&id= 6">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1"></a>', 100, 6, 1),
(72, '2016-10-06 12:59:03', 'af inholdet Blog: Oversigt over indlæg på Velkommen', 100, 6, 3),
(73, '2016-10-06 12:59:22', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 7" data-page="page-content-edit" data-params="page-id=1&id= 7">''wgwg''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1"></a>', 100, 6, 1),
(74, '2016-10-06 13:00:11', 'af inholdet wgwg på Velkommen', 100, 6, 3),
(75, '2016-10-06 13:00:15', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 8" data-page="page-content-edit" data-params="page-id=1&id= 8">''wggw''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 1),
(76, '2016-10-06 13:00:35', 'af inholdet wggw på Velkommen', 100, 6, 3),
(77, '2016-10-07 07:38:27', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse1''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(78, '2016-10-07 07:38:41', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(79, '2016-10-07 07:39:34', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">Kontaktformular</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(80, '2016-10-07 07:39:57', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(81, '2016-10-07 08:03:33', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse1''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(82, '2016-10-07 08:03:41', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(83, '2016-10-07 08:03:46', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(84, '2016-10-07 08:03:49', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 2" data-page="page-content-edit" data-params="page-id=1&id= 2">''Overskrift og kort beskrivelse''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(85, '2016-10-07 08:03:55', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(86, '2016-10-07 08:04:00', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(87, '2016-10-07 08:04:08', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">''Test''</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(88, '2016-10-07 08:04:17', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 1" data-page="page-content-edit" data-params="page-id=1&id= 1">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(89, '2016-10-07 08:44:06', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 9" data-page="page-content-edit" data-params="page-id=1&id= 9">Kontaktformular</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 1),
(90, '2016-10-07 08:44:45', 'af indholdet <a href="index.php?page=page-content-edit&page-id=1&id= 9" data-page="page-content-edit" data-params="page-id=1&id= 9">Kontaktformular</a> på siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(91, '2016-10-07 08:45:01', 'af inholdet Kontaktformular på Velkommen', 100, 6, 3),
(92, '2016-10-07 10:58:05', 'af siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(93, '2016-10-07 10:59:01', 'af indholdet <a href="index.php?page=page-content-edit&page-id=4&id= 10" data-page="page-content-edit" data-params="page-id=4&id= 10">''Tekst til kontaktside''</a> på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(94, '2016-10-07 10:59:10', 'af indholdet <a href="index.php?page=page-content-edit&page-id=4&id= 11" data-page="page-content-edit" data-params="page-id=4&id= 11">Kontaktformular</a> på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `event_types`
--

CREATE TABLE `event_types` (
  `event_type_id` tinyint(3) UNSIGNED NOT NULL,
  `event_type_name` varchar(45) NOT NULL,
  `event_type_class` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `event_types`
--

INSERT INTO `event_types` (`event_type_id`, `event_type_name`, `event_type_class`) VALUES
(1, 'CREATION', 'success'),
(2, 'UPDATE', 'warning'),
(3, 'DELETION', 'danger'),
(4, 'INFORMATION', 'info');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `menus`
--

CREATE TABLE `menus` (
  `menu_id` tinyint(3) UNSIGNED NOT NULL,
  `menu_status` tinyint(1) UNSIGNED NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `menu_name` varchar(25) NOT NULL,
  `menu_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_status`, `menu_name`, `menu_description`) VALUES
(1, 1, 'Main', 'Hovedmenu på hjemmesiden'),
(2, 1, 'Footer', 'Menu i bunden af hjemmesiden');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `menu_links`
--

CREATE TABLE `menu_links` (
  `menu_link_id` mediumint(8) UNSIGNED NOT NULL,
  `menu_link_order` tinyint(3) UNSIGNED NOT NULL,
  `menu_link_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Only page, 2=Post',
  `menu_link_name` varchar(50) NOT NULL,
  `fk_page_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_post_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `fk_menu_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `menu_links`
--

INSERT INTO `menu_links` (`menu_link_id`, `menu_link_order`, `menu_link_type`, `menu_link_name`, `fk_page_id`, `fk_post_id`, `fk_menu_id`) VALUES
(1, 2, 1, 'Blog', 3, NULL, 1),
(2, 3, 2, 'Indlæg 1', 3, 1, 1),
(3, 4, 1, 'Kontakt', 4, NULL, 1),
(4, 1, 1, 'Forside', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pages`
--

CREATE TABLE `pages` (
  `page_id` mediumint(8) UNSIGNED NOT NULL,
  `page_status` tinyint(1) UNSIGNED NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `page_protected` tinyint(1) UNSIGNED NOT NULL COMMENT '0=No, 1=Yes',
  `page_url_key` varchar(50) NOT NULL,
  `page_title` varchar(55) NOT NULL,
  `page_meta_robots` enum('noindex, follow','noindex, nofollow','index, follow','index, nofollow') NOT NULL DEFAULT 'noindex, follow',
  `page_meta_description` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `pages`
--

INSERT INTO `pages` (`page_id`, `page_status`, `page_protected`, `page_url_key`, `page_title`, `page_meta_robots`, `page_meta_description`) VALUES
(1, 1, 1, '', 'Velkommen', 'index, follow', NULL),
(3, 0, 0, 'blog', 'Blog', 'index, follow', NULL),
(4, 1, 0, 'kontakt', 'Kontakt', 'index, follow', 'Kontakt os her');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `page_content`
--

CREATE TABLE `page_content` (
  `page_content_id` mediumint(8) UNSIGNED NOT NULL,
  `page_content_order` tinyint(3) UNSIGNED NOT NULL,
  `page_content_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Text editor, 2=Page function',
  `page_content_description` varchar(255) DEFAULT NULL,
  `page_content` text,
  `fk_page_function_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `fk_page_layout_id` tinyint(3) UNSIGNED NOT NULL,
  `fk_page_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `page_content`
--

INSERT INTO `page_content` (`page_content_id`, `page_content_order`, `page_content_type`, `page_content_description`, `page_content`, `fk_page_function_id`, `fk_page_layout_id`, `fk_page_id`) VALUES
(1, 2, 2, NULL, NULL, 1, 1, 1),
(2, 1, 1, 'Overskrift og kort beskrivelse', '<p>Mumletekst...</p>\r\n', NULL, 1, 1),
(10, 1, 1, 'Tekst til kontaktside', '<h1>Kontakt</h1>\r\n\r\n<p>Kontakt os ved hj&aelig;lp af nedenst&aring;ende formular</p>\r\n', NULL, 1, 4),
(11, 2, 2, NULL, NULL, 2, 1, 4);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `page_functions`
--

CREATE TABLE `page_functions` (
  `page_function_id` tinyint(3) UNSIGNED NOT NULL,
  `page_function_description` varchar(255) NOT NULL,
  `page_function_filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `page_functions`
--

INSERT INTO `page_functions` (`page_function_id`, `page_function_description`, `page_function_filename`) VALUES
(1, 'Blog: Oversigt over indlæg', 'blog_oversigt.php'),
(2, 'Kontaktformular', 'kontakt.php');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `page_layouts`
--

CREATE TABLE `page_layouts` (
  `page_layout_id` tinyint(3) UNSIGNED NOT NULL,
  `page_layout_description` varchar(100) NOT NULL,
  `page_layout_class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `page_layouts`
--

INSERT INTO `page_layouts` (`page_layout_id`, `page_layout_description`, `page_layout_class`) VALUES
(1, '100%', 'col-md-12'),
(2, '75%', 'col-md-9'),
(3, '66%', 'col-md-8'),
(4, '50%', 'col-md-6'),
(5, '33%', 'col-md-4'),
(6, '25%', 'col-md-3');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `posts`
--

CREATE TABLE `posts` (
  `post_id` mediumint(8) UNSIGNED NOT NULL,
  `post_status` tinyint(1) UNSIGNED NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `post_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_url_key` varchar(50) NOT NULL,
  `post_title` varchar(55) NOT NULL,
  `post_content` text NOT NULL,
  `post_meta_description` varchar(155) DEFAULT NULL,
  `fk_user_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `posts`
--

INSERT INTO `posts` (`post_id`, `post_status`, `post_created`, `post_url_key`, `post_title`, `post_content`, `post_meta_description`, `fk_user_id`) VALUES
(1, 1, '2016-10-07 10:49:07', 'eksempel-paa-indlaeg-1', 'Eksempel på indlæg 1', 'Indhold til indlæg 1', NULL, 3),
(2, 1, '2016-10-07 10:54:50', 'eksempel-paa-indlaeg-2', 'Eksempel på indlæg 2', 'Indhold til indlæg 2', NULL, 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE `roles` (
  `role_id` tinyint(3) UNSIGNED NOT NULL,
  `role_name` varchar(25) NOT NULL,
  `role_access_level` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_access_level`) VALUES
(1, 'SUPER_ADMINISTRATOR', 1000),
(2, 'ADMINISTRATOR', 100),
(3, 'MODERATOR', 10),
(4, 'USER', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `settings`
--

CREATE TABLE `settings` (
  `setting_id` tinyint(3) UNSIGNED NOT NULL,
  `setting_person_name` varchar(100) NOT NULL,
  `setting_company_name` varchar(100) DEFAULT NULL,
  `setting_email` varchar(100) NOT NULL,
  `setting_phone` varchar(8) DEFAULT NULL,
  `setting_address` varchar(255) DEFAULT NULL,
  `setting_zip` varchar(4) DEFAULT NULL,
  `setting_city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `user_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0=Disabled, 1=Enabled',
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `fk_role_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`user_id`, `user_status`, `user_created`, `user_name`, `user_email`, `user_password`, `fk_role_id`) VALUES
(2, 1, '2016-01-10 22:14:00', 'Arne Jacobsen', 'aj@eksempel.dk', '$2y$10$FyFc6.gtitdPO2WecbHJnu20DQFhCdW98NmC6rJfExNZCHfU6YmNq', 2),
(3, 1, '2015-12-24 17:00:40', 'Børge Mogensen', 'bm@eksempel.dk', '$2y$10$1zk7IJnbtSfK.mlzb7XkdeKTCb6jBWTOg4hhnw3gMsbC7MygIxtUm', 3),
(4, 1, '2015-04-12 08:14:04', 'Hans Wegner', 'hw@eksempel.dk', '1234', 4),
(6, 1, '2016-09-29 09:18:56', 'Kasper Madsen', 'khm@rts.dk', '$2y$10$bRTjeRydJ.SCdgyLDWMh2.kDDNEbJ2jCXpXC2XEPB245z3BFEui3q', 1),
(7, 1, '2016-10-04 06:56:08', 'Bjarke Rubeksen', 'bbr@rts.dk', '$2y$10$IXzZ76yVTQ6kmzxE/772n.stBV/SnEqiXhnykvoTM7VJgHYnpY.C.', 1),
(8, 1, '2016-10-04 06:59:17', 'Senne', 'hhh@rts.dk', '$2y$10$PJhGFhy1dT99JgYkPsfyV.LZadP5Ctt1PKFJvIu5NC/lPUgmAI4Oy', 4);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_post_id` (`fk_post_id`);

--
-- Indeks for tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_event_type_id` (`fk_event_type_id`);

--
-- Indeks for tabel `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indeks for tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks for tabel `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`menu_link_id`),
  ADD KEY `fk_menu_id` (`fk_menu_id`),
  ADD KEY `fk_post_id` (`fk_post_id`),
  ADD KEY `fk_page_id` (`fk_page_id`);

--
-- Indeks for tabel `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page_url_key` (`page_url_key`);

--
-- Indeks for tabel `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`page_content_id`),
  ADD KEY `fk_page_function_id` (`fk_page_function_id`),
  ADD KEY `fk_page_id` (`fk_page_id`),
  ADD KEY `fk_page_layout_id` (`fk_page_layout_id`);

--
-- Indeks for tabel `page_functions`
--
ALTER TABLE `page_functions`
  ADD PRIMARY KEY (`page_function_id`);

--
-- Indeks for tabel `page_layouts`
--
ALTER TABLE `page_layouts`
  ADD PRIMARY KEY (`page_layout_id`);

--
-- Indeks for tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_url_key` (`post_url_key`),
  ADD KEY `fk_user_id` (`fk_user_id`);

--
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks for tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_role_id` (`fk_role_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `events`
--
ALTER TABLE `events`
  MODIFY `event_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- Tilføj AUTO_INCREMENT i tabel `event_types`
--
ALTER TABLE `event_types`
  MODIFY `event_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `menu_link_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `page_content`
--
ALTER TABLE `page_content`
  MODIFY `page_content_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Tilføj AUTO_INCREMENT i tabel `page_functions`
--
ALTER TABLE `page_functions`
  MODIFY `page_function_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `page_layouts`
--
ALTER TABLE `page_layouts`
  MODIFY `page_layout_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Tilføj AUTO_INCREMENT i tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`fk_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`fk_event_type_id`) REFERENCES `event_types` (`event_type_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `menu_links`
--
ALTER TABLE `menu_links`
  ADD CONSTRAINT `menu_links_ibfk_1` FOREIGN KEY (`fk_menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_2` FOREIGN KEY (`fk_page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_3` FOREIGN KEY (`fk_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `page_content_ibfk_1` FOREIGN KEY (`fk_page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_2` FOREIGN KEY (`fk_page_function_id`) REFERENCES `page_functions` (`page_function_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_3` FOREIGN KEY (`fk_page_layout_id`) REFERENCES `page_layouts` (`page_layout_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
