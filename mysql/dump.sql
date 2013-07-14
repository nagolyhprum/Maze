-- MySQL dump 10.13  Distrib 5.6.12, for Win64 (x86_64)
--
-- Host: localhost    Database: worldtactics
-- ------------------------------------------------------
-- Server version	5.6.12


UNLOCK TABLES;

DROP SCHEMA IF EXISTS worldtactics;

CREATE SCHEMA IF NOT EXISTS worldtactics;

USE worldtactics;

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
-- Table structure for table `attacktype`
--

DROP TABLE IF EXISTS `attacktype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attacktype` (
  `AttackTypeID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AttackTypeName` varchar(32) NOT NULL,
  PRIMARY KEY (`AttackTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attacktype`
--

LOCK TABLES `attacktype` WRITE;
/*!40000 ALTER TABLE `attacktype` DISABLE KEYS */;
INSERT INTO `attacktype` VALUES (1,'slash'),(2,'hurt'),(3,'bow'),(4,'thrust'),(5,'walk'),(6,'spellcast');
/*!40000 ALTER TABLE `attacktype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audio`
--

DROP TABLE IF EXISTS `audio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audio` (
  `AudioID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AudioName` varchar(64) NOT NULL,
  PRIMARY KEY (`AudioID`),
  UNIQUE KEY `AudioName_UNIQUE` (`AudioName`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audio`
--

LOCK TABLES `audio` WRITE;
/*!40000 ALTER TABLE `audio` DISABLE KEYS */;
INSERT INTO `audio` VALUES (1,'music/dungeon'),(56,'sound/battle/magic1'),(57,'sound/battle/spell'),(58,'sound/battle/swing1'),(59,'sound/battle/swing2'),(60,'sound/battle/swing3'),(61,'sound/battle/sword-unsheat'),(66,'sound/blood/blood1'),(67,'sound/blood/blood2'),(68,'sound/blood/blood3'),(69,'sound/blood/blood4'),(70,'sound/grunts/grunt1'),(71,'sound/grunts/grunt10'),(72,'sound/grunts/grunt11'),(73,'sound/grunts/grunt2'),(74,'sound/grunts/grunt3'),(75,'sound/grunts/grunt4'),(76,'sound/grunts/grunt5'),(77,'sound/grunts/grunt6'),(78,'sound/grunts/grunt7'),(79,'sound/grunts/grunt8'),(80,'sound/grunts/grunt9'),(81,'sound/interface/interface1'),(82,'sound/interface/interface2'),(83,'sound/interface/interface3'),(84,'sound/interface/interface4'),(85,'sound/interface/interface5'),(86,'sound/interface/interface6'),(87,'sound/inventory/armor-light'),(88,'sound/inventory/beads'),(89,'sound/inventory/bottle'),(90,'sound/inventory/bubble'),(91,'sound/inventory/bubble2'),(92,'sound/inventory/bubble3'),(93,'sound/inventory/chainmail1'),(94,'sound/inventory/chainmail2'),(95,'sound/inventory/cloth-heavy'),(96,'sound/inventory/cloth'),(97,'sound/inventory/coin'),(98,'sound/inventory/coin2'),(99,'sound/inventory/coin3'),(100,'sound/inventory/metal-ring'),(101,'sound/inventory/metal-small'),(104,'sound/inventory/wood-small'),(105,'sound/misc/burp'),(106,'sound/misc/random1'),(107,'sound/misc/random2'),(108,'sound/misc/random3'),(109,'sound/misc/random4'),(110,'sound/misc/random5'),(111,'sound/misc/random6'),(2,'sound/NPC/beetle/bite-small'),(5,'sound/NPC/giant/giant1'),(6,'sound/NPC/giant/giant2'),(7,'sound/NPC/giant/giant3'),(8,'sound/NPC/giant/giant4'),(9,'sound/NPC/giant/giant5'),(10,'sound/NPC/gutteral beast/mnstr1'),(25,'sound/NPC/misc/wolfman'),(26,'sound/NPC/ogre/ogre1'),(27,'sound/NPC/ogre/ogre2'),(28,'sound/NPC/ogre/ogre3'),(29,'sound/NPC/ogre/ogre4'),(30,'sound/NPC/ogre/ogre5'),(31,'sound/NPC/shade/shade1'),(32,'sound/NPC/shade/shade10'),(33,'sound/NPC/shade/shade11'),(34,'sound/NPC/shade/shade12'),(35,'sound/NPC/shade/shade13'),(36,'sound/NPC/shade/shade14'),(37,'sound/NPC/shade/shade15'),(38,'sound/NPC/shade/shade2'),(39,'sound/NPC/shade/shade3'),(40,'sound/NPC/shade/shade4'),(41,'sound/NPC/shade/shade5'),(42,'sound/NPC/shade/shade6'),(43,'sound/NPC/shade/shade7'),(44,'sound/NPC/shade/shade8'),(45,'sound/NPC/shade/shade9'),(46,'sound/NPC/slime/slime1'),(47,'sound/NPC/slime/slime10'),(48,'sound/NPC/slime/slime2'),(49,'sound/NPC/slime/slime3'),(50,'sound/NPC/slime/slime4'),(51,'sound/NPC/slime/slime5'),(52,'sound/NPC/slime/slime6'),(53,'sound/NPC/slime/slime7'),(54,'sound/NPC/slime/slime8'),(55,'sound/NPC/slime/slime9'),(112,'sound/scream/scream1'),(114,'sound/scream/scream2'),(116,'sound/scream/scream3'),(118,'sound/scream/scream4'),(120,'sound/scream/scream5'),(122,'sound/walk/stepdirt_1'),(123,'sound/walk/stepdirt_2'),(124,'sound/walk/stepdirt_3'),(125,'sound/walk/stepdirt_4'),(126,'sound/walk/stepdirt_5'),(127,'sound/walk/stepdirt_6'),(128,'sound/walk/stepdirt_7'),(129,'sound/walk/stepdirt_8'),(130,'sound/walk/stepsnow_1'),(131,'sound/walk/stepsnow_2'),(132,'sound/walk/stepstone_1'),(133,'sound/walk/stepstone_2'),(134,'sound/walk/stepstone_3'),(135,'sound/walk/stepstone_4'),(136,'sound/walk/stepstone_5'),(137,'sound/walk/stepstone_6'),(138,'sound/walk/stepstone_7'),(139,'sound/walk/stepstone_8'),(140,'sound/walk/stepwater_1'),(141,'sound/walk/stepwater_2'),(142,'sound/walk/stepwood_1'),(143,'sound/walk/stepwood_2'),(144,'sound/world/door');
/*!40000 ALTER TABLE `audio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badge`
--

DROP TABLE IF EXISTS `badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badge` (
  `BadgeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `BadgeName` varchar(32) NOT NULL,
  `CategoryID` bigint(20) DEFAULT NULL,
  `BadgeCount` bigint(20) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `SubcategoryID` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`BadgeId`),
  KEY `fk_Badge_BehaviorCategory1_idx` (`CategoryID`),
  KEY `fk_Badge_Image1_idx` (`ImageID`),
  KEY `fk_Badge_Subcategory1_idx` (`SubcategoryID`),
  CONSTRAINT `fk_Badge_BehaviorCategory1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Subcategory1` FOREIGN KEY (`SubcategoryID`) REFERENCES `subcategory` (`SubcategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badge`
--

LOCK TABLES `badge` WRITE;
/*!40000 ALTER TABLE `badge` DISABLE KEYS */;
INSERT INTO `badge` VALUES 
	(1,'First Step',1,1,2,1),
	(2,'Adventurer',2,10,11,4),
	(3,'Explorer',2,1,10,5),
	(4,'First Death',1,1,7,2),
	(5,'Killer',4,50,4,NULL),
	(6,'First Kill',4,1,5,NULL),
	(7,'Skillful',3,10,9,NULL);
/*!40000 ALTER TABLE `badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `CategoryID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(32) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Character'),(2,'Discovered'),(3,'Skills Used'),(4,'Kills'),(5,'Damage');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character`
--

DROP TABLE IF EXISTS `character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `character` (
  `CharacterID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterName` varchar(64) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `CharacterCurrentStatisticID` bigint(20) NOT NULL,
  `CharacterMaxStatisticID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `RoomID` bigint(20) DEFAULT NULL,
  `CharacterColumn` bigint(20) DEFAULT NULL,
  `CharacterRow` bigint(20) DEFAULT NULL,
  `CharacterIsMale` tinyint(1) NOT NULL,
  `CharacterCanUse` BIGINT NOT NULL DEFAULT 0,
	`CharacterUsedAt` BIGINT DEFAULT NULL,
	`CharacterLastEnergyUpdate` BIGINT DEFAULT NULL,
  PRIMARY KEY (`CharacterID`),
  KEY `fk_Character_Image1_idx` (`ImageID`),
  KEY `fk_Character_Statistic1_idx` (`CharacterCurrentStatisticID`),
  KEY `fk_Character_Statistic2_idx` (`CharacterMaxStatisticID`),
  KEY `fk_Character_User1_idx` (`UserID`),
  KEY `fk_Character_Room1_idx` (`RoomID`),
  CONSTRAINT `fk_Character_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic1` FOREIGN KEY (`CharacterCurrentStatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic2` FOREIGN KEY (`CharacterMaxStatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_User1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character`
--

LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` VALUES (1,'nagolyhprum',50,1,2,1,null,null,null,1, 0, NULL, 0);
/*!40000 ALTER TABLE `character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characteraudio`
--

DROP TABLE IF EXISTS `characteraudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characteraudio` (
  `CharacterAudioID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AudioID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  `CharacterAudioIsMale` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`CharacterAudioID`),
  KEY `fk_CharacterSound_Sound1_idx` (`AudioID`),
  KEY `fk_CharacterSound_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_CharacterSound_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSound_Sound1` FOREIGN KEY (`AudioID`) REFERENCES `audio` (`AudioID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characteraudio`
--

LOCK TABLES `characteraudio` WRITE;
/*!40000 ALTER TABLE `characteraudio` DISABLE KEYS */;
INSERT INTO `characteraudio` VALUES (1,56,6,1),(2,58,1,1),(3,70,2,1),(4,58,3,1),(5,58,4,1);
/*!40000 ALTER TABLE `characteraudio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characterimage`
--

DROP TABLE IF EXISTS `characterimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characterimage` (
  `CharacterImageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterID` bigint(20) NOT NULL,
  `CharacterImageChoiceGroupID` bigint(20) NOT NULL,
  PRIMARY KEY (`CharacterImageID`),
  KEY `fk_CharacterImage_Character1_idx` (`CharacterID`),
  KEY `fk_CharacterImage_CharacterImageChoiceGroup1_idx` (`CharacterImageChoiceGroupID`),
  CONSTRAINT `fk_CharacterImage_Character1` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImage_CharacterImageChoiceGroup1` FOREIGN KEY (`CharacterImageChoiceGroupID`) REFERENCES `characterimagechoicegroup` (`CharacterImageChoiceGroupID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterimage`
--

LOCK TABLES `characterimage` WRITE;
/*!40000 ALTER TABLE `characterimage` DISABLE KEYS */;
INSERT INTO `characterimage` VALUES (1,1,1);
/*!40000 ALTER TABLE `characterimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characterimagechoice`
--

DROP TABLE IF EXISTS `characterimagechoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characterimagechoice` (
  `CharacterImageChoiceID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterImageChoiceRows` bigint(20) NOT NULL,
  `CharacterImageChoiceColumns` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `CharacterImageChoiceGroupID` bigint(20) NOT NULL,
  PRIMARY KEY (`CharacterImageChoiceID`),
  KEY `fk_CharacterImageChoice_Image1_idx` (`ImageID`),
  KEY `fk_CharacterImageChoice_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_CharacterImageChoice_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImageChoice_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterimagechoice`
--

LOCK TABLES `characterimagechoice` WRITE;
/*!40000 ALTER TABLE `characterimagechoice` DISABLE KEYS */;
INSERT INTO `characterimagechoice` VALUES (1,4,13,2,60,1),(2,1,6,2,60,1),(3,4,6,1,191,1),(4,4,7,6,223,1),(5,4,8,4,255,1),(6,4,9,5,314,1);
/*!40000 ALTER TABLE `characterimagechoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characterimagechoicegroup`
--

DROP TABLE IF EXISTS `characterimagechoicegroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characterimagechoicegroup` (
  `CharacterImageChoiceGroupID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemTypeID` bigint(20) NOT NULL,
  `CharacterImageChoiceGroupIsMale` tinyint(1) NOT NULL,
  `CharacterImageChoiceGroupName` varchar(32) NOT NULL,
  PRIMARY KEY (`CharacterImageChoiceGroupID`),
  UNIQUE KEY `CharacterImageChoiceGroupName_UNIQUE` (`CharacterImageChoiceGroupName`),
  KEY `fk_CharacterImageChoiceGroup_ItemType1_idx` (`ItemTypeID`),
  CONSTRAINT `fk_CharacterImageChoiceGroup_ItemType1` FOREIGN KEY (`ItemTypeID`) REFERENCES `itemtype` (`ItemTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterimagechoicegroup`
--

LOCK TABLES `characterimagechoicegroup` WRITE;
/*!40000 ALTER TABLE `characterimagechoicegroup` DISABLE KEYS */;
INSERT INTO `characterimagechoicegroup` VALUES (1,1,1,'white body');
/*!40000 ALTER TABLE `characterimagechoicegroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `characterskill`
--

DROP TABLE IF EXISTS `characterskill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `characterskill` (
  `CharacterSkillID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterID` bigint(20) NOT NULL,
  `SkillID` bigint(20) NOT NULL,
  `CharacterSkillIndex` bigint(20) DEFAULT NULL,
  `CharacterSkillCanUse` BIGINT NOT NULL DEFAULT 0,
  `CharacterSkillUsedAt` BIGINT DEFAULT NULL,
  PRIMARY KEY (`CharacterSkillID`),
  KEY `fk_CharacterSkill_Skill2_idx` (`SkillID`),
  KEY `fk_CharacterSkill_Character2_idx` (`CharacterID`),
  CONSTRAINT `fk_CharacterSkill_Character2` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSkill_Skill2` FOREIGN KEY (`SkillID`) REFERENCES `skill` (`SkillID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterskill`
--

LOCK TABLES `characterskill` WRITE;
/*!40000 ALTER TABLE `characterskill` DISABLE KEYS */;
INSERT INTO `characterskill` VALUES 
	(1,1,1,0,0,NULL),
	(2,1,2,1,0,NULL),
	(3,1,3,2,0,NULL),
	(4,1,4,3,0,NULL);
/*!40000 ALTER TABLE `characterskill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemy`
--

DROP TABLE IF EXISTS `enemy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemy` (
  `EnemyID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ImageID` bigint(20) NOT NULL,
  `EnemyName` varchar(32) NOT NULL,
  `StatisticID` bigint(20) NOT NULL,
  PRIMARY KEY (`EnemyID`),
  KEY `fk_Enemy_Image1_idx` (`ImageID`),
  KEY `fk_Enemy_Statistic1_idx` (`StatisticID`),
  CONSTRAINT `fk_Enemy_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemy`
--

LOCK TABLES `enemy` WRITE;
/*!40000 ALTER TABLE `enemy` DISABLE KEYS */;
INSERT INTO `enemy` VALUES (1,53,'Skeleton',3);
/*!40000 ALTER TABLE `enemy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemyaudio`
--

DROP TABLE IF EXISTS `enemyaudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemyaudio` (
  `EnemyAudioID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AudioID` bigint(20) NOT NULL,
  `EnemyID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  PRIMARY KEY (`EnemyAudioID`),
  KEY `fk_EnemySound_Enemy1_idx` (`EnemyID`),
  KEY `fk_EnemySound_Sound1_idx` (`AudioID`),
  KEY `fk_EnemySound_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_EnemySound_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_Sound1` FOREIGN KEY (`AudioID`) REFERENCES `audio` (`AudioID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyaudio`
--

LOCK TABLES `enemyaudio` WRITE;
/*!40000 ALTER TABLE `enemyaudio` DISABLE KEYS */;
INSERT INTO `enemyaudio` VALUES (1,31,1,2),(2,58,1,1);
/*!40000 ALTER TABLE `enemyaudio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemyimage`
--

DROP TABLE IF EXISTS `enemyimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemyimage` (
  `EnemyImageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `EnemyID` bigint(20) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `ItemTypeID` bigint(20) NOT NULL,
  `EnemyImageRows` bigint(20) NOT NULL,
  `EnemyImageColumns` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  PRIMARY KEY (`EnemyImageID`),
  KEY `fk_EnemyImage_Image1_idx` (`ImageID`),
  KEY `fk_EnemyImage_ItemType1_idx` (`ItemTypeID`),
  KEY `fk_EnemyImage_Enemy1_idx` (`EnemyID`),
  KEY `fk_EnemyImage_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_EnemyImage_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_ItemType1` FOREIGN KEY (`ItemTypeID`) REFERENCES `itemtype` (`ItemTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyimage`
--

LOCK TABLES `enemyimage` WRITE;
/*!40000 ALTER TABLE `enemyimage` DISABLE KEYS */;
INSERT INTO `enemyimage` VALUES (1,1,61,1,1,6,2),(2,1,192,1,4,6,1),(3,1,315,1,4,9,5);
/*!40000 ALTER TABLE `enemyimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemyinroom`
--

DROP TABLE IF EXISTS `enemyinroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemyinroom` (
  `EnemyInRoomID` bigint(20) NOT NULL AUTO_INCREMENT,
  `StatisticID` bigint(20) NOT NULL,
  `EnemyID` bigint(20) NOT NULL,
  `RoomID` bigint(20) NOT NULL,
  `EnemyInRoomColumn` bigint(20) NOT NULL,
  `EnemyInRoomRow` bigint(20) NOT NULL,
	`EnemyInRoomCanUse` BIGINT NOT NULL DEFAULT 0,
	`EnemyInRoomUsedAt` BIGINT DEFAULT NULL,
  PRIMARY KEY (`EnemyInRoomID`),
  KEY `fk_EnemyInRoom_Room1_idx` (`RoomID`),
  KEY `fk_EnemyInRoom_Enemy1_idx` (`EnemyID`),
  KEY `fk_EnemyInRoom_Statistic1_idx` (`StatisticID`),
  CONSTRAINT `fk_EnemyInRoom_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enemyinroommodel`
--

DROP TABLE IF EXISTS `enemyinroommodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemyinroommodel` (
  `EnemyInRoomModelID` bigint(20) NOT NULL AUTO_INCREMENT,
  `EnemyID` bigint(20) NOT NULL,
  `RoomModelID` bigint(20) NOT NULL,
  `EnemyInRoomModelRow` bigint(20) NOT NULL,
  `EnemyInRoomModelColumn` bigint(20) NOT NULL,
  PRIMARY KEY (`EnemyInRoomModelID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyinroommodel`
--

LOCK TABLES `enemyinroommodel` WRITE;
/*!40000 ALTER TABLE `enemyinroommodel` DISABLE KEYS */;
INSERT INTO `enemyinroommodel` VALUES (1,1,1,3,1),(2,1,1,1,3);
/*!40000 ALTER TABLE `enemyinroommodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `ImageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ImageName` varchar(64) NOT NULL,
  PRIMARY KEY (`ImageID`),
  UNIQUE KEY `ImageName_UNIQUE` (`ImageName`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,'background.jpg'),(2,'badges/arrow.png'),(3,'badges/award.png'),(4,'badges/ddeath.png'),(5,'badges/death.png'),(6,'badges/dup.png'),(7,'badges/killed.png'),(8,'badges/line.png'),(9,'badges/tstar.png'),(10,'badges/tup.png'),(11,'badges/up.png'),(12,'badges/wings.png'),(13,'bk_drops.png'),(14,'bow/BELT_leather.png'),(15,'bow/BELT_rope.png'),(16,'bow/BODY_human.png'),(40,'bow/chest.png'),(41,'bow/feet.png'),(17,'bow/FEET_plate_armor_shoes.png'),(18,'bow/FEET_shoes_brown.png'),(42,'bow/hands.png'),(19,'bow/HANDS_plate_armor_gloves.png'),(43,'bow/head.png'),(20,'bow/HEAD_chain_armor_helmet.png'),(21,'bow/HEAD_chain_armor_hood.png'),(22,'bow/HEAD_hair_blonde.png'),(23,'bow/HEAD_leather_armor_hat.png'),(24,'bow/HEAD_plate_armor_helmet.png'),(25,'bow/HEAD_robe_hood.png'),(44,'bow/legs.png'),(26,'bow/LEGS_pants_greenish.png'),(27,'bow/LEGS_plate_armor_pants.png'),(28,'bow/LEGS_robe_skirt.png'),(29,'bow/TORSO_chain_armor_jacket_purple.png'),(30,'bow/TORSO_chain_armor_torso.png'),(31,'bow/TORSO_leather_armor_bracers.png'),(32,'bow/TORSO_leather_armor_shirt_white.png'),(33,'bow/TORSO_leather_armor_shoulders.png'),(34,'bow/TORSO_leather_armor_torso.png'),(35,'bow/TORSO_plate_armor_arms_shoulders.png'),(36,'bow/TORSO_plate_armor_torso.png'),(37,'bow/TORSO_robe_shirt_brown.png'),(38,'bow/WEAPON_arrow.png'),(39,'bow/WEAPON_bow.png'),(45,'combat_dummy/BODY_animation.png'),(46,'drops.png'),(47,'face/FlareFemaleHero1.png'),(48,'face/FlareFemaleHero2.png'),(49,'face/FlareFemaleHero3.png'),(50,'face/FlareMaleHero1.png'),(51,'face/FlareMaleHero2.png'),(52,'face/FlareMaleHero3.png'),(53,'face/skeleton.png'),(54,'health/background.png'),(55,'health/foreground_gold.png'),(56,'health/foreground_gray.png'),(57,'hurt/BEHIND_quiver.png'),(58,'hurt/BELT_leather.png'),(59,'hurt/BELT_rope.png'),(60,'hurt/BODY_human.png'),(61,'hurt/BODY_skeleton.png'),(62,'hurt/FEET_plate_armor_shoes.png'),(63,'hurt/FEET_shoes_brown.png'),(64,'hurt/HANDS_plate_armor_gloves.png'),(65,'hurt/HEAD_chain_armor_helmet.png'),(66,'hurt/HEAD_chain_armor_hood.png'),(67,'hurt/HEAD_hair_blonde.png'),(68,'hurt/HEAD_leather_armor_hat.png'),(69,'hurt/HEAD_plate_armor_helmet.png'),(70,'hurt/HEAD_robe_hood.png'),(71,'hurt/LEGS_pants_greenish.png'),(72,'hurt/LEGS_plate_armor_pants.png'),(73,'hurt/LEGS_robe_skirt.png'),(74,'hurt/TORSO_chain_armor_jacket_purple.png'),(75,'hurt/TORSO_chain_armor_torso.png'),(76,'hurt/TORSO_leather_armor_bracers.png'),(77,'hurt/TORSO_leather_armor_shirt_white.png'),(78,'hurt/TORSO_leather_armor_shoulders.png'),(79,'hurt/TORSO_leather_armor_torso.png'),(80,'hurt/TORSO_plate_armor_arms_shoulders.png'),(81,'hurt/TORSO_plate_armor_torso.png'),(82,'hurt/TORSO_robe_shirt_brown.png'),(83,'items/buckler.png'),(84,'items/chain-chest.png'),(85,'items/chain-feet.png'),(86,'items/chain-hands.png'),(87,'items/chain-head.png'),(88,'items/chain-legs.png'),(89,'items/chest.png'),(90,'items/cloth-chest.png'),(91,'items/cloth-feet.png'),(92,'items/cloth-hands.png'),(93,'items/cloth-legs.png'),(94,'items/dagger.png'),(95,'items/feet.png'),(96,'items/greatbow.png'),(97,'items/greatstaff.png'),(98,'items/greatsword.png'),(99,'items/hands.png'),(100,'items/head.png'),(101,'items/hide-chest.png'),(102,'items/hide-feet.png'),(103,'items/hide-hands.png'),(104,'items/hide-head.png'),(105,'items/hide-legs.png'),(106,'items/leather-chest.png'),(107,'items/leather-feet.png'),(108,'items/leather-hands.png'),(109,'items/leather-head.png'),(110,'items/leather-legs.png'),(111,'items/legs.png'),(112,'items/longbow.png'),(113,'items/longsword.png'),(114,'items/mainhand.png'),(115,'items/neck.png'),(116,'items/offhand.png'),(117,'items/ring.png'),(118,'items/ring0.png'),(119,'items/ring1.png'),(120,'items/ring2.png'),(121,'items/ring3.png'),(122,'items/ring4.png'),(123,'items/ring5.png'),(124,'items/ring6.png'),(125,'items/ring7.png'),(126,'items/ring8.png'),(127,'items/ring9.png'),(128,'items/rod.png'),(129,'items/shield.png'),(130,'items/shortbow.png'),(131,'items/shortsword.png'),(132,'items/slingshot.png'),(133,'items/staff.png'),(134,'items/steel-chest.png'),(135,'items/steel-feet.png'),(136,'items/steel-hands.png'),(137,'items/steel-head.png'),(138,'items/steel-legs.png'),(139,'items/wand.png'),(140,'skills/ball/dark.png'),(141,'skills/ball/fire.png'),(142,'skills/ball/ice.png'),(143,'skills/ball/light.png'),(144,'skills/ball/lightning.png'),(145,'skills/ball/poison.png'),(146,'skills/bolt/dark.png'),(147,'skills/bolt/fire.png'),(148,'skills/bolt/ice.png'),(149,'skills/bolt/light.png'),(150,'skills/bolt/poison.png'),(156,'skills/boost-adv/dark.png'),(157,'skills/boost-adv/fire.png'),(158,'skills/boost-adv/ice.png'),(159,'skills/boost-adv/light.png'),(160,'skills/boost-adv/poison.png'),(151,'skills/boost/dark.png'),(152,'skills/boost/fire.png'),(153,'skills/boost/ice.png'),(154,'skills/boost/light.png'),(155,'skills/boost/poison.png'),(166,'skills/breath-adv/dark.png'),(167,'skills/breath-adv/fire.png'),(168,'skills/breath-adv/ice.png'),(169,'skills/breath-adv/light.png'),(170,'skills/breath-adv/lightning.png'),(171,'skills/breath-adv/poison.png'),(161,'skills/breath/dark.png'),(162,'skills/breath/fire.png'),(163,'skills/breath/ice.png'),(164,'skills/breath/lightning.png'),(165,'skills/breath/poison.png'),(172,'skills/resist/dark.png'),(173,'skills/resist/fire.png'),(174,'skills/resist/ice.png'),(175,'skills/resist/poison.png'),(176,'skills/thrust/bloody.png'),(177,'skills/thrust/ice.png'),(178,'skills/thrust/light.png'),(179,'skills/thrust/lightning.png'),(180,'skills/thrust/normal.png'),(181,'skills/thrust/poison.png'),(182,'skills/vampire/125.png'),(183,'skills/vampire/126.png'),(184,'skills/wave/dark.png'),(185,'skills/wave/fire.png'),(186,'skills/wave/ice.png'),(187,'skills/wave/poison.png'),(188,'slash/BEHIND_quiver.png'),(189,'slash/BELT_leather.png'),(190,'slash/BELT_rope.png'),(191,'slash/BODY_human.png'),(192,'slash/BODY_skeleton.png'),(215,'slash/chest.png'),(216,'slash/feet.png'),(193,'slash/FEET_plate_armor_shoes.png'),(194,'slash/FEET_shoes_brown.png'),(217,'slash/hands.png'),(195,'slash/HANDS_plate_armor_gloves.png'),(218,'slash/head.png'),(196,'slash/HEAD_chain_armor_helmet.png'),(197,'slash/HEAD_chain_armor_hood.png'),(198,'slash/HEAD_hair_blonde.png'),(199,'slash/HEAD_leather_armor_hat.png'),(200,'slash/HEAD_plate_armor_helmet.png'),(201,'slash/HEAD_robe_hood.png'),(219,'slash/legs.png'),(202,'slash/LEGS_pants_greenish.png'),(203,'slash/LEGS_plate_armor_pants.png'),(204,'slash/LEGS_robe_skirt.png'),(205,'slash/TORSO_chain_armor_jacket_purple.png'),(206,'slash/TORSO_chain_armor_torso.png'),(207,'slash/TORSO_leather_armor_bracers.png'),(208,'slash/TORSO_leather_armor_shirt_white.png'),(209,'slash/TORSO_leather_armor_shoulders.png'),(210,'slash/TORSO_leather_armor_torso.png'),(211,'slash/TORSO_plate_armor_arms_shoulders.png'),(212,'slash/TORSO_plate_armor_torso.png'),(213,'slash/TORSO_robe_shirt_brown.png'),(214,'slash/WEAPON_dagger.png'),(220,'spellcast/BEHIND_quiver.png'),(221,'spellcast/BELT_leather.png'),(222,'spellcast/BELT_rope.png'),(223,'spellcast/BODY_human.png'),(224,'spellcast/BODY_skeleton.png'),(247,'spellcast/chest.png'),(248,'spellcast/feet.png'),(225,'spellcast/FEET_plate_armor_shoes.png'),(226,'spellcast/FEET_shoes_brown.png'),(249,'spellcast/hands.png'),(227,'spellcast/HANDS_plate_armor_gloves.png'),(250,'spellcast/head.png'),(228,'spellcast/HEAD_chain_armor_helmet.png'),(229,'spellcast/HEAD_chain_armor_hood.png'),(230,'spellcast/HEAD_hair_blonde.png'),(231,'spellcast/HEAD_leather_armor_hat.png'),(232,'spellcast/HEAD_plate_armor_helmet.png'),(233,'spellcast/HEAD_robe_hood.png'),(234,'spellcast/HEAD_skeleton_eye_glow.png'),(251,'spellcast/legs.png'),(235,'spellcast/LEGS_pants_greenish.png'),(236,'spellcast/LEGS_plate_armor_pants.png'),(237,'spellcast/LEGS_robe_skirt.png'),(238,'spellcast/TORSO_chain_armor_jacket_purple.png'),(239,'spellcast/TORSO_chain_armor_torso.png'),(240,'spellcast/TORSO_leather_armor_bracers.png'),(241,'spellcast/TORSO_leather_armor_shirt_white.png'),(242,'spellcast/TORSO_leather_armor_shoulders.png'),(243,'spellcast/TORSO_leather_armor_torso.png'),(244,'spellcast/TORSO_plate_armor_arms_shoulders.png'),(245,'spellcast/TORSO_plate_armor_torso.png'),(246,'spellcast/TORSO_robe_shirt_brown.png'),(252,'thrust/BEHIND_quiver.png'),(253,'thrust/BELT_leather.png'),(254,'thrust/BELT_rope.png'),(255,'thrust/BODY_human.png'),(281,'thrust/chest.png'),(282,'thrust/feet.png'),(256,'thrust/FEET_plate_armor_shoes.png'),(257,'thrust/FEET_shoes_brown.png'),(283,'thrust/hands.png'),(258,'thrust/HANDS_plate_armor_gloves.png'),(284,'thrust/head.png'),(259,'thrust/HEAD_chain_armor_helmet.png'),(260,'thrust/HEAD_chain_armor_hood.png'),(261,'thrust/HEAD_hair_blonde.png'),(262,'thrust/HEAD_leather_armor_hat.png'),(263,'thrust/HEAD_plate_armor_helmet.png'),(264,'thrust/HEAD_robe_hood.png'),(285,'thrust/legs.png'),(265,'thrust/LEGS_pants_greenish.png'),(266,'thrust/LEGS_plate_armor_pants.png'),(267,'thrust/LEGS_robe_skirt.png'),(268,'thrust/TORSO_chain_armor_jacket_purple.png'),(269,'thrust/TORSO_chain_armor_torso.png'),(270,'thrust/TORSO_leather_armor_bracers.png'),(271,'thrust/TORSO_leather_armor_shirt_white.png'),(272,'thrust/TORSO_leather_armor_shoulders.png'),(273,'thrust/TORSO_leather_armor_torso.png'),(274,'thrust/TORSO_plate_armor_arms_shoulders.png'),(275,'thrust/TORSO_plate_armor_torso.png'),(276,'thrust/TORSO_robe_shirt_brown.png'),(277,'thrust/WEAPON_shield_cutout_body.png'),(278,'thrust/WEAPON_shield_cutout_chain_armor_helmet.png'),(279,'thrust/WEAPON_spear.png'),(280,'thrust/WEAPON_staff.png'),(286,'tiles.gif'),(287,'ui/arrowsdown.png'),(288,'ui/arrowsleft.png'),(289,'ui/arrowsright.png'),(290,'ui/arrowsup.png'),(291,'ui/bar_hp_mp.png'),(292,'ui/button_default.png'),(293,'ui/button_small.png'),(294,'ui/button_x.png'),(295,'ui/checkbox_default.png'),(296,'ui/combobox_default.png'),(297,'ui/confirm_bg.png'),(298,'ui/dialog_box.png'),(299,'ui/input.png'),(300,'ui/listbox_default.png'),(301,'ui/menu_xp.png'),(302,'ui/mouse_pointer.png'),(303,'ui/portrait.png'),(304,'ui/radiobutton_default.png'),(305,'ui/scrollbar_default.png'),(306,'ui/slider_default.png'),(307,'ui/slot.png'),(308,'ui/tab_active.png'),(309,'ui/tab_inactive.png'),(310,'ui/window.png'),(311,'walk/BEHIND_quiver.png'),(312,'walk/BELT_leather.png'),(313,'walk/BELT_rope.png'),(314,'walk/BODY_male.png'),(315,'walk/BODY_skeleton.png'),(339,'walk/chest.png'),(340,'walk/feet.png'),(316,'walk/FEET_plate_armor_shoes.png'),(317,'walk/FEET_shoes_brown.png'),(341,'walk/hands.png'),(318,'walk/HANDS_plate_armor_gloves.png'),(342,'walk/head.png'),(319,'walk/HEAD_chain_armor_helmet.png'),(320,'walk/HEAD_chain_armor_hood.png'),(321,'walk/HEAD_hair_blonde.png'),(322,'walk/HEAD_leather_armor_hat.png'),(323,'walk/HEAD_plate_armor_helmet.png'),(324,'walk/HEAD_robe_hood.png'),(343,'walk/legs.png'),(325,'walk/LEGS_pants_greenish.png'),(326,'walk/LEGS_plate_armor_pants.png'),(327,'walk/LEGS_robe_skirt.png'),(328,'walk/TORSO_chain_armor_jacket_purple.png'),(329,'walk/TORSO_chain_armor_torso.png'),(330,'walk/TORSO_leather_armor_bracers.png'),(331,'walk/TORSO_leather_armor_shirt_white.png'),(332,'walk/TORSO_leather_armor_shoulders.png'),(333,'walk/TORSO_leather_armor_torso.png'),(334,'walk/TORSO_plate_armor_arms_shoulders.png'),(335,'walk/TORSO_plate_armor_torso.png'),(336,'walk/TORSO_robe_shirt_brown.png'),(337,'walk/WEAPON_shield_cutout_body.png'),(338,'walk/WEAPON_shield_cutout_chain_armor_helmet.png'),(344,'window/border.png'),(345,'window/bottom.png'),(346,'window/bottomleft.png'),(347,'window/bottomright.png'),(348,'window/left.png'),(349,'window/right.png'),(350,'window/texture.png'),(351,'window/top.png'),(352,'window/topleft.png'),(353,'window/topright.png');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `ItemID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemModelID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `fk_Item_ItemModel1_idx` (`ItemModelID`),
  CONSTRAINT `fk_Item_ItemModel1` FOREIGN KEY (`ItemModelID`) REFERENCES `itemmodel` (`ItemModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iteminequipment`
--

DROP TABLE IF EXISTS `iteminequipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iteminequipment` (
  `ItemInEquipmentID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterID` bigint(20) NOT NULL,
	`ItemTypeID` BIGINT NOT NULL,
  `ItemID` bigint(20),
  PRIMARY KEY (`ItemInEquipmentID`),
  KEY `fk_ItemInEquipment_Item1_idx` (`ItemID`),
  KEY `fk_ItemInEquipment_Character1_idx` (`CharacterID`),
	FOREIGN KEY (`ItemTypeID`) REFERENCES `ItemType`(`ItemTypeID`),
  CONSTRAINT `fk_ItemInEquipment_Character1` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInEquipment_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iteminequipment`
--

LOCK TABLES `iteminequipment` WRITE;
/*!40000 ALTER TABLE `iteminequipment` DISABLE KEYS */;
INSERT INTO ItemInEquipment VALUES 
	(1, 1, 7, NULL), 
	(2, 1, 8, NULL), 
	(3, 1, 9, NULL), 
	(4, 1, 10, NULL), 
	(5, 1, 11, NULL), 
	(6, 1, 12, NULL), 
	(7, 1, 12, NULL);
/*!40000 ALTER TABLE `iteminequipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemininventory`
--

DROP TABLE IF EXISTS `itemininventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemininventory` (
  `ItemInInventoryID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemInInventoryColumn` bigint(20) NOT NULL,
  `ItemInInventoryRow` bigint(20) NOT NULL,
  `ItemID` bigint(20),
  `CharacterID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemInInventoryID`),
  KEY `fk_ItemInInventory_Item1_idx` (`ItemID`),
  KEY `fk_ItemInInventory_Character1_idx` (`CharacterID`),
  CONSTRAINT `fk_ItemInInventory_Character1` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInInventory_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemininventory`
--

LOCK TABLES `itemininventory` WRITE;
/*!40000 ALTER TABLE `itemininventory` DISABLE KEYS */;
INSERT INTO ItemInInventory VALUES
	(1, 0, 0, NULL, 1),
	(2, 1, 0, NULL, 1),
	(3, 2, 0, NULL, 1),
	(4, 3, 0, NULL, 1),
	(5, 4, 0, NULL, 1),
	(6, 5, 0, NULL, 1),
	(7, 0, 1, NULL, 1),
	(8, 1, 1, NULL, 1),
	(9, 2, 1, NULL, 1),
	(10, 3, 1, NULL, 1),
	(11, 4, 1, NULL, 1),
	(12, 5, 1, NULL, 1),
	(13, 0, 2, NULL, 1),
	(14, 1, 2, NULL, 1),
	(15, 2, 2, NULL, 1),
	(16, 3, 2, NULL, 1),
	(17, 4, 2, NULL, 1),
	(18, 5, 2, NULL, 1),
	(19, 0, 3, NULL, 1),
	(20, 1, 3, NULL, 1),
	(21, 2, 3, NULL, 1),
	(22, 3, 3, NULL, 1),
	(23, 4, 3, NULL, 1),
	(24, 5, 3, NULL, 1);
/*!40000 ALTER TABLE `itemininventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iteminroom`
--

DROP TABLE IF EXISTS `iteminroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iteminroom` (
  `ItemInRoomID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemInRoomColumn` bigint(20) NOT NULL,
  `ItemInRoomRow` bigint(20) NOT NULL,
  `RoomID` bigint(20) NOT NULL,
  `ItemID` bigint(20) NOT NULL,
	`ItemInRoomIsActive` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`ItemInRoomID`),
  KEY `fk_ItemInRoom_Room1_idx` (`RoomID`),
  KEY `fk_ItemInRoom_Item1_idx` (`ItemID`),
  CONSTRAINT `fk_ItemInRoom_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInRoom_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInRoom_Room2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iteminroom`
--

LOCK TABLES `iteminroom` WRITE;
/*!40000 ALTER TABLE `iteminroom` DISABLE KEYS */;
/*!40000 ALTER TABLE `iteminroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemmodel`
--

DROP TABLE IF EXISTS `itemmodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemmodel` (
  `ItemModelID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemModelName` varchar(32) NOT NULL,
  `ItemModelArea` bigint(20),
  `StatisticID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20),
  `ItemModelWeight` bigint(20),
  `ItemTypeID` bigint(20) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemModelID`),
  KEY `fk_ItemModel_ItemType1_idx` (`ItemTypeID`),
  KEY `fk_ItemModel_AttackType1_idx` (`AttackTypeID`),
  KEY `fk_ItemModel_Statistic1_idx` (`StatisticID`),
  KEY `fk_ItemModel_Image1_idx` (`ImageID`),
  CONSTRAINT `fk_ItemModel_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_ItemType1` FOREIGN KEY (`ItemTypeID`) REFERENCES `itemtype` (`ItemTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmodel`
--

LOCK TABLES `itemmodel` WRITE;
/*!40000 ALTER TABLE `itemmodel` DISABLE KEYS */;
INSERT INTO `itemmodel` VALUES (1,'Short Sword',1,5,1,2,12,131);
/*!40000 ALTER TABLE `itemmodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemmodelaudio`
--

DROP TABLE IF EXISTS `itemmodelaudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemmodelaudio` (
  `ItemModelAudioID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemModelID` bigint(20) NOT NULL,
  `AudioID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemModelAudioID`),
  KEY `fk_ItemSound_ItemModel1_idx` (`ItemModelID`),
  KEY `fk_ItemSound_Sound1_idx` (`AudioID`),
  CONSTRAINT `fk_ItemSound_ItemModel1` FOREIGN KEY (`ItemModelID`) REFERENCES `itemmodel` (`ItemModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemSound_Sound1` FOREIGN KEY (`AudioID`) REFERENCES `audio` (`AudioID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmodelaudio`
--

LOCK TABLES `itemmodelaudio` WRITE;
/*!40000 ALTER TABLE `itemmodelaudio` DISABLE KEYS */;
INSERT INTO `itemmodelaudio` VALUES (1,1,97);
/*!40000 ALTER TABLE `itemmodelaudio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemmodelimage`
--

DROP TABLE IF EXISTS `itemmodelimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemmodelimage` (
  `ItemModelImageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ImageID` bigint(20) NOT NULL,
  `ItemModelID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  `ItemModelImageColumns` bigint(20) NOT NULL,
  `ItemModelImageRows` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemModelImageID`),
  KEY `fk_ItemModelImage_Image1_idx` (`ImageID`),
  KEY `fk_ItemModelImage_AttackType1_idx` (`AttackTypeID`),
  KEY `fk_ItemModelImage_ItemModel1_idx` (`ItemModelID`),
  CONSTRAINT `fk_ItemModelImage_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_ItemModel1` FOREIGN KEY (`ItemModelID`) REFERENCES `itemmodel` (`ItemModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmodelimage`
--

LOCK TABLES `itemmodelimage` WRITE;
/*!40000 ALTER TABLE `itemmodelimage` DISABLE KEYS */;
INSERT INTO `itemmodelimage` VALUES (1,214,1,1,6,4);
/*!40000 ALTER TABLE `itemmodelimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemtype`
--

DROP TABLE IF EXISTS `itemtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemtype` (
  `ItemTypeID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ItemTypeName` varchar(32) NOT NULL,
  `ItemTypeDrawingOrder` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemtype`
--

LOCK TABLES `itemtype` WRITE;
/*!40000 ALTER TABLE `itemtype` DISABLE KEYS */;
INSERT INTO `itemtype` VALUES (1,'default body',1),(2,'default head',2),(3,'default torso',3),(4,'default legs',4),(5,'default feet',5),(6,'default hands',6),(7,'torso',10),(8,'head',11),(9,'hands',13),(10,'legs',14),(11,'feet',15),(12,'mainhand',16);
/*!40000 ALTER TABLE `itemtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map`
--

DROP TABLE IF EXISTS `map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map` (
  `MapID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MapIsActive` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`MapID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mapmodel`
--

DROP TABLE IF EXISTS `mapmodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mapmodel` (
  `MapModelID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MapModelName` varchar(32) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `MapModelRows` bigint(20) NOT NULL,
  `MapModelColumns` bigint(20) NOT NULL,
  PRIMARY KEY (`MapModelID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapmodel`
--

LOCK TABLES `mapmodel` WRITE;
/*!40000 ALTER TABLE `mapmodel` DISABLE KEYS */;
INSERT INTO `mapmodel` VALUES (1,'Sewers',1,5,5);
/*!40000 ALTER TABLE `mapmodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `RoomID` bigint(20) NOT NULL AUTO_INCREMENT,
  `MapID` bigint(20) NOT NULL,
  `RoomColumn` bigint(20) NOT NULL,
  `RoomRow` bigint(20) NOT NULL,
  `RoomIsDiscovered` tinyint(1) NOT NULL DEFAULT 0,
  `RoomWalls` bigint(20) NOT NULL,
  PRIMARY KEY (`RoomID`),
  KEY `fk_Room_Map1_idx` (`MapID`),
  CONSTRAINT `fk_Room_Map1` FOREIGN KEY (`MapID`) REFERENCES `map` (`MapID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roommodel`
--

DROP TABLE IF EXISTS `roommodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roommodel` (
  `RoomModelID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RoomModelName` varchar(32) NOT NULL,
  PRIMARY KEY (`RoomModelID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roommodel`
--

LOCK TABLES `roommodel` WRITE;
/*!40000 ALTER TABLE `roommodel` DISABLE KEYS */;
INSERT INTO `roommodel` VALUES (1,'Two Skeletons');
/*!40000 ALTER TABLE `roommodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roommodelinmapmodel`
--

DROP TABLE IF EXISTS `roommodelinmapmodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roommodelinmapmodel` (
  `RoomModelInMapModelID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RoomModelID` bigint(20) NOT NULL,
  `MapModelID` bigint(20) NOT NULL,
  `RoomModelInMapModelCount` bigint(20) NOT NULL,
  PRIMARY KEY (`RoomModelInMapModelID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roommodelinmapmodel`
--

LOCK TABLES `roommodelinmapmodel` WRITE;
/*!40000 ALTER TABLE `roommodelinmapmodel` DISABLE KEYS */;
INSERT INTO `roommodelinmapmodel` VALUES (1,1,1,24);
/*!40000 ALTER TABLE `roommodelinmapmodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill`
--

DROP TABLE IF EXISTS `skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill` (
  `SkillID` bigint(20) NOT NULL AUTO_INCREMENT,
  `SkillName` varchar(64) NOT NULL,
  `SkillDescription` varchar(64) NOT NULL,
  `ImageID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) DEFAULT NULL,
  `SkillIsActive` tinyint(1) NOT NULL,
  `SkillCooldown` bigint(20) NOT NULL,
  `SkillEnergy` bigint(20) NOT NULL,
  `SkillArea` bigint(20) NOT NULL,
  PRIMARY KEY (`SkillID`),
  UNIQUE KEY `SkillName_UNIQUE` (`SkillName`),
  KEY `fk_Skill_AttackType1_idx` (`AttackTypeID`),
	FOREIGN KEY (`ImageID`) REFERENCES Image(ImageID),
  CONSTRAINT `fk_Skill_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` VALUES (1,'Heal','Recover some missing life.',173,NULL,1,10000,100,0),(2,'Power Thrust','A more powerful thrust.',180,4,1,500,25,1),(3,'Fire Arrow','Shoot a flaming arrow.',147,3,1,1000,25,7),(4,'Fire Wave','Generate a wave of fire.',185,6,1,10000,50,-7);
/*!40000 ALTER TABLE `skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skillstatistic`
--

DROP TABLE IF EXISTS `skillstatistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skillstatistic` (
  `SkillStatisticID` bigint(20) NOT NULL AUTO_INCREMENT,
  `StatisticID` bigint(20) NOT NULL,
  `SkillID` bigint(20) NOT NULL,
  `SkillStatisticIsAdd` tinyint(1) NOT NULL,
  `SkillStatisticDuration` BIGINT(20) NOT NULL,
  PRIMARY KEY (`SkillStatisticID`),
  KEY `fk_SkillStatistics_Statistic1_idx` (`StatisticID`),
  KEY `fk_SkillStatistics_Skill1_idx` (`SkillID`),
  CONSTRAINT `fk_SkillStatistics_Skill1` FOREIGN KEY (`SkillID`) REFERENCES `skill` (`SkillID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_SkillStatistics_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skillstatistic`
--

LOCK TABLES `skillstatistic` WRITE;
/*!40000 ALTER TABLE `skillstatistic` DISABLE KEYS */;
INSERT INTO `skillstatistic` VALUES (1,4,1,1, -1);
/*!40000 ALTER TABLE `skillstatistic` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS Statistic;

CREATE TABLE Statistic (
	StatisticID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	StatisticIsActive BOOLEAN NOT NULL DEFAULT 1
);

INSERT INTO Statistic VALUES (1, 1), (2, 1), (3, 1), (4, 1), (5, 1);

DROP TABLE IF EXISTS StatisticAttribute;

CREATE TABLE StatisticAttribute (
	StatisticAttributeID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	StatisticID BIGINT NOT NULL,
	StatisticNameID BIGINT NOT NULL,
	StatisticAttributeValue BIGINT NOT NULL,
	FOREIGN KEY (StatisticID) REFERENCES Statistic(StatisticID),
	FOREIGN KEY (StatisticNameID) REFERENCES StatisticName(StatisticNameID)
);

INSERT INTO StatisticAttribute VALUES
--  id, s, sn, v 
	-- current
	(1, 1, 1, 0),
	(2, 1, 2, 0),
	(3, 1, 3, 0),
	(4, 1, 4, 0),
	(5, 1, 5, 0),
	(6, 1, 6, 0),
	(7, 1, 7, 0), -- health
	(8, 1, 8, 0),
	-- max
	(9, 2, 1, 10),
	(10, 2, 2, 20),
	(11, 2, 3, 0),
	(12, 2, 4, 0),
	(13, 2, 5, 20),
	(14, 2, 6, 0),
	(15, 2, 7, 100), -- health
	(16, 2, 8, 100),
	-- enemy
	(17, 3, 7, 20), -- health
	(18, 3, 8, 20), 
	(19, 3, 1, 5),
	(20, 3, 2, 5), -- defense
	(21, 3, 5, 5),
	-- skill
	(22, 4, 7, 100),
	-- item
	(23, 5, 1, 5),
	(24, 5, 5, 5);

DROP TABLE IF EXISTS StatisticName;

CREATE TABLE StatisticName (
	StatisticNameID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	StatisticNameValue VARCHAR(32) NOT NULL
);

INSERT INTO StatisticName VALUES 
	(1, "strength"), 
	(2, "defense"), 
	(3, "intelligence"), 
	(4, "resistance"), 
	(5, "speed"), 
	(6, "experience"), 
	(7, "health"), 
	(8, "energy");

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategory` (
  `SubcategoryID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CategoryID` bigint(20) NOT NULL,
  `SubcategoryName` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`SubcategoryID`),
  KEY `fk_BehaviorSubcategory_BehaviorCategory1_idx` (`CategoryID`),
  CONSTRAINT `fk_BehaviorSubcategory_BehaviorCategory1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategory`
--

LOCK TABLES `subcategory` WRITE;
/*!40000 ALTER TABLE `subcategory` DISABLE KEYS */;
INSERT INTO `subcategory` VALUES 
	(1,1,'Steps'),
	(2,1,'Deaths'),
	(3,1,'Seconds Played'),
	(4,2,'Rooms'),
	(5,2,'Maps'),
	(6,3,'Heal'),
	(7,3,'Power Thrust'),
	(8,3,'Fire Arrow'),
	(9,3,'Fire Wave'),
	(10,4,'Skeleton'),
	(11,5,'Taken'),
	(12,5,'Dealt');
/*!40000 ALTER TABLE `subcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UserID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `UserFacebookID` bigint(20) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Logan Murphy',1276877482);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userbehavior`
--

DROP TABLE IF EXISTS `userbehavior`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userbehavior` (
  `UserBehaviorID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) NOT NULL,
  `SubcategoryID` bigint(20) NOT NULL,
  `UserBehaviorCount` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserBehaviorID`),
  KEY `fk_UserBehavior_BehaviorSubcategory1_idx` (`SubcategoryID`),
  KEY `fk_UserBehavior_User1_idx` (`UserID`),
  CONSTRAINT `fk_UserBehavior_BehaviorSubcategory1` FOREIGN KEY (`SubcategoryID`) REFERENCES `subcategory` (`SubcategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserBehavior_User1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userbehavior`
--

LOCK TABLES `userbehavior` WRITE;
/*!40000 ALTER TABLE `userbehavior` DISABLE KEYS */;
INSERT INTO `userbehavior` VALUES 
	(1, 1, 1, 0),
	(2, 1, 2, 0),
	(3, 1, 3, 0),
	(4, 1, 4, 0),
	(5, 1, 5, 0),
	(6, 1, 6, 0),
	(7, 1, 7, 0),
	(8, 1, 8, 0),
	(9, 1, 9, 0),
	(10, 1, 10, 0),
	(11, 1, 11, 0),
	(12, 1, 12, 0);
/*!40000 ALTER TABLE `userbehavior` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS EnemyItem;

CREATE TABLE EnemyItem (
	EnemyItemID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	EnemyID BIGINT NOT NULL,
	EnemyItemChance BIGINT NOT NULL,
	ItemModelID BIGINT NOT NULL,
	FOREIGN KEY (EnemyID) REFERENCES Enemy(EnemyID),
	FOREIGN KEY (ItemModelID) REFERENCES ItemModel(ItemModelID)
);

INSERT INTO EnemyItem VALUES (1, 1, 100, 1);

SET FOREIGN_KEY_CHECKS=1;