-- Exportiere Datenbank Struktur für Timesheet
DROP DATABASE IF EXISTS `Timesheet`;
CREATE DATABASE IF NOT EXISTS `Timesheet` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Timesheet`;


-- Exportiere Struktur von Tabelle Timesheet.projekt
DROP TABLE IF EXISTS `projekt`;
CREATE TABLE IF NOT EXISTS `projekt` (
  `projektId` int(11) NOT NULL AUTO_INCREMENT,
  `projektname` varchar(50) NOT NULL,
  `beschreibung` tinytext NOT NULL,
  `archiviert` tinytext NOT NULL,
  PRIMARY KEY (`projektId`),
  UNIQUE KEY `Schlüssel 2` (`projektname`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle Timesheet.projekt: ~4 rows (ungefähr)
INSERT INTO `projekt` (`projektId`, `projektname`, `beschreibung`, `archiviert`) VALUES
	(1, 'Ferien', 'Bei abwesenheit wegen Ferien', 'false'),
	(1, 'Feiertage', 'Bei abwesenheit wegen Feiertage', 'false'),
	(1, 'Krank', 'Bei abwesenheit wegen Krankheit', 'false'),

-- Exportiere Struktur von Tabelle Timesheet.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `nachname` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwort` varchar(50) NOT NULL,
  `typ` varchar(50) NOT NULL,
  `soll` time DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle Timesheet.user: ~4 rows (ungefähr)
DELETE FROM `user`;
INSERT INTO `user` (`userId`, `nachname`, `vorname`, `email`, `passwort`, `typ`, `soll`) VALUES
	(1, 'Admin', 'Admin', 'admin@reamis.ch', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', NULL),
	(2, 'Bertolf', 'Simon', 'simon.bertolf@reamsi.ch', '827ccb0eea8a706c4c34a16891f84e7b', 'user', NULL),

-- Exportiere Struktur von Tabelle Timesheet.zeit
DROP TABLE IF EXISTS `zeit`;
CREATE TABLE IF NOT EXISTS `zeit` (
  `zeitId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `projektId` int(11) NOT NULL,
  `datum` date NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL,
  `beschreibung` tinytext NOT NULL,
  PRIMARY KEY (`zeitId`),
  KEY `FK_zeit_user` (`userId`),
  KEY `FK_zeit_projekt` (`projektId`),
  CONSTRAINT `FK_zeit_projekt` FOREIGN KEY (`projektId`) REFERENCES `projekt` (`projektId`),
  CONSTRAINT `FK_zeit_user` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
