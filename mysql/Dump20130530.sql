CREATE DATABASE  IF NOT EXISTS `worldtactics` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `worldtactics`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: worldtactics
-- ------------------------------------------------------
-- Server version	5.1.68-community

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
INSERT INTO `attacktype` (`AttackTypeID`, `AttackTypeName`) VALUES (1,'slash'),(2,'hurt'),(3,'bow'),(4,'thrust'),(5,'walk'),(6,'spellcast');
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
  `AudioName` varchar(32) NOT NULL,
  PRIMARY KEY (`AudioID`),
  UNIQUE KEY `AudioName_UNIQUE` (`AudioName`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audio`
--

LOCK TABLES `audio` WRITE;
/*!40000 ALTER TABLE `audio` DISABLE KEYS */;
INSERT INTO `audio` (`AudioID`, `AudioName`) VALUES (1,'audio/music/dungeon.ogg'),(56,'audio/sound/battle/magic1.wav'),(57,'audio/sound/battle/spell.wav'),(58,'audio/sound/battle/swing1.wav'),(59,'audio/sound/battle/swing2.wav'),(60,'audio/sound/battle/swing3.wav'),(61,'audio/sound/battle/sword-unsheat'),(66,'audio/sound/blood/blood1.wav'),(67,'audio/sound/blood/blood2.wav'),(68,'audio/sound/blood/blood3.wav'),(69,'audio/sound/blood/blood4.wav'),(70,'audio/sound/grunts/grunt1.wav'),(71,'audio/sound/grunts/grunt10.wav'),(72,'audio/sound/grunts/grunt11.wav'),(73,'audio/sound/grunts/grunt2.wav'),(74,'audio/sound/grunts/grunt3.wav'),(75,'audio/sound/grunts/grunt4.wav'),(76,'audio/sound/grunts/grunt5.wav'),(77,'audio/sound/grunts/grunt6.wav'),(78,'audio/sound/grunts/grunt7.wav'),(79,'audio/sound/grunts/grunt8.wav'),(80,'audio/sound/grunts/grunt9.wav'),(81,'audio/sound/interface/interface1'),(82,'audio/sound/interface/interface2'),(83,'audio/sound/interface/interface3'),(84,'audio/sound/interface/interface4'),(85,'audio/sound/interface/interface5'),(86,'audio/sound/interface/interface6'),(87,'audio/sound/inventory/armor-ligh'),(88,'audio/sound/inventory/beads.wav'),(89,'audio/sound/inventory/bottle.wav'),(90,'audio/sound/inventory/bubble.wav'),(91,'audio/sound/inventory/bubble2.wa'),(92,'audio/sound/inventory/bubble3.wa'),(93,'audio/sound/inventory/chainmail1'),(94,'audio/sound/inventory/chainmail2'),(95,'audio/sound/inventory/cloth-heav'),(96,'audio/sound/inventory/cloth.wav'),(97,'audio/sound/inventory/coin.wav'),(98,'audio/sound/inventory/coin2.wav'),(99,'audio/sound/inventory/coin3.wav'),(100,'audio/sound/inventory/metal-ring'),(101,'audio/sound/inventory/metal-smal'),(104,'audio/sound/inventory/wood-small'),(105,'audio/sound/misc/burp.wav'),(106,'audio/sound/misc/random1.wav'),(107,'audio/sound/misc/random2.wav'),(108,'audio/sound/misc/random3.wav'),(109,'audio/sound/misc/random4.wav'),(110,'audio/sound/misc/random5.wav'),(111,'audio/sound/misc/random6.wav'),(2,'audio/sound/NPC/beetle/bite-smal'),(5,'audio/sound/NPC/giant/giant1.wav'),(6,'audio/sound/NPC/giant/giant2.wav'),(7,'audio/sound/NPC/giant/giant3.wav'),(8,'audio/sound/NPC/giant/giant4.wav'),(9,'audio/sound/NPC/giant/giant5.wav'),(10,'audio/sound/NPC/gutteral beast/m'),(25,'audio/sound/NPC/misc/wolfman.wav'),(26,'audio/sound/NPC/ogre/ogre1.wav'),(27,'audio/sound/NPC/ogre/ogre2.wav'),(28,'audio/sound/NPC/ogre/ogre3.wav'),(29,'audio/sound/NPC/ogre/ogre4.wav'),(30,'audio/sound/NPC/ogre/ogre5.wav'),(31,'audio/sound/NPC/shade/shade1.wav'),(32,'audio/sound/NPC/shade/shade10.wa'),(33,'audio/sound/NPC/shade/shade11.wa'),(34,'audio/sound/NPC/shade/shade12.wa'),(35,'audio/sound/NPC/shade/shade13.wa'),(36,'audio/sound/NPC/shade/shade14.wa'),(37,'audio/sound/NPC/shade/shade15.wa'),(38,'audio/sound/NPC/shade/shade2.wav'),(39,'audio/sound/NPC/shade/shade3.wav'),(40,'audio/sound/NPC/shade/shade4.wav'),(41,'audio/sound/NPC/shade/shade5.wav'),(42,'audio/sound/NPC/shade/shade6.wav'),(43,'audio/sound/NPC/shade/shade7.wav'),(44,'audio/sound/NPC/shade/shade8.wav'),(45,'audio/sound/NPC/shade/shade9.wav'),(46,'audio/sound/NPC/slime/slime1.wav'),(47,'audio/sound/NPC/slime/slime10.wa'),(48,'audio/sound/NPC/slime/slime2.wav'),(49,'audio/sound/NPC/slime/slime3.wav'),(50,'audio/sound/NPC/slime/slime4.wav'),(51,'audio/sound/NPC/slime/slime5.wav'),(52,'audio/sound/NPC/slime/slime6.wav'),(53,'audio/sound/NPC/slime/slime7.wav'),(54,'audio/sound/NPC/slime/slime8.wav'),(55,'audio/sound/NPC/slime/slime9.wav'),(112,'audio/sound/scream/scream1.mp3'),(113,'audio/sound/scream/scream1.wav'),(114,'audio/sound/scream/scream2.mp3'),(115,'audio/sound/scream/scream2.wav'),(116,'audio/sound/scream/scream3.mp3'),(117,'audio/sound/scream/scream3.wav'),(118,'audio/sound/scream/scream4.mp3'),(119,'audio/sound/scream/scream4.wav'),(120,'audio/sound/scream/scream5.mp3'),(121,'audio/sound/scream/scream5.wav'),(122,'audio/sound/walk/stepdirt_1.wav'),(123,'audio/sound/walk/stepdirt_2.wav'),(124,'audio/sound/walk/stepdirt_3.wav'),(125,'audio/sound/walk/stepdirt_4.wav'),(126,'audio/sound/walk/stepdirt_5.wav'),(127,'audio/sound/walk/stepdirt_6.wav'),(128,'audio/sound/walk/stepdirt_7.wav'),(129,'audio/sound/walk/stepdirt_8.wav'),(130,'audio/sound/walk/stepsnow_1.wav'),(131,'audio/sound/walk/stepsnow_2.wav'),(132,'audio/sound/walk/stepstone_1.wav'),(133,'audio/sound/walk/stepstone_2.wav'),(134,'audio/sound/walk/stepstone_3.wav'),(135,'audio/sound/walk/stepstone_4.wav'),(136,'audio/sound/walk/stepstone_5.wav'),(137,'audio/sound/walk/stepstone_6.wav'),(138,'audio/sound/walk/stepstone_7.wav'),(139,'audio/sound/walk/stepstone_8.wav'),(140,'audio/sound/walk/stepwater_1.wav'),(141,'audio/sound/walk/stepwater_2.wav'),(142,'audio/sound/walk/stepwood_1.wav'),(143,'audio/sound/walk/stepwood_2.wav'),(144,'audio/sound/world/door.wav');
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
  `BadgeIcon` bigint(20) NOT NULL,
  `SubcategoryID` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`BadgeId`),
  KEY `fk_Badge_BehaviorCategory1_idx` (`CategoryID`),
  KEY `fk_Badge_Image1_idx` (`BadgeIcon`),
  KEY `fk_Badge_Subcategory1_idx` (`SubcategoryID`),
  CONSTRAINT `fk_Badge_BehaviorCategory1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Image1` FOREIGN KEY (`BadgeIcon`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Subcategory1` FOREIGN KEY (`SubcategoryID`) REFERENCES `subcategory` (`SubcategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badge`
--

LOCK TABLES `badge` WRITE;
/*!40000 ALTER TABLE `badge` DISABLE KEYS */;
INSERT INTO `badge` (`BadgeId`, `BadgeName`, `CategoryID`, `BadgeCount`, `BadgeIcon`, `SubcategoryID`) VALUES (1,'First Step',NULL,1,2,1),(2,'Adventurer',NULL,10,11,6),(3,'Explorer',NULL,1,10,7),(4,'First Death',NULL,1,7,3),(5,'Killer',4,50,4,NULL),(6,'First Kill',4,1,5,NULL),(7,'Skillful',3,10,9,NULL);
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
INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES (1,'Character'),(2,'Discover'),(3,'Skill'),(4,'Kill'),(5,'Damage');
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
  `CharacterPortrait` bigint(20) NOT NULL,
  `CharacterCurrentStatisticID` bigint(20) NOT NULL,
  `CharacterMaxStatisticID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `RoomID` bigint(20) DEFAULT NULL,
  `CharacterColumn` bigint(20) DEFAULT NULL,
  `CharacterRow` bigint(20) DEFAULT NULL,
  `CharacterDirection` bigint(20) DEFAULT NULL,
  `CharacterIsMale` tinyint(1) NOT NULL,
  `CharacterCanUse` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`CharacterID`),
  KEY `fk_Character_Image1_idx` (`CharacterPortrait`),
  KEY `fk_Character_Statistic1_idx` (`CharacterCurrentStatisticID`),
  KEY `fk_Character_Statistic2_idx` (`CharacterMaxStatisticID`),
  KEY `fk_Character_User1_idx` (`UserID`),
  KEY `fk_Character_Room1_idx` (`RoomID`),
  CONSTRAINT `fk_Character_Image1` FOREIGN KEY (`CharacterPortrait`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic1` FOREIGN KEY (`CharacterCurrentStatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic2` FOREIGN KEY (`CharacterMaxStatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_User1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character`
--

LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` (`CharacterID`, `CharacterName`, `CharacterPortrait`, `CharacterCurrentStatisticID`, `CharacterMaxStatisticID`, `UserID`, `RoomID`, `CharacterColumn`, `CharacterRow`, `CharacterDirection`, `CharacterIsMale`) VALUES (1,'nagolyhprum',50,1,2,1,NULL,NULL,NULL,NULL,1);
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
  CONSTRAINT `fk_CharacterSound_Sound1` FOREIGN KEY (`AudioID`) REFERENCES `audio` (`AudioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSound_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characteraudio`
--

LOCK TABLES `characteraudio` WRITE;
/*!40000 ALTER TABLE `characteraudio` DISABLE KEYS */;
INSERT INTO `characteraudio` (`CharacterAudioID`, `AudioID`, `AttackTypeID`, `CharacterAudioIsMale`) VALUES (1,56,6,1),(2,58,1,1),(3,70,2,1),(4,58,3,1),(5,58,4,1);
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
INSERT INTO `characterimage` (`CharacterImageID`, `CharacterID`, `CharacterImageChoiceGroupID`) VALUES (1,1,1);
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
  CONSTRAINT `fk_CharacterImageChoice_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImageChoice_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterimagechoice`
--

LOCK TABLES `characterimagechoice` WRITE;
/*!40000 ALTER TABLE `characterimagechoice` DISABLE KEYS */;
INSERT INTO `characterimagechoice` (`CharacterImageChoiceID`, `CharacterImageChoiceRows`, `CharacterImageChoiceColumns`, `AttackTypeID`, `ImageID`, `CharacterImageChoiceGroupID`) VALUES (1,4,13,2,16,1),(2,1,6,2,60,1),(3,4,6,1,191,1),(4,4,7,6,223,1),(5,4,8,4,255,1),(6,4,9,5,314,1);
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
INSERT INTO `characterimagechoicegroup` (`CharacterImageChoiceGroupID`, `ItemTypeID`, `CharacterImageChoiceGroupIsMale`, `CharacterImageChoiceGroupName`) VALUES (1,1,1,'white body');
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
  `CharacterSkillCanUse` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CharacterSkillID`),
  KEY `fk_CharacterSkill_Skill2_idx` (`SkillID`),
  KEY `fk_CharacterSkill_Character2_idx` (`CharacterID`),
  CONSTRAINT `fk_CharacterSkill_Skill2` FOREIGN KEY (`SkillID`) REFERENCES `skill` (`SkillID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSkill_Character2` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `characterskill`
--

LOCK TABLES `characterskill` WRITE;
/*!40000 ALTER TABLE `characterskill` DISABLE KEYS */;
INSERT INTO `characterskill` (`CharacterSkillID`, `CharacterID`, `SkillID`, `CharacterSkillIndex`, `CharacterSkillCanUse`) VALUES (1,1,3,0,'0000-00-00 00:00:00'),(2,1,4,1,'0000-00-00 00:00:00'),(3,1,1,2,'0000-00-00 00:00:00'),(4,1,2,3,'0000-00-00 00:00:00');
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
  `EnemyPortrait` bigint(20) NOT NULL,
  `EnemyName` varchar(32) NOT NULL,
  `StatisticID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) NOT NULL,
  `EnemyCanMove` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`EnemyID`),
  KEY `fk_Enemy_Image1_idx` (`EnemyPortrait`),
  KEY `fk_Enemy_Statistic1_idx` (`StatisticID`),
  KEY `fk_Enemy_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_Enemy_Image1` FOREIGN KEY (`EnemyPortrait`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemy`
--

LOCK TABLES `enemy` WRITE;
/*!40000 ALTER TABLE `enemy` DISABLE KEYS */;
INSERT INTO `enemy` (`EnemyID`, `EnemyPortrait`, `EnemyName`, `StatisticID`, `AttackTypeID`) VALUES (1,53,'Skeleton',3,1);
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
  CONSTRAINT `fk_EnemySound_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_Sound1` FOREIGN KEY (`AudioID`) REFERENCES `audio` (`AudioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyaudio`
--

LOCK TABLES `enemyaudio` WRITE;
/*!40000 ALTER TABLE `enemyaudio` DISABLE KEYS */;
INSERT INTO `enemyaudio` (`EnemyAudioID`, `AudioID`, `EnemyID`, `AttackTypeID`) VALUES (1,31,1,2),(2,58,1,1);
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
  CONSTRAINT `fk_EnemyImage_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_ItemType1` FOREIGN KEY (`ItemTypeID`) REFERENCES `itemtype` (`ItemTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyimage`
--

LOCK TABLES `enemyimage` WRITE;
/*!40000 ALTER TABLE `enemyimage` DISABLE KEYS */;
INSERT INTO `enemyimage` (`EnemyImageID`, `EnemyID`, `ImageID`, `ItemTypeID`, `EnemyImageRows`, `EnemyImageColumns`, `AttackTypeID`) VALUES (1,1,61,1,1,6,2),(2,1,192,1,4,6,1),(3,1,315,1,4,9,5);
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
  `EnemyInRoomStatistics` bigint(20) NOT NULL,
  `EnemyID` bigint(20) NOT NULL,
  `RoomID` bigint(20) NOT NULL,
  `EnemyInRoomColumn` bigint(20) NOT NULL,
  `EnemyInRoomRow` bigint(20) NOT NULL,
  `EnemyInRoomDirection` bigint(20) NOT NULL,
  PRIMARY KEY (`EnemyInRoomID`),
  KEY `fk_EnemyInRoom_Room1_idx` (`RoomID`),
  KEY `fk_EnemyInRoom_Enemy1_idx` (`EnemyID`),
  KEY `fk_EnemyInRoom_Statistic1_idx` (`EnemyInRoomStatistics`),
  CONSTRAINT `fk_EnemyInRoom_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Enemy1` FOREIGN KEY (`EnemyID`) REFERENCES `enemy` (`EnemyID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Statistic1` FOREIGN KEY (`EnemyInRoomStatistics`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemyinroom`
--

LOCK TABLES `enemyinroom` WRITE;
/*!40000 ALTER TABLE `enemyinroom` DISABLE KEYS */;
/*!40000 ALTER TABLE `enemyinroom` ENABLE KEYS */;
UNLOCK TABLES;

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
  `EnemyInRoomModelDirection` bigint(20) NOT NULL,
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
INSERT INTO `enemyinroommodel` (`EnemyInRoomModelID`, `EnemyID`, `RoomModelID`, `EnemyInRoomModelDirection`, `EnemyInRoomModelRow`, `EnemyInRoomModelColumn`) VALUES (1,1,1,1,3,1),(2,1,1,2,1,3);
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
INSERT INTO `image` (`ImageID`, `ImageName`) VALUES (1,'images/background.jpg'),(2,'images/badges/arrow.png'),(3,'images/badges/award.png'),(4,'images/badges/ddeath.png'),(5,'images/badges/death.png'),(6,'images/badges/dup.png'),(7,'images/badges/killed.png'),(8,'images/badges/line.png'),(9,'images/badges/tstar.png'),(10,'images/badges/tup.png'),(11,'images/badges/up.png'),(12,'images/badges/wings.png'),(13,'images/bk_drops.png'),(14,'images/bow/BELT_leather.png'),(15,'images/bow/BELT_rope.png'),(16,'images/bow/BODY_human.png'),(40,'images/bow/chest.png'),(41,'images/bow/feet.png'),(17,'images/bow/FEET_plate_armor_shoes.png'),(18,'images/bow/FEET_shoes_brown.png'),(42,'images/bow/hands.png'),(19,'images/bow/HANDS_plate_armor_gloves.png'),(43,'images/bow/head.png'),(20,'images/bow/HEAD_chain_armor_helmet.png'),(21,'images/bow/HEAD_chain_armor_hood.png'),(22,'images/bow/HEAD_hair_blonde.png'),(23,'images/bow/HEAD_leather_armor_hat.png'),(24,'images/bow/HEAD_plate_armor_helmet.png'),(25,'images/bow/HEAD_robe_hood.png'),(44,'images/bow/legs.png'),(26,'images/bow/LEGS_pants_greenish.png'),(27,'images/bow/LEGS_plate_armor_pants.png'),(28,'images/bow/LEGS_robe_skirt.png'),(29,'images/bow/TORSO_chain_armor_jacket_purple.png'),(30,'images/bow/TORSO_chain_armor_torso.png'),(31,'images/bow/TORSO_leather_armor_bracers.png'),(32,'images/bow/TORSO_leather_armor_shirt_white.png'),(33,'images/bow/TORSO_leather_armor_shoulders.png'),(34,'images/bow/TORSO_leather_armor_torso.png'),(35,'images/bow/TORSO_plate_armor_arms_shoulders.png'),(36,'images/bow/TORSO_plate_armor_torso.png'),(37,'images/bow/TORSO_robe_shirt_brown.png'),(38,'images/bow/WEAPON_arrow.png'),(39,'images/bow/WEAPON_bow.png'),(45,'images/combat_dummy/BODY_animation.png'),(46,'images/drops.png'),(47,'images/face/FlareFemaleHero1.png'),(48,'images/face/FlareFemaleHero2.png'),(49,'images/face/FlareFemaleHero3.png'),(50,'images/face/FlareMaleHero1.png'),(51,'images/face/FlareMaleHero2.png'),(52,'images/face/FlareMaleHero3.png'),(53,'images/face/skeleton.png'),(54,'images/health/background.png'),(55,'images/health/foreground_gold.png'),(56,'images/health/foreground_gray.png'),(57,'images/hurt/BEHIND_quiver.png'),(58,'images/hurt/BELT_leather.png'),(59,'images/hurt/BELT_rope.png'),(60,'images/hurt/BODY_human.png'),(61,'images/hurt/BODY_skeleton.png'),(62,'images/hurt/FEET_plate_armor_shoes.png'),(63,'images/hurt/FEET_shoes_brown.png'),(64,'images/hurt/HANDS_plate_armor_gloves.png'),(65,'images/hurt/HEAD_chain_armor_helmet.png'),(66,'images/hurt/HEAD_chain_armor_hood.png'),(67,'images/hurt/HEAD_hair_blonde.png'),(68,'images/hurt/HEAD_leather_armor_hat.png'),(69,'images/hurt/HEAD_plate_armor_helmet.png'),(70,'images/hurt/HEAD_robe_hood.png'),(71,'images/hurt/LEGS_pants_greenish.png'),(72,'images/hurt/LEGS_plate_armor_pants.png'),(73,'images/hurt/LEGS_robe_skirt.png'),(74,'images/hurt/TORSO_chain_armor_jacket_purple.png'),(75,'images/hurt/TORSO_chain_armor_torso.png'),(76,'images/hurt/TORSO_leather_armor_bracers.png'),(77,'images/hurt/TORSO_leather_armor_shirt_white.png'),(78,'images/hurt/TORSO_leather_armor_shoulders.png'),(79,'images/hurt/TORSO_leather_armor_torso.png'),(80,'images/hurt/TORSO_plate_armor_arms_shoulders.png'),(81,'images/hurt/TORSO_plate_armor_torso.png'),(82,'images/hurt/TORSO_robe_shirt_brown.png'),(83,'images/items/buckler.png'),(84,'images/items/chain-chest.png'),(85,'images/items/chain-feet.png'),(86,'images/items/chain-hands.png'),(87,'images/items/chain-head.png'),(88,'images/items/chain-legs.png'),(89,'images/items/chest.png'),(90,'images/items/cloth-chest.png'),(91,'images/items/cloth-feet.png'),(92,'images/items/cloth-hands.png'),(93,'images/items/cloth-legs.png'),(94,'images/items/dagger.png'),(95,'images/items/feet.png'),(96,'images/items/greatbow.png'),(97,'images/items/greatstaff.png'),(98,'images/items/greatsword.png'),(99,'images/items/hands.png'),(100,'images/items/head.png'),(101,'images/items/hide-chest.png'),(102,'images/items/hide-feet.png'),(103,'images/items/hide-hands.png'),(104,'images/items/hide-head.png'),(105,'images/items/hide-legs.png'),(106,'images/items/leather-chest.png'),(107,'images/items/leather-feet.png'),(108,'images/items/leather-hands.png'),(109,'images/items/leather-head.png'),(110,'images/items/leather-legs.png'),(111,'images/items/legs.png'),(112,'images/items/longbow.png'),(113,'images/items/longsword.png'),(114,'images/items/mainhand.png'),(115,'images/items/neck.png'),(116,'images/items/offhand.png'),(117,'images/items/ring.png'),(118,'images/items/ring0.png'),(119,'images/items/ring1.png'),(120,'images/items/ring2.png'),(121,'images/items/ring3.png'),(122,'images/items/ring4.png'),(123,'images/items/ring5.png'),(124,'images/items/ring6.png'),(125,'images/items/ring7.png'),(126,'images/items/ring8.png'),(127,'images/items/ring9.png'),(128,'images/items/rod.png'),(129,'images/items/shield.png'),(130,'images/items/shortbow.png'),(131,'images/items/shortsword.png'),(132,'images/items/slingshot.png'),(133,'images/items/staff.png'),(134,'images/items/steel-chest.png'),(135,'images/items/steel-feet.png'),(136,'images/items/steel-hands.png'),(137,'images/items/steel-head.png'),(138,'images/items/steel-legs.png'),(139,'images/items/wand.png'),(140,'images/skills/ball/dark.png'),(141,'images/skills/ball/fire.png'),(142,'images/skills/ball/ice.png'),(143,'images/skills/ball/light.png'),(144,'images/skills/ball/lightning.png'),(145,'images/skills/ball/poison.png'),(146,'images/skills/bolt/dark.png'),(147,'images/skills/bolt/fire.png'),(148,'images/skills/bolt/ice.png'),(149,'images/skills/bolt/light.png'),(150,'images/skills/bolt/poison.png'),(156,'images/skills/boost-adv/dark.png'),(157,'images/skills/boost-adv/fire.png'),(158,'images/skills/boost-adv/ice.png'),(159,'images/skills/boost-adv/light.png'),(160,'images/skills/boost-adv/poison.png'),(151,'images/skills/boost/dark.png'),(152,'images/skills/boost/fire.png'),(153,'images/skills/boost/ice.png'),(154,'images/skills/boost/light.png'),(155,'images/skills/boost/poison.png'),(166,'images/skills/breath-adv/dark.png'),(167,'images/skills/breath-adv/fire.png'),(168,'images/skills/breath-adv/ice.png'),(169,'images/skills/breath-adv/light.png'),(170,'images/skills/breath-adv/lightning.png'),(171,'images/skills/breath-adv/poison.png'),(161,'images/skills/breath/dark.png'),(162,'images/skills/breath/fire.png'),(163,'images/skills/breath/ice.png'),(164,'images/skills/breath/lightning.png'),(165,'images/skills/breath/poison.png'),(172,'images/skills/resist/dark.png'),(173,'images/skills/resist/fire.png'),(174,'images/skills/resist/ice.png'),(175,'images/skills/resist/poison.png'),(176,'images/skills/thrust/bloody.png'),(177,'images/skills/thrust/ice.png'),(178,'images/skills/thrust/light.png'),(179,'images/skills/thrust/lightning.png'),(180,'images/skills/thrust/normal.png'),(181,'images/skills/thrust/poison.png'),(182,'images/skills/vampire/125.png'),(183,'images/skills/vampire/126.png'),(184,'images/skills/wave/dark.png'),(185,'images/skills/wave/fire.png'),(186,'images/skills/wave/ice.png'),(187,'images/skills/wave/poison.png'),(188,'images/slash/BEHIND_quiver.png'),(189,'images/slash/BELT_leather.png'),(190,'images/slash/BELT_rope.png'),(191,'images/slash/BODY_human.png'),(192,'images/slash/BODY_skeleton.png'),(215,'images/slash/chest.png'),(216,'images/slash/feet.png'),(193,'images/slash/FEET_plate_armor_shoes.png'),(194,'images/slash/FEET_shoes_brown.png'),(217,'images/slash/hands.png'),(195,'images/slash/HANDS_plate_armor_gloves.png'),(218,'images/slash/head.png'),(196,'images/slash/HEAD_chain_armor_helmet.png'),(197,'images/slash/HEAD_chain_armor_hood.png'),(198,'images/slash/HEAD_hair_blonde.png'),(199,'images/slash/HEAD_leather_armor_hat.png'),(200,'images/slash/HEAD_plate_armor_helmet.png'),(201,'images/slash/HEAD_robe_hood.png'),(219,'images/slash/legs.png'),(202,'images/slash/LEGS_pants_greenish.png'),(203,'images/slash/LEGS_plate_armor_pants.png'),(204,'images/slash/LEGS_robe_skirt.png'),(205,'images/slash/TORSO_chain_armor_jacket_purple.png'),(206,'images/slash/TORSO_chain_armor_torso.png'),(207,'images/slash/TORSO_leather_armor_bracers.png'),(208,'images/slash/TORSO_leather_armor_shirt_white.png'),(209,'images/slash/TORSO_leather_armor_shoulders.png'),(210,'images/slash/TORSO_leather_armor_torso.png'),(211,'images/slash/TORSO_plate_armor_arms_shoulders.png'),(212,'images/slash/TORSO_plate_armor_torso.png'),(213,'images/slash/TORSO_robe_shirt_brown.png'),(214,'images/slash/WEAPON_dagger.png'),(220,'images/spellcast/BEHIND_quiver.png'),(221,'images/spellcast/BELT_leather.png'),(222,'images/spellcast/BELT_rope.png'),(223,'images/spellcast/BODY_human.png'),(224,'images/spellcast/BODY_skeleton.png'),(247,'images/spellcast/chest.png'),(248,'images/spellcast/feet.png'),(225,'images/spellcast/FEET_plate_armor_shoes.png'),(226,'images/spellcast/FEET_shoes_brown.png'),(249,'images/spellcast/hands.png'),(227,'images/spellcast/HANDS_plate_armor_gloves.png'),(250,'images/spellcast/head.png'),(228,'images/spellcast/HEAD_chain_armor_helmet.png'),(229,'images/spellcast/HEAD_chain_armor_hood.png'),(230,'images/spellcast/HEAD_hair_blonde.png'),(231,'images/spellcast/HEAD_leather_armor_hat.png'),(232,'images/spellcast/HEAD_plate_armor_helmet.png'),(233,'images/spellcast/HEAD_robe_hood.png'),(234,'images/spellcast/HEAD_skeleton_eye_glow.png'),(251,'images/spellcast/legs.png'),(235,'images/spellcast/LEGS_pants_greenish.png'),(236,'images/spellcast/LEGS_plate_armor_pants.png'),(237,'images/spellcast/LEGS_robe_skirt.png'),(238,'images/spellcast/TORSO_chain_armor_jacket_purple.png'),(239,'images/spellcast/TORSO_chain_armor_torso.png'),(240,'images/spellcast/TORSO_leather_armor_bracers.png'),(241,'images/spellcast/TORSO_leather_armor_shirt_white.png'),(242,'images/spellcast/TORSO_leather_armor_shoulders.png'),(243,'images/spellcast/TORSO_leather_armor_torso.png'),(244,'images/spellcast/TORSO_plate_armor_arms_shoulders.png'),(245,'images/spellcast/TORSO_plate_armor_torso.png'),(246,'images/spellcast/TORSO_robe_shirt_brown.png'),(252,'images/thrust/BEHIND_quiver.png'),(253,'images/thrust/BELT_leather.png'),(254,'images/thrust/BELT_rope.png'),(255,'images/thrust/BODY_human.png'),(281,'images/thrust/chest.png'),(282,'images/thrust/feet.png'),(256,'images/thrust/FEET_plate_armor_shoes.png'),(257,'images/thrust/FEET_shoes_brown.png'),(283,'images/thrust/hands.png'),(258,'images/thrust/HANDS_plate_armor_gloves.png'),(284,'images/thrust/head.png'),(259,'images/thrust/HEAD_chain_armor_helmet.png'),(260,'images/thrust/HEAD_chain_armor_hood.png'),(261,'images/thrust/HEAD_hair_blonde.png'),(262,'images/thrust/HEAD_leather_armor_hat.png'),(263,'images/thrust/HEAD_plate_armor_helmet.png'),(264,'images/thrust/HEAD_robe_hood.png'),(285,'images/thrust/legs.png'),(265,'images/thrust/LEGS_pants_greenish.png'),(266,'images/thrust/LEGS_plate_armor_pants.png'),(267,'images/thrust/LEGS_robe_skirt.png'),(268,'images/thrust/TORSO_chain_armor_jacket_purple.png'),(269,'images/thrust/TORSO_chain_armor_torso.png'),(270,'images/thrust/TORSO_leather_armor_bracers.png'),(271,'images/thrust/TORSO_leather_armor_shirt_white.png'),(272,'images/thrust/TORSO_leather_armor_shoulders.png'),(273,'images/thrust/TORSO_leather_armor_torso.png'),(274,'images/thrust/TORSO_plate_armor_arms_shoulders.png'),(275,'images/thrust/TORSO_plate_armor_torso.png'),(276,'images/thrust/TORSO_robe_shirt_brown.png'),(277,'images/thrust/WEAPON_shield_cutout_body.png'),(278,'images/thrust/WEAPON_shield_cutout_chain_armor_helmet.png'),(279,'images/thrust/WEAPON_spear.png'),(280,'images/thrust/WEAPON_staff.png'),(286,'images/tiles.gif'),(287,'images/ui/arrowsdown.png'),(288,'images/ui/arrowsleft.png'),(289,'images/ui/arrowsright.png'),(290,'images/ui/arrowsup.png'),(291,'images/ui/bar_hp_mp.png'),(292,'images/ui/button_default.png'),(293,'images/ui/button_small.png'),(294,'images/ui/button_x.png'),(295,'images/ui/checkbox_default.png'),(296,'images/ui/combobox_default.png'),(297,'images/ui/confirm_bg.png'),(298,'images/ui/dialog_box.png'),(299,'images/ui/input.png'),(300,'images/ui/listbox_default.png'),(301,'images/ui/menu_xp.png'),(302,'images/ui/mouse_pointer.png'),(303,'images/ui/portrait.png'),(304,'images/ui/radiobutton_default.png'),(305,'images/ui/scrollbar_default.png'),(306,'images/ui/slider_default.png'),(307,'images/ui/slot.png'),(308,'images/ui/tab_active.png'),(309,'images/ui/tab_inactive.png'),(310,'images/ui/window.png'),(311,'images/walk/BEHIND_quiver.png'),(312,'images/walk/BELT_leather.png'),(313,'images/walk/BELT_rope.png'),(314,'images/walk/BODY_male.png'),(315,'images/walk/BODY_skeleton.png'),(339,'images/walk/chest.png'),(340,'images/walk/feet.png'),(316,'images/walk/FEET_plate_armor_shoes.png'),(317,'images/walk/FEET_shoes_brown.png'),(341,'images/walk/hands.png'),(318,'images/walk/HANDS_plate_armor_gloves.png'),(342,'images/walk/head.png'),(319,'images/walk/HEAD_chain_armor_helmet.png'),(320,'images/walk/HEAD_chain_armor_hood.png'),(321,'images/walk/HEAD_hair_blonde.png'),(322,'images/walk/HEAD_leather_armor_hat.png'),(323,'images/walk/HEAD_plate_armor_helmet.png'),(324,'images/walk/HEAD_robe_hood.png'),(343,'images/walk/legs.png'),(325,'images/walk/LEGS_pants_greenish.png'),(326,'images/walk/LEGS_plate_armor_pants.png'),(327,'images/walk/LEGS_robe_skirt.png'),(328,'images/walk/TORSO_chain_armor_jacket_purple.png'),(329,'images/walk/TORSO_chain_armor_torso.png'),(330,'images/walk/TORSO_leather_armor_bracers.png'),(331,'images/walk/TORSO_leather_armor_shirt_white.png'),(332,'images/walk/TORSO_leather_armor_shoulders.png'),(333,'images/walk/TORSO_leather_armor_torso.png'),(334,'images/walk/TORSO_plate_armor_arms_shoulders.png'),(335,'images/walk/TORSO_plate_armor_torso.png'),(336,'images/walk/TORSO_robe_shirt_brown.png'),(337,'images/walk/WEAPON_shield_cutout_body.png'),(338,'images/walk/WEAPON_shield_cutout_chain_armor_helmet.png'),(344,'images/window/border.png'),(345,'images/window/bottom.png'),(346,'images/window/bottomleft.png'),(347,'images/window/bottomright.png'),(348,'images/window/left.png'),(349,'images/window/right.png'),(350,'images/window/texture.png'),(351,'images/window/top.png'),(352,'images/window/topleft.png'),(353,'images/window/topright.png');
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
  `ItemID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemInEquipmentID`),
  KEY `fk_ItemInEquipment_Item1_idx` (`ItemID`),
  KEY `fk_ItemInEquipment_Character1_idx` (`CharacterID`),
  CONSTRAINT `fk_ItemInEquipment_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInEquipment_Character1` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iteminequipment`
--

LOCK TABLES `iteminequipment` WRITE;
/*!40000 ALTER TABLE `iteminequipment` DISABLE KEYS */;
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
  `ItemID` bigint(20) NOT NULL,
  `CharacterID` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemInInventoryID`),
  KEY `fk_ItemInInventory_Item1_idx` (`ItemID`),
  KEY `fk_ItemInInventory_Character1_idx` (`CharacterID`),
  CONSTRAINT `fk_ItemInInventory_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInInventory_Character1` FOREIGN KEY (`CharacterID`) REFERENCES `character` (`CharacterID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemininventory`
--

LOCK TABLES `itemininventory` WRITE;
/*!40000 ALTER TABLE `itemininventory` DISABLE KEYS */;
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
  PRIMARY KEY (`ItemInRoomID`),
  KEY `fk_ItemInRoom_Room1_idx` (`RoomID`),
  KEY `fk_ItemInRoom_Item1_idx` (`ItemID`),
  CONSTRAINT `fk_ItemInRoom_Room1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInRoom_Item1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  `ItemModelArea` bigint(20) NOT NULL,
  `StatisticID` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) DEFAULT NULL,
  `ItemModelWeight` bigint(20) NOT NULL,
  `ItemTypeID` bigint(20) NOT NULL,
  `ItemModelPortrait` bigint(20) NOT NULL,
  PRIMARY KEY (`ItemModelID`),
  KEY `fk_ItemModel_ItemType1_idx` (`ItemTypeID`),
  KEY `fk_ItemModel_AttackType1_idx` (`AttackTypeID`),
  KEY `fk_ItemModel_Statistic1_idx` (`StatisticID`),
  KEY `fk_ItemModel_Image1_idx` (`ItemModelPortrait`),
  CONSTRAINT `fk_ItemModel_ItemType1` FOREIGN KEY (`ItemTypeID`) REFERENCES `itemtype` (`ItemTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Image1` FOREIGN KEY (`ItemModelPortrait`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmodel`
--

LOCK TABLES `itemmodel` WRITE;
/*!40000 ALTER TABLE `itemmodel` DISABLE KEYS */;
INSERT INTO `itemmodel` (`ItemModelID`, `ItemModelName`, `ItemModelArea`, `StatisticID`, `AttackTypeID`, `ItemModelWeight`, `ItemTypeID`, `ItemModelPortrait`) VALUES (1,'Short Sword',1,4,1,2,12,131);
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
INSERT INTO `itemmodelaudio` (`ItemModelAudioID`, `ItemModelID`, `AudioID`) VALUES (1,1,97);
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
  CONSTRAINT `fk_ItemModelImage_Image1` FOREIGN KEY (`ImageID`) REFERENCES `image` (`ImageID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_ItemModel1` FOREIGN KEY (`ItemModelID`) REFERENCES `itemmodel` (`ItemModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmodelimage`
--

LOCK TABLES `itemmodelimage` WRITE;
/*!40000 ALTER TABLE `itemmodelimage` DISABLE KEYS */;
INSERT INTO `itemmodelimage` (`ItemModelImageID`, `ImageID`, `ItemModelID`, `AttackTypeID`, `ItemModelImageColumns`, `ItemModelImageRows`) VALUES (1,214,1,1,7,4);
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
INSERT INTO `itemtype` (`ItemTypeID`, `ItemTypeName`, `ItemTypeDrawingOrder`) VALUES (1,'default body',1),(2,'default head',2),(3,'default torso',3),(4,'default legs',4),(5,'default feet',5),(6,'default hands',6),(7,'torso',10),(8,'head',11),(9,'hands',13),(10,'legs',14),(11,'feet',15),(12,'mainhand',16);
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
	`MapIsActive` TINYINT(1) NOT NULL,
  PRIMARY KEY (`MapID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map`
--

LOCK TABLES `map` WRITE;
/*!40000 ALTER TABLE `map` DISABLE KEYS */;
/*!40000 ALTER TABLE `map` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `mapmodel` (`MapModelID`, `MapModelName`, `ImageID`, `MapModelRows`, `MapModelColumns`) VALUES (1,'Sewers',1,5,5);
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
  `RoomIsDiscovered` tinyint(1) NOT NULL,
  `RoomWalls` BIGINT NOT NULL,
  PRIMARY KEY (`RoomID`),
  KEY `fk_Room_Map1_idx` (`MapID`),
  CONSTRAINT `fk_Room_Map1` FOREIGN KEY (`MapID`) REFERENCES `map` (`MapID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `roommodel` (`RoomModelID`, `RoomModelName`) VALUES (1,'Two Skeletons');
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
INSERT INTO `roommodelinmapmodel` (`RoomModelInMapModelID`, `RoomModelID`, `MapModelID`, `RoomModelInMapModelCount`) VALUES (1,1,1,24);
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
  `SkillIcon` bigint(20) NOT NULL,
  `AttackTypeID` bigint(20) DEFAULT NULL,
  `SkillIsActive` tinyint(1) NOT NULL,
  `SkillCooldown` bigint(20) NOT NULL,
  `SkillEnergy` bigint(20) NOT NULL,
  `SkillArea` bigint(20) NOT NULL,
  PRIMARY KEY (`SkillID`),
  UNIQUE KEY `SkillName_UNIQUE` (`SkillName`),
  KEY `fk_Skill_AttackType1_idx` (`AttackTypeID`),
  CONSTRAINT `fk_Skill_AttackType1` FOREIGN KEY (`AttackTypeID`) REFERENCES `attacktype` (`AttackTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` (`SkillID`, `SkillName`, `SkillDescription`, `SkillIcon`, `AttackTypeID`, `SkillIsActive`, `SkillCooldown`, `SkillEnergy`, `SkillArea`) VALUES (1,'Heal','Recover some missing life.',173,NULL,1,10000,100,0),(2,'Power Thrust','A more powerful thrust.',180,4,1,500,25,1),(3,'Fire Arrow','Shoot a flaming arrow.',147,3,1,1000,25,7),(4,'Fire Wave','Generate a wave of fire.',185,6,1,10000,50,-7);
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
  `SkillStatisticDuration` bigint(20) NOT NULL,
  PRIMARY KEY (`SkillStatisticID`),
  KEY `fk_SkillStatistics_Statistic1_idx` (`StatisticID`),
  KEY `fk_SkillStatistics_Skill1_idx` (`SkillID`),
  CONSTRAINT `fk_SkillStatistics_Statistic1` FOREIGN KEY (`StatisticID`) REFERENCES `statistic` (`StatisticID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_SkillStatistics_Skill1` FOREIGN KEY (`SkillID`) REFERENCES `skill` (`SkillID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skillstatistic`
--

LOCK TABLES `skillstatistic` WRITE;
/*!40000 ALTER TABLE `skillstatistic` DISABLE KEYS */;
INSERT INTO `skillstatistic` (`SkillStatisticID`, `StatisticID`, `SkillID`, `SkillStatisticIsAdd`, `SkillStatisticDuration`) VALUES (1,5,1,1,-1);
/*!40000 ALTER TABLE `skillstatistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic`
--

DROP TABLE IF EXISTS `statistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic` (
  `StatisticID` bigint(20) NOT NULL AUTO_INCREMENT,
  `StatisticStrength` bigint(20) NOT NULL,
  `StatisticDefense` bigint(20) NOT NULL,
  `StatisticHealth` bigint(20) NOT NULL,
  `StatisticEnergy` bigint(20) NOT NULL,
  `StatisticIntelligence` bigint(20) NOT NULL,
  `StatisticResistance` bigint(20) NOT NULL,
  `StatisticSpeed` BIGINT(20) NOT NULL,
  `StatisticExperience` BIGINT(20) NOT NULL,
  PRIMARY KEY (`StatisticID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic`
--

LOCK TABLES `statistic` WRITE;
/*!40000 ALTER TABLE `statistic` DISABLE KEYS */;
INSERT INTO `statistic` (`StatisticID`, `StatisticStrength`, `StatisticDefense`, `StatisticHealth`, `StatisticEnergy`, `StatisticIntelligence`, `StatisticResistance`, `StatisticExperience`, `StatisticSpeed`) VALUES (1,0,0,100,100,0,0,0,1),(2,0,0,100,100,0,0,0,1),(3,20,20,20,0,20,20,0,1),(4,5,0,0,0,0,0,0,1),(5,0,0,50,0,0,0,0,1);
/*!40000 ALTER TABLE `statistic` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `subcategory` (`SubcategoryID`, `CategoryID`, `SubcategoryName`) VALUES (1,1,'Step'),(3,1,'Death'),(5,1,'Seconds Played'),(6,2,'Room'),(7,2,'Map'),(8,3,'Heal'),(9,3,'Power Thrust'),(10,3,'Fire Arrow'),(11,3,'Fire Wave'),(12,4,'Skeleton'),(13,5,'Taken'),(14,5,'Dealt');
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
INSERT INTO `user` (`UserID`, `UserName`, `UserFacebookID`) VALUES (1,'Logan Murphy',1276877482);
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
  `BehaviorSubcategoryID` bigint(20) NOT NULL,
  `UserBehaviorCount` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserBehaviorID`),
  KEY `fk_UserBehavior_BehaviorSubcategory1_idx` (`BehaviorSubcategoryID`),
  KEY `fk_UserBehavior_User1_idx` (`UserID`),
  CONSTRAINT `fk_UserBehavior_BehaviorSubcategory1` FOREIGN KEY (`BehaviorSubcategoryID`) REFERENCES `subcategory` (`SubcategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserBehavior_User1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userbehavior`
--

LOCK TABLES `userbehavior` WRITE;
/*!40000 ALTER TABLE `userbehavior` DISABLE KEYS */;
/*!40000 ALTER TABLE `userbehavior` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-30  1:30:36
