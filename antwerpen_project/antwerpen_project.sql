-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 mei 2016 om 11:24
-- Serverversie: 10.1.9-MariaDB
-- PHP-versie: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antwerpen_project`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `antwoorden`
--

CREATE TABLE `antwoorden` (
  `id` int(10) UNSIGNED NOT NULL,
  `antwoorden` text COLLATE utf8_unicode_ci,
  `vragen_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `fases`
--

CREATE TABLE `fases` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `beschrijving` text COLLATE utf8_unicode_ci,
  `fases` enum('open fase','in progress','fase afgesloten') COLLATE utf8_unicode_ci NOT NULL,
  `fases_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'fases_picture_default.jpg',
  `projecten_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locatie`
--

CREATE TABLE `locatie` (
  `id` int(10) UNSIGNED NOT NULL,
  `straat_naam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poscode` int(10) UNSIGNED DEFAULT NULL,
  `huisnummer` int(10) UNSIGNED DEFAULT NULL,
  `position_latitude` double DEFAULT NULL,
  `position_longitude` double DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `locatie`
--

INSERT INTO `locatie` (`id`, `straat_naam`, `poscode`, `huisnummer`, `position_latitude`, `position_longitude`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'antwerpen', NULL, NULL, 51.2194475, 4.40246430000002, NULL, '2016-05-02 22:00:00', '2016-05-02 22:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locatie_projecten`
--

