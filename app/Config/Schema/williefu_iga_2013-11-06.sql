# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.25)
# Database: williefu_iga
# Generation Time: 2013-11-07 01:50:04 +0000
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `meta`, `votes`)
VALUES
	(1,'{\"title\":\"Bioshock Infinite\",\"hashtag\":\"BioshockInfinite\",\"image\":\"bioshockinfinite.jpg\"}',1),
	(2,'{\"title\":\"Tomb Raider\",\"hashtag\":\"TombRaider\",\"image\":\"tombraider.jpg\"}',2),
	(3,'{\"title\":\"Grand Theft Auto V\",\"hashtag\":\"GTAV\",\"image\":\"gtav.jpg\"}',1),
	(4,'{\"title\":\"Saint\'s Row 4\",\"hashtag\":\"SaintsRow4\",\"image\":\"saintsrow4.jpg\"}',1),
	(5,'{\"title\":\"The Last of Us\",\"hashtag\":\"TheLastOfUs\",\"image\":\"lastofus.jpg\"}',1),
	(6,'{\"title\":\"Battleblock Theatre\",\"hashtag\":\"BattleblockTheatre\",\"image\":\"battleblock.jpg\"}',1),
	(7,'{\"title\":\"Battlefield 4\",\"hashtag\":\"Battlefield4\",\"image\":\"bf4.jpg\"}',1),
	(8,'{\"title\":\"Call of Duty: Ghosts\",\"hashtag\":\"CoDGhosts\",\"image\":\"codghosts.jpg\"}',1),
	(9,'{\"title\":\"DOTA 2\",\"hashtag\":\"DOTA2\",\"image\":\"dota2.jpg\"}',1),
	(10,'{\"title\":\"Assassin\'s Creed 4\",\"hashtag\":\"AC4\",\"image\":\"ac4.jpg\"}',1);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
