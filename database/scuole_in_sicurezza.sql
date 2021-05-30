-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 28, 2021 alle 08:19
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scuole_in_sicurezza`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `fill_calendar` (`start_date` DATE, `end_date` DATE)  BEGIN
       DECLARE crt_date DATE;
       SET crt_date=start_date;
       WHILE crt_date <= end_date DO INSERT INTO calendar VALUES(crt_date); 
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY); 
    END WHILE; END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `allarmi_in_corso`
--

CREATE TABLE `allarmi_in_corso` (
  `btmac1` varchar(17) NOT NULL,
  `btmac2` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `alunni`
--

CREATE TABLE `alunni` (
  `id_alunno` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `telefono_genitore` char(10) NOT NULL,
  `email_genitore` varchar(255) NOT NULL,
  `id_classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `alunni`
--

INSERT INTO `alunni` (`id_alunno`, `nome`, `cognome`, `telefono_genitore`, `email_genitore`, `id_classe`) VALUES
(1, 'Dan', 'Cernei', '3893445437', 'dan@genitore.it', 1),
(2, 'Stefano', 'Baldazzi', '3286775476', 'stefano@genitore.it', 2),
(3, 'Chiara', 'Nerozzi', '3434541214', 'chiara@genitore.it', 1),
(4, 'Luisella', 'Salve', '3334545654', 'luisella@genitore.it', 2),
(5, 'Daniela', 'Zanna', '3293443337', 'daniela@genitore.it', 1),
(6, 'Mario', 'Rossi', '3244587698', 'mario@genitore.it', 2),
(7, 'Roberto', 'Giotto', '3284597699', 'roberto@genitore.it', 1),
(8, 'Gianna', 'Monte', '3344576178', 'gianna@genitore.it', 2),
(9, 'Pietro', 'Rosso', '3299875023', 'pietro@genitore.it', 1),
(10, 'Pamela', 'Azzurro', '3454672456', 'pamela@genitore.it', 2),
(11, 'Camilla', 'Bella', '3894991593', 'camilla@genitore.it', 2),
(12, 'Federica', 'Esposito', '3893335437', 'federica@genitore.it', 1),
(14, 'Leonardo', 'Leoncino', '3286758748', 'leonardo@genitore.it', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `classi`
--

CREATE TABLE `classi` (
  `id_classe` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `sezione` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `classi`
--

INSERT INTO `classi` (`id_classe`, `numero`, `sezione`) VALUES
(1, 1, 'C'),
(2, 3, 'B');

-- --------------------------------------------------------

--
-- Struttura della tabella `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `btmac` varchar(17) NOT NULL,
  `status` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `device`
--

INSERT INTO `device` (`id`, `btmac`, `status`, `timestamp`) VALUES
(1, '24:0a:c4:5a:e3:d2', 0, '2021-05-18 07:15:55'),
(2, '24:0a:c4:5a:e6:ee', 0, '2021-05-18 07:15:55'),
(3, 'c4:4f:33:6a:75:1b', 0, '2021-05-18 06:28:50'),
(4, 'f0:08:d1:d7:95:6a', 0, '2021-05-17 09:44:51'),
(5, 'f0:08:d1:ca:5a:6e', 0, '2021-04-27 07:16:56'),
(6, '3c:61:05:14:0a:2a', 0, '2021-05-11 08:34:58'),
(7, '84:cc:a8:64:bf:ca', 0, '2021-05-17 17:19:41'),
(8, '84:cc:a8:64:be:da', 0, '2021-04-27 07:20:04'),
(9, '84:cc:a8:64:bd:d6', 0, '2021-04-27 07:20:04'),
(10, '24:0a:c4:5a:e7:8e', 0, '2021-04-27 07:22:30'),
(12, '8c:aa:b5:95:50:ce', 0, '2021-05-27 17:08:42'),
(14, 'f0:08:d1:d8:21:36', 0, '2021-05-27 17:08:42');

-- --------------------------------------------------------

--
-- Struttura della tabella `insegnano`
--

CREATE TABLE `insegnano` (
  `id_utente` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `insegnano`
--

INSERT INTO `insegnano` (`id_utente`, `id_classe`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `proxy`
--

CREATE TABLE `proxy` (
  `mybtmac` varchar(17) NOT NULL,
  `otherbtmac` varchar(17) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `proxy`
--

INSERT INTO `proxy` (`mybtmac`, `otherbtmac`, `timestamp`, `status`, `duration`) VALUES
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-09 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-09 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-13 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-13 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-15 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-15 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-19 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-19 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-23 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-23 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-26 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-27 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-27 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-29 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-29 02:10:45', 0, 14),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-30 02:10:31', 1, 0),
('24:0a:c4:5a:e3:d2', '24:0a:c4:5a:e6:ee', '2021-04-30 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-08 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-08 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-09 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-09 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-13 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-13 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-15 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-15 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-19 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-19 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-23 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-23 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-26 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-27 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-27 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-29 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-29 02:10:45', 0, 14),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-30 02:10:31', 1, 0),
('24:0a:c4:5a:e6:ee', '24:0a:c4:5a:e3:d2', '2021-04-30 02:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-07 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-07 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-08 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-08 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-09 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-09 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-12 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-12 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-13 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-13 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-14 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-14 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-15 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-15 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-16 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-16 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-19 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-19 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-21 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-21 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-22 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-22 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-23 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-23 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-26 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-26 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-27 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-27 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-28 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-28 06:10:45', 0, 14),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-29 06:10:31', 1, 0),
('24:0a:c4:5a:e7:8e', '84:cc:a8:64:bd:d6', '2021-04-29 06:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-07 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-07 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-08 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-08 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-09 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-09 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-12 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-12 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-13 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-13 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-14 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-14 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-15 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-16 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-16 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-19 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-19 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-21 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-23 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-23 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-26 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-26 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-28 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-28 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-29 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-29 04:10:45', 0, 14),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-30 04:10:31', 1, 0),
('3c:61:05:14:0a:2a', 'f0:08:d1:ca:5a:6e', '2021-04-30 04:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-07 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-07 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-08 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-08 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-09 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-09 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-12 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-12 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-13 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-13 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-14 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-14 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-15 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-15 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-16 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-16 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-19 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-19 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-21 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-21 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-22 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-22 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-23 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-23 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-26 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-26 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-27 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-27 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-28 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-28 06:10:45', 0, 14),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-29 06:10:31', 1, 0),
('84:cc:a8:64:bd:d6', '24:0a:c4:5a:e7:8e', '2021-04-29 06:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-07 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-07 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-08 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-08 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-09 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-09 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-12 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-12 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-13 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-13 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-14 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-14 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-16 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-16 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-19 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-19 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-21 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-21 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-23 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-23 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-26 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-26 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-27 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-27 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-28 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-28 05:10:45', 0, 14),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-29 05:10:31', 1, 0),
('84:cc:a8:64:be:da', '84:cc:a8:64:bf:ca', '2021-04-30 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-07 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-07 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-08 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-08 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-09 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-09 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-12 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-12 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-13 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-13 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-14 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-14 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-15 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-16 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-16 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-19 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-19 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-21 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-21 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-23 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-23 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-26 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-26 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-27 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-27 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-28 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-28 05:10:45', 0, 14),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-29 05:10:31', 1, 0),
('84:cc:a8:64:bf:ca', '84:cc:a8:64:be:da', '2021-04-30 05:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-08 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-08 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-09 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-09 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-13 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-13 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-14 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-14 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-15 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-15 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-19 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-19 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-23 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-23 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-26 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-26 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-28 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-28 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-29 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-29 03:10:45', 0, 14),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-30 03:10:31', 1, 0),
('c4:4f:33:6a:75:1b', 'f0:08:d1:d7:95:6a', '2021-04-30 03:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-07 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-07 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-08 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-08 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-09 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-09 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-12 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-12 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-13 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-13 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-14 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-14 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-16 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-16 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-19 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-19 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-21 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-23 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-23 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-26 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-26 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-28 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-28 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-29 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-29 04:10:45', 0, 14),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-30 04:10:31', 1, 0),
('f0:08:d1:ca:5a:6e', '3c:61:05:14:0a:2a', '2021-04-30 04:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-08 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-08 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-09 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-09 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-13 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-13 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-14 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-14 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-15 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-15 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-19 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-19 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-23 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-23 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-26 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-26 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-28 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-28 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-29 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-29 03:10:45', 0, 14),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-30 03:10:31', 1, 0),
('f0:08:d1:d7:95:6a', 'c4:4f:33:6a:75:1b', '2021-04-30 03:10:45', 0, 14);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `temp`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `temp` (
`bt` varchar(17)
,`bt2` varchar(17)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(11) NOT NULL,
  `approvazione` set('sì','no') NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `cf` char(16) NOT NULL,
  `ruolo` set('Dirigenza','Segreteria','Insegnanti','Responsabile Covid','Amministrazione') NOT NULL,
  `telefono` char(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nazione` varchar(255) NOT NULL,
  `città` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `via` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `approvazione`, `nome`, `cognome`, `cf`, `ruolo`, `telefono`, `email`, `password`, `nazione`, `città`, `provincia`, `via`) VALUES
(1, 'sì', 'Dan', 'Cernei', 'CRNDNA00T27Z140Z', 'Segreteria', '3894991593', 'dan@sicurezza.it', '$2y$12$AxqG3zgwZ26gw./TF1gG7.GqTGMm03aCe.rrp4H8SblkbrNjglAZG', 'Italia', 'Bologna', 'Bologna', 'Via Caravaggio 11'),
(2, 'sì', 'Michela', 'Ciaralli', 'MCHCLL80A41A944I', 'Insegnanti', '3200000000', 'michela@sicurezza.it', '$2y$12$/3BdcWkL4YNIrhw/5iTBRetgdCidaw5FcwnPBDTWF21K1Al9KDKKK', 'Italia', 'Bologna', 'Bologna', 'Via Ugo Bassi 12'),
(3, 'sì', 'Duilio', 'Peroni', 'PRNDLU80A01A944R', 'Responsabile Covid', '330000000', 'duilio@sicurezza.it', '$2y$12$hj0th0Aathiy5e.3C1esx.Q3p2/Q5PINpB4QU3jdhidkNrr.KUzeC', 'Italia', 'Bologna', 'Bologna', 'Via Indipendenza 13'),
(4, 'no', 'Lidia', 'Sera', 'SRELDI00M47A944I', 'Dirigenza', '3224883454', 'lidia@sicurezza.it', '$2y$12$BW6PdFF.POjMGRn5gflEzOcpWYebOi8ejMs6C1oma8mlg7O7qznX6', 'Italia', 'Bologna', 'Bologna', 'Via Speranza'),
(5, 'sì', 'Michele', 'Drago', 'DRMICU20A01A274R', 'Amministrazione', '3893227693', 'michele@sicurezza.it', '$2y$12$pUvjnTg5IRa9zplB1mbOBue.RWfs8Vg1uhGLqZjRjIDvr3G/MnfF2', 'Italia', 'Bologna', 'Bologna', 'Via Ponente');

-- --------------------------------------------------------

--
-- Struttura per vista `temp`
--
DROP TABLE IF EXISTS `temp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `temp`  AS  select `a`.`btmac1` AS `bt`,`a`.`btmac2` AS `bt2` from `allarmi_in_corso` `a` where `a`.`btmac1` <= `a`.`btmac2` union all select `b`.`btmac1` AS `bt`,`b`.`btmac2` AS `bt2` from `allarmi_in_corso` `b` where `b`.`btmac1` > `b`.`btmac2` and !exists(select 1 from `allarmi_in_corso` `t2` where `t2`.`btmac1` = `b`.`btmac2` and `t2`.`btmac2` = `b`.`btmac1` limit 1) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `allarmi_in_corso`
--
ALTER TABLE `allarmi_in_corso`
  ADD PRIMARY KEY (`btmac1`,`btmac2`),
  ADD KEY `allarmi_in_corso_ibfk_2` (`btmac2`);

--
-- Indici per le tabelle `alunni`
--
ALTER TABLE `alunni`
  ADD PRIMARY KEY (`id_alunno`),
  ADD KEY `id_classe` (`id_classe`);

--
-- Indici per le tabelle `classi`
--
ALTER TABLE `classi`
  ADD PRIMARY KEY (`id_classe`);

--
-- Indici per le tabelle `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `btmac` (`btmac`);

--
-- Indici per le tabelle `insegnano`
--
ALTER TABLE `insegnano`
  ADD PRIMARY KEY (`id_utente`,`id_classe`),
  ADD KEY `id_classe` (`id_classe`);

--
-- Indici per le tabelle `proxy`
--
ALTER TABLE `proxy`
  ADD PRIMARY KEY (`mybtmac`,`otherbtmac`,`timestamp`),
  ADD KEY `otherbtmac` (`otherbtmac`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `alunni`
--
ALTER TABLE `alunni`
  MODIFY `id_alunno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `classi`
--
ALTER TABLE `classi`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `allarmi_in_corso`
--
ALTER TABLE `allarmi_in_corso`
  ADD CONSTRAINT `allarmi_in_corso_ibfk_1` FOREIGN KEY (`btmac1`) REFERENCES `device` (`btmac`),
  ADD CONSTRAINT `allarmi_in_corso_ibfk_2` FOREIGN KEY (`btmac2`) REFERENCES `device` (`btmac`);

--
-- Limiti per la tabella `alunni`
--
ALTER TABLE `alunni`
  ADD CONSTRAINT `alunni_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`);

--
-- Limiti per la tabella `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `device_ibfk_1` FOREIGN KEY (`id`) REFERENCES `alunni` (`id_alunno`);

--
-- Limiti per la tabella `insegnano`
--
ALTER TABLE `insegnano`
  ADD CONSTRAINT `insegnano_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`),
  ADD CONSTRAINT `insegnano_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`);

--
-- Limiti per la tabella `proxy`
--
ALTER TABLE `proxy`
  ADD CONSTRAINT `proxy_ibfk_1` FOREIGN KEY (`mybtmac`) REFERENCES `device` (`btmac`),
  ADD CONSTRAINT `proxy_ibfk_2` FOREIGN KEY (`otherbtmac`) REFERENCES `device` (`btmac`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
