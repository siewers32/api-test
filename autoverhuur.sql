-- MySQL dump 10.13  Distrib 5.7.39, for osx10.12 (x86_64)
--
-- Host: localhost    Database: autoverhuur
-- ------------------------------------------------------
-- Server version	5.7.39-log

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
-- Table structure for table `autos`
--

DROP TABLE IF EXISTS `autos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autos` (
  `Kenteken` char(8) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `Merk` char(20) COLLATE latin1_general_ci DEFAULT NULL,
  `Type` char(20) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumAPK` datetime DEFAULT NULL,
  `Kilometerstand` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autos`
--

LOCK TABLES `autos` WRITE;
/*!40000 ALTER TABLE `autos` DISABLE KEYS */;
INSERT INTO `autos` VALUES ('DT-LT-87','Citroen','XM','1999-09-23 00:00:00',34500),('GF-NX-07','Volkswagen','Polo','1999-07-12 00:00:00',78000),('GF-PD-34','Volkswagen','Polo','1999-07-22 00:00:00',57500),('KR-RT-65','Volkswagen','Golf','1999-08-08 00:00:00',42000),('PT-ER-45','Ford','Fiesta','1999-03-02 00:00:00',25000),('TT-PR-73','Citroen','XM',NULL,1200),('TT-RW-01','Volkswagen','Polo','1999-11-14 00:00:00',4500);
/*!40000 ALTER TABLE `autos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `huurders`
--

DROP TABLE IF EXISTS `huurders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `huurders` (
  `Huurdernr` int(11) DEFAULT '0',
  `Naam` char(25) COLLATE latin1_general_ci DEFAULT NULL,
  `Adres` char(25) COLLATE latin1_general_ci DEFAULT NULL,
  `Postcode` char(7) COLLATE latin1_general_ci DEFAULT NULL,
  `Plaats` char(25) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `huurders`
--

LOCK TABLES `huurders` WRITE;
/*!40000 ALTER TABLE `huurders` DISABLE KEYS */;
INSERT INTO `huurders` VALUES (12563,'De Gier','Lokkerlandsdijk 23','3234 KN','Tinte'),(13876,'Plomp Acc','Fuutstraat 28','1121 BN','Landsmeer'),(20036,'Jos Francke','Mathernesserlaan 437','3081 FV','Rotterdam'),(23135,'Gekroonden','Lange haven 72','3111 CH','Schiedam'),(48212,'Medina BV','Erfdijk 38','3079 TR','Rotterdam'),(51884,'Wendel','Weteringlaan 149','5032 XX','Tilburg'),(53441,'Van Aal / De Graaf','Duifstraat 12','3136 XH','Vlaardingen'),(59067,'Van Waveren','Churchillstraat 40','1411 XD','Naarden'),(73775,'Paardekoper BV','Sluisjesdijk 103','3087 AE','Rotterdam'),(84930,'Van Aalst','Coolhaven 128 a','3024 AK','Rotterdam'),(93323,'Strijbosch','Houtvester 46','3834 CX','Leusden'),(95201,'Pieters','Gouwsingel 26','1566 XB','Assendelft');
/*!40000 ALTER TABLE `huurders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijzen`
--

DROP TABLE IF EXISTS `prijzen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prijzen` (
  `Merk` char(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `Type` char(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `PrijsPerDag` double DEFAULT '0',
  `PrijsPerDagDeel` double DEFAULT '0',
  `PrijsPerWeek` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijzen`
--

LOCK TABLES `prijzen` WRITE;
/*!40000 ALTER TABLE `prijzen` DISABLE KEYS */;
INSERT INTO `prijzen` VALUES ('Citroen','XM',93,67.5,525.7),('Ford','Fiesta',67,43,325),('Volkswagen','Golf',82,44,475),('Volkswagen','Polo',72.5,45.9,396);
/*!40000 ALTER TABLE `prijzen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verhuur`
--

DROP TABLE IF EXISTS `verhuur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verhuur` (
  `Kenteken` char(8) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumVerhuur` datetime DEFAULT NULL,
  `Huurdernr` int(11) DEFAULT '0',
  `Identificatie` char(15) COLLATE latin1_general_ci DEFAULT NULL,
  `DatumRetour` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verhuur`
--

LOCK TABLES `verhuur` WRITE;
/*!40000 ALTER TABLE `verhuur` DISABLE KEYS */;
INSERT INTO `verhuur` VALUES ('DT-LT-87','1999-11-10 00:00:00',20036,'P 78JKD','1999-11-11 00:00:00'),('DT-LT-87','1999-11-12 00:00:00',51884,'A 3644-33','1999-11-12 00:00:00'),('DT-LT-87','1999-11-12 00:00:00',95201,'A 7373893','1999-11-18 00:00:00'),('DT-LT-87','1999-11-15 00:00:00',53441,'L 66336','1999-11-16 00:00:00'),('GF-NX-07','1999-11-10 00:00:00',12563,'R 8844944l','1999-11-11 00:00:00'),('GF-NX-07','1999-11-11 00:00:00',93323,'P 83390','1999-11-11 00:00:00'),('GF-NX-07','1999-11-13 00:00:00',12563,'R 8844944l','1999-11-14 00:00:00'),('GF-NX-07','1999-11-14 00:00:00',59067,'P 89833K','1999-11-14 00:00:00'),('GF-PD-34','1999-11-15 00:00:00',23135,'R 883733G','1999-11-15 00:00:00'),('KR-RT-65','1999-11-10 00:00:00',59067,'A 9933KP8','1999-11-13 00:00:00'),('KR-RT-65','1999-11-14 00:00:00',48212,'R 88333GH',NULL),('PT-ER-45','1999-11-10 00:00:00',48212,'R 88333GH','1999-11-10 00:00:00'),('PT-ER-45','1999-11-11 00:00:00',23135,'R 88333GH','1999-11-11 00:00:00'),('PT-ER-45','1999-11-13 00:00:00',53441,'L 66336','1999-11-14 00:00:00'),('PT-ER-45','1999-11-14 00:00:00',93323,'P 83390','1999-11-14 00:00:00'),('tt-rw-01','1999-03-01 00:00:00',84930,'sadas','1999-05-01 00:00:00'),('TT-RW-01','1999-11-11 00:00:00',93323,'P 83390','1999-11-12 00:00:00'),('TT-RW-01','1999-11-12 00:00:00',73775,'P 744478','1999-11-12 00:00:00'),('TT-RW-01','1999-11-13 00:00:00',84930,'P J773HJ','1999-11-13 00:00:00'),('TT-RW-01','1999-11-14 00:00:00',84930,'P J773HJ','1999-11-27 00:00:00');
/*!40000 ALTER TABLE `verhuur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-06  9:36:26
