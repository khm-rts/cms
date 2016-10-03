-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 29. 09 2016 kl. 15:22:40
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
(4, '2016-09-29 13:08:51', 'Kasper Madsen loggede ind', 100, 6, 4);

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

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `page_content`
--

CREATE TABLE `page_content` (
  `page_content_id` mediumint(8) UNSIGNED NOT NULL,
  `page_content_order` tinyint(3) UNSIGNED NOT NULL,
  `page_content_type` tinyint(1) UNSIGNED NOT NULL,
  `page_content_description` varchar(255) DEFAULT NULL,
  `page_content` text,
  `fk_page_function_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `fk_page_layout_id` tinyint(3) UNSIGNED NOT NULL,
  `fk_page_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 0, '2015-12-24 17:00:40', 'Børge Mogensen', 'bm@eksempel.dk', '1234', 3),
(4, 1, '2015-04-12 08:14:04', 'Hans Wegner', 'hw@eksempel.dk', '1234', 4),
(6, 1, '2016-09-29 09:18:56', 'Kasper Madsen', 'khm@rts.dk', '$2y$10$bRTjeRydJ.SCdgyLDWMh2.kDDNEbJ2jCXpXC2XEPB245z3BFEui3q', 1);

--
-- Begrænsninger for dumpede tabeller
--

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
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

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
-- Tilføj AUTO_INCREMENT i tabel `events`
--
ALTER TABLE `events`
  MODIFY `event_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `event_types`
--
ALTER TABLE `event_types`
  MODIFY `event_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `page_content`
--
ALTER TABLE `page_content`
  MODIFY `page_content_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
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
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`fk_event_type_id`) REFERENCES `event_types` (`event_type_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `page_content_ibfk_1` FOREIGN KEY (`fk_page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_2` FOREIGN KEY (`fk_page_function_id`) REFERENCES `page_functions` (`page_function_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_content_ibfk_3` FOREIGN KEY (`fk_page_layout_id`) REFERENCES `page_layouts` (`page_layout_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
