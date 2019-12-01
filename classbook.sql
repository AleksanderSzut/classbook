-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Gru 2019, 14:42
-- Wersja serwera: 10.1.39-MariaDB
-- Wersja PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `classbook`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `friends`
--

CREATE TABLE `friends` (
  `id_knowledge` bigint(20) NOT NULL,
  `id_user_1` bigint(20) NOT NULL,
  `id_user_2` bigint(20) NOT NULL,
  `was_accepted` tinyint(4) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `friends`
--

INSERT INTO `friends` (`id_knowledge`, `id_user_1`, `id_user_2`, `was_accepted`, `date`) VALUES
(12, 4, 3, 1, '2017-05-25'),
(13, 6, 3, 1, '2017-05-25'),
(14, 2, 3, 1, '2017-05-25'),
(17, 1, 2, 0, '0000-00-00'),
(19, 1, 3, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `group_db`
--

CREATE TABLE `group_db` (
  `id` bigint(123) NOT NULL,
  `name` char(123) COLLATE utf8_polish_ci NOT NULL,
  `description` char(123) COLLATE utf8_polish_ci NOT NULL,
  `type` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  `background` bigint(20) DEFAULT NULL,
  `img` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `group_db`
--

INSERT INTO `group_db` (`id`, `name`, `description`, `type`, `date`, `background`, `img`) VALUES
(1, '1c-Publiczna szkoła podstawowa', 'Grupa publicznej szkoły podstawowej w strzelcach', 1, 123456, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `group_users`
--

CREATE TABLE `group_users` (
  `id` int(11) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_group` bigint(20) NOT NULL,
  `type` int(11) NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `group_users`
--

INSERT INTO `group_users` (`id`, `id_user`, `id_group`, `type`, `date`) VALUES
(1, 1, 1, 3, 123123123),
(8, 3, 0, 0, 1504805949);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `info_users`
--

CREATE TABLE `info_users` (
  `id_user` bigint(255) NOT NULL,
  `type` int(11) NOT NULL,
  `content` text COLLATE utf8_polish_ci,
  `view` int(11) NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `info_users`
--

INSERT INTO `info_users` (`id_user`, `type`, `content`, `view`, `date`) VALUES
(1, 4, 'Publiczne Gimnazjum W Strzelcach kraj.', 1, 12342234);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `like_post`
--

CREATE TABLE `like_post` (
  `id_like` bigint(20) NOT NULL,
  `id_user` bigint(255) NOT NULL,
  `id_post` bigint(255) NOT NULL,
  `type_like` int(11) NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `like_post`
--

INSERT INTO `like_post` (`id_like`, `id_user`, `id_post`, `type_like`, `date`) VALUES
(13, 4, 32, 1, 1495737193),
(14, 2, 32, 1, 1495737280),
(15, 3, 30, 1, 1495739526),
(16, 4, 31, 1, 1495739541),
(17, 2, 31, 1, 1495838142),
(18, 6, 31, 1, 1495838151),
(19, 1, 32, 1, 1496676976),
(20, 1, 31, 2, 1501446798),
(21, 1, 46, 1, 1496902535),
(22, 1, 43, 1, 1496943201),
(23, 1, 39, 1, 1496943202),
(24, 1, 38, 1, 1496943204),
(25, 1, 47, 1, 1497022309),
(26, 1, 48, 1, 1497100060),
(27, 3, 49, 1, 1574512381),
(28, 3, 48, 1, 1504722133),
(29, 3, 46, 1, 1504722144),
(30, 1, 49, 1, 1504722485),
(31, 3, 54, 2, 1574512387),
(32, 3, 55, 2, 1574512387),
(33, 3, 53, 1, 1574512377),
(34, 3, 52, 2, 1574512386),
(35, 3, 51, 2, 1574512383),
(36, 3, 40, 1, 1574512648);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_item` bigint(20) NOT NULL,
  `type_news` bigint(20) NOT NULL,
  `view` tinyint(1) NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `news`
--

INSERT INTO `news` (`id`, `id_user`, `id_item`, `type_news`, `view`, `date`) VALUES
(15, 3, 8, 1, 1, 1495653001),
(17, 3, 9, 1, 1, 1495655284),
(18, 3, 10, 1, 1, 1495655335),
(19, 3, 11, 1, 1, 1495655371),
(20, 3, 13, 1, 1, 1495737193),
(21, 3, 14, 1, 1, 1495737280),
(26, 1, 15, 1, 1, 1495739503),
(27, 3, 16, 1, 1, 1495739541),
(28, 3, 17, 1, 1, 1495838142),
(29, 3, 18, 1, 1, 1495838151),
(31, 2, 17, 2, 1, 1495838308),
(32, 3, 19, 1, 1, 1496676976),
(33, 3, 20, 1, 1, 1496757711),
(34, 3, 1, 3, 0, 1503098843),
(35, 1, 27, 1, 1, 1504722128),
(36, 1, 28, 1, 1, 1504722133),
(37, 1, 29, 1, 1, 1504722144),
(38, 1, 31, 1, 1, 1574512371),
(39, 1, 32, 1, 1, 1574512375),
(40, 1, 33, 1, 1, 1574512377),
(41, 1, 34, 1, 1, 1574512378),
(42, 1, 35, 1, 1, 1574512379),
(43, 3, 18, 2, 0, 1574512581),
(44, 3, 19, 2, 0, 1574512612),
(45, 6, 36, 1, 0, 1574512648);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post`
--

CREATE TABLE `post` (
  `id_post` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `type` int(11) NOT NULL,
  `text` text COLLATE utf8_polish_ci NOT NULL,
  `view` int(11) NOT NULL,
  `data` bigint(20) NOT NULL,
  `img` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `post`
--

INSERT INTO `post` (`id_post`, `id_user`, `type`, `text`, `view`, `data`, `img`) VALUES
(29, 1, 1, '', 1, 1495121569, 1),
(30, 1, 1, '', 1, 1495121572, 1),
(31, 3, 1, '', 1, 1495121577, 1),
(32, 3, 1, 'Nie na widzÄ™ Å›wiata', 3, 1495652987, 0),
(36, 1, 1, 'XD', 0, 1495739650, 0),
(37, 1, 1, 'XD', 0, 1495739656, 0),
(38, 1, 1, 'XD', 0, 1495739658, 0),
(39, 1, 1, 'XD', 0, 1495739663, 0),
(40, 6, 1, 'XD', 0, 1495999162, 0),
(41, 4, 1, 'Error', 0, 1495999167, 0),
(42, 2, 1, 'Jprdl', 0, 1495999172, 0),
(43, 1, 1, '1c-Publiczna szkoÅ‚a podstawowa', 0, 1496764667, 0),
(46, 1, 1, '', 1, 1496902527, 1),
(48, 1, 1, 'ðŸ˜˜ðŸ˜ðŸ˜‚ðŸ˜Šâ¤ðŸ‘ŒðŸ˜', 0, 1497100056, 0),
(49, 1, 1, '', 1, 1503704118, 1),
(50, 3, 1, 'fes', 0, 1504722546, 0),
(51, 1, 1, 'XD', 0, 1573433776, 0),
(52, 1, 1, 'XD', 0, 1574512337, 0),
(53, 1, 1, 'JebaÄ‡ disa ', 0, 1574512350, 0),
(54, 1, 1, 'O boÅ¼e o kurwa', 0, 1574512367, 0),
(55, 1, 1, '', 0, 1574512367, 0),
(60, 1, 1, 'XD', 2, 1574512449, 0),
(61, 1, 1, '', 2, 1574512509, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `id_profile` bigint(20) NOT NULL,
  `id` int(11) NOT NULL,
  `src` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `profile`
--

INSERT INTO `profile` (`id_profile`, `id`, `src`, `date`) VALUES
(2, 1, '', 1493634980),
(3, 3, '', 1493804327),
(4, 1, '', 1496847844),
(5, 1, '', 1496847896),
(6, 1, '', 1496847900),
(7, 1, '', 1496847904),
(8, 1, '', 1496864894),
(9, 1, '', 1496864909),
(10, 1, '', 1496864927),
(11, 1, '', 1496864980),
(12, 0, '', 0),
(13, 0, '', 0),
(14, 0, '', 0),
(15, 0, '', 0),
(16, 0, '', 0),
(17, 0, '', 0),
(18, 0, '', 0),
(19, 1, '', 0),
(20, 1, '', 1496943571),
(21, 1, '', 1496943602),
(22, 1, '', 1496943621),
(23, 1, '', 1496943628),
(24, 1, '', 1496943680),
(25, 1, '', 1496943838),
(26, 1, '', 1496943840),
(27, 1, '', 1496943869),
(28, 1, '', 1496943877),
(29, 1, '', 1496943916),
(30, 1, '', 1496943923),
(31, 1, '', 1496943980),
(32, 1, '', 1496943982),
(33, 1, '', 1496943984),
(34, 1, '', 1496944007),
(35, 0, '', 1496944119),
(36, 1, '', 1496944134),
(37, 1, '', 1496944140),
(38, 1, '', 1496944215);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` tinytext CHARACTER SET utf32 COLLATE utf32_polish_ci NOT NULL,
  `name_account` text COLLATE utf8_polish_ci,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `last_name` text COLLATE utf8_polish_ci NOT NULL,
  `birthday_year` int(11) NOT NULL,
  `birthday_month` int(11) NOT NULL,
  `birthday_day` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `keys` bigint(11) NOT NULL,
  `activated` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `uknow` int(11) NOT NULL,
  `year_create` int(11) NOT NULL,
  `month_create` int(11) NOT NULL,
  `day_create` int(11) NOT NULL,
  `online_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `name_account`, `pass`, `name`, `last_name`, `birthday_year`, `birthday_month`, `birthday_day`, `sex`, `keys`, `activated`, `id_profile`, `uknow`, `year_create`, `month_create`, `day_create`, `online_time`) VALUES
(1, 'szut.aleksander@gmail.com', NULL, '$2y$10$VUsczR0keKMIg6tAsiYsS.oXbs2FOgcXPjsManb8IxmdM14EbGSUO', 'Aleksander', 'Szut', 2003, 4, 29, 1, 3782258975738, 1, 0, 0, 2016, 12, 12, 1574512675),
(2, 'test@op.pl', NULL, '$2y$10$iDUsxeG3LnQC.S0oPsFY1uf8pb.8NK87RDLxokoqvO3AwGUOQHCBC', 'Testowe ', 'Konto', 2003, 4, 29, 0, 7602585427186, 1, 0, 0, 2016, 12, 12, 1496066717),
(3, 'kowalska@op.pl', NULL, '$2y$10$DHnbvn.j.Sxyso3W9VFMvu6q1FoRSDRxhmAXHIsc34R2VS1ZvM/I.', 'Anna', 'Kowalska', 2000, 4, 29, 0, 664863838004, 1, 3, 0, 2016, 12, 13, 1574512693),
(4, 'janek@gmail.com', NULL, '$2y$10$.VLqPfU0QO69ziyn4ebVne2qvVMxOt7Atq7x7DXxjwe9Ne4khWmO6', 'Janusz', 'Kowalski', 2003, 4, 29, 1, 628830709128, 1, 0, 0, 2016, 12, 13, 1496066869),
(6, 'martyna@op.pl', NULL, '$2y$10$ogDgCoepkUSP7SoPy0HtsegHU5QLfk/SF16D9xdaIBUn2p6qcAkIG', 'Martyna', 'Walczak', 2002, 4, 19, 0, 2238496209407, 1, 0, 0, 2017, 2, 8, 1496066715);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id_knowledge`);

--
-- Indeksy dla tabeli `group_db`
--
ALTER TABLE `group_db`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `like_post`
--
ALTER TABLE `like_post`
  ADD PRIMARY KEY (`id_like`);

--
-- Indeksy dla tabeli `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- Indeksy dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `friends`
--
ALTER TABLE `friends`
  MODIFY `id_knowledge` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `group_db`
--
ALTER TABLE `group_db`
  MODIFY `id` bigint(123) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `group_users`
--
ALTER TABLE `group_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `like_post`
--
ALTER TABLE `like_post`
  MODIFY `id_like` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT dla tabeli `post`
--
ALTER TABLE `post`
  MODIFY `id_post` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT dla tabeli `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
