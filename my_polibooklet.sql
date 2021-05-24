-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 23, 2021 alle 18:20
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
  `id_corso_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `id_attdid_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid_esame` varchar(10) CHARACTER SET utf8  NOT NULL,
  `id_docente_esame` varchar(6) CHARACTER SET utf8  NOT NULL,
  `data_svolgimento` datetime NOT NULL,
  `data_inizio` datetime NOT NULL,
  `data_fine` datetime NOT NULL,
  `aula` tinytext CHARACTER SET utf8  NOT NULL,
  `messaggio` text CHARACTER SET utf8  NOT NULL,
  `max_iscritti` int NOT NULL,
  PRIMARY KEY (`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`,`data_svolgimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `appello`
--

INSERT INTO `appello` (`id_corso_esame`, `id_attdid_esame`, `ord_attdid_esame`, `id_docente_esame`, `data_svolgimento`, `data_inizio`, `data_fine`, `aula`, `messaggio`, `max_iscritti`) VALUES
('A', 'ANLMAT', '2020/2021', '000022', '2021-05-26 00:00:00', '2021-05-03 00:00:00', '2021-05-25 00:00:00', 'H', 'TEST TEST TEST', 50);

--
-- Trigger `appello`
--
DROP TRIGGER IF EXISTS `aggdata`;
DELIMITER //
CREATE TRIGGER `aggdata` AFTER UPDATE ON `appello`
 FOR EACH ROW UPDATE risultato r SET data_svolgimento_appello=NEW.data_svolgimento WHERE r.id_docente_esame_appello=OLD.id_docente_esame AND r.id_attdid_esame_appello=OLD.id_attdid_esame AND r.ord_attdid_esame_appello=OLD.ord_attdid_esame AND r.data_svolgimento_appello=OLD.data_svolgimento AND r.id_corso_esame_appello=OLD.id_corso_esame
//
DELIMITER ;

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
  `caratterizzante` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_attdid`,`ord_attdid`,`id_cdl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `attdid_cdl`
--

INSERT INTO `attdid_cdl` (`id_attdid`, `ord_attdid`, `id_cdl`, `anno`, `semestre`, `percorso`, `caratterizzante`) VALUES
('ANLMAT', '2020/2021', 'INGINF', '1', '1', 'AUTOMAZIONE', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `attivita_didattica`
--

CREATE TABLE IF NOT EXISTS `attivita_didattica` (
  `id` varchar(10) NOT NULL,
  `ordinamento` varchar(10) CHARACTER SET utf8  NOT NULL,
  `cfu` int NOT NULL,
  `nome` text NOT NULL,
  `descrizione` text NOT NULL,
  `programma` blob NOT NULL,
  `SSD` tinytext NOT NULL,
  PRIMARY KEY (`id`,`ordinamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `attivita_didattica`
--

INSERT INTO `attivita_didattica` (`id`, `ordinamento`, `cfu`, `nome`, `descrizione`, `programma`, `SSD`) VALUES
('ANLMAT', '2020/2021', 12, 'ita:Analisi Matematica</br>ciao:sono una riga a capo\r\neng:Advanced Calculus', 'ita:prova\r\neng:test', 0x3c6974613e70726f76613c2f6974613e0d0a3c656e673e746573743c2f656e673e, 'MAT03');

-- --------------------------------------------------------

--
-- Struttura della tabella `avviso`
--

CREATE TABLE IF NOT EXISTS `avviso` (
  `timestamp` datetime NOT NULL,
  `titolo` tinytext NOT NULL,
  `contenuto` text NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Struttura della tabella `cdl`
--

CREATE TABLE IF NOT EXISTS `cdl` (
  `id` varchar(6) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` text NOT NULL,
  `cfu_totali` int NOT NULL,
  `id_facolta` varchar(10) NOT NULL,
  `tipologia` tinytext NOT NULL,
  `durata` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `cdl`
--

INSERT INTO `cdl` (`id`, `nome`, `descrizione`, `cfu_totali`, `id_facolta`, `tipologia`, `durata`) VALUES
('INFING', '<ita>Ingegneria Inforatica</ita>\r\n<eng>Information Engineering</eng>', '<ita>prova</ita>\r\n<eng>test</eng>', 180, 'INGELEINF', 'TRIENNALE', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` varchar(6) NOT NULL,
  `nome` tinytext NOT NULL,
  `cognome` tinytext NOT NULL,
  `CV` text,
  `cellulare` varchar(13) CHARACTER SET utf8  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `docente`
--

INSERT INTO `docente` (`id`, `nome`, `cognome`, `CV`, `cellulare`) VALUES
('000022', 'Maria', 'Rottermaier', NULL, '333000000');

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE IF NOT EXISTS `esame` (
  `id_corso` varchar(10) CHARACTER SET utf8  NOT NULL,
  `id_attdid` varchar(10) CHARACTER SET utf8  NOT NULL,
  `ord_attdid` varchar(10) NOT NULL,
  `id_docente` varchar(6) NOT NULL,
  PRIMARY KEY (`id_corso`,`id_attdid`,`ord_attdid`,`id_docente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `facolta`
--

CREATE TABLE IF NOT EXISTS `facolta` (
  `id` varchar(10) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
  `data_svolgimento` date DEFAULT NULL,
  `voto` int DEFAULT NULL,
  `lode` tinyint(1) DEFAULT NULL,
  `questionario` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`matricola_studente`,`id_corso_esame`,`id_attdid_esame`,`ord_attdid_esame`,`id_docente_esame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `frequentato`
--

INSERT INTO `frequentato` (`matricola_studente`, `id_corso_esame`, `id_attdid_esame`, `ord_attdid_esame`, `id_docente_esame`, `superato`, `data_svolgimento`, `voto`, `lode`, `questionario`) VALUES
('000000', 'A', 'ANLMAT', '2020/2021', '000022', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `questionario`
--

CREATE TABLE IF NOT EXISTS `questionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_compilazione` datetime NOT NULL,
  `risposte` text NOT NULL,
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
  PRIMARY KEY (`matricola_studente`,`id_attdid_esame_appello`,`ord_attdid_esame_appello`,`id_docente_esame_appello`,`id_corso_esame_appello`,`data_svolgimento_appello`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `studente`
--

CREATE TABLE IF NOT EXISTS `studente` (
  `matricola` varchar(6) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8  NOT NULL,
  `email` text CHARACTER SET utf8  NOT NULL,
  `nome` tinytext CHARACTER SET utf8  NOT NULL,
  `cognome` tinytext NOT NULL,
  `cf` varchar(16) NOT NULL,
  `data_nascita` date NOT NULL,
  `indirizzo` text CHARACTER SET utf8  NOT NULL,
  `foto` blob,
  `id_cdl` varchar(6) CHARACTER SET utf8  NOT NULL,
  `percorso` tinytext CHARACTER SET utf8  NOT NULL,
  `anno_iscrizione` varchar(9) NOT NULL,
  `anno_corso` int NOT NULL,
  PRIMARY KEY (`matricola`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dump dei dati per la tabella `studente`
--

INSERT INTO `studente` (`matricola`, `password`, `email`, `nome`, `cognome`, `cf`, `data_nascita`, `indirizzo`, `foto`, `id_cdl`, `percorso`, `anno_iscrizione`, `anno_corso`) VALUES
('000000', 'PASSWORD', 'a.dellealpi@studenti.fake.it', 'Adelaide', 'Delle Alpi', 'AAAABBBBCCCCDDDD', '1997-10-10', 'Via dei monti sorridenti 9', NULL, 'INFING', 'AUTOMAZIONE', '2020', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
