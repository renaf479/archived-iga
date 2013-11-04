# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.25)
# Database: williefu_iga
# Generation Time: 2013-11-04 02:36:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `meta` text,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `meta`, `votes`)
VALUES
	(1,'{\"title\":\"Bioshock Infinite\",\"hashtag\":\"BioshockInfinite\",\"image\":\"bioshockinfinite.jpg\"}',55),
	(2,'{\"title\":\"Tomb Raider\",\"hashtag\":\"TombRaider\",\"image\":\"tombraider.jpg\"}',117),
	(3,'{\"title\":\"Grand Theft Auto V\",\"hashtag\":\"GTAV\",\"image\":\"gtav.jpg\"}',117),
	(4,'{\"title\":\"Saint\'s Row 4\",\"hashtag\":\"SaintsRow4\",\"image\":\"saintsrow4.jpg\"}',110),
	(5,'{\"title\":\"The Last of Us\",\"hashtag\":\"TheLastOfUs\",\"image\":\"lastofus.jpg\"}',111),
	(6,'{\"title\":\"Beyond: Two Souls\",\"hashtag\":\"Beyond2Souls\",\"image\":\"beyond.jpg\"}',112),
	(7,'{\"title\":\"Gone Home\",\"hashtag\":\"GoneHome\",\"image\":\"gonehome.jpg\"}',111),
	(8,'{\"title\":\"Pokemon X & Y\",\"hashtag\":\"PokemonX&Y\",\"image\":\"pokemon.jpg\"}',113),
	(9,'{\"title\":\"Rayman Legends\",\"hashtag\":\"RaymanLegends\",\"image\":\"raymanlegends.jpg\"}',110),
	(10,'{\"title\":\"Brothers: A Tale of Two Sons\",\"hashtag\":\"Brothers\",\"image\":\"brothers.jpg\"}',110);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table newsletters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsletters`;

CREATE TABLE `newsletters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
