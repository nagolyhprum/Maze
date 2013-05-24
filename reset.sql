SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `WorldTactics` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `WorldTactics` ;

-- -----------------------------------------------------
-- Table `WorldTactics`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`User` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`User` (
  `UserID` BIGINT NOT NULL ,
  `UserName` VARCHAR(64) NOT NULL ,
  `UserFacebookID` BIGINT NOT NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Image` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Image` (
  `ImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ImageName` VARCHAR(64) NOT NULL ,
  PRIMARY KEY (`ImageID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Statistic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Statistic` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Statistic` (
  `StatisticID` BIGINT NOT NULL AUTO_INCREMENT ,
  `StatisticsStrength` BIGINT NOT NULL ,
  `StatisticDefense` BIGINT NOT NULL ,
  `StatisticHealth` BIGINT NOT NULL ,
  `StatisticEnergy` BIGINT NOT NULL ,
  `StatisticIntelligence` BIGINT NOT NULL ,
  `StatisticResistance` BIGINT NOT NULL ,
  PRIMARY KEY (`StatisticID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Enemy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Enemy` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Enemy` (
  `EnemyID` BIGINT NOT NULL AUTO_INCREMENT ,
  `EnemyPortrait` BIGINT NOT NULL ,
  `EnemyName` VARCHAR(32) NOT NULL ,
  `EnemieStatistics` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyID`) ,
  INDEX `fk_Enemy_Image1_idx` (`EnemyPortrait` ASC) ,
  INDEX `fk_Enemy_Statistic1_idx` (`EnemieStatistics` ASC) ,
  CONSTRAINT `fk_Enemy_Image1`
    FOREIGN KEY (`EnemyPortrait` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_Statistic1`
    FOREIGN KEY (`EnemieStatistics` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Map` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Map` (
  `MapID` BIGINT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`MapID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Room`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Room` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Room` (
  `RoomID` BIGINT NOT NULL AUTO_INCREMENT ,
  `MapID` BIGINT NOT NULL ,
  `RoomColumn` BIGINT NOT NULL ,
  `RoomRow` BIGINT NOT NULL ,
  `RoomIsDiscovered` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`RoomID`) ,
  INDEX `fk_Room_Map1_idx` (`MapID` ASC) ,
  CONSTRAINT `fk_Room_Map1`
    FOREIGN KEY (`MapID` )
    REFERENCES `WorldTactics`.`Map` (`MapID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Character`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Character` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Character` (
  `CharacterID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CharacterName` VARCHAR(64) NOT NULL ,
  `CharacterPortrait` BIGINT NOT NULL ,
  `CharacterCurrentStatistics` BIGINT NOT NULL ,
  `CharacterMaxStatisitcs` BIGINT NOT NULL ,
  `UserID` BIGINT NOT NULL ,
  `RoomID` BIGINT NULL ,
  `CharacterColumn` BIGINT NULL ,
  `CharacterRow` BIGINT NULL ,
  PRIMARY KEY (`CharacterID`) ,
  INDEX `fk_Character_Image1_idx` (`CharacterPortrait` ASC) ,
  INDEX `fk_Character_Statistic1_idx` (`CharacterCurrentStatistics` ASC) ,
  INDEX `fk_Character_Statistic2_idx` (`CharacterMaxStatisitcs` ASC) ,
  INDEX `fk_Character_User1_idx` (`UserID` ASC) ,
  INDEX `fk_Character_Room1_idx` (`RoomID` ASC) ,
  CONSTRAINT `fk_Character_Image1`
    FOREIGN KEY (`CharacterPortrait` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic1`
    FOREIGN KEY (`CharacterCurrentStatistics` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic2`
    FOREIGN KEY (`CharacterMaxStatisitcs` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_User1`
    FOREIGN KEY (`UserID` )
    REFERENCES `WorldTactics`.`User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Room1`
    FOREIGN KEY (`RoomID` )
    REFERENCES `WorldTactics`.`Room` (`RoomID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Skill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Skill` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Skill` (
  `SkillID` BIGINT NOT NULL ,
  `SkillName` VARCHAR(64) NOT NULL ,
  `SkillDescription` VARCHAR(64) NOT NULL ,
  `SkillIcon` BIGINT NOT NULL ,
  `SkillAction` BIGINT NOT NULL ,
  `SkillIsActive` TINYINT(1) NOT NULL ,
  `SkillCooldown` BIGINT NOT NULL ,
  `SkillEnergy` BIGINT NOT NULL ,
  PRIMARY KEY (`SkillID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`BehaviorCategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`BehaviorCategory` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`BehaviorCategory` (
  `BehaviorCategoryID` BIGINT NOT NULL AUTO_INCREMENT ,
  `BehaviorCategoryName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`BehaviorCategoryID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`BehaviorSubcategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`BehaviorSubcategory` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`BehaviorSubcategory` (
  `BehaviorSubcategoryID` BIGINT NOT NULL AUTO_INCREMENT ,
  `BehaviorCategoryID` BIGINT NOT NULL ,
  `BehaviorSubcategoryName` VARCHAR(32) NULL ,
  PRIMARY KEY (`BehaviorSubcategoryID`) ,
  INDEX `fk_BehaviorSubcategory_BehaviorCategory1_idx` (`BehaviorCategoryID` ASC) ,
  CONSTRAINT `fk_BehaviorSubcategory_BehaviorCategory1`
    FOREIGN KEY (`BehaviorCategoryID` )
    REFERENCES `WorldTactics`.`BehaviorCategory` (`BehaviorCategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Badge`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Badge` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Badge` (
  `BadgeId` BIGINT NOT NULL AUTO_INCREMENT ,
  `BadgeName` VARCHAR(32) NOT NULL ,
  `BadgeCategory` BIGINT NOT NULL ,
  `BadgeSubcategory` BIGINT NULL ,
  `BadgeCount` BIGINT NOT NULL ,
  `BadgeIcon` BIGINT NOT NULL ,
  PRIMARY KEY (`BadgeId`) ,
  INDEX `fk_Badge_BehaviorSubcategory1_idx` (`BadgeSubcategory` ASC) ,
  INDEX `fk_Badge_BehaviorCategory1_idx` (`BadgeCategory` ASC) ,
  INDEX `fk_Badge_Image1_idx` (`BadgeIcon` ASC) ,
  CONSTRAINT `fk_Badge_BehaviorSubcategory1`
    FOREIGN KEY (`BadgeSubcategory` )
    REFERENCES `WorldTactics`.`BehaviorSubcategory` (`BehaviorCategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_BehaviorCategory1`
    FOREIGN KEY (`BadgeCategory` )
    REFERENCES `WorldTactics`.`BehaviorCategory` (`BehaviorCategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Image1`
    FOREIGN KEY (`BadgeIcon` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemType` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemType` (
  `ItemTypeID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemTypeName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`ItemTypeID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`AttackType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`AttackType` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`AttackType` (
  `AttackTypeID` BIGINT NOT NULL AUTO_INCREMENT ,
  `AttackTypeName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`AttackTypeID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemModel` (
  `ItemModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemModelName` VARCHAR(32) NOT NULL ,
  `ItemModelArea` BIGINT NOT NULL ,
  `ItemModelStatistics` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `ItemModelWeight` BIGINT NOT NULL ,
  `ItemTypeID` BIGINT NOT NULL ,
  `ItemModelPortrait` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemModelID`) ,
  INDEX `fk_ItemModel_ItemType1_idx` (`ItemTypeID` ASC) ,
  INDEX `fk_ItemModel_AttackType1_idx` (`AttackTypeID` ASC) ,
  INDEX `fk_ItemModel_Statistic1_idx` (`ItemModelStatistics` ASC) ,
  INDEX `fk_ItemModel_Image1_idx` (`ItemModelPortrait` ASC) ,
  CONSTRAINT `fk_ItemModel_ItemType1`
    FOREIGN KEY (`ItemTypeID` )
    REFERENCES `WorldTactics`.`ItemType` (`ItemTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Statistic1`
    FOREIGN KEY (`ItemModelStatistics` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModel_Image1`
    FOREIGN KEY (`ItemModelPortrait` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Item` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Item` (
  `ItemID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemModelID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemID`) ,
  INDEX `fk_Item_ItemModel1_idx` (`ItemModelID` ASC) ,
  CONSTRAINT `fk_Item_ItemModel1`
    FOREIGN KEY (`ItemModelID` )
    REFERENCES `WorldTactics`.`ItemModel` (`ItemModelID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemInEquipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemInEquipment` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemInEquipment` (
  `ItemInEquipmentID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CharacterID` BIGINT NOT NULL ,
  `ItemID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemInEquipmentID`) ,
  INDEX `fk_ItemInEquipment_Item1_idx` (`ItemID` ASC) ,
  INDEX `fk_ItemInEquipment_Character1_idx` (`CharacterID` ASC) ,
  CONSTRAINT `fk_ItemInEquipment_Item1`
    FOREIGN KEY (`ItemID` )
    REFERENCES `WorldTactics`.`Item` (`ItemID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInEquipment_Character1`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemInInventory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemInInventory` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemInInventory` (
  `ItemInInventoryID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemInInventoryColumn` BIGINT NOT NULL ,
  `ItemInInventoryRow` BIGINT NOT NULL ,
  `ItemID` BIGINT NOT NULL ,
  `CharacterID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemInInventoryID`) ,
  INDEX `fk_ItemInInventory_Item1_idx` (`ItemID` ASC) ,
  INDEX `fk_ItemInInventory_Character1_idx` (`CharacterID` ASC) ,
  CONSTRAINT `fk_ItemInInventory_Item1`
    FOREIGN KEY (`ItemID` )
    REFERENCES `WorldTactics`.`Item` (`ItemID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInInventory_Character1`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`EnemyInRoom`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`EnemyInRoom` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`EnemyInRoom` (
  `EnemyInRoomID` BIGINT NOT NULL AUTO_INCREMENT ,
  `EnemyInRoomStatistics` BIGINT NOT NULL ,
  `EnemyID` BIGINT NOT NULL ,
  `RoomID` BIGINT NOT NULL ,
  `EnemyInRoomColumn` BIGINT NOT NULL ,
  `EnemyInRoomRow` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyInRoomID`) ,
  INDEX `fk_EnemyInRoom_Room1_idx` (`RoomID` ASC) ,
  INDEX `fk_EnemyInRoom_Enemy1_idx` (`EnemyID` ASC) ,
  INDEX `fk_EnemyInRoom_Statistic1_idx` (`EnemyInRoomStatistics` ASC) ,
  CONSTRAINT `fk_EnemyInRoom_Room1`
    FOREIGN KEY (`RoomID` )
    REFERENCES `WorldTactics`.`Room` (`RoomID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Enemy1`
    FOREIGN KEY (`EnemyID` )
    REFERENCES `WorldTactics`.`Enemy` (`EnemyID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyInRoom_Statistic1`
    FOREIGN KEY (`EnemyInRoomStatistics` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemInRoom`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemInRoom` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemInRoom` (
  `ItemInRoomID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemInRoomColumn` BIGINT NOT NULL ,
  `ItemInRoomRow` BIGINT NOT NULL ,
  `RoomID` BIGINT NOT NULL ,
  `ItemID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemInRoomID`) ,
  INDEX `fk_ItemInRoom_Room1_idx` (`RoomID` ASC) ,
  INDEX `fk_ItemInRoom_Item1_idx` (`ItemID` ASC) ,
  CONSTRAINT `fk_ItemInRoom_Room1`
    FOREIGN KEY (`RoomID` )
    REFERENCES `WorldTactics`.`Room` (`RoomID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInRoom_Item1`
    FOREIGN KEY (`ItemID` )
    REFERENCES `WorldTactics`.`Item` (`ItemID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemInRoom_Room2`
    FOREIGN KEY (`RoomID` )
    REFERENCES `WorldTactics`.`Room` (`RoomID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`UserBehavior`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`UserBehavior` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`UserBehavior` (
  `UserBehaviorID` BIGINT NOT NULL AUTO_INCREMENT ,
  `UserID` BIGINT NOT NULL ,
  `BehaviorCategoryID` BIGINT NOT NULL ,
  `BehaviorSubcategoryID` BIGINT NOT NULL ,
  `UserBehaviorCount` BIGINT NOT NULL ,
  PRIMARY KEY (`UserBehaviorID`) ,
  INDEX `fk_UserBehavior_BehaviorCategory1_idx` (`BehaviorCategoryID` ASC) ,
  INDEX `fk_UserBehavior_BehaviorSubcategory1_idx` (`BehaviorSubcategoryID` ASC) ,
  INDEX `fk_UserBehavior_User1_idx` (`UserID` ASC) ,
  CONSTRAINT `fk_UserBehavior_BehaviorCategory1`
    FOREIGN KEY (`BehaviorCategoryID` )
    REFERENCES `WorldTactics`.`BehaviorCategory` (`BehaviorCategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserBehavior_BehaviorSubcategory1`
    FOREIGN KEY (`BehaviorSubcategoryID` )
    REFERENCES `WorldTactics`.`BehaviorSubcategory` (`BehaviorSubcategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserBehavior_User1`
    FOREIGN KEY (`UserID` )
    REFERENCES `WorldTactics`.`User` (`UserID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`SkillStatistic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`SkillStatistic` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`SkillStatistic` (
  `SkillStatisticsID` BIGINT NOT NULL AUTO_INCREMENT ,
  `StatisticID` BIGINT NOT NULL ,
  `SkillID` BIGINT NOT NULL ,
  `SkillStatisticIsAdd` TINYINT(1) NOT NULL ,
  `SkillStatisticDuration` BIGINT NOT NULL ,
  PRIMARY KEY (`SkillStatisticsID`) ,
  INDEX `fk_SkillStatistics_Statistic1_idx` (`StatisticID` ASC) ,
  INDEX `fk_SkillStatistics_Skill1_idx` (`SkillID` ASC) ,
  CONSTRAINT `fk_SkillStatistics_Statistic1`
    FOREIGN KEY (`StatisticID` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SkillStatistics_Skill1`
    FOREIGN KEY (`SkillID` )
    REFERENCES `WorldTactics`.`Skill` (`SkillID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterSkill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterSkill` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterSkill` (
  `CharacterSkillID` BIGINT NOT NULL ,
  `CharacterID` BIGINT NOT NULL ,
  `SkillID` BIGINT NULL ,
  `CharacterSkillIndex` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterSkillID`) ,
  INDEX `fk_CharacterSkill_Skill2_idx` (`SkillID` ASC) ,
  INDEX `fk_CharacterSkill_Character2_idx` (`CharacterID` ASC) ,
  CONSTRAINT `fk_CharacterSkill_Skill2`
    FOREIGN KEY (`SkillID` )
    REFERENCES `WorldTactics`.`Skill` (`SkillID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSkill_Character2`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Sound`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Sound` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Sound` (
  `SoundID` BIGINT NOT NULL AUTO_INCREMENT ,
  `SoundName` VARCHAR(464) NOT NULL ,
  PRIMARY KEY (`SoundID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterSound`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterSound` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterSound` (
  `CharacterSoundID` BIGINT NOT NULL AUTO_INCREMENT ,
  `SoundID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `SoundIsMale` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`CharacterSoundID`) ,
  INDEX `fk_CharacterSound_Sound1_idx` (`SoundID` ASC) ,
  INDEX `fk_CharacterSound_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_CharacterSound_Sound1`
    FOREIGN KEY (`SoundID` )
    REFERENCES `WorldTactics`.`Sound` (`SoundID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSound_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemSound`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemSound` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemSound` (
  `ItemSoundID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemID` BIGINT NOT NULL ,
  `SoundID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemSoundID`) ,
  INDEX `fk_ItemSound_ItemModel1_idx` (`ItemID` ASC) ,
  INDEX `fk_ItemSound_Sound1_idx` (`SoundID` ASC) ,
  CONSTRAINT `fk_ItemSound_ItemModel1`
    FOREIGN KEY (`ItemID` )
    REFERENCES `WorldTactics`.`ItemModel` (`ItemModelID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemSound_Sound1`
    FOREIGN KEY (`SoundID` )
    REFERENCES `WorldTactics`.`Sound` (`SoundID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterImage` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterImage` (
  `CharacterImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ImageID` BIGINT NOT NULL ,
  `CharacterID` BIGINT NOT NULL ,
  `CharacterImageRows` BIGINT NOT NULL ,
  `CharacterImagecColumns` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterImageID`) ,
  INDEX `fk_CharacterImage_Character1_idx` (`CharacterID` ASC) ,
  INDEX `fk_CharacterImage_Image1_idx` (`ImageID` ASC) ,
  INDEX `fk_CharacterImage_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_CharacterImage_Character1`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImage_Image1`
    FOREIGN KEY (`ImageID` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImage_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemModelImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemModelImage` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemModelImage` (
  `ItemImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ImageID` BIGINT NOT NULL ,
  `ItemModelID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `ItemImageColumns` BIGINT NOT NULL ,
  `ItemImageRows` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemImageID`) ,
  INDEX `fk_ItemModelImage_Image1_idx` (`ImageID` ASC) ,
  INDEX `fk_ItemModelImage_AttackType1_idx` (`AttackTypeID` ASC) ,
  INDEX `fk_ItemModelImage_ItemModel1_idx` (`ItemModelID` ASC) ,
  CONSTRAINT `fk_ItemModelImage_Image1`
    FOREIGN KEY (`ImageID` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemModelImage_ItemModel1`
    FOREIGN KEY (`ItemModelID` )
    REFERENCES `WorldTactics`.`ItemModel` (`ItemModelID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterSkill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterSkill` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterSkill` (
  `CharacterSkillID` BIGINT NOT NULL ,
  `CharacterID` BIGINT NOT NULL ,
  `SkillID` BIGINT NULL ,
  `CharacterSkillIndex` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterSkillID`) ,
  INDEX `fk_CharacterSkill_Skill2_idx` (`SkillID` ASC) ,
  INDEX `fk_CharacterSkill_Character2_idx` (`CharacterID` ASC) ,
  CONSTRAINT `fk_CharacterSkill_Skill2`
    FOREIGN KEY (`SkillID` )
    REFERENCES `WorldTactics`.`Skill` (`SkillID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSkill_Character2`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterImageChoice`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterImageChoice` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterImageChoice` (
  `CharacterImageChoiceID` BIGINT NOT NULL ,
  `CharacterImageChoiceRows` BIGINT NOT NULL ,
  `CharacterImageChoiceColumns` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `ImageID` BIGINT NOT NULL ,
  `CharacterID` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterImageChoiceID`) ,
  INDEX `fk_CharacterImageChoice_Character1_idx` (`CharacterID` ASC) ,
  INDEX `fk_CharacterImageChoice_Image1_idx` (`ImageID` ASC) ,
  INDEX `fk_CharacterImageChoice_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_CharacterImageChoice_Character1`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImageChoice_Image1`
    FOREIGN KEY (`ImageID` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImageChoice_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `WorldTactics` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
