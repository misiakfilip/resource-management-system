-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 21, 2024 at 01:14 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smz_baza_danych`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `ID` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `id_rola` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`ID`, `imie`, `nazwisko`, `email`, `haslo`, `id_rola`) VALUES
(1, 'Jan', 'Kowalski', 'admin@example.com', '$2y$10$Dvs8rt8CRnepNnNHCLL.y.54cmWP6thngPQYp7pNKwlaSUDxqCTDu', 1),
(2, 'Anna', 'Nowak', 'manager@example.com', '$2y$10$t0O7nt4xHN4v6VMWqTZlyeCabE9r5pgM51I1q.hCtQS/d5sNaRRi.', 2),
(3, 'Piotr', 'Dąbrowski', 'employee@example.com', '$2y$10$LGbloa.jSUhoN50Gh29E2.VOmUmuKquNmig/caUf6Qe/rEJUeCZMK', 3),
(4, 'Arek', 'Szparek', 'szparek@example.com', '*B81E9F4FE52C1F5ED3559FC2BE7F09EC16865E19', 3),
(5, 'Arek', 'Kowalski', 'kowalski@example.com', '*73251B9BAC02D283845559F2AF2F9E5A048EFA17', 2),
(12, 'Filip', 'Marecki', 'marecki@example.com', '$2y$10$6xqqMB3E24DCyFmVif0aFOGoaqfY5kKVcXpbkJo15SF4vOTlDPotG', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekty`
--

CREATE TABLE `projekty` (
  `ID` int(11) NOT NULL,
  `nazwa_projektu` varchar(100) NOT NULL,
  `data_rozpoczecia` date NOT NULL,
  `data_zakonczenia` date NOT NULL,
  `kierownik_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projekty`
--

INSERT INTO `projekty` (`ID`, `nazwa_projektu`, `data_rozpoczecia`, `data_zakonczenia`, `kierownik_id`) VALUES
(1, 'Projekt A', '2023-01-01', '2023-03-31', 2),
(2, 'Projekt B', '2023-02-15', '2023-05-15', 3),
(4, 'Projekt D', '2024-01-01', '0000-00-00', 1),
(5, 'nowy projekty 2', '2024-01-01', '2024-01-14', 2),
(12, 'projekt xd', '2024-01-01', '2024-01-14', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nazwa`) VALUES
(1, 'Administrator'),
(2, 'Pracownik'),
(3, 'Kierownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `ID` int(11) NOT NULL,
  `nazwa_zadania` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `status` enum('do wykonania','w trakcie','zakonczone') NOT NULL,
  `projekt_id` int(11) DEFAULT NULL,
  `pracownik_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zadania`
--

INSERT INTO `zadania` (`ID`, `nazwa_zadania`, `opis`, `status`, `projekt_id`, `pracownik_id`) VALUES
(1, 'Analiza wymagań', 'Przygotowanie dokumentu z analizą wymagań', 'do wykonania', 1, 3),
(2, 'Tworzenie interfejsu', 'Projektowanie interfejsu użytkownika', 'w trakcie', 1, 3),
(3, 'Testowanie oprogramowania', 'Przeprowadzenie testów jednostkowych', 'do wykonania', 2, 3),
(5, 'Dokonczyc ', 'dokoncz to', 'w trakcie', 1, 1),
(7, 'Nowe zadanie', 'Koniec', 'w trakcie', NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rola` (`id_rola`);

--
-- Indeksy dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `kierownik_id` (`kierownik_id`);

--
-- Indeksy dla tabeli `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `projekt_id` (`projekt_id`),
  ADD KEY `pracownik_id` (`pracownik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `projekty`
--
ALTER TABLE `projekty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zadania`
--
ALTER TABLE `zadania`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`id_rola`) REFERENCES `role` (`id`);

--
-- Constraints for table `projekty`
--
ALTER TABLE `projekty`
  ADD CONSTRAINT `kierownik_id` FOREIGN KEY (`kierownik_id`) REFERENCES `pracownicy` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `zadania`
--
ALTER TABLE `zadania`
  ADD CONSTRAINT `pracownik_id` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownicy` (`ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `projekt_id` FOREIGN KEY (`projekt_id`) REFERENCES `projekty` (`ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE USER 'SMZ'@'localhost' IDENTIFIED BY 'haslo123';
GRANT ALL PRIVILEGES ON smz_baza_danych.* TO 'SMZ'@'localhost';
FLUSH PRIVILEGES;

