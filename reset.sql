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
  `UserID` BIGINT NOT NULL AUTO_INCREMENT ,
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
  PRIMARY KEY (`ImageID`) ,
  UNIQUE INDEX `ImageName_UNIQUE` (`ImageName` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Statistic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Statistic` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Statistic` (
  `StatisticID` BIGINT NOT NULL AUTO_INCREMENT ,
  `StatisticStrength` BIGINT NOT NULL ,
  `StatisticDefense` BIGINT NOT NULL ,
  `StatisticHealth` BIGINT NOT NULL ,
  `StatisticEnergy` BIGINT NOT NULL ,
  `StatisticIntelligence` BIGINT NOT NULL ,
  `StatisticResistance` BIGINT NOT NULL ,
  PRIMARY KEY (`StatisticID`) )
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
-- Table `WorldTactics`.`Enemy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Enemy` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Enemy` (
  `EnemyID` BIGINT NOT NULL AUTO_INCREMENT ,
  `EnemyPortrait` BIGINT NOT NULL ,
  `EnemyName` VARCHAR(32) NOT NULL ,
  `StatisticID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyID`) ,
  INDEX `fk_Enemy_Image1_idx` (`EnemyPortrait` ASC) ,
  INDEX `fk_Enemy_Statistic1_idx` (`StatisticID` ASC) ,
  INDEX `fk_Enemy_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_Enemy_Image1`
    FOREIGN KEY (`EnemyPortrait` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_Statistic1`
    FOREIGN KEY (`StatisticID` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Enemy_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
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
  `CharacterCurrentStatisticID` BIGINT NOT NULL ,
  `CharacterMaxStatisticID` BIGINT NOT NULL ,
  `UserID` BIGINT NOT NULL ,
  `RoomID` BIGINT NULL ,
  `CharacterColumn` BIGINT NULL ,
  `CharacterRow` BIGINT NULL ,
  `CharacterDirection` BIGINT NULL ,
  `CharacterIsMale` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`CharacterID`) ,
  INDEX `fk_Character_Image1_idx` (`CharacterPortrait` ASC) ,
  INDEX `fk_Character_Statistic1_idx` (`CharacterCurrentStatisticID` ASC) ,
  INDEX `fk_Character_Statistic2_idx` (`CharacterMaxStatisticID` ASC) ,
  INDEX `fk_Character_User1_idx` (`UserID` ASC) ,
  INDEX `fk_Character_Room1_idx` (`RoomID` ASC) ,
  CONSTRAINT `fk_Character_Image1`
    FOREIGN KEY (`CharacterPortrait` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic1`
    FOREIGN KEY (`CharacterCurrentStatisticID` )
    REFERENCES `WorldTactics`.`Statistic` (`StatisticID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Character_Statistic2`
    FOREIGN KEY (`CharacterMaxStatisticID` )
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
  `SkillID` BIGINT NOT NULL AUTO_INCREMENT ,
  `SkillName` VARCHAR(64) NOT NULL ,
  `SkillDescription` VARCHAR(64) NOT NULL ,
  `SkillIcon` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NULL ,
  `SkillIsActive` TINYINT(1) NOT NULL ,
  `SkillCooldown` BIGINT NOT NULL ,
  `SkillEnergy` BIGINT NOT NULL ,
  `SkillArea` BIGINT NOT NULL ,
  PRIMARY KEY (`SkillID`) ,
  INDEX `fk_Skill_AttackType1_idx` (`AttackTypeID` ASC) ,
  UNIQUE INDEX `SkillName_UNIQUE` (`SkillName` ASC) ,
  CONSTRAINT `fk_Skill_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Category` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Category` (
  `CategoryID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CategoryName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`CategoryID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`Subcategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Subcategory` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Subcategory` (
  `SubcategoryID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CategoryID` BIGINT NOT NULL ,
  `SubcategoryName` VARCHAR(32) NULL ,
  PRIMARY KEY (`SubcategoryID`) ,
  INDEX `fk_BehaviorSubcategory_BehaviorCategory1_idx` (`CategoryID` ASC) ,
  CONSTRAINT `fk_BehaviorSubcategory_BehaviorCategory1`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `WorldTactics`.`Category` (`CategoryID` )
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
  `CategoryID` BIGINT NULL ,
  `BadgeCount` BIGINT NOT NULL ,
  `BadgeIcon` BIGINT NOT NULL ,
  `SubcategoryID` BIGINT NULL ,
  PRIMARY KEY (`BadgeId`) ,
  INDEX `fk_Badge_BehaviorCategory1_idx` (`CategoryID` ASC) ,
  INDEX `fk_Badge_Image1_idx` (`BadgeIcon` ASC) ,
  INDEX `fk_Badge_Subcategory1_idx` (`SubcategoryID` ASC) ,
  CONSTRAINT `fk_Badge_BehaviorCategory1`
    FOREIGN KEY (`CategoryID` )
    REFERENCES `WorldTactics`.`Category` (`CategoryID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Image1`
    FOREIGN KEY (`BadgeIcon` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Badge_Subcategory1`
    FOREIGN KEY (`SubcategoryID` )
    REFERENCES `WorldTactics`.`Subcategory` (`SubcategoryID` )
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
  `ItemTypeDrawingOrder` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemTypeID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemModel` (
  `ItemModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemModelName` VARCHAR(32) NOT NULL ,
  `ItemModelArea` BIGINT NOT NULL ,
  `StatisticID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NULL ,
  `ItemModelWeight` BIGINT NOT NULL ,
  `ItemTypeID` BIGINT NOT NULL ,
  `ItemModelPortrait` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemModelID`) ,
  INDEX `fk_ItemModel_ItemType1_idx` (`ItemTypeID` ASC) ,
  INDEX `fk_ItemModel_AttackType1_idx` (`AttackTypeID` ASC) ,
  INDEX `fk_ItemModel_Statistic1_idx` (`StatisticID` ASC) ,
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
    FOREIGN KEY (`StatisticID` )
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
  `EnemyInRoomDirection` BIGINT NOT NULL ,
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
  `BehaviorSubcategoryID` BIGINT NOT NULL ,
  `UserBehaviorCount` BIGINT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`UserBehaviorID`) ,
  INDEX `fk_UserBehavior_BehaviorSubcategory1_idx` (`BehaviorSubcategoryID` ASC) ,
  INDEX `fk_UserBehavior_User1_idx` (`UserID` ASC) ,
  CONSTRAINT `fk_UserBehavior_BehaviorSubcategory1`
    FOREIGN KEY (`BehaviorSubcategoryID` )
    REFERENCES `WorldTactics`.`Subcategory` (`SubcategoryID` )
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
  `SkillStatisticID` BIGINT NOT NULL AUTO_INCREMENT ,
  `StatisticID` BIGINT NOT NULL ,
  `SkillID` BIGINT NOT NULL ,
  `SkillStatisticIsAdd` TINYINT(1) NOT NULL ,
  `SkillStatisticDuration` BIGINT NOT NULL ,
  PRIMARY KEY (`SkillStatisticID`) ,
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
-- Table `WorldTactics`.`Audio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`Audio` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`Audio` (
  `AudioID` BIGINT NOT NULL AUTO_INCREMENT ,
  `AudioName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`AudioID`) ,
  UNIQUE INDEX `AudioName_UNIQUE` (`AudioName` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterAudio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterAudio` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterAudio` (
  `CharacterAudioID` BIGINT NOT NULL AUTO_INCREMENT ,
  `AudioID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `CharacterAudioIsMale` TINYINT(1) NULL ,
  PRIMARY KEY (`CharacterAudioID`) ,
  INDEX `fk_CharacterSound_Sound1_idx` (`AudioID` ASC) ,
  INDEX `fk_CharacterSound_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_CharacterSound_Sound1`
    FOREIGN KEY (`AudioID` )
    REFERENCES `WorldTactics`.`Audio` (`AudioID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterSound_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemModelAudio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemModelAudio` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemModelAudio` (
  `ItemModelAudioID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemModelID` BIGINT NOT NULL ,
  `AudioID` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemModelAudioID`) ,
  INDEX `fk_ItemSound_ItemModel1_idx` (`ItemModelID` ASC) ,
  INDEX `fk_ItemSound_Sound1_idx` (`AudioID` ASC) ,
  CONSTRAINT `fk_ItemSound_ItemModel1`
    FOREIGN KEY (`ItemModelID` )
    REFERENCES `WorldTactics`.`ItemModel` (`ItemModelID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemSound_Sound1`
    FOREIGN KEY (`AudioID` )
    REFERENCES `WorldTactics`.`Audio` (`AudioID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterImageChoiceGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterImageChoiceGroup` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterImageChoiceGroup` (
  `CharacterImageChoiceGroupID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ItemTypeID` BIGINT NOT NULL ,
  `CharacterImageChoiceGroupIsMale` TINYINT(1) NOT NULL ,
  `CharacterImageChoiceGroupName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`CharacterImageChoiceGroupID`) ,
  INDEX `fk_CharacterImageChoiceGroup_ItemType1_idx` (`ItemTypeID` ASC) ,
  UNIQUE INDEX `CharacterImageChoiceGroupName_UNIQUE` (`CharacterImageChoiceGroupName` ASC) ,
  CONSTRAINT `fk_CharacterImageChoiceGroup_ItemType1`
    FOREIGN KEY (`ItemTypeID` )
    REFERENCES `WorldTactics`.`ItemType` (`ItemTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`CharacterImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`CharacterImage` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`CharacterImage` (
  `CharacterImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CharacterID` BIGINT NOT NULL ,
  `CharacterImageChoiceGroupID` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterImageID`) ,
  INDEX `fk_CharacterImage_Character1_idx` (`CharacterID` ASC) ,
  INDEX `fk_CharacterImage_CharacterImageChoiceGroup1_idx` (`CharacterImageChoiceGroupID` ASC) ,
  CONSTRAINT `fk_CharacterImage_Character1`
    FOREIGN KEY (`CharacterID` )
    REFERENCES `WorldTactics`.`Character` (`CharacterID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CharacterImage_CharacterImageChoiceGroup1`
    FOREIGN KEY (`CharacterImageChoiceGroupID` )
    REFERENCES `WorldTactics`.`CharacterImageChoiceGroup` (`CharacterImageChoiceGroupID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`ItemModelImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`ItemModelImage` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`ItemModelImage` (
  `ItemModelImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `ImageID` BIGINT NOT NULL ,
  `ItemModelID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `ItemModelImageColumns` BIGINT NOT NULL ,
  `ItemModelImageRows` BIGINT NOT NULL ,
  PRIMARY KEY (`ItemModelImageID`) ,
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
  `CharacterSkillID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CharacterID` BIGINT NOT NULL ,
  `SkillID` BIGINT NOT NULL ,
  `CharacterSkillIndex` BIGINT NULL ,
  `CharacterSkillExpireTime` TIMESTAMP NULL ,
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
  `CharacterImageChoiceID` BIGINT NOT NULL AUTO_INCREMENT ,
  `CharacterImageChoiceRows` BIGINT NOT NULL ,
  `CharacterImageChoiceColumns` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  `ImageID` BIGINT NOT NULL ,
  `CharacterImageChoiceGroupID` BIGINT NOT NULL ,
  PRIMARY KEY (`CharacterImageChoiceID`) ,
  INDEX `fk_CharacterImageChoice_Image1_idx` (`ImageID` ASC) ,
  INDEX `fk_CharacterImageChoice_AttackType1_idx` (`AttackTypeID` ASC) ,
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


-- -----------------------------------------------------
-- Table `WorldTactics`.`EnemyImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`EnemyImage` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`EnemyImage` (
  `EnemyImageID` BIGINT NOT NULL AUTO_INCREMENT ,
  `EnemyID` BIGINT NOT NULL ,
  `ImageID` BIGINT NOT NULL ,
  `ItemTypeID` BIGINT NOT NULL ,
  `EnemyImageRows` BIGINT NOT NULL ,
  `EnemyImageColumns` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyImageID`) ,
  INDEX `fk_EnemyImage_Image1_idx` (`ImageID` ASC) ,
  INDEX `fk_EnemyImage_ItemType1_idx` (`ItemTypeID` ASC) ,
  INDEX `fk_EnemyImage_Enemy1_idx` (`EnemyID` ASC) ,
  INDEX `fk_EnemyImage_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_EnemyImage_Image1`
    FOREIGN KEY (`ImageID` )
    REFERENCES `WorldTactics`.`Image` (`ImageID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_ItemType1`
    FOREIGN KEY (`ItemTypeID` )
    REFERENCES `WorldTactics`.`ItemType` (`ItemTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_Enemy1`
    FOREIGN KEY (`EnemyID` )
    REFERENCES `WorldTactics`.`Enemy` (`EnemyID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemyImage_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`EnemyAudio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`EnemyAudio` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`EnemyAudio` (
  `EnemyAudioID` BIGINT NOT NULL AUTO_INCREMENT ,
  `AudioID` BIGINT NOT NULL ,
  `EnemyID` BIGINT NOT NULL ,
  `AttackTypeID` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyAudioID`) ,
  INDEX `fk_EnemySound_Enemy1_idx` (`EnemyID` ASC) ,
  INDEX `fk_EnemySound_Sound1_idx` (`AudioID` ASC) ,
  INDEX `fk_EnemySound_AttackType1_idx` (`AttackTypeID` ASC) ,
  CONSTRAINT `fk_EnemySound_Enemy1`
    FOREIGN KEY (`EnemyID` )
    REFERENCES `WorldTactics`.`Enemy` (`EnemyID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_Sound1`
    FOREIGN KEY (`AudioID` )
    REFERENCES `WorldTactics`.`Audio` (`AudioID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EnemySound_AttackType1`
    FOREIGN KEY (`AttackTypeID` )
    REFERENCES `WorldTactics`.`AttackType` (`AttackTypeID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`MapModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`MapModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`MapModel` (
  `MapModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `MapModelName` VARCHAR(32) NOT NULL ,
  `ImageID` BIGINT NOT NULL ,
  `MapModelRows` BIGINT NOT NULL ,
  `MapModelColumns` BIGINT NOT NULL ,
  PRIMARY KEY (`MapModelID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`RoomModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`RoomModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`RoomModel` (
  `RoomModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `RoomModelName` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`RoomModelID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`EnemyInRoomModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`EnemyInRoomModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`EnemyInRoomModel` (
  `EnemyInRoomModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `EnemyID` BIGINT NOT NULL ,
  `RoomModelID` BIGINT NOT NULL ,
  `EnemyInRoomModelDirection` BIGINT NOT NULL ,
  `EnemyInRoomModelRow` BIGINT NOT NULL ,
  `EnemyInRoomModelColumn` BIGINT NOT NULL ,
  PRIMARY KEY (`EnemyInRoomModelID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WorldTactics`.`RoomModelInMapModel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `WorldTactics`.`RoomModelInMapModel` ;

CREATE  TABLE IF NOT EXISTS `WorldTactics`.`RoomModelInMapModel` (
  `RoomModelInMapModelID` BIGINT NOT NULL AUTO_INCREMENT ,
  `RoomModelID` BIGINT NOT NULL ,
  `MapModelID` BIGINT NOT NULL ,
  `RoomModelInMapModelCount` BIGINT NOT NULL ,
  PRIMARY KEY (`RoomModelInMapModelID`) )
ENGINE = InnoDB;

USE `WorldTactics` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
