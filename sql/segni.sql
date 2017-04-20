-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Apr 20, 2017 alle 14:49
-- Versione del server: 5.6.31
-- Versione PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `segni`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Accesso`
--

CREATE TABLE IF NOT EXISTS `Accesso` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_roman_ci NOT NULL,
  `passcode` varchar(25) COLLATE utf8_roman_ci NOT NULL,
  `amministrazione` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `Accesso`
--

INSERT INTO `Accesso` (`id`, `username`, `passcode`, `amministrazione`) VALUES
(1, 'paolino.paperino', 'quack', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

CREATE TABLE IF NOT EXISTS `Evento` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `durata` int(11) NOT NULL,
  `tipologia` int(11) NOT NULL COMMENT 'FK to tipologiaEvento(id)',
  `eta_min` int(2) NOT NULL DEFAULT '0',
  `eta_max` int(3) NOT NULL DEFAULT '0',
  `ticket` tinyint(1) NOT NULL,
  `speciale_ragazzi` tinyint(1) NOT NULL DEFAULT '0',
  `descrizione_ita` text NOT NULL,
  `descrizione_eng` text CHARACTER SET utf8 COLLATE utf8_roman_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Evento`
--

INSERT INTO `Evento` (`id`, `nome`, `durata`, `tipologia`, `eta_min`, `eta_max`, `ticket`, `speciale_ragazzi`, `descrizione_ita`, `descrizione_eng`) VALUES
(1, 'Rumore di Acque', 60, 1, 13, 150, 0, 0, '', ''),
(2, 'Il Fuoco nel Silenzio', 70, 1, 6, 150, 0, 0, '', ''),
(3, 'MYLOEMAYA', 50, 1, 3, 5, 1, 0, 'Un lungo tavolo bianco e due curiosi personaggi che inventano un nuovo modo di  apparecchiare dove tutto diventa musica, canto, gioco. Ogni stoviglia è un suono per uno spettacolo di teatro musicale ed esperienza tattile che permette di avvicinare i più piccoli al mondo  dell’opera lirica. Da ascoltare insieme,  \r\nda cantare insieme.', 'A table set becomes a sound art installation to be explored and listened to.'),
(4, 'Il Giardino di Gaia', 45, 1, 1, 5, 1, 0, '', ''),
(5, 'Buio', 45, 1, 2, 5, 1, 0, '', ''),
(6, 'Semino', 45, 1, 2, 6, 1, 0, '', ''),
(7, 'Lupus in Fabula', 45, 1, 3, 5, 1, 0, '', ''),
(8, 'Let''s play Kawara', 60, 2, 3, 5, 1, 0, '', ''),
(9, 'A Passeggio con i Pennelli', 45, 2, 3, 7, 0, 0, '', ''),
(10, 'Le Città Incantate - suoni e visioni dal Giappone', 45, 1, 3, 10, 1, 0, '', ''),
(11, 'L''ultimo Lupo', 120, 4, 6, 150, 1, 0, '', ''),
(12, 'Playcity', 120, 3, 0, 0, 0, 0, '', ''),
(13, 'Little Bang', 60, 1, 4, 10, 1, 0, '', ''),
(14, 'Tripula', 55, 1, 5, 10, 1, 0, 'Torna a grande richiesta lo spettacolo emozionante sull’avventura dei fratelli Montgolfier che diventa metafora del volo e del potere d’immaginazione dell’uomo che rende possibili importanti progressi. Come in un vero e proprio  viaggio in mongolfiera gli spettatori vengono fatti accomodare in un enorme pallone aerostatico, ne diventano l’equipaggio, e sono attivamente coinvolti in alcune azioni necessarie alla navigazione. Divertimento assicurato che fa della didattica un gioco da ragazzi.', 'An exciting show about Mongolfier brothers’ adventure that becomes a metaphor of flight and human imagination.'),
(15, 'In Viaggio per l''Europa', 120, 3, 14, 18, 0, 1, 'Uno spazio di confronto dedicato agli studenti degli Istituti Superiori per  scoprire strumenti e possibilità che l’Europa offre alle nuove generazioni nell’esplorazioni di settori professionali legati alla cultura e al teatro. Un appuntamento che offre nuove ispirazioni e contenuti per  immaginare  il  proprio futuro grazie allo SVE, Erasmus +, Europa Creativa e dove familiarizzare meglio con obiettivi e contenuti possibili dell’alternanza scuola – lavoro.', 'A space to discuss about the instruments and the opportunities that are offered by  Europe to new generations exploring the professional sectors that are linked to culture and theatre.'),
(76, 'L''alba dei vivi morenti', 30, 4, 14, 99, 1, 0, 'descrizione di test', 'test description'),
(77, 'laboratorio di dexter', 30, 3, 18, 20, 1, 1, 'descrizione di test', 'test description'),
(88, 'UsoSempreQuesto', 120, 4, 3, 28, 0, 0, 'descrizione di test', 'test description');

