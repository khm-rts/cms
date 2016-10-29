-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2016 at 05:55 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_url_key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_url_key`) VALUES
(1, 'Kategori1', 'kategori-1'),
(3, 'Kategori2', 'kategori-2');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` mediumint(8) UNSIGNED NOT NULL,
  `comment_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` varchar(255) NOT NULL,
  `fk_user_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_post_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_created`, `comment_content`, `fk_user_id`, `fk_post_id`) VALUES
(1, '2016-10-12 12:22:11', 'Eksempel 1 på svar til indlæg 1', 4, 1),
(2, '2016-10-12 12:24:09', 'Eksempel 2 på svar til indlæg 1', 4, 1),
(3, '2016-10-13 07:32:44', '<p>Test2</p>\r\n', 6, 1),
(4, '2016-10-27 13:05:49', '<p>Test</p>\r\n', 6, 2),
(5, '2016-10-27 13:09:57', '<p>Test</p>\r\n', 6, 4),
(6, '2016-10-29 11:40:15', '<p>Test2</p>\r\n', 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `events`
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
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_time`, `event_description`, `event_access_level_required`, `fk_user_id`, `fk_event_type_id`) VALUES
(2, '2016-09-29 12:52:26', 'af brugeren <a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a>', 100, 6, 2),
(4, '2016-09-29 13:08:51', 'Kasper Madsen loggede ind', 100, 6, 4),
(5, '2016-09-30 07:17:47', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(6, '2016-09-30 07:50:10', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(7, '2016-09-30 07:51:19', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(9, '2016-09-30 09:52:21', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(17, '2016-10-03 08:10:58', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(21, '2016-10-03 12:27:44', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(22, '2016-10-03 12:40:11', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(23, '2016-10-03 12:59:44', 'af brugeren <a href="index.php?page=user-edit&id=3" data-page="user-edit" data-params="id=3">Børge Mogensen</a>', 100, 6, 2),
(24, '2016-10-03 13:04:39', '<a href="index.php?page=user-edit&id=3" data-page="user-edit" data-params="id=3">Børge Mogensen</a> loggede ind', 100, 3, 4),
(25, '2016-10-04 06:13:21', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(26, '2016-10-04 06:44:51', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(27, '2016-10-04 06:45:14', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(30, '2016-10-04 06:59:38', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, NULL, 4),
(31, '2016-10-04 07:04:00', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(32, '2016-10-04 07:06:19', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, NULL, 4),
(33, '2016-10-04 07:06:56', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(34, '2016-10-04 07:28:01', '<a href="index.php?page=user-edit&id=8" data-page="user-edit" data-params="id=8">Senne</a> loggede ind', 100, NULL, 4),
(35, '2016-10-04 08:47:02', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(37, '2016-10-04 09:12:36', '<a href="index.php?page=user-edit&id=7" data-page="user-edit" data-params="id=7">Bjarke Rubeksen</a> loggede ind', 100, NULL, 4),
(38, '2016-10-04 09:13:10', '<a href="index.php?page=user-edit&id=2" data-page="user-edit" data-params="id=2">Arne Jacobsen</a> loggede ind', 100, 2, 4),
(45, '2016-10-04 09:31:16', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
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
(94, '2016-10-07 10:59:10', 'af indholdet <a href="index.php?page=page-content-edit&page-id=4&id= 11" data-page="page-content-edit" data-params="page-id=4&id= 11">Kontaktformular</a> på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(95, '2016-10-07 20:15:57', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(99, '2016-10-09 13:24:27', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(100, '2016-10-11 21:29:24', 'af siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 2),
(101, '2016-10-11 21:29:24', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 4" data-page="menu-link-edit" data-params="menu-id=1&id= 4">Forside</a> til siden <a href="index.php?page=page-edit&id=1" data-page="page-edit" data-params="id=1">Velkommen</a>', 100, 6, 1),
(102, '2016-10-11 21:29:41', 'af siden Linktest', 100, 6, 3),
(103, '2016-10-11 21:29:58', 'af siden <a href="index.php?page=page-edit&id=7" data-page="page-edit" data-params="id=7">Linktest</a>', 100, 6, 1),
(104, '2016-10-11 21:29:58', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 5" data-page="menu-link-edit" data-params="menu-id=1&id= 5">linktest</a> til siden <a href="index.php?page=page-edit&id=7" data-page="page-edit" data-params="id=7">Linktest</a>', 100, 6, 1),
(105, '2016-10-11 21:30:05', 'af linket linktest til siden <a href="index.php?page=page-edit&id=7" data-page="page-edit" data-params="id=7">Linktest</a>', 100, 6, 3),
(106, '2016-10-11 21:30:15', 'af siden Linktest', 100, 6, 3),
(107, '2016-10-11 21:30:33', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(108, '2016-10-11 21:30:33', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 6" data-page="menu-link-edit" data-params="menu-id=1&id= 6">Blog</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(109, '2016-10-11 21:30:42', 'af siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 2),
(110, '2016-10-11 21:30:42', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 7" data-page="menu-link-edit" data-params="menu-id=1&id= 7">Kontakt</a> til siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(111, '2016-10-11 21:31:42', 'af siden <a href="index.php?page=page-edit&id=8" data-page="page-edit" data-params="id=8">Linktest</a>', 100, 6, 1),
(112, '2016-10-11 21:31:42', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 8" data-page="menu-link-edit" data-params="menu-id=1&id= 8">linktest</a> til siden <a href="index.php?page=page-edit&id=8" data-page="page-edit" data-params="id=8">Linktest</a>', 100, 6, 1),
(113, '2016-10-11 21:32:01', 'af siden Linktest', 100, 6, 3),
(114, '2016-10-12 10:20:02', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(115, '2016-10-12 13:11:53', 'af blog-indlægget <a href="index.php?page=post-edit&id=3" data-page="post-edit" data-params="id=3">Nyt blogindlæg</a>', 10, 6, 1),
(116, '2016-10-12 13:11:53', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 8" data-page="menu-link-edit" data-params="menu-id=1&id= 8">Nyt blogindlæg</a> til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 1),
(117, '2016-10-12 13:12:48', 'af linket Nyt blogindlæg til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 3),
(118, '2016-10-12 13:12:48', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 8" data-page="menu-link-edit" data-params="menu-id=1&id= 8">Nyt blogindlæg</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(119, '2016-10-12 13:45:54', 'af blog-indlægget <a href="index.php?page=post-edit&id=" data-page="post-edit" data-params="id=">Nyt blogindlæg</a>', 10, 6, 2),
(120, '2016-10-12 13:45:54', 'af linket Nyt blogindlæg til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 3),
(121, '2016-10-12 13:47:18', 'af blog-indlægget <a href="index.php?page=post-edit&id=3" data-page="post-edit" data-params="id=3">Nyt blogindlæg</a>', 10, 6, 2),
(122, '2016-10-12 13:47:18', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 9" data-page="menu-link-edit" data-params="menu-id=1&id= 9">Nyt blogindlæg</a> til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 1),
(123, '2016-10-12 13:48:00', 'af blog-indlægget <a href="index.php?page=post-edit&id=3" data-page="post-edit" data-params="id=3">Nyt blogindlæg</a>', 10, 6, 2),
(124, '2016-10-12 13:48:15', 'af blog-indlægget <a href="index.php?page=post-edit&id=3" data-page="post-edit" data-params="id=3">Nyt blogindlæg</a>', 10, 6, 2),
(125, '2016-10-12 13:48:15', 'af linket Nyt blogindlæg til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 3),
(126, '2016-10-12 13:49:04', 'af blog-indlægget <a href="index.php?page=post-edit&id=3" data-page="post-edit" data-params="id=3">Nyt blogindlæg</a>', 10, 6, 2),
(127, '2016-10-12 13:49:04', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 10" data-page="menu-link-edit" data-params="menu-id=1&id= 10">Nyt blogindlæg</a> til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 1),
(128, '2016-10-12 13:49:22', 'af linket Nyt blogindlæg til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 3),
(129, '2016-10-12 13:49:38', 'af linket Nyt blogindlæg til blog-indlægget <a href="index.php?page=post-edit&id=3">Nyt blogindlæg</a>', 100, 6, 3),
(130, '2016-10-12 13:49:53', 'af blog-indlægget Nyt blogindlæg', 10, 6, 3),
(131, '2016-10-12 13:52:43', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 1),
(132, '2016-10-12 13:52:43', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 11" data-page="menu-link-edit" data-params="menu-id=1&id= 11">Nyt blogindlæg</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Nyt blogindlæg</a>', 100, 6, 1),
(133, '2016-10-12 13:53:31', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 11" data-page="menu-link-edit" data-params="menu-id=1&id= 11">Nyt blogindlæg2</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(134, '2016-10-12 13:53:41', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 11" data-page="menu-link-edit" data-params="menu-id=1&id= 11">Nyt blogindlæg2</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Nyt blogindlæg</a>', 100, 6, 2),
(135, '2016-10-12 13:55:35', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 11" data-page="menu-link-edit" data-params="menu-id=1&id= 11">Nyt blogindlæg</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Nyt blogindlæg</a>', 100, 6, 2),
(136, '2016-10-12 14:02:36', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(137, '2016-10-12 14:02:36', 'af linket Nyt blogindlæg til blog-indlægget <a href="index.php?page=post-edit&id=4">Nyt blogindlæg</a>', 100, 6, 3),
(138, '2016-10-12 14:05:30', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(139, '2016-10-12 14:05:30', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 1),
(140, '2016-10-12 14:05:56', 'af blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 10, 6, 2),
(141, '2016-10-12 14:05:56', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 13" data-page="menu-link-edit" data-params="menu-id=1&id= 13">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=1">Eksempel på indlæg 1</a>', 100, 6, 1),
(142, '2016-10-12 14:06:00', 'af blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 10, 6, 2),
(143, '2016-10-12 14:06:00', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 13" data-page="menu-link-edit" data-params="menu-id=1&id= 13">Indlæg 1</a> til blog-indlægget <a href="index.php?page=post-edit&id=1">Eksempel på indlæg 1</a>', 100, 6, 2),
(144, '2016-10-12 14:45:43', 'af indholdet <a href="index.php?page=page-content-edit&page-id=3&id= 12" data-page="page-content-edit" data-params="page-id=3&id= 12">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(145, '2016-10-12 14:47:49', 'af indholdet Blog: Oversigt over indlæg på Velkommen', 100, 6, 3),
(146, '2016-10-12 14:50:50', 'af indholdet Blog: Oversigt over indlæg på Blog', 100, 6, 3),
(147, '2016-10-12 14:51:08', 'af indholdet <a href="index.php?page=page-content-edit&page-id=3&id= 13" data-page="page-content-edit" data-params="page-id=3&id= 13">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(148, '2016-10-12 15:31:14', 'af indholdet Blog: Oversigt over indlæg på Blog', 100, 6, 3),
(149, '2016-10-13 07:32:44', 'af kommentar til blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 10, 6, 1),
(150, '2016-10-13 07:48:53', 'af <a href="index.php?page=comment-edit&post-id=1&id=3" data-page="comment-edit" data-params="post-id=1&id=3">kommentar</a> til blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 100, 6, 2),
(151, '2016-10-13 08:07:51', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(152, '2016-10-13 08:12:41', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(153, '2016-10-13 08:16:15', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(154, '2016-10-13 08:16:21', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(155, '2016-10-13 08:16:29', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(156, '2016-10-13 08:16:51', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(157, '2016-10-13 08:17:57', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Nyt blogindlæg</a>', 10, 6, 2),
(158, '2016-10-13 08:26:12', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(159, '2016-10-13 08:29:18', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(160, '2016-10-13 08:33:06', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(161, '2016-10-13 08:33:26', 'af blog-indlægget Nyt blogindlæg', 10, 6, 3),
(162, '2016-10-13 08:36:06', 'af indholdet <a href="index.php?page=page-content-edit&page-id=3&id= 14" data-page="page-content-edit" data-params="page-id=3&id= 14">Blog: Oversigt over indlæg</a> på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(163, '2016-10-13 14:59:07', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 14" data-page="menu-link-edit" data-params="menu-id=1&id= 14">Test</a> til bogmærket test på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(164, '2016-10-14 08:27:33', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(165, '2016-10-14 09:00:50', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 14" data-page="menu-link-edit" data-params="menu-id=1&id= 14">Indlæg 1</a> til bogmærket post1 på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 2),
(166, '2016-10-14 09:01:18', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 15" data-page="menu-link-edit" data-params="menu-id=1&id= 15">Indlæg 2</a> til bogmærket post2 på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(167, '2016-10-14 09:01:39', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 16" data-page="menu-link-edit" data-params="menu-id=1&id= 16">Indlæg 3</a> til bogmærket post3 på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 1),
(168, '2016-10-14 11:20:00', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 14" data-page="menu-link-edit" data-params="menu-id=1&id= 14">Indlæg 1</a> til bogmærket post1 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(169, '2016-10-14 11:20:07', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 15" data-page="menu-link-edit" data-params="menu-id=1&id= 15">Indlæg 2</a> til bogmærket post2 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(170, '2016-10-14 11:20:11', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 16" data-page="menu-link-edit" data-params="menu-id=1&id= 16">Indlæg 3</a> til bogmærket post3 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(171, '2016-10-18 09:23:55', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(172, '2016-10-20 10:19:10', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(173, '2016-10-25 07:12:06', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 14" data-page="menu-link-edit" data-params="menu-id=1&id= 14">Indlæg 1</a> til bogmærket post-1 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(174, '2016-10-25 07:12:13', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 15" data-page="menu-link-edit" data-params="menu-id=1&id= 15">Indlæg 2</a> til bogmærket post-2 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(175, '2016-10-25 07:12:29', 'af linket Indlæg 3 til bogmærket post3 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 3),
(176, '2016-10-25 08:28:34', 'af indstillinger', 100, 6, 2),
(177, '2016-10-25 08:28:53', 'af indstillinger', 100, 6, 2),
(192, '2016-10-25 11:08:07', 'af tagget <a href="index.php?page=tag-edit&id=3" data-page="tag-edit" data-params="id=3">Tag1</a>', 100, 6, 1),
(193, '2016-10-25 11:08:11', 'af tagget <a href="index.php?page=tag-edit&id=4" data-page="tag-edit" data-params="id=4">Tag2</a>', 100, 6, 1),
(194, '2016-10-25 11:08:14', 'af tagget <a href="index.php?page=tag-edit&id=5" data-page="tag-edit" data-params="id=5">Tag3</a>', 100, 6, 1),
(195, '2016-10-25 11:08:38', 'af kategorien <a href="index.php?page=category-edit&id=1" data-page="category-edit" data-params="id=1">Kategori1</a>', 100, 6, 2),
(196, '2016-10-25 11:08:55', 'af kategorien <a href="index.php?page=category-edit&id=3" data-page="category-edit" data-params="id=3">Kategori2</a>', 100, 6, 1),
(200, '2016-10-25 11:13:45', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 1),
(201, '2016-10-25 11:13:45', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 18" data-page="menu-link-edit" data-params="menu-id=1&id= 18">Indlæg 3</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 1),
(220, '2016-10-26 12:47:03', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(221, '2016-10-26 12:47:03', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(222, '2016-10-26 12:47:35', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(223, '2016-10-26 12:47:35', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(224, '2016-10-26 12:49:34', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(225, '2016-10-26 12:49:34', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(226, '2016-10-27 08:30:46', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(227, '2016-10-27 08:30:46', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 18" data-page="menu-link-edit" data-params="menu-id=1&id= 18">Indlæg 3</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 2),
(228, '2016-10-27 08:31:19', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(229, '2016-10-27 08:31:19', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(230, '2016-10-27 08:31:56', 'af blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 10, 6, 2),
(231, '2016-10-27 08:31:56', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 13" data-page="menu-link-edit" data-params="menu-id=1&id= 13">Indlæg 1</a> til blog-indlægget <a href="index.php?page=post-edit&id=1">Eksempel på indlæg 1</a>', 100, 6, 2),
(232, '2016-10-27 11:17:46', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(233, '2016-10-27 11:17:46', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 18" data-page="menu-link-edit" data-params="menu-id=1&id= 18">Indlæg 3</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 2),
(234, '2016-10-27 11:17:58', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(235, '2016-10-27 11:17:58', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(236, '2016-10-27 11:18:10', 'af blog-indlægget <a href="index.php?page=post-edit&id=1" data-page="post-edit" data-params="id=1">Eksempel på indlæg 1</a>', 10, 6, 2),
(237, '2016-10-27 11:18:10', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 13" data-page="menu-link-edit" data-params="menu-id=1&id= 13">Indlæg 1</a> til blog-indlægget <a href="index.php?page=post-edit&id=1">Eksempel på indlæg 1</a>', 100, 6, 2),
(238, '2016-10-27 12:35:52', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 18" data-page="menu-link-edit" data-params="menu-id=1&id= 18">Indlæg 3</a> til bogmærket post-3 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(239, '2016-10-27 12:36:19', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 18" data-page="menu-link-edit" data-params="menu-id=1&id= 18">Indlæg 3</a> til bogmærket post-4 på siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(240, '2016-10-28 08:11:40', '<a href="index.php?page=user-edit&id=6" data-page="user-edit" data-params="id=6">Kasper Madsen</a> loggede ind', 100, 6, 4),
(241, '2016-10-28 08:20:26', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(242, '2016-10-28 08:20:26', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 19" data-page="menu-link-edit" data-params="menu-id=1&id= 19">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 1),
(243, '2016-10-28 08:21:34', 'af linket Indlæg 2 til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 3),
(244, '2016-10-28 08:22:18', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(245, '2016-10-28 08:22:26', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(246, '2016-10-28 08:22:26', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2a</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(247, '2016-10-28 08:22:33', 'af blog-indlægget <a href="index.php?page=post-edit&id=2" data-page="post-edit" data-params="id=2">Eksempel på indlæg 2</a>', 10, 6, 2),
(248, '2016-10-28 08:22:33', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 12" data-page="menu-link-edit" data-params="menu-id=1&id= 12">Indlæg 2</a> til blog-indlægget <a href="index.php?page=post-edit&id=2">Eksempel på indlæg 2</a>', 100, 6, 2),
(249, '2016-10-28 08:29:07', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(250, '2016-10-28 08:29:07', 'af link <a href="index.php?page=menu-link-edit&menu-id=2&id= 20" data-page="menu-link-edit" data-params="menu-id=2&id= 20">Test</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 1),
(251, '2016-10-28 08:29:24', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(252, '2016-10-28 08:31:39', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(253, '2016-10-28 08:31:46', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(254, '2016-10-28 08:31:46', 'af linket Test til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 3),
(255, '2016-10-28 08:32:12', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(256, '2016-10-28 08:32:12', 'af link <a href="index.php?page=menu-link-edit&menu-id=2&id= 21" data-page="menu-link-edit" data-params="menu-id=2&id= 21">Test</a> til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 1),
(257, '2016-10-28 08:32:25', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(258, '2016-10-28 08:32:32', 'af blog-indlægget <a href="index.php?page=post-edit&id=4" data-page="post-edit" data-params="id=4">Test med kategori og tags</a>', 10, 6, 2),
(259, '2016-10-28 08:32:32', 'af linket Test til blog-indlægget <a href="index.php?page=post-edit&id=4">Test med kategori og tags</a>', 100, 6, 3),
(260, '2016-10-28 08:32:56', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(261, '2016-10-28 08:32:56', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 6" data-page="menu-link-edit" data-params="menu-id=1&id= 6">Blog</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(262, '2016-10-28 08:39:27', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(263, '2016-10-28 08:39:27', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 22" data-page="menu-link-edit" data-params="menu-id=1&id= 22">Blog</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(264, '2016-10-28 08:39:39', 'af linket Blog til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 3),
(265, '2016-10-28 08:40:03', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(266, '2016-10-28 08:40:25', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(267, '2016-10-28 08:40:25', 'af linket Blog til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 3),
(268, '2016-10-28 08:40:51', 'af siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 2),
(269, '2016-10-28 08:40:51', 'af link <a href="index.php?page=menu-link-edit&menu-id=1&id= 23" data-page="menu-link-edit" data-params="menu-id=1&id= 23">Blog</a> til siden <a href="index.php?page=page-edit&id=3" data-page="page-edit" data-params="id=3">Blog</a>', 100, 6, 1),
(270, '2016-10-28 08:55:09', 'af indstillinger', 100, 6, 2),
(271, '2016-10-28 09:29:29', 'af indstillinger', 100, 6, 2),
(272, '2016-10-28 09:30:03', 'af indstillinger', 100, 6, 2),
(273, '2016-10-28 10:10:16', 'af indstillinger', 100, 6, 2),
(274, '2016-10-28 10:32:48', 'af indholdet <a href="index.php?page=page-content-edit&page-id=4&id= 10" data-page="page-content-edit" data-params="page-id=4&id= 10">''Tekst til kontaktside''</a> på siden <a href="index.php?page=page-edit&id=4" data-page="page-edit" data-params="id=4">Kontakt</a>', 100, 6, 2),
(275, '2016-10-28 10:44:21', 'af siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 1),
(276, '2016-10-28 10:45:51', 'af indholdet <a href="index.php?page=page-content-edit&page-id=5&id= 15" data-page="page-content-edit" data-params="page-id=5&id= 15">''Overskrift og indledning''</a> på siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 1),
(277, '2016-10-28 10:47:16', 'af indholdet <a href="index.php?page=page-content-edit&page-id=5&id= 16" data-page="page-content-edit" data-params="page-id=5&id= 16">Formular til at oprette ny bruger</a> på siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 1),
(278, '2016-10-28 11:22:45', 'af indholdet <a href="index.php?page=page-content-edit&page-id=5&id= 17" data-page="page-content-edit" data-params="page-id=5&id= 17">''Overskrift og indledning til login''</a> på siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 1),
(279, '2016-10-28 11:26:37', 'af indholdet <a href="index.php?page=page-content-edit&page-id=5&id= 18" data-page="page-content-edit" data-params="page-id=5&id= 18">Formular til at logge ind</a> på siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 1),
(280, '2016-10-28 11:28:30', 'af indholdet <a href="index.php?page=page-content-edit&page-id=5&id= 15" data-page="page-content-edit" data-params="page-id=5&id= 15">''Overskrift og indledning til ny profil''</a> på siden <a href="index.php?page=page-edit&id=5" data-page="page-edit" data-params="id=5">Ny profil</a>', 100, 6, 2),
(281, '2016-10-29 10:02:18', 'af siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 1),
(282, '2016-10-29 10:05:26', 'af indholdet <a href="index.php?page=page-content-edit&page-id=6&id= 19" data-page="page-content-edit" data-params="page-id=6&id= 19">''Overskrift og indledning til min profil''</a> på siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 1),
(283, '2016-10-29 10:20:56', 'af indholdet <a href="index.php?page=page-content-edit&page-id=6&id= 20" data-page="page-content-edit" data-params="page-id=6&id= 20">Formular til at rette adresse og kontaktoplysninger</a> på siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 1),
(284, '2016-10-29 10:54:30', 'af indholdet <a href="index.php?page=page-content-edit&page-id=6&id= 21" data-page="page-content-edit" data-params="page-id=6&id= 21">''Titel til ret adgangskode''</a> på siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 1),
(285, '2016-10-29 10:54:41', 'af indholdet <a href="index.php?page=page-content-edit&page-id=6&id= 21" data-page="page-content-edit" data-params="page-id=6&id= 21">''Overskrift til ret adgangskode''</a> på siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 2),
(286, '2016-10-29 11:10:28', 'af indholdet <a href="index.php?page=page-content-edit&page-id=6&id= 22" data-page="page-content-edit" data-params="page-id=6&id= 22">Formular til at rette adgangskode</a> på siden <a href="index.php?page=page-edit&id=6" data-page="page-edit" data-params="id=6">Min profil</a>', 100, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `event_type_id` tinyint(3) UNSIGNED NOT NULL,
  `event_type_name` varchar(45) NOT NULL,
  `event_type_class` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`event_type_id`, `event_type_name`, `event_type_class`) VALUES
(1, 'CREATION', 'success'),
(2, 'UPDATE', 'warning'),
(3, 'DELETION', 'danger'),
(4, 'INFORMATION', 'info');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` tinyint(3) UNSIGNED NOT NULL,
  `menu_name` varchar(25) NOT NULL,
  `menu_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_description`) VALUES
