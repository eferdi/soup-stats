-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.10 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von View c1soupstats.most active user
-- Erstelle temporäre Tabelle um View Abhängigkeiten zuvorzukommen
CREATE TABLE `most active user` (
	`cusername` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`cuserid` VARCHAR(255) NOT NULL COMMENT 'csoupid from tusers' COLLATE 'utf8_general_ci',
	`sum(t2.ccounthelp)` DECIMAL(25,0) NULL
) ENGINE=MyISAM;


-- Exportiere Struktur von Tabelle c1soupstats.tstatsposts
CREATE TABLE IF NOT EXISTS `tstatsposts` (
  `cuserid` varchar(255) NOT NULL COMMENT 'csoupid from tusers',
  `cpost` varchar(255) NOT NULL,
  `cfromsoupname` varchar(255) NOT NULL,
  `cfromsoupid` varchar(255) NOT NULL,
  `cviasoupname` varchar(255) NOT NULL,
  `cviasoupid` varchar(255) NOT NULL,
  `crepostcounter` int(10) unsigned NOT NULL,
  `cdate` date NOT NULL,
  `ctime` time NOT NULL,
  `cposttype` varchar(255) NOT NULL,
  `ccontenttype` varchar(255) NOT NULL,
  `creaction` tinyint(1) unsigned NOT NULL,
  `cimported` tinyint(1) NOT NULL,
  `ccounthelp` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cpost`),
  UNIQUE KEY `cpost` (`cpost`),
  KEY `cfromsoupname` (`cfromsoupname`,`cfromsoupid`,`cviasoupname`,`cviasoupid`,`crepostcounter`),
  KEY `cuserid` (`cuserid`,`cpost`),
  KEY `ccontenttype` (`ccontenttype`,`creaction`,`cimported`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle c1soupstats.tstatsreposts
CREATE TABLE IF NOT EXISTS `tstatsreposts` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csoupid` varchar(255) NOT NULL,
  `cpostid` varchar(255) NOT NULL,
  `creposterid` varchar(255) NOT NULL,
  `crepostername` varchar(255) NOT NULL,
  `ccounthelp` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle c1soupstats.tusers
CREATE TABLE IF NOT EXISTS `tusers` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csoupid` varchar(255) NOT NULL,
  `cusername` varchar(255) NOT NULL,
  `cavatar` varchar(255) NOT NULL,
  `clastsince` int(255) unsigned DEFAULT NULL,
  `clastcrawl` datetime DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `csoupid` (`csoupid`,`cusername`),
  KEY `cusername` (`cusername`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von View c1soupstats.most active user
-- Entferne temporäre Tabelle und erstelle die eigentliche View
DROP TABLE IF EXISTS `most active user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`c1soupstats`@`localhost` SQL SECURITY DEFINER VIEW `most active user` AS select `t1`.`cusername` AS `cusername`,`t2`.`cuserid` AS `cuserid`,sum(`t2`.`ccounthelp`) AS `sum(t2.ccounthelp)` from (`tstatsposts` `t2` join `tusers` `t1`) where (`t1`.`csoupid` = `t2`.`cuserid`) group by `t2`.`cuserid`;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
