-- --------------------------------------------------------
-- Host:                         localhost
-- Server Version:               5.5.62-0+deb8u1 - (Debian)
-- Server Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Datenbank Struktur für Timesheet
DROP DATABASE IF EXISTS `Timesheet`;
CREATE DATABASE IF NOT EXISTS `Timesheet` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Timesheet`;

-- Exportiere Struktur von Tabelle Timesheet.feiertag
DROP TABLE IF EXISTS `feiertag`;
CREATE TABLE IF NOT EXISTS `feiertag` (
  `feiertagId` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `feiertagName` varchar(30) NOT NULL,
  PRIMARY KEY (`feiertagId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle Timesheet.feiertag: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `feiertag` DISABLE KEYS */;
/*!40000 ALTER TABLE `feiertag` ENABLE KEYS */;

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
/*!40000 ALTER TABLE `projekt` DISABLE KEYS */;
INSERT INTO `projekt` (`projektId`, `projektname`, `beschreibung`, `archiviert`) VALUES
	(1, 'TestProjekt', 'ein TestProjekt', 'false'),
	(2, 'Telefon', 'telefon in session', 'false'),
	(3, 'Salat', 'Salat Jonglieren', 'true'),
	(8, 'Hans', 'asdasdasd', 'true');
/*!40000 ALTER TABLE `projekt` ENABLE KEYS */;

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
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`userId`, `nachname`, `vorname`, `email`, `passwort`, `typ`, `soll`) VALUES
	(1, 'admin', 'admin', 'testadmin@admin.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', NULL),
	(2, 'Test', 'User', 'TestUser@test.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user', '08:20:00'),
	(3, 'adi', 'Bahwar', 'bahwar.adi@reamis.ch', '347c0f9ec90de0db8d7c0e306903c138', 'user', '140:00:00'),
	(4, 'Peter', 'Hans', 'bahwar00@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user', '09:24:13');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle Timesheet.zeit
DROP TABLE IF EXISTS `zeit`;
CREATE TABLE IF NOT EXISTS `zeit` (
  `zeitId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `projektId` int(11) NOT NULL,
  `kw` int(11) NOT NULL,
  `datum` date NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL,
  `pause` time DEFAULT NULL,
  `beschreibung` tinytext NOT NULL,
  PRIMARY KEY (`zeitId`),
  KEY `FK_zeit_user` (`userId`),
  KEY `FK_zeit_projekt` (`projektId`),
  CONSTRAINT `FK_zeit_projekt` FOREIGN KEY (`projektId`) REFERENCES `projekt` (`projektId`),
  CONSTRAINT `FK_zeit_user` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle Timesheet.zeit: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `zeit` DISABLE KEYS */;
/*!40000 ALTER TABLE `zeit` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
