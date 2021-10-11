-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 11. Okt 2021 um 15:29
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
-- Datenbank: `sae_joins`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `actors`
--

CREATE TABLE `actors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `breakthrough_movie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `actors`
--

INSERT INTO `actors` (`id`, `name`, `breakthrough_movie`) VALUES
(1, 'Tom Cruise', NULL),
(2, 'Daniel Craig', NULL),
(3, 'Johnny Depp', NULL),
(4, 'Keira Nightley', NULL),
(5, 'Jennifer Aniston', NULL),
(6, 'Brad Pitt', NULL),
(7, 'Leonaro DiCaprio', NULL),
(8, 'Kate Winslet', NULL),
(9, 'The Rock', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `actors_movies_mm`
--

CREATE TABLE `actors_movies_mm` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `actors_movies_mm`
--

INSERT INTO `actors_movies_mm` (`id`, `actor_id`, `movie_id`) VALUES
(1, 6, 4),
(2, 2, 3),
(3, 5, 4),
(4, 3, 5),
(5, 8, 1),
(6, 4, 5),
(7, 7, 1),
(8, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Drama'),
(3, 'Sitcom'),
(4, 'Comedy');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genres_movies_mm`
--

CREATE TABLE `genres_movies_mm` (
  `id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `genres_movies_mm`
--

INSERT INTO `genres_movies_mm` (`id`, `genre_id`, `movie_id`) VALUES
(1, 1, 3),
(2, 1, 2),
(3, 2, 1),
(4, 3, 4),
(5, 4, 5),
(6, 1, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `plot` text DEFAULT NULL,
  `year_of_publication` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `movies`
--

INSERT INTO `movies` (`id`, `title`, `plot`, `year_of_publication`) VALUES
(1, 'Titanic', NULL, NULL),
(2, 'Mission Impossible 1-n', NULL, NULL),
(3, 'James Bond', NULL, NULL),
(4, 'Friends', NULL, NULL),
(5, 'Fluch der Karibik', NULL, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `breakthrough_movie` (`breakthrough_movie`);

--
-- Indizes für die Tabelle `actors_movies_mm`
--
ALTER TABLE `actors_movies_mm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indizes für die Tabelle `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `genres_movies_mm`
--
ALTER TABLE `genres_movies_mm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indizes für die Tabelle `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `actors_movies_mm`
--
ALTER TABLE `actors_movies_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `genres_movies_mm`
--
ALTER TABLE `genres_movies_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `actors`
--
ALTER TABLE `actors`
  ADD CONSTRAINT `actors_ibfk_1` FOREIGN KEY (`breakthrough_movie`) REFERENCES `movies` (`id`);

--
-- Constraints der Tabelle `actors_movies_mm`
--
ALTER TABLE `actors_movies_mm`
  ADD CONSTRAINT `actors_movies_mm_ibfk_1` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`),
  ADD CONSTRAINT `actors_movies_mm_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints der Tabelle `genres_movies_mm`
--
ALTER TABLE `genres_movies_mm`
  ADD CONSTRAINT `genres_movies_mm_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `genres_movies_mm_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