(1, 'Main', 'Hovedmenu på hjemmesiden'),
(2, 'Footer', 'Menu i bunden af hjemmesiden');

-- --------------------------------------------------------

--
-- Table structure for table `menus_menu_links`
--

CREATE TABLE `menus_menu_links` (
  `menu_link_order` tinyint(3) UNSIGNED NOT NULL,
  `fk_menu_id` tinyint(3) UNSIGNED NOT NULL,
  `fk_menu_link_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus_menu_links`
--

INSERT INTO `menus_menu_links` (`menu_link_order`, `fk_menu_id`, `fk_menu_link_id`) VALUES
(1, 2, 4),
(1, 1, 4),
(3, 2, 7),
(5, 1, 7),
(4, 1, 12),
(3, 1, 13),
(6, 1, 14),
(7, 1, 15),
(8, 1, 18),
(2, 2, 23),
(2, 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE `menu_links` (
  `menu_link_id` mediumint(8) UNSIGNED NOT NULL,
  `menu_link_name` varchar(50) NOT NULL,
  `menu_link_bookmark` varchar(50) DEFAULT NULL,
  `fk_link_type_id` tinyint(3) UNSIGNED NOT NULL,
  `fk_page_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_post_id` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_links`
--

INSERT INTO `menu_links` (`menu_link_id`, `menu_link_name`, `menu_link_bookmark`, `fk_link_type_id`, `fk_page_id`, `fk_post_id`) VALUES
(4, 'Forside', NULL, 1, 1, NULL),
(7, 'Kontakt', NULL, 1, 4, NULL),
(12, 'Indlæg 2', NULL, 2, 3, 2),
(13, 'Indlæg 1', NULL, 2, 3, 1),
(14, 'Indlæg 1', 'post-1', 3, 3, NULL),
(15, 'Indlæg 2', 'post-2', 3, 3, NULL),
(18, 'Indlæg 3', 'post-4', 3, 3, NULL),
(23, 'Blog', NULL, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_link_types`
--

CREATE TABLE `menu_link_types` (
  `menu_link_type_id` tinyint(3) UNSIGNED NOT NULL,
  `menu_link_type_name` varchar(25) NOT NULL,
  `menu_link_type_prefix_url` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_link_types`
--

INSERT INTO `menu_link_types` (`menu_link_type_id`, `menu_link_type_name`, `menu_link_type_prefix_url`) VALUES
(1, 'PAGE', ''),
(2, 'BLOG_POSTS', '&post='),
(3, 'BOOKMARK', '#');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
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
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_status`, `page_protected`, `page_url_key`, `page_title`, `page_meta_robots`, `page_meta_description`) VALUES
(1, 1, 1, '', 'Velkommen', 'index, follow', NULL),
(3, 1, 0, 'blog', 'Blog', 'index, follow', NULL),
(4, 1, 1, 'kontakt', 'Kontakt', 'index, follow', 'Kontakt os her'),
(5, 1, 1, 'ny-profil', 'Ny profil', 'index, follow', 'Opret ny profil her'),
(6, 1, 1, 'profil', 'Min profil', 'noindex, nofollow', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
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
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`page_content_id`, `page_content_order`, `page_content_type`, `page_content_description`, `page_content`, `fk_page_function_id`, `fk_page_layout_id`, `fk_page_id`) VALUES
(2, 1, 1, 'Overskrift og kort beskrivelse', '<p>Mumletekst...</p>\r\n', NULL, 1, 1),
(10, 1, 1, 'Tekst til kontaktside', '<h1>Kontakt</h1>\r\n\r\n<p>Er du nysgerrig omkring et eller andet? Du er velkommen til at kontakte os ved hj&aelig;lp af nedenst&aring;ende kontaktformular.</p>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, 1, 4),
(11, 2, 2, NULL, NULL, 2, 1, 4),
(15, 1, 1, 'Overskrift og indledning til ny profil', '<h1>Ny profil</h1>\r\n\r\n<p class="lead">Ingen profil endnu?</p>\r\n\r\n<p>Det er nemt og gjort p&aring; 1 minut og giver dig adgang til at skrive kommentarer p&aring; vores blog og meget mere!</p>\r\n', NULL, 4, 5),
(16, 3, 2, NULL, NULL, 3, 4, 5),
(17, 2, 1, 'Overskrift og indledning til login', '<h1>Log p&aring;</h1>\r\n\r\n<p class="lead">Har du allerede en profil?</p>\r\n\r\n<p>Log ind ved at indtaste din e-mailadresse og adgangskode nedenfor.</p>\r\n', NULL, 4, 5),
(18, 4, 2, NULL, NULL, 4, 4, 5),
(19, 1, 1, 'Overskrift og indledning til min profil', '<h1>Min profil</h1>\r\n\r\n<p class="lead">Ret din adresse og kontaktoplysninger eller din adgangskode her.</p>\r\n\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>\r\n\r\n<h3>Adresse og kontaktoplysninger</h3>\r\n', NULL, 1, 6),
(20, 2, 2, NULL, NULL, 5, 1, 6),
(21, 3, 1, 'Overskrift til ret adgangskode', '<hr />\r\n<h3>Ret adgangskode</h3>\r\n', NULL, 1, 6),
(22, 4, 2, NULL, NULL, 6, 1, 6),
(24, 1, 2, NULL, NULL, 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `page_functions`
--

CREATE TABLE `page_functions` (
  `page_function_id` tinyint(3) UNSIGNED NOT NULL,
  `page_function_description` varchar(255) NOT NULL,
  `page_function_filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_functions`
--

INSERT INTO `page_functions` (`page_function_id`, `page_function_description`, `page_function_filename`) VALUES
(1, 'Blog: Oversigt over indlæg', 'posts.php'),
(2, 'Formular til at kontakte os', 'form-contact.php'),
(3, 'Formular til at oprette ny bruger', 'form-user-create.php'),
(4, 'Formular til at logge ind', 'form-login.php'),
(5, 'Formular til at rette adresse og kontaktoplysninger', 'form-user-edit.php'),
(6, 'Formular til at rette adgangskode', 'form-user-edit-password.php');

-- --------------------------------------------------------

--
-- Table structure for table `page_layouts`
--

CREATE TABLE `page_layouts` (
  `page_layout_id` tinyint(3) UNSIGNED NOT NULL,
  `page_layout_description` varchar(100) NOT NULL,
  `page_layout_class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_layouts`
--

INSERT INTO `page_layouts` (`page_layout_id`, `page_layout_description`, `page_layout_class`) VALUES
(1, '100%', 'col-md-12 match-height'),
(2, '75%', 'col-md-9 match-height'),
(3, '66%', 'col-md-8 match-height'),
(4, '50%', 'col-md-6 match-height'),
(5, '33%', 'col-md-4 match-height'),
(6, '25%', 'col-md-3 match-height');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` mediumint(8) UNSIGNED NOT NULL,
  `post_status` tinyint(1) UNSIGNED NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `post_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_url_key` varchar(50) NOT NULL,
  `post_title` varchar(55) NOT NULL,
  `post_content` text NOT NULL,
  `post_meta_description` varchar(155) DEFAULT NULL,
  `fk_user_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_category_id` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_status`, `post_created`, `post_url_key`, `post_title`, `post_content`, `post_meta_description`, `fk_user_id`, `fk_category_id`) VALUES
(1, 1, '2016-10-07 10:49:07', 'eksempel-paa-indlaeg-1', 'Eksempel på indlæg 1', '<p class="lead">Si meliora dies, ut vina, poemata reddit, velim scire, chartis pretium quotus arroget annus. scriptor abhinc annos centum qui decidit, inter perfectos veteresque referri debet an inter vilis atque novos? Excludat iurgia finis, &quot;Est vetus atque probus, centum qui perficit annos.&quot;</p>\r\n\r\n<p>Quid, qui deperiit minor uno mense vel anno, inter quos referendus erit? Veteresne poetas, an quos et praesens et postera respuat aetas? Iste quidem veteres inter ponetur honeste, qui vel mense brevi vel toto est iunior anno. Utor permisso, caudaeque pilos ut equinae paulatim vello unum, demo etiam unum, dum cadat elusus ratione ruentis acervi, qui redit in fastos et virtutem aestimat annis miraturque nihil nisi quod Libitina sacravit.</p>\r\n\r\n<p>Ennius et sapines et fortis et alter Homerus, ut critici dicunt, leviter curare videtur, quo promissa cadant et somnia Pythagorea. Naevius in manibus non est et mentibus haeret paene recens. Adeo sanctum est vetus omne poema. ambigitur quotiens, uter utro sit prior, aufert Pacuvius docti famam senis Accius alti.</p>\r\n', NULL, 3, NULL),
(2, 1, '2016-10-07 10:54:50', 'eksempel-paa-indlaeg-2', 'Eksempel på indlæg 2', '<p class="lead">Man kan fremad se, at de har v&aelig;ret udset til at l&aelig;se, at der skal dannes par af ligheder. Dermed kan der afsluttes uden l&oslash;se ender, og de kan optimeres fra oven af at formidles stort uden brug fra presse.</p>\r\n\r\n<p>I en kant af landet g&aring;r der blandt om, at de vil s&aelig;tte den over forbehold for tiden. Vi flotter med et hold, der vil rundt og se sig om i byen. Det g&oslash;r heller ikke mere. Men hvor vi nu overbringer denne st&oslash;rrelse til det den handler om, s&aring; kan der fort&aelig;lles op til 3 gange. Hvis det er tr&aelig;et til dit bord der f&aring;r dig op, er det snarere varmen over de andre. Selv om hun har sat alt mere frem, og derfor ikke l&aelig;ngere kan betragtes som den glade giver, er det en nem sammenstilling, som b&aelig;rer ved i lang tid.</p>\r\n\r\n<p>Det g&aring;r der s&aring; nogle timer ud, hvor det er indlysende, at virkeligheden bliver tydelig istands&aelig;ttelse. Det er opmuntrende og anderledes, at det er dampet af kurset i morgen. Der indgives hvert &aring;r enorme strenge af blade af st&oslash;rre eller mindre tilsnit.</p>\r\n', NULL, 3, 1),
(4, 1, '2016-10-25 11:13:45', 'test-med-kategori-og-tags', 'Test med kategori og tags', '<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce quis lectus quis sem lacinia nonummy. Proin mollis lorem non dolor. In hac habitasse platea dictumst. Nulla ultrices odio. Donec augue. Phasellus dui. Maecenas facilisis nisl vitae nibh. Proin vel est vitae eros pretium dignissim.</p>\r\n\r\n<p>Aliquam aliquam sodales orci. Suspendisse potenti. Nunc adipiscing euismod arcu. Quisque facilisis mattis lacus. Fusce bibendum, velit in venenatis viverra, tellus ligula dignissim felis, quis euismod mauris tellus ut urna. Proin scelerisque. Nulla in mi. Integer ac leo. Nunc urna ligula, gravida a, pretium vitae, bibendum nec, ante. Aliquam ullamcorper iaculis lectus. Sed vel dui. Etiam lacinia risus vitae lacus. Aliquam elementum imperdiet turpis. In id metus. Mauris eu nisl. Nam pharetra nisi nec enim. Nulla aliquam, tellus sed laoreet blandit, eros urna vehicula lectus, et vulputate mauris arcu ut arcu. Praesent eros metus, accumsan a, malesuada et, commodo vel, nulla. Aliquam sagittis auctor sapien. Morbi a nibh.</p>\r\n', NULL, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `posts_tags`
--

CREATE TABLE `posts_tags` (
  `fk_post_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_tag_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_tags`
--

INSERT INTO `posts_tags` (`fk_post_id`, `fk_tag_id`) VALUES
(4, 4),
(4, 5),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` tinyint(3) UNSIGNED NOT NULL,
  `role_name` varchar(25) NOT NULL,
  `role_access_level` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_access_level`) VALUES
(1, 'SUPER_ADMINISTRATOR', 1000),
(2, 'ADMINISTRATOR', 100),
(3, 'MODERATOR', 10),
(4, 'USER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` tinyint(3) UNSIGNED NOT NULL,
  `setting_person_name` varchar(100) NOT NULL,
  `setting_company_name` varchar(100) DEFAULT NULL,
  `setting_email` varchar(100) NOT NULL,
  `setting_phone` varchar(8) DEFAULT NULL,
  `setting_street` varchar(255) DEFAULT NULL,
  `setting_zip` varchar(4) DEFAULT NULL,
  `setting_city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_person_name`, `setting_company_name`, `setting_email`, `setting_phone`, `setting_street`, `setting_zip`, `setting_city`) VALUES
(1, 'Kasper Madsen', 'Roskilde Tekniske Skole', 'khm@rts.dk', '12345678', 'Pulsen 8', '4000', 'Roskilde');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` smallint(5) UNSIGNED NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(3, 'Tag1'),
(4, 'Tag2'),
(5, 'Tag3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `user_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0=Disabled, 1=Enabled',
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `user_address` varchar(100) DEFAULT NULL,
  `user_zip` varchar(10) DEFAULT NULL,
  `user_city` varchar(50) DEFAULT NULL,
  `fk_role_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_status`, `user_created`, `user_name`, `user_email`, `user_password`, `user_phone`, `user_address`, `user_zip`, `user_city`, `fk_role_id`) VALUES
(2, 1, '2016-01-10 22:14:00', 'Arne Jacobsen', 'aj@eksempel.dk', '$2y$10$FyFc6.gtitdPO2WecbHJnu20DQFhCdW98NmC6rJfExNZCHfU6YmNq', NULL, NULL, NULL, NULL, 2),
(3, 1, '2015-12-24 17:00:40', 'Børge Mogensen', 'bm@eksempel.dk', '$2y$10$1zk7IJnbtSfK.mlzb7XkdeKTCb6jBWTOg4hhnw3gMsbC7MygIxtUm', NULL, NULL, NULL, NULL, 3),
(4, 1, '2015-04-12 08:14:04', 'Hans Wegner', 'hw@eksempel.dk', '1234', NULL, NULL, NULL, NULL, 4),
(6, 1, '2016-09-29 09:18:56', 'Kasper Madsen', 'khm@rts.dk', '$2y$10$bRTjeRydJ.SCdgyLDWMh2.kDDNEbJ2jCXpXC2XEPB245z3BFEui3q', NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_url_key` (`category_url_key`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_post_id` (`fk_post_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_event_type_id` (`fk_event_type_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `menus_menu_links`
--
ALTER TABLE `menus_menu_links`
  ADD KEY `fk_menu_id` (`fk_menu_id`),
  ADD KEY `fk_menu_link_id` (`fk_menu_link_id`);

--
-- Indexes for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`menu_link_id`),
  ADD KEY `fk_post_id` (`fk_post_id`),
  ADD KEY `fk_page_id` (`fk_page_id`),
  ADD KEY `fk_link_type_id` (`fk_link_type_id`);

--
-- Indexes for table `menu_link_types`
--
ALTER TABLE `menu_link_types`
  ADD PRIMARY KEY (`menu_link_type_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page_url_key` (`page_url_key`);

--
-- Indexes for table `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`page_content_id`),
  ADD KEY `fk_page_function_id` (`fk_page_function_id`),
  ADD KEY `fk_page_id` (`fk_page_id`),
  ADD KEY `fk_page_layout_id` (`fk_page_layout_id`);

--
-- Indexes for table `page_functions`
--
ALTER TABLE `page_functions`
  ADD PRIMARY KEY (`page_function_id`);

--
-- Indexes for table `page_layouts`
--
ALTER TABLE `page_layouts`
  ADD PRIMARY KEY (`page_layout_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_url_key` (`post_url_key`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_category_id` (`fk_category_id`);

--
-- Indexes for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD KEY `fk_post_id` (`fk_post_id`),
  ADD KEY `fk_tag_id` (`fk_tag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_role_id` (`fk_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `event_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `menu_link_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `menu_link_types`
--
ALTER TABLE `menu_link_types`
  MODIFY `menu_link_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `page_content`
--
ALTER TABLE `page_content`
  MODIFY `page_content_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `page_functions`
--
ALTER TABLE `page_functions`
  MODIFY `page_function_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `page_layouts`
--
ALTER TABLE `page_layouts`
  MODIFY `page_layout_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`fk_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`fk_event_type_id`) REFERENCES `event_types` (`event_type_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `menus_menu_links`
--
ALTER TABLE `menus_menu_links`
  ADD CONSTRAINT `menus_menu_links_ibfk_1` FOREIGN KEY (`fk_menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menus_menu_links_ibfk_2` FOREIGN KEY (`fk_menu_link_id`) REFERENCES `menu_links` (`menu_link_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD CONSTRAINT `menu_links_ibfk_2` FOREIGN KEY (`fk_page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_3` FOREIGN KEY (`fk_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_4` FOREIGN KEY (`fk_link_type_id`) REFERENCES `menu_link_types` (`menu_link_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `page_content_ibfk_1` FOREIGN KEY (`fk_page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_2` FOREIGN KEY (`fk_page_function_id`) REFERENCES `page_functions` (`page_function_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_3` FOREIGN KEY (`fk_page_layout_id`) REFERENCES `page_layouts` (`page_layout_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`fk_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `posts_tags_ibfk_1` FOREIGN KEY (`fk_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_tags_ibfk_2` FOREIGN KEY (`fk_tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