CREATE TABLE `locatie_projecten` (
  `id` int(10) UNSIGNED NOT NULL,
  `projecten_id` int(10) UNSIGNED NOT NULL,
  `locatie_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `locatie_projecten`
--

INSERT INTO `locatie_projecten` (`id`, `projecten_id`, `locatie_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 151, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_04_14_091150_creat_projecten_table', 1),
('2016_04_14_104356_creat_locatie_table', 1),
('2016_04_14_110059_creat_fases_table', 1),
('2016_04_14_111250_creat_reacktie_table', 1),
('2016_04_14_120056_creat_vragen_table', 1),
('2016_04_14_121505_creat_antwoorden_table', 1),
('2016_04_17_120614_create_project_fotos_table', 1),
('2016_04_17_123149_create_locatie_projeten_table', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projecten`
--

CREATE TABLE `projecten` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `beschrijving` text COLLATE utf8_unicode_ci NOT NULL,
  `begin_datum` date DEFAULT NULL,
  `eind_datum` date DEFAULT NULL,
  `project_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'project_picture_default.jpg',
  `user_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `projecten`
--

INSERT INTO `projecten` (`id`, `titel`, `beschrijving`, `begin_datum`, `eind_datum`, `project_picture`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(145, 'project 1 is qqngepqst', 'beschrijving is qqngepqst', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:32:21', '2016-05-03 09:32:21'),
(146, 'project 2222222222222', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:32:29', '2016-05-03 09:32:29'),
(147, 'lll7', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:35:30', '2016-05-03 09:35:30'),
(148, 'fff', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:35:35', '2016-05-03 09:35:35'),
(149, 'fff', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:35:37', '2016-05-03 09:35:37'),
(150, 'ffff', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:35:46', '2016-05-03 09:35:46'),
(151, 'dfds aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-03 09:45:20', '2016-05-03 09:45:20'),
(152, 'jj', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-05 09:03:13', '2016-05-05 09:03:13'),
(153, 'aangepastggggggggggggggggg', 'aangepast', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-05 11:30:10', '2016-05-05 11:30:10'),
(154, 'Pas mij aan om een nieuw project aan te maken', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-05 14:13:31', '2016-05-05 14:13:31'),
(155, 'Pas mij aan om een nieuw project aan te maken', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-05 14:14:07', '2016-05-05 14:14:07'),
(156, 'sqfsdqf', 'klick op mij en pas mij aan voor de beschrijving', '0000-00-00', '0000-00-00', 'proef_proef.jpg', 1, NULL, '2016-05-06 06:41:36', '2016-05-06 06:41:36');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `project_fotos`
--

CREATE TABLE `project_fotos` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `projecten_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `project_fotos`
--

INSERT INTO `project_fotos` (`id`, `project_picture`, `projecten_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(16, 'pipboy_recreation_by_subject_241-d5hxvyf.png', 145, NULL, '2016-05-03 09:34:06', '2016-05-03 09:34:06'),
(17, 'caitlin portofolio.jpg', 145, NULL, '2016-05-03 09:34:13', '2016-05-03 09:34:13'),
(18, 'Untitled-2.jpg', 145, NULL, '2016-05-03 09:34:25', '2016-05-03 09:34:25'),
(19, 'Untitled-1.jpg', 145, NULL, '2016-05-03 09:34:25', '2016-05-03 09:34:25'),
(20, 'caitlin portofolio.jpg', 145, NULL, '2016-05-03 09:34:25', '2016-05-03 09:34:25'),
(21, '13112837_708493355956884_8026930619702681426_o.jpg', 145, NULL, '2016-05-03 09:34:25', '2016-05-03 09:34:25'),
(22, 'pipboy_recreation_by_subject_241-d5hxvyf.png', 145, NULL, '2016-05-03 09:34:26', '2016-05-03 09:34:26'),
(23, 'pipboy_recreation_by_subject_241-d5hxvyf.png', 145, NULL, '2016-05-03 09:41:12', '2016-05-03 09:41:12'),
(24, 'pipboy_recreation_by_subject_241-d5hxvyf.png', 153, NULL, '2016-05-05 11:30:23', '2016-05-05 11:30:23'),
(25, 'Untitled-2.jpg', 153, NULL, '2016-05-05 11:50:06', '2016-05-05 11:50:06'),
(26, 'caitlin portofolio.jpg', 145, NULL, '2016-05-06 07:09:16', '2016-05-06 07:09:16');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reactie`
--

CREATE TABLE `reactie` (
  `id` int(10) UNSIGNED NOT NULL,
  `reactie_masseg` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `projecten_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'profile_picture_default.jpg',
  `is_adm` tinyint(1) NOT NULL DEFAULT '0',
  `high_score` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_picture`, `is_adm`, `high_score`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'anton', 'patokin', '123456', 'profile_picture_default.jpg', 1, NULL, NULL, NULL, '2016-04-27 22:00:00', '2016-04-27 22:00:00'),
(2, 'Anton Patokin', 'paraplu@list.ru', '$2y$10$/ln6etmE.OjvxNzqIoY/Aupscv7fDZx7sgz5KyGgmpUaWkMAw5GLW', 'profile_picture_default.jpg', 1, NULL, 'nx0UEZXGb6DGEwaaZRPTdEgdaUjWmgPtNJKF0GMkTaQAOshV6xCbEHae1L0q', NULL, '2016-05-05 08:46:01', '2016-05-06 07:10:32'),
(3, 'p@list.com', 'p@list.com', '$2y$10$VaNwYwDinXfSnX.TFy8akeF8h/FpmvDc.cmIp89ueFGKUCnkN/pmS', 'profile_picture_default.jpg', 0, NULL, 'QxFwg3aLOPm4YiOjCG9xgKL6XKvrs60Mk3MJAziMg9FiU4J8TwQpy3t3eH85', NULL, '2016-05-05 10:35:50', '2016-05-06 07:10:01'),
(4, 'ss@gmail.com', 'ss@gmail.com', '$2y$10$yITLWqpqxXxnmN5qOxwf2.oaLtyRmGwjHOByosfjjWlYz/rnJb4oe', 'profile_picture_default.jpg', 0, NULL, '8Qcsq2a9Qo7lTHnUrRRtHHgaeXk06TfSoo07vv6Z6RrnYTykgYFVTKHzX9H9', NULL, '2016-05-05 11:17:09', '2016-05-05 16:54:45'),
(5, 'aaaaaaaaaaaaaaaaaaa', 'ssddds@gmail.com', '$2y$10$M6cMAU266LaJOHL3T7KSDeTQuhjpQJDqKcVkpLQg9JqybTffmkCFO', 'profile_picture_default.jpg', 0, NULL, 'hIBl2jImZfXQ7hkDiSwOq4CHGtjeZukpUOYpVQ2BObzpvR0n8Dai5cv45lor', NULL, '2016-05-05 13:12:38', '2016-05-05 13:39:34'),
(6, 'Anton Patokin', 'parapdddlu@list.ru', '$2y$10$FIIq/TzRLgBP6/sQKXJ7z.ZxykMBPofJjrkN4xVppoSUz9ejuSg3y', 'profile_picture_default.jpg', 1, NULL, '2hXcDGmKxYWef5DDNCcJr3z09W29oNjjTUY2znYHXPE7RfXSmjvGF7r0d8cT', NULL, '2016-05-05 14:32:11', '2016-05-06 07:09:51'),
(7, 'artem', 'art@h.com', '$2y$10$q10VswJdu2oUAUApoFzD7eauhE8pmwE4iucQAtd7WHcR7MmTqXzKi', 'profile_picture_default.jpg', 0, NULL, 'aSi1jRoA3KAbq11tzapTqrDbHh2ERkP5fFMd5ZCMOIbR4GJNFwwK4CRSh4aI', NULL, '2016-05-05 14:40:01', '2016-05-05 14:40:43'),
(8, 'bezoeker', 'bezoeker@gmail.com', '$2y$10$FVyZpSxTGNgOx3TEnIJn7OHj7JlZ6cq/qYt1GC99fcyiWzwf5CitO', 'profile_picture_default.jpg', 0, NULL, '0aXtX3bqMgMGrULT65TFbEKrADwl8VeOrWZU9G1MCjPF02KCVogNxAPfsa81', NULL, '2016-05-05 16:59:53', '2016-05-05 17:00:00'),
(9, 'project', 'project@list.ru', '$2y$10$yj8YuvvXfYQpKhso2fI27.iTNFrjoOEmwZXc10k6uhnGN3BEdtSeS', 'profile_picture_default.jpg', 0, NULL, 'f1JqGX4DdghBf23KoGwSC6fK7FHzdsATOaCqAVQ8pCvv0fJ3FPMr9woywnvZ', NULL, '2016-05-05 17:02:02', '2016-05-05 17:02:09'),
(10, 'Hasan', 'hasan@hasan.com', '$2y$10$i/4DGmGPgzudRSFb9/1VdO/rxpsUF4V1R6cwdoo0dHfnbAnLBGI4G', 'profile_picture_default.jpg', 1, NULL, NULL, NULL, '2016-05-06 07:18:36', '2016-05-06 07:18:36');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vragen`
--

CREATE TABLE `vragen` (
  `id` int(10) UNSIGNED NOT NULL,
  `choices` enum('open vragen','meerkeuzevragen','Gesloten vragen','Suggestieve vragen','Controlevragen') COLLATE utf8_unicode_ci NOT NULL,
  `vraag` text COLLATE utf8_unicode_ci NOT NULL,
  `mogelijke_antwoorden_1` text COLLATE utf8_unicode_ci,
  `mogelijke_antwoorden_2` text COLLATE utf8_unicode_ci,
  `mogelijke_antwoorden_3` text COLLATE utf8_unicode_ci,
  `mogelijke_antwoorden_4` text COLLATE utf8_unicode_ci,
  `projecten_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vragen`
--

INSERT INTO `vragen` (`id`, `choices`, `vraag`, `mogelijke_antwoorden_1`, `mogelijke_antwoorden_2`, `mogelijke_antwoorden_3`, `mogelijke_antwoorden_4`, `projecten_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 153, NULL, '2016-05-05 11:50:08', '2016-05-05 11:50:08'),
(2, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 153, NULL, '2016-05-05 13:09:08', '2016-05-05 13:09:08'),
(3, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 153, NULL, '2016-05-05 13:09:09', '2016-05-05 13:09:09'),
(4, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 153, NULL, '2016-05-05 13:09:09', '2016-05-05 13:09:09'),
(5, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 153, NULL, '2016-05-05 13:09:09', '2016-05-05 13:09:09'),
(6, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 145, NULL, '2016-05-05 16:04:01', '2016-05-05 16:04:01'),
(7, 'Gesloten vragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 145, NULL, '2016-05-05 16:04:02', '2016-05-05 16:04:02'),
(8, 'open vragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 145, NULL, '2016-05-05 16:04:02', '2016-05-05 16:04:02'),
(9, 'meerkeuzevragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 146, NULL, '2016-05-05 16:24:34', '2016-05-05 16:24:34'),
(10, 'Gesloten vragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 145, NULL, '2016-05-06 07:08:55', '2016-05-06 07:08:55'),
(11, 'Gesloten vragen', 'Voer hier je vraag in', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 'geef hier mogelijke aantwoord', 145, NULL, '2016-05-06 07:08:55', '2016-05-06 07:08:55');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `antwoorden`
--
ALTER TABLE `antwoorden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antwoorden_vragen_id_foreign` (`vragen_id`),
  ADD KEY `antwoorden_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `fases`
--
ALTER TABLE `fases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fases_projecten_id_foreign` (`projecten_id`);

--
-- Indexen voor tabel `locatie`
--
ALTER TABLE `locatie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `locatie_projecten`
--
ALTER TABLE `locatie_projecten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locatie_projecten_projecten_id_foreign` (`projecten_id`),
  ADD KEY `locatie_projecten_locatie_id_foreign` (`locatie_id`);

--
-- Indexen voor tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projecten_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `project_fotos`
--
ALTER TABLE `project_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_fotos_projecten_id_foreign` (`projecten_id`);

--
-- Indexen voor tabel `reactie`
--
ALTER TABLE `reactie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reactie_user_id_foreign` (`user_id`),
  ADD KEY `reactie_projecten_id_foreign` (`projecten_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexen voor tabel `vragen`
--
ALTER TABLE `vragen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vragen_projecten_id_foreign` (`projecten_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `antwoorden`
--
ALTER TABLE `antwoorden`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `fases`
--
ALTER TABLE `fases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `locatie`
--
ALTER TABLE `locatie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `locatie_projecten`
--
ALTER TABLE `locatie_projecten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `projecten`
--
ALTER TABLE `projecten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
--
-- AUTO_INCREMENT voor een tabel `project_fotos`
--
ALTER TABLE `project_fotos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT voor een tabel `reactie`
--
ALTER TABLE `reactie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT voor een tabel `vragen`
--
ALTER TABLE `vragen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `antwoorden`
--
ALTER TABLE `antwoorden`
  ADD CONSTRAINT `antwoorden_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `antwoorden_vragen_id_foreign` FOREIGN KEY (`vragen_id`) REFERENCES `vragen` (`id`);

--
-- Beperkingen voor tabel `fases`
--
ALTER TABLE `fases`
  ADD CONSTRAINT `fases_projecten_id_foreign` FOREIGN KEY (`projecten_id`) REFERENCES `projecten` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `locatie_projecten`
--
ALTER TABLE `locatie_projecten`
  ADD CONSTRAINT `locatie_projecten_locatie_id_foreign` FOREIGN KEY (`locatie_id`) REFERENCES `locatie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locatie_projecten_projecten_id_foreign` FOREIGN KEY (`projecten_id`) REFERENCES `projecten` (`id`);

--
-- Beperkingen voor tabel `projecten`
--
ALTER TABLE `projecten`
  ADD CONSTRAINT `projecten_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `project_fotos`
--
ALTER TABLE `project_fotos`
  ADD CONSTRAINT `project_fotos_projecten_id_foreign` FOREIGN KEY (`projecten_id`) REFERENCES `projecten` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `reactie`
--
ALTER TABLE `reactie`
  ADD CONSTRAINT `reactie_projecten_id_foreign` FOREIGN KEY (`projecten_id`) REFERENCES `projecten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactie_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `vragen`
--
ALTER TABLE `vragen`
  ADD CONSTRAINT `vragen_projecten_id_foreign` FOREIGN KEY (`projecten_id`) REFERENCES `projecten` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
