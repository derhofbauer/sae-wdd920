-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 08. Nov 2021 um 16:42
-- Server-Version: 10.5.12-MariaDB-1:10.5.12+maria~focal
-- PHP-Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mvc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_from` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `time_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `foreign_table` varchar(255) NOT NULL,
  `foreign_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `units` int(11) NOT NULL DEFAULT 1,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `description`, `units`, `type_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Shure SM58', NULL, 10, 1, '2021-10-25 14:21:40', '2021-10-25 14:21:40', NULL),
(2, 'XLR Kabel 10m', NULL, 20, 2, '2021-10-25 14:21:40', '2021-10-25 14:21:40', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` text DEFAULT NULL,
  `room_nr` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `location`, `room_nr`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VR Lounge', '2. Stock, rechts', 'vr-lounge', '2021-10-25 14:18:49', '2021-10-27 17:50:13', NULL),
(2, 'Ottakring', '1. Stock, links im Eck', 'HSG-8', '2021-10-25 14:18:49', '2021-11-08 14:13:39', NULL),
(3, 'Simmering', '1. Stock links', 'HSG-2', '2021-11-08 15:26:54', '2021-11-08 15:27:03', NULL),
(4, 'Projektraum Schlosspark', '2. Stock, Bibliothek', '14', '2021-11-08 15:28:44', '2021-11-08 16:17:58', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rooms_room_features_mm`
--

CREATE TABLE `rooms_room_features_mm` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rooms_room_features_mm`
--

INSERT INTO `rooms_room_features_mm` (`id`, `room_id`, `room_feature_id`) VALUES
(1, 2, 1),
(2, 1, 1),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `room_features`
--

CREATE TABLE `room_features` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `room_features`
--

INSERT INTO `room_features` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Beamer', NULL, '2021-10-25 14:19:49', '2021-10-25 14:19:49', NULL),
(2, 'Flipchart', NULL, '2021-10-25 14:19:49', '2021-10-25 14:19:49', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mikrofone', '2021-10-25 14:21:12', '2021-10-25 14:21:12', NULL),
(2, 'Kabel', '2021-10-25 14:21:12', '2021-10-25 14:21:12', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Password Hash!',
  `is_admin` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adent', 'arthur.dent@galaxy.com', '$2a$12$Iok3WcgII9wqge7tzKDnbeRBQdbunJOooGflz0VixsFf0d/6lmyL2', 1, '2021-10-25 14:22:24', '2021-10-25 14:23:17', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipments_ibfk_1` (`type_id`);

--
-- Indizes für die Tabelle `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_nr_uindex` (`room_nr`),
  ADD KEY `rooms_location_index` (`location`(768));

--
-- Indizes für die Tabelle `rooms_room_features_mm`
--
ALTER TABLE `rooms_room_features_mm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_features_mm_ibfk_1` (`room_feature_id`),
  ADD KEY `rooms_room_features_mm_ibfk_2` (`room_id`);

--
-- Indizes für die Tabelle `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `rooms_room_features_mm`
--
ALTER TABLE `rooms_room_features_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `room_features`
--
ALTER TABLE `room_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Constraints der Tabelle `rooms_room_features_mm`
--
ALTER TABLE `rooms_room_features_mm`
  ADD CONSTRAINT `rooms_room_features_mm_ibfk_1` FOREIGN KEY (`room_feature_id`) REFERENCES `room_features` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_room_features_mm_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
