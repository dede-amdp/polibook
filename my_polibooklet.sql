-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 03, 2021 alle 17:09
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
  `ord_attdid_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `id_docente_esame` varchar(6) CHARACTER SET utf8  NOT NULL,
  `data_svolgimento` datetime NOT NULL,
  `data_inizio` datetime NOT NULL,
  `data_fine` datetime NOT NULL,
  `aula` text NOT NULL,
  `messaggio` text CHARACTER SET utf8  NOT NULL,
  `max_iscritti` int NOT NULL,
  PRIMARY KEY (`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`,`data_svolgimento`),
  KEY `fk_esame` (`id_attdid_esame`,`ord_attdid_esame`,`id_corso_esame`,`id_docente_esame`),
  KEY `fk_appello` (`id_attdid_esame`,`id_corso_esame`,`id_docente_esame`,`ord_attdid_esame`,`data_svolgimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `attdid_cdl`
--

CREATE TABLE IF NOT EXISTS `attdid_cdl` (
  `id_attdid` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid` varchar(10) NOT NULL,
  `id_cdl` varchar(6) NOT NULL,
  `anno` varchar(1) NOT NULL,
  `semestre` varchar(1) NOT NULL,
  `percorso` tinytext CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`id_attdid`,`ord_attdid`,`id_cdl`),
  KEY `fk_cdl` (`id_cdl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

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
  `SSD` tinytext NOT NULL,
  PRIMARY KEY (`id`,`ordinamento`),
  KEY `fk_attdid` (`id`,`ordinamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `attivita_didattica`
--

INSERT INTO `attivita_didattica` (`id`, `ordinamento`, `cfu`, `nome`, `descrizione`, `programma`, `SSD`) VALUES
('ANLMAT', '2020/2021', 12, 0x6974613a416e616c697369204d6174656d61746963613c2f62723e6369616f3a736f6e6f20756e6120726967612061206361706f0d0a656e673a416476616e6365642043616c63756c7573, 0x3c6974613e70726f76613c2f6974613e0d0a3c656e673e746573743c2f656e673e, 0x3c6974613e70726f76613c2f6974613e0d0a3c656e673e746573743c2f656e673e, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `avvisi`
--

CREATE TABLE IF NOT EXISTS `avvisi` (
  `timestamp` datetime NOT NULL,
  `titolo` tinytext NOT NULL,
  `contenuto` blob NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_cdl` (`id`),
  KEY `fk_facolta` (`id_facolta`),
  KEY `fk_cdl1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `cdl`
--

INSERT INTO `cdl` (`id`, `nome`, `descrizione`, `cfu_totali`, `id_facolta`) VALUES
('INFING', 0x3c6974613e496e6765676e6572696120496e666f7261746963613c2f6974613e0d0a3c656e673e496e666f726d6174696f6e20456e67696e656572696e673c2f656e673e, 0x3c6974613e70726f76613c2f6974613e0d0a3c656e673e746573743c2f656e673e, 180, 'INGELEINF');

-- --------------------------------------------------------

--
-- Struttura della tabella `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` varchar(6) NOT NULL,
  `nome` tinytext NOT NULL,
  `cognome` tinytext NOT NULL,
  `CV` blob,
  `cellulare` varchar(13) CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cellulare` (`cellulare`),
  KEY `fk_docente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `docente`
--

INSERT INTO `docente` (`id`, `nome`, `cognome`, `CV`, `cellulare`) VALUES
('000001', 'Maria', 'Rottermaier', NULL, '333000000');

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE IF NOT EXISTS `esame` (
  `id_corso` varchar(6) CHARACTER SET utf8  NOT NULL,
  `id_attdid` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid` varchar(10) NOT NULL,
  `id_docente` varchar(6) NOT NULL,
  PRIMARY KEY (`id_corso`,`id_attdid`,`ord_attdid`,`id_docente`),
  KEY `fk_esame_attdid` (`id_attdid`,`ord_attdid`),
  KEY `fk_docente` (`id_docente`),
  KEY `fk_esame` (`id_corso`,`id_attdid`,`ord_attdid`,`id_docente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `facolta`
--

CREATE TABLE IF NOT EXISTS `facolta` (
  `id` varchar(10) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` blob,
  PRIMARY KEY (`id`),
  KEY `fk_facolta` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `facolta`
--

INSERT INTO `facolta` (`id`, `nome`, `descrizione`) VALUES
('INGELEINF', 'Facoltà di ingegneria elettrica e informatica', NULL);

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
  PRIMARY KEY (`matricola_studente`,`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`),
  KEY `fk_frequentato` (`id_attdid_esame`,`id_corso_esame`,`id_docente_esame`,`ord_attdid_esame`,`data_svolgimento`),
  KEY `fk_esame` (`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

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
  `data_svolgimento_appello` datetime NOT NULL,
  `status` varchar(10) CHARACTER SET utf8  DEFAULT NULL,
  `risultato` int DEFAULT NULL,
  `lode` tinyint(1) NOT NULL,
  `verbalizzazione` tinyint(1) NOT NULL DEFAULT '0',
  `data_scadenza` datetime NOT NULL,
  `data_iscrizione` datetime NOT NULL,
  PRIMARY KEY (`matricola_studente`,`id_attdid_esame_appello`,`ord_attdid_esame_appello`,`id_docente_esame_appello`,`id_corso_esame_appello`,`data_svolgimento_appello`),
  KEY `fk_risultato` (`data_svolgimento_appello`,`id_attdid_esame_appello`,`id_corso_esame_appello`,`id_docente_esame_appello`,`matricola_studente`,`ord_attdid_esame_appello`),
  KEY `fk_appello` (`id_attdid_esame_appello`,`id_corso_esame_appello`,`id_docente_esame_appello`,`ord_attdid_esame_appello`,`data_svolgimento_appello`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

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
  `foto` blob,
  `id_cdl` varchar(6) CHARACTER SET utf8  NOT NULL,
  `percorso` tinytext CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`matricola`),
  KEY `fk_studente` (`matricola`),
  KEY `fk_cdl1` (`id_cdl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `studente`
--

INSERT INTO `studente` (`matricola`, `password`, `email`, `nome`, `cognome`, `cf`, `data_nascita`, `indirizzo`, `foto`, `id_cdl`, `percorso`) VALUES
('000000', 'PASSWORD', 'a.dellealpi@studenti.fake.it', 'Adelaide', 'Delle Alpi', 'AAAABBBBCCCCDDDD', '1997-10-10', 'Via dei monti sorridenti 9', NULL, 'INFING', 'AUTOMAZIONE');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appello`
--
ALTER TABLE `appello`
  ADD CONSTRAINT `fk_appello_esame` FOREIGN KEY (`id_attdid_esame`, `ord_attdid_esame`, `id_corso_esame`, `id_docente_esame`) REFERENCES `esame` (`id_corso`, `id_attdid`, `ord_attdid`, `id_docente`);

--
-- Limiti per la tabella `attdid_cdl`
--
ALTER TABLE `attdid_cdl`
  ADD CONSTRAINT `fk_attdid` FOREIGN KEY (`id_attdid`, `ord_attdid`) REFERENCES `attivita_didattica` (`id`, `ordinamento`),
  ADD CONSTRAINT `fk_attdid_cdl` FOREIGN KEY (`id_attdid`, `ord_attdid`) REFERENCES `attivita_didattica` (`id`, `ordinamento`),
  ADD CONSTRAINT `fk_cdl` FOREIGN KEY (`id_cdl`) REFERENCES `cdl` (`id`);

--
-- Limiti per la tabella `cdl`
--
ALTER TABLE `cdl`
  ADD CONSTRAINT `fk_facolta` FOREIGN KEY (`id_facolta`) REFERENCES `facolta` (`id`);

--
-- Limiti per la tabella `esame`
--
ALTER TABLE `esame`
  ADD CONSTRAINT `fk_esame_attdid` FOREIGN KEY (`id_attdid`, `ord_attdid`) REFERENCES `attivita_didattica` (`id`, `ordinamento`),
  ADD CONSTRAINT `fk_esame_docente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id`);

--
-- Limiti per la tabella `frequentato`
--
ALTER TABLE `frequentato`
  ADD CONSTRAINT `fk_esame` FOREIGN KEY (`id_corso_esame`, `id_attdid_esame`, `ord_attdid_esame`, `id_docente_esame`) REFERENCES `esame` (`id_corso`, `id_attdid`, `ord_attdid`, `id_docente`),
  ADD CONSTRAINT `fk_studente` FOREIGN KEY (`matricola_studente`) REFERENCES `studente` (`matricola`);

--
-- Limiti per la tabella `risultato`
--
ALTER TABLE `risultato`
  ADD CONSTRAINT `fk_appello` FOREIGN KEY (`id_attdid_esame_appello`, `id_corso_esame_appello`, `id_docente_esame_appello`, `ord_attdid_esame_appello`, `data_svolgimento_appello`) REFERENCES `appello` (`id_attdid_esame`, `id_corso_esame`, `id_docente_esame`, `ord_attdid_esame`, `data_svolgimento`);

--
-- Limiti per la tabella `studente`
--
ALTER TABLE `studente`
  ADD CONSTRAINT `fk_cdl1` FOREIGN KEY (`id_cdl`) REFERENCES `cdl` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
