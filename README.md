Live demo : https://rekrutacjarekrutacja23.refy.pl/form.html

Baza danych do testów lokalnych:

--
-- Database: `kandydat`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `candidate`
--

CREATE TABLE `candidate` (
`id` int(11) NOT NULL,
`name` varchar(100) NOT NULL,
`surname` varchar(100) NOT NULL,
`birthDate` date NOT NULL,
`email` varchar(100) NOT NULL,
`education` varchar(150) NOT NULL,
`cv` varchar(200) NOT NULL,
`motivationLetter` varchar(200) NOT NULL,
`cv2` varchar(200) DEFAULT NULL,
`internships` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla tabeli `candidate`
--
ALTER TABLE `candidate`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
