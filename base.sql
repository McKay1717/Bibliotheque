-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: etu
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1

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
-- Table structure for table `ADHERENT`
--

DROP TABLE IF EXISTS `ADHERENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADHERENT` (
  `idAdherent` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomAdherent` varchar(50) DEFAULT NULL,
  `datePaiement` date NOT NULL,
  `adresse` text,
  PRIMARY KEY (`idAdherent`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ADHERENT`
--

LOCK TABLES `ADHERENT` WRITE;
/*!40000 ALTER TABLE `ADHERENT` DISABLE KEYS */;
INSERT INTO `ADHERENT` VALUES (1,'millet','2016-05-19','Coucou'),(4,'bedez','2016-05-19',NULL),(6,'cambot','2016-05-19',NULL),(7,'bonilla','2016-05-19',NULL),(8,'asproitis','2016-05-19',NULL),(9,'pereira','2016-05-19',NULL),(10,'dupont','2016-05-19',NULL),(11,'Test','2015-06-10','Rue des tests');
/*!40000 ALTER TABLE `ADHERENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AUTEUR`
--

DROP TABLE IF EXISTS `AUTEUR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AUTEUR` (
  `idAuteur` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomAuteur` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `prenomAuteur` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idAuteur`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AUTEUR`
--

LOCK TABLES `AUTEUR` WRITE;
/*!40000 ALTER TABLE `AUTEUR` DISABLE KEYS */;
INSERT INTO `AUTEUR` VALUES (1,'Christie','agatha'),(2,'Chateaubriand',''),(5,'De la fontaine','jean'),(6,'Daudet',''),(7,'hugo','victor'),(8,'kessel',''),(9,'duras',''),(10,'Proust','marcel'),(11,'Zola','Ã©mile'),(12,'Highsmith',''),(13,'Kipling',''),(14,'Azimov',''),(15,'Baudelaire',''),(16,'Hubet','Rodwald'),(17,'Jean','Paul'),(19,'Hubert','d'),(20,'Hubert','Test'),(21,'Hubert','t'),(22,'Hubert','h'),(23,'Test','se'),(24,'Test','Test'),(25,'Test','Paul'),(26,'Jean-Claude','Test'),(27,'Iung','Test'),(28,'Hubert','2'),(29,'Hubet','d'),(31,'Test','test'),(32,'Jean-Claude','Test'),(33,'Test','Test');
/*!40000 ALTER TABLE `AUTEUR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EMPRUNT`
--

DROP TABLE IF EXISTS `EMPRUNT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EMPRUNT` (
  `adherent_idadherent` bigint(20) DEFAULT NULL,
  `exemplaire_noexemplaire` bigint(20) DEFAULT NULL,
  `dateEmprunt` date NOT NULL,
  `dateRendu` date DEFAULT NULL,
  PRIMARY KEY (`dateEmprunt`),
  KEY `FK_EMPRUNT_adherent_idadherent` (`adherent_idadherent`),
  KEY `FK_EMPRUNT_exemplaire_noexemplaire` (`exemplaire_noexemplaire`),
  CONSTRAINT `FK_EMPRUNT_adherent_idadherent` FOREIGN KEY (`adherent_idadherent`) REFERENCES `ADHERENT` (`idAdherent`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_EMPRUNT_exemplaire_noexemplaire` FOREIGN KEY (`exemplaire_noexemplaire`) REFERENCES `EXEMPLAIRE` (`noExemplaire`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EMPRUNT`
--

LOCK TABLES `EMPRUNT` WRITE;
/*!40000 ALTER TABLE `EMPRUNT` DISABLE KEYS */;
INSERT INTO `EMPRUNT` VALUES (8,33,'2015-08-30','0000-00-00');
/*!40000 ALTER TABLE `EMPRUNT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EXEMPLAIRE`
--

DROP TABLE IF EXISTS `EXEMPLAIRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EXEMPLAIRE` (
  `noExemplaire` bigint(20) NOT NULL AUTO_INCREMENT,
  `dateAchat` date NOT NULL,
  `etat` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `oeuvre_nooeuvre` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`noExemplaire`),
  KEY `FK_EXEMPLAIRE_oeuvre_nooeuvre` (`oeuvre_nooeuvre`),
  CONSTRAINT `FK_EXEMPLAIRE_oeuvre_nooeuvre` FOREIGN KEY (`oeuvre_nooeuvre`) REFERENCES `OEUVRE` (`noOeuvre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EXEMPLAIRE`
--

LOCK TABLES `EXEMPLAIRE` WRITE;
/*!40000 ALTER TABLE `EXEMPLAIRE` DISABLE KEYS */;
INSERT INTO `EXEMPLAIRE` VALUES (7,'2016-05-19',NULL,10,35),(8,'2016-05-19','Bon',10,3),(9,'2016-05-19',NULL,18,4),(10,'2016-05-19',NULL,21,4),(12,'2016-05-19',NULL,22,6),(13,'2016-05-19',NULL,22,6),(14,'2016-05-19',NULL,28,7),(15,'2016-05-19',NULL,28,7),(17,'2016-05-19',NULL,32,9),(23,'2016-05-19',NULL,21,12),(26,'2016-05-19',NULL,26,14),(27,'2016-05-19',NULL,13,14),(28,'2016-05-19',NULL,12,15),(29,'2016-05-19',NULL,15,15),(31,'2016-05-19',NULL,19,17),(32,'2016-05-19',NULL,19,17),(33,'2016-05-19',NULL,20,17),(34,'2016-05-19',NULL,11,18),(35,'2016-05-19',NULL,15,18),(36,'2016-05-19',NULL,18,18),(37,'2016-05-19',NULL,8,19),(38,'2016-05-19',NULL,18,20),(39,'2016-05-19',NULL,18,20),(40,'2016-05-19',NULL,11,24),(41,'2016-05-19',NULL,10,31),(42,'2016-05-19',NULL,50,32),(43,'2015-05-12','Bon',0,36);
/*!40000 ALTER TABLE `EXEMPLAIRE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OEUVRE`
--

DROP TABLE IF EXISTS `OEUVRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OEUVRE` (
  `noOeuvre` bigint(20) NOT NULL AUTO_INCREMENT,
  `auteur_idauteur` bigint(20) DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `dateParution` date NOT NULL,
  PRIMARY KEY (`noOeuvre`),
  KEY `FK_OEUVRE_auteur_idauteur` (`auteur_idauteur`),
  CONSTRAINT `FK_OEUVRE_auteur_idauteur` FOREIGN KEY (`auteur_idauteur`) REFERENCES `AUTEUR` (`idAuteur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OEUVRE`
--

LOCK TABLES `OEUVRE` WRITE;
/*!40000 ALTER TABLE `OEUVRE` DISABLE KEYS */;
INSERT INTO `OEUVRE` VALUES (3,1,'dix br&Atilde;&uml;ves rencontres','2016-05-19'),(4,1,'le miroir de la mort','2016-05-19'),(6,12,'une crÃ©ature de rÃªve','2016-05-19'),(7,2,'mÃ©moire d\'outre-tombe','2016-05-19'),(9,9,'un amour de de swam','2016-05-19'),(12,15,'Les fleurs du mal','2016-05-19'),(14,14,'les mondes perdus','2016-05-19'),(15,14,'La guerre des mondes','2016-05-19'),(17,5,'Les fables','2016-05-19'),(18,5,'Le triomphe de l\'amour','2016-05-19'),(19,13,'le livre de la jungle','2016-05-19'),(20,13,'kim','2016-05-19'),(21,9,'le marin de Gibraltar','2016-05-19'),(22,11,'lâ€™assommoir','2016-05-19'),(23,11,'j\'accuse','2016-05-19'),(24,10,'la terre','2016-05-19'),(26,22,'test','2016-05-19'),(27,22,'test','2016-05-19'),(28,23,'t','2016-05-19'),(30,25,'Izly &agrave; l\'ab2i','2016-05-19'),(31,26,'Une Oeuvre','2016-05-19'),(32,29,'Un Nouveau livre de test 2','2016-05-19'),(34,1,'dix br&Atilde;&uml;ves rencontres','2016-05-19'),(35,31,'Test','2016-05-19'),(36,33,'Test','2017-10-05');
/*!40000 ALTER TABLE `OEUVRE` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-24 21:45:56
