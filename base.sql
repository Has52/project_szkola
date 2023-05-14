-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Maj 2023, 23:48
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `mecze`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `firstTeamId` int(11) NOT NULL,
  `secondTeamId` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `end` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `games`
--

INSERT INTO `games` (`id`, `firstTeamId`, `secondTeamId`, `start`, `end`, `updatedAt`, `createdAt`) VALUES
(2, 1, 2, '2023-05-14 21:41:00', '2023-05-14 21:45:00', '2023-05-14 21:41:15', '2023-05-14 21:41:15');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `gameId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `playerId` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `goals`
--

INSERT INTO `goals` (`id`, `gameId`, `teamId`, `playerId`, `time`, `updatedAt`, `createdAt`) VALUES
(6, 2, 2, 5, '2023-05-14 21:45:13', '0000-00-00 00:00:00', '2023-05-14 21:45:13');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `playerName` text NOT NULL,
  `playerTeamId` int(11) NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `players`
--

INSERT INTO `players` (`id`, `playerName`, `playerTeamId`, `updatedAt`, `createdAt`) VALUES
(1, 'gracz1 1', 1, '2023-05-14 21:47:54', '2023-05-14 12:53:03'),
(2, 'gracz1 2', 1, '2023-05-14 21:47:54', '2023-05-14 12:53:03'),
(3, 'gracz2 1', 2, '2023-05-14 21:48:01', '2023-05-14 12:53:25'),
(4, 'gracz2 2', 2, '2023-05-14 21:48:01', '2023-05-14 12:53:25'),
(5, 'gracz2 3', 2, '2023-05-14 21:48:01', '2023-05-14 12:53:25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `teamName` text NOT NULL,
  `teamLogo` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `teams`
--

INSERT INTO `teams` (`id`, `teamName`, `teamLogo`, `points`, `updatedAt`, `createdAt`) VALUES
(1, 'Testowa druzyna 1', '4x.png', 0, '2023-05-14 12:53:03', '2023-05-14 12:53:03'),
(2, 'Testowa druzyna 2', 'mucka.png', 0, '2023-05-14 12:53:25', '2023-05-14 12:53:25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `updatedAt`, `createdAt`) VALUES
(16, '23132113213', '395f264ec99525aebe10d3a9aa7492388c88897c', '2023-02-07 10:41:34', '2023-02-07 10:41:34'),
(18, '23132113213dssdasda', '602d02509a46a54cd5d3095c1c172ebf7a4fbd7e', '2023-02-07 10:41:44', '2023-02-07 10:41:44'),
(21, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2023-02-28 10:15:08', '2023-02-28 10:14:22');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;