CREATE DATABASE  IF NOT EXISTS `php` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `php`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: instanz1.cf6ecdewusof.eu-central-1.rds.amazonaws.com    Database: php
-- ------------------------------------------------------
-- Server version	5.6.27-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attacken`
--

DROP TABLE IF EXISTS `attacken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attacken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `schaden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attacken`
--

LOCK TABLES `attacken` WRITE;
/*!40000 ALTER TABLE `attacken` DISABLE KEYS */;
INSERT INTO `attacken` VALUES (1,'Aquaknarre',5),(2,'Tackle',3),(3,'Rankenhieb',5),(4,'Rasierklinge',6),(5,'Flammenwurf',6),(6,'Hitzekoller',4),(7,'Bodycheck',3),(8,'Fuchtler',3),(9,'Aquahaubitze',6),(10,'Platscher',1),(11,'Heuler',1);
/*!40000 ALTER TABLE `attacken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokemon`
--

DROP TABLE IF EXISTS `pokemon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pokename` varchar(255) DEFAULT NULL,
  `kp` int(11) NOT NULL,
  `staerke` double NOT NULL,
  `att1` int(11) NOT NULL,
  `att2` int(11) NOT NULL,
  `att3` int(11) NOT NULL,
  `att4` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `att1` (`att1`),
  KEY `att2` (`att2`),
  KEY `att3` (`att3`),
  KEY `att4` (`att4`),
  CONSTRAINT `pokemon_ibfk_1` FOREIGN KEY (`att1`) REFERENCES `attacken` (`id`),
  CONSTRAINT `pokemon_ibfk_2` FOREIGN KEY (`att2`) REFERENCES `attacken` (`id`),
  CONSTRAINT `pokemon_ibfk_3` FOREIGN KEY (`att3`) REFERENCES `attacken` (`id`),
  CONSTRAINT `pokemon_ibfk_4` FOREIGN KEY (`att4`) REFERENCES `attacken` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemon`
--

LOCK TABLES `pokemon` WRITE;
/*!40000 ALTER TABLE `pokemon` DISABLE KEYS */;
INSERT INTO `pokemon` VALUES (1,'Bisasam',20,0.5,3,4,7,11),(2,'Schiggy',20,0.5,1,9,2,10),(3,'Glumanda',20,0.5,5,6,8,11);
/*!40000 ALTER TABLE `pokemon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spielstand`
--

DROP TABLE IF EXISTS `spielstand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spielstand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spielerid` int(11) NOT NULL,
  `saved_at` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `pokemon` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pokemon` (`pokemon`),
  KEY `spielerid` (`spielerid`),
  CONSTRAINT `spielstand_ibfk_1` FOREIGN KEY (`pokemon`) REFERENCES `pokemon` (`id`),
  CONSTRAINT `spielstand_ibfk_2` FOREIGN KEY (`spielerid`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwort` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `changed_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `passwortcode` varchar(45) DEFAULT NULL,
  `passwortcode_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-12 20:07:57
