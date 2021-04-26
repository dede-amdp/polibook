-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2021 alle 18:09
-- Versione del server: 8.0.21
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_polibooklet`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appello`
--

CREATE TABLE IF NOT EXISTS `appello` (
  `id_corso_esame` varchar(6) CHARACTER SET utf8  NOT NULL,
  `id_attdid_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid_esame` varchar(10) NOT NULL,
  `id_docente_esame` varchar(6) NOT NULL,
  `data_inizio` datetime NOT NULL,
  `data_fine` datetime NOT NULL,
  `data_svolgimento` datetime NOT NULL,
  `aula` text NOT NULL,
  `messaggio` text NOT NULL,
  `max_iscritti` int NOT NULL,
  PRIMARY KEY (`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`,`data_svolgimento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `attdid_cdl`
--

CREATE TABLE IF NOT EXISTS `attdid_cdl` (
  `id_attdid` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid` varchar(10) NOT NULL,
  `id_cdl` varchar(6) NOT NULL,
  PRIMARY KEY (`id_attdid`,`ord_attdid`,`id_cdl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `attivita_didattica`
--

CREATE TABLE IF NOT EXISTS `attivita_didattica` (
  `id` varchar(10) NOT NULL,
  `ordinamento` varchar(10) CHARACTER SET utf8  NOT NULL,
  `cfu` int NOT NULL,
  `nome` blob NOT NULL,
  `descrizione` blob NOT NULL,
  `programma` blob NOT NULL,
  PRIMARY KEY (`id`,`ordinamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `attivita_didattica`
--

INSERT INTO `attivita_didattica` (`id`, `ordinamento`, `cfu`, `nome`, `descrizione`, `programma`) VALUES
('0000', '2020/2021', 0, 0x72656776656762726777623372627277, 0x49542c20414243443b0d0a454e2c20444342413b, 0x7a66767a6466627a64626e7a676861646376);

-- --------------------------------------------------------

--
-- Struttura della tabella `avvisi`
--

CREATE TABLE IF NOT EXISTS `avvisi` (
  `timestamp` datetime NOT NULL,
  `titolo` tinytext NOT NULL,
  `contenuto` blob NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cdl`
--

CREATE TABLE IF NOT EXISTS `cdl` (
  `id` varchar(6) NOT NULL,
  `nome` blob NOT NULL,
  `descrizione` blob NOT NULL,
  `cfu_totali` int NOT NULL,
  `id_facolta` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` varchar(6) NOT NULL,
  `nome` tinytext NOT NULL,
  `cognome` tinytext NOT NULL,
  `CV` blob NOT NULL,
  `cellulare` varchar(13) CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cellulare` (`cellulare`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE IF NOT EXISTS `esame` (
  `id_corso` varchar(6) CHARACTER SET utf8  NOT NULL,
  `id_attdid` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid` varchar(10) NOT NULL,
  `id_docente` varchar(6) NOT NULL,
  PRIMARY KEY (`id_corso`,`id_attdid`,`ord_attdid`,`id_docente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `facolta`
--

CREATE TABLE IF NOT EXISTS `facolta` (
  `id` varchar(10) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `frequentato`
--

CREATE TABLE IF NOT EXISTS `frequentato` (
  `matricola_studente` varchar(6) NOT NULL,
  `id_corso_esame` varchar(6) CHARACTER SET utf8  NOT NULL,
  `id_attdid_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid_esame` varchar(10) NOT NULL,
  `id_docente_esame` varchar(6) NOT NULL,
  `superato` tinyint(1) NOT NULL DEFAULT '0',
  `data_svolgimento` date NOT NULL,
  `voto` int DEFAULT NULL,
  `lode` tinyint(1) DEFAULT NULL,
  `questionario` tinyint(1) NOT NULL,
  PRIMARY KEY (`matricola_studente`,`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `questionario`
--

CREATE TABLE IF NOT EXISTS `questionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_compilazione` datetime NOT NULL,
  `risposte` blob NOT NULL,
  `id_esame_corso` varchar(6) NOT NULL,
  `id_esame_attdid` varchar(10) NOT NULL,
  `ord_esame_attdid` varchar(10) NOT NULL,
  `id_esame_docente` varchar(6) CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`id`,`data_compilazione`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `risultato`
--

CREATE TABLE IF NOT EXISTS `risultato` (
  `matricola_studente` varchar(6) NOT NULL,
  `id_attdid_esame_appello` varchar(10) NOT NULL,
  `ord_attdid_esame_appello` varchar(10) NOT NULL,
  `id_docente_esame_appello` varchar(6) NOT NULL,
  `id_corso_esame_appello` varchar(10) NOT NULL,
  `status` varchar(10) CHARACTER SET utf8  DEFAULT NULL,
  `risultato` int DEFAULT NULL,
  `lode` tinyint(1) NOT NULL,
  `verbalizzazione` tinyint(1) NOT NULL DEFAULT '0',
  `data_scadenza` datetime NOT NULL,
  `data_iscrizione` datetime NOT NULL,
  PRIMARY KEY (`matricola_studente`,`id_attdid_esame_appello`,`ord_attdid_esame_appello`,`id_docente_esame_appello`,`id_corso_esame_appello`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `studente`
--

CREATE TABLE IF NOT EXISTS `studente` (
  `matricola` varchar(6) NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `nome` tinytext NOT NULL,
  `cognome` tinytext NOT NULL,
  `cf` varchar(16) NOT NULL,
  `data_nascita` date NOT NULL,
  `indirizzo` mediumtext NOT NULL,
  `foto` blob NOT NULL,
  `id_cdl` varchar(6) CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`matricola`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