-- --------------------------------------------------------

--
-- Struttura della tabella `eventoLuogoData`
--

CREATE TABLE IF NOT EXISTS `eventoLuogoData` (
  `id_istanza` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_luogo` int(11) NOT NULL,
  `data` date NOT NULL,
  `orario` time NOT NULL,
  `orario_esteso` varchar(255) COLLATE utf8_roman_ci NOT NULL COMMENT 'per modellare le fasce orarie (es. lupoteca)',
  `data_ora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speciale` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `eventoLuogoData`
--

INSERT INTO `eventoLuogoData` (`id_istanza`, `id_evento`, `id_luogo`, `data`, `orario`, `orario_esteso`, `data_ora`, `speciale`) VALUES
(1, 3, 7, '2016-10-26', '09:30:00', '', '2017-04-06 06:50:24', 0),
(2, 3, 7, '2016-10-26', '17:00:00', '', '2017-04-06 06:50:24', 0),
(3, 3, 7, '2016-10-27', '09:30:00', '', '2017-04-06 06:50:24', 0),
(4, 3, 7, '2016-10-27', '11:00:00', '', '2017-04-06 06:50:24', 0),
(7, 13, 6, '2016-10-26', '10:00:00', '', '2017-04-06 06:50:24', 0),
(8, 13, 15, '2016-10-26', '17:00:00', '', '2017-07-01 22:05:00', 0),
(9, 13, 6, '2016-10-27', '09:30:00', '', '2017-04-06 06:50:24', 0),
(10, 13, 6, '2016-10-27', '17:00:00', '', '2017-04-06 06:50:24', 0),
(11, 13, 6, '2016-10-28', '09:30:00', '', '2017-04-06 06:50:24', 0),
(12, 13, 7, '2016-10-28', '17:00:00', '', '2017-03-31 22:00:00', 0),
(13, 13, 38, '2016-10-29', '10:30:00', '', '2017-01-01 00:05:00', 1),
(14, 13, 27, '2016-10-29', '16:00:00', '', '2017-09-15 11:55:00', 1),
(15, 14, 2, '2016-10-31', '20:30:00', '', '2017-04-06 06:50:24', 1),
(16, 14, 2, '2016-11-01', '11:00:00', '', '2017-04-06 06:50:24', 1),
(17, 14, 2, '2016-11-01', '18:00:00', '', '2017-04-06 06:50:24', 1),
(18, 14, 2, '2016-11-02', '09:00:00', '', '2017-04-06 06:50:24', 0),
(19, 14, 2, '2016-11-02', '11:00:00', '', '2017-04-06 06:50:24', 0),
(20, 15, 22, '2016-10-28', '14:30:00', '', '2017-04-06 06:50:24', 0),
(62, 88, 32, '2017-09-22', '11:45:00', '', '2017-10-22 11:00:00', 0),
(67, 88, 12, '2017-08-01', '09:35:18', '', '2017-08-01 04:55:00', 0),
(69, 13, 38, '2017-04-23', '03:45:00', '', '2017-04-23 01:45:00', 1),
(88, 15, 10, '2017-04-07', '01:10:00', '', '2017-04-06 23:10:00', 1),
(89, 88, 32, '2017-04-08', '04:15:00', '', '2017-04-08 02:15:00', 1),
(90, 88, 32, '2017-04-16', '12:15:00', '', '2017-04-16 10:15:00', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `eventoPersona`
--

CREATE TABLE IF NOT EXISTS `eventoPersona` (
  `id_istanza` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `tipologia` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `eventoPersona`
--

INSERT INTO `eventoPersona` (`id_istanza`, `id_evento`, `id_persona`, `tipologia`) VALUES
(1, 15, 28, 4),
(2, 15, 26, 9),
(3, 15, 27, 9),
(4, 15, 25, 9),
(5, 15, 22, 1),
(6, 15, 23, 1),
(7, 15, 24, 8),
(8, 15, 7, 13),
(9, 3, 29, 2),
(11, 3, 31, 12),
(12, 3, 32, 13),
(13, 3, 33, 5),
(106, 88, 1, 2),
(108, 88, 3, 8),
(109, 1, 5, 26);

-- --------------------------------------------------------

--
-- Struttura della tabella `Luogo`
--

CREATE TABLE IF NOT EXISTS `Luogo` (
  `id` int(11) NOT NULL,
  `lettera` varchar(5) CHARACTER SET latin1 NOT NULL COMMENT 'id del volantino evento',
  `colore` enum('orange','green','blue','red') COLLATE utf8_roman_ci NOT NULL,
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `latitudine` float NOT NULL,
  `longitudine` float NOT NULL,
  `citta` varchar(25) CHARACTER SET latin1 NOT NULL,
  `tipo_via` enum('Via','Piazza','Viale','Corso') CHARACTER SET latin1 NOT NULL DEFAULT 'Via',
  `via` varchar(75) CHARACTER SET latin1 NOT NULL,
  `numero_civico` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `Luogo`
--

INSERT INTO `Luogo` (`id`, `lettera`, `colore`, `nome`, `latitudine`, `longitudine`, `citta`, `tipo_via`, `via`, `numero_civico`) VALUES
(1, 'A', 'orange', 'Biblioteca Baratta', 45.1484, 10.7959, 'Mantova', 'Via', 'Giuseppe Garibaldi', 88),
(2, 'B', 'orange', 'Centro Culturale Contardo Ferrini', 45.1521, 10.7919, 'Mantova', 'Via', 'Giulio Romano', 15),
(3, 'C', 'orange', 'FOR.MA', 45.1517, 10.795, 'Mantova', 'Via', 'Lorenzo Gandolfo', 13),
(4, 'D', 'orange', 'Hub Socio Educativo', 45.146, 10.7986, 'Mantova', 'Via', 'Leopoldo Camillo Volta', 9),
(5, 'E', 'orange', 'Palazzo Ducale, Aula Didattica', 0, 0, 'Mantova', 'Piazza', 'Sordello', 0),
(6, 'F', 'orange', 'Palazzo Ducale, Atrio degli Arcieri', 0, 0, 'Mantova', 'Piazza', 'Pallone', 0),
(7, 'G', 'orange', 'Palazzo Ducale, Rustica', 0, 0, 'Mantova', 'Piazza', 'Santa Barbara', 0),
(8, 'H', 'orange', 'Palazzo Te, Fruttiere', 0, 0, 'Mantova', 'Viale', 'Te', 0),
(9, 'I', 'green', 'Piazza Broletto', 45.1591, 10.7957, 'Mantova', 'Piazza', 'Broletto', 0),
(10, 'J', 'green', 'Piazza Concordia', 0, 0, 'Mantova', 'Piazza', 'Concordia', 0),
(11, 'K', 'green', 'Piazza Erbe', 0, 0, 'Mantova', 'Piazza', 'Erbe', 0),
(12, 'L', 'green', 'Piazza Marconi', 0, 0, 'Mantova', 'Piazza', 'Marconi', 0),
(13, 'N', 'green', 'Piazza Sordello', 0, 0, 'Mantova', 'Piazza', 'Sordello', 0),
(14, 'O', 'orange', 'Sala Oberdan', 0, 0, 'Mantova', 'Via', 'Oberdan', 11),
(15, 'P', 'orange', 'Salone Mantegnesco, Fondazione Università di Mantova', 0, 0, 'Mantova', 'Via', 'Scarsellini', 2),
(22, 'V', 'orange', 'Teatro Bibiena', 45.158, 10.7982, 'Mantova', 'Via', 'Accademia', 47),
(27, '1', 'blue', 'Gazebo Informativo', 45.1603, 10.7972, 'Mantova', 'Piazza', 'Sordello', 0),
(32, '6', 'red', 'Punto Zero/Biglietteria', 45.159, 10.7956, 'Mantova', 'Piazza', 'Broletto', 5),
(33, '7', 'blue', 'Stazione FS', 0, 0, 'Mantova', 'Piazza', 'Don Leoni', 0),
(38, 'IZI', 'orange', 'WaWaChicccWaWa2', 15.002, 89.9888, 'Mantova', 'Piazza', 'WAWA', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `Persona`
--

CREATE TABLE IF NOT EXISTS `Persona` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_roman_ci DEFAULT NULL,
  `cognome` varchar(255) COLLATE utf8_roman_ci DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8_roman_ci DEFAULT NULL COMMENT 'per compagnie o nomi d''arte',
  `titolo` varchar(255) COLLATE utf8_roman_ci DEFAULT NULL,
  `tipologia` int(11) NOT NULL COMMENT 'FK to tipologiaPersona(id)',
  `biografia` text COLLATE utf8_roman_ci
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `Persona`
--

INSERT INTO `Persona` (`id`, `nome`, `cognome`, `alt_name`, `titolo`, `tipologia`, `biografia`) VALUES
(1, 'Marçelo', 'Maravilla', 'En?gma', '', 1, ''),
(2, NULL, NULL, 'Pixar', NULL, 2, ''),
(3, 'Lorenzo', 'Cherubini', 'Jovanotti', NULL, 1, ''),
(4, NULL, NULL, 'Microsoft', NULL, 2, ''),
(5, NULL, NULL, 'Apple', NULL, 2, ''),
(6, 'Paolino', 'Paperino', 'Donald Duck', '', 1, ''),
(7, 'Zlatan', 'Ibrahimovic', NULL, NULL, 1, ''),
(8, 'Francesco', 'Facchinetti', 'Capitano uncino con pistola', NULL, 1, ''),
(9, '', '', 'Machete Crew', 'Prima crew rapcoreasdrubalcore', 3, ''),
(10, NULL, NULL, 'Comune di Narnia', NULL, 2, ''),
(11, NULL, NULL, 'Compagnia delle Ombre', NULL, 3, ''),
(12, NULL, NULL, 'Luci Basse', NULL, 3, ''),
(13, NULL, NULL, 'Silvano Belfiore Band', NULL, 3, ''),
(15, '', '', 'Universal', '', 2, ''),
(16, '', '', 'Warner', '', 2, ''),
(17, 'Vittorio', 'Sgarbi', 'Capra', NULL, 1, ''),
(18, 'Son', 'Goku', 'Kakarot', 'Salvatore della terra n-mila volte', 1, ''),
(19, NULL, NULL, 'Bustaffa', NULL, 4, ''),
(20, NULL, NULL, 'Levoni', NULL, 4, ''),
(21, 'Matteo', 'Terzi', 'Soltanto', NULL, 1, ''),
(22, NULL, NULL, 'In search of Europe', NULL, 3, ''),
(23, NULL, NULL, 'Meeting Modern Visionaries', NULL, 3, ''),
(24, 'Lucas', 'De Man', '', NULL, 1, ''),
(25, 'Bruno', 'Marasà', NULL, 'Direttore presso bla bla', 1, ''),
(26, 'Barbara', 'Forni', NULL, 'Opportunità formative nel blabla', 1, ''),
(27, 'Giacomo', 'D''Arrigo', NULL, 'Direttore generale bla bla', 1, ''),
(28, NULL, NULL, 'Ufficio d’ informazione a Milano del Parlamento europeo', NULL, 5, ''),
(29, NULL, NULL, 'AsLiCo', NULL, 2, ''),
(30, NULL, NULL, 'Scarlattineteatro_Campsirago Residenza', NULL, 2, ''),
(31, NULL, NULL, 'Opera Baby', NULL, 5, ''),
(32, 'Serena', 'Crocco', NULL, NULL, 1, ''),
(33, 'Sara', 'Milani', NULL, NULL, 1, ''),
(34, 'Anna', 'Fascendini', NULL, NULL, 1, ''),
(36, NULL, NULL, 'Agenzia Nazionale per i Giovani', NULL, 5, ''),
(42, 'Valentino', 'Rossi', 'Dottore', '9 campionati mondiali', 1, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiaEvento`
--

CREATE TABLE IF NOT EXISTS `tipologiaEvento` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_roman_ci NOT NULL,
  `descrizione` text COLLATE utf8_roman_ci
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `tipologiaEvento`
--

INSERT INTO `tipologiaEvento` (`id`, `nome`, `descrizione`) VALUES
(1, 'spettacolo', ''),
(2, 'laboratorio', ''),
(3, 'formazione', ''),
(4, 'film', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiaEventoPersona`
--

CREATE TABLE IF NOT EXISTS `tipologiaEventoPersona` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_roman_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `tipologiaEventoPersona`
--

INSERT INTO `tipologiaEventoPersona` (`id`, `nome`) VALUES
(6, 'coproduzione'),
(1, 'in collaborazione con'),
(2, 'musica'),
(9, 'partecipa'),
(5, 'progetto'),
(29, 'reggaeEBossanova'),
(4, 'regia'),
(12, 'tipo12'),
(13, 'tipo13'),
(26, 'video'),
(8, 'visual grafici');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiaPersona`
--

CREATE TABLE IF NOT EXISTS `tipologiaPersona` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_roman_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `tipologiaPersona`
--

INSERT INTO `tipologiaPersona` (`id`, `nome`) VALUES
(5, 'altro'),
(3, 'compagnia'),
(1, 'persona'),
(2, 'produzione'),
(4, 'sponsor');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Accesso`
--
ALTER TABLE `Accesso`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Evento`
--
ALTER TABLE `Evento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tipologiabis` (`tipologia`),
  ADD KEY `id_2` (`id`);

--
-- Indici per le tabelle `eventoLuogoData`
--
ALTER TABLE `eventoLuogoData`
  ADD PRIMARY KEY (`id_istanza`),
  ADD KEY `eventoluogodata_ibfk_1` (`id_evento`),
  ADD KEY `eventoluogodata_ibfk_2` (`id_luogo`);

--
-- Indici per le tabelle `eventoPersona`
--
ALTER TABLE `eventoPersona`
  ADD PRIMARY KEY (`id_istanza`),
  ADD KEY `eventopersona_ibfk_1` (`id_evento`),
  ADD KEY `eventopersona_ibfk_2` (`id_persona`),
  ADD KEY `tipologia` (`tipologia`);

--
-- Indici per le tabelle `Luogo`
--
ALTER TABLE `Luogo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lettera` (`lettera`);

--
-- Indici per le tabelle `Persona`
--
ALTER TABLE `Persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipologiabis` (`tipologia`);

--
-- Indici per le tabelle `tipologiaEvento`
--
ALTER TABLE `tipologiaEvento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `tipologiaEventoPersona`
--
ALTER TABLE `tipologiaEventoPersona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `tipologiaPersona`
--
ALTER TABLE `tipologiaPersona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Evento`
--
ALTER TABLE `Evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT per la tabella `eventoLuogoData`
--
ALTER TABLE `eventoLuogoData`
  MODIFY `id_istanza` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT per la tabella `eventoPersona`
--
ALTER TABLE `eventoPersona`
  MODIFY `id_istanza` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT per la tabella `Luogo`
--
ALTER TABLE `Luogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT per la tabella `Persona`
--
ALTER TABLE `Persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT per la tabella `tipologiaEvento`
--
ALTER TABLE `tipologiaEvento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `tipologiaEventoPersona`
--
ALTER TABLE `tipologiaEventoPersona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT per la tabella `tipologiaPersona`
--
ALTER TABLE `tipologiaPersona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Evento`
--
ALTER TABLE `Evento`
  ADD CONSTRAINT `FKa TipoEvento` FOREIGN KEY (`tipologia`) REFERENCES `tipologiaEvento` (`id`);

--
-- Limiti per la tabella `eventoLuogoData`
--
ALTER TABLE `eventoLuogoData`
  ADD CONSTRAINT `eventoluogodata_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `Evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventoluogodata_ibfk_2` FOREIGN KEY (`id_luogo`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `eventoPersona`
--
ALTER TABLE `eventoPersona`
  ADD CONSTRAINT `eventopersona_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `Evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventopersona_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventopersona_ibfk_3` FOREIGN KEY (`tipologia`) REFERENCES `tipologiaEventoPersona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `Persona`
--
ALTER TABLE `Persona`
  ADD CONSTRAINT `FKaTipoPersona` FOREIGN KEY (`tipologia`) REFERENCES `tipologiaPersona` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
