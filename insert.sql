set RoomSize = 7;

-- complete
-- 		attacktype
-- 		badge
-- 		behaviorcategory
-- 		behaviorsubcategory
-- 		character
-- 		characterimage
-- 		characterimagechoice
-- 		characterimagechoicegroup
-- 		characterskill
-- 		charactersound
-- 		enemy
-- 		enemyimage
-- 		enemysound
-- 		REQUIRED : image
-- 		REQUIRED : itemmodel
-- 		REQUIRED : itemmodelimage
-- 		REQUIRED : itemmodelsound
-- 		itemtype
-- 		skill
-- 		REQUIRED : skillstatistic
-- 		REQUIRED : sound
-- 		REQUIRED : statistic
-- 		user
-- 		userbehavior

-- not required
-- 	enemyinroom
-- 	item
-- 	iteminequipment
-- 	itemininventory
-- 	iteminroom
-- 	map
-- 	room

-- insert the attack types
INSERT INTO AttackType 
	(AttackTypeName) VALUES
	("walk"), -- 1
	("thrust"), -- 2
	("slash"), -- 3
	("spellcast"), -- 4
	("bow"), -- 5
	("hurt"); -- 6

-- character sounds
INSERT INTO Sound
	(SoundName) VALUES
	-- hurt
	("sound/grunts/grunt1"), -- 1
	("sound/grunts/grunt2"), -- 2
	("sound/grunts/grunt3"), -- 3
	("sound/grunts/grunt4"), -- 4
	("sound/grunts/grunt5"), -- 5
	("sound/grunts/grunt6"), -- 6
	("sound/grunts/grunt7"), -- 7
	("sound/grunts/grunt8"), -- 8
	("sound/grunts/grunt9"), -- 9
	("sound/grunts/grunt10"), -- 10
	("sound/grunts/grunt11"), -- 11
	-- attack
	("slash/battle/swing1"), -- 12
	("slash/battle/swing2"), -- 13
	("slash/battle/swing3"); -- 14

INSERT INTO CharacterSound
	(SoundID, AttackTypeID, CharacterSoundIsMale) VALUES
	-- hurt
	(1, 6, TRUE),
	(2, 6, TRUE),
	(3, 6, TRUE),
	(4, 6, TRUE),
	(5, 6, TRUE),
	(6, 6, TRUE),
	(7, 6, TRUE),
	(8, 6, TRUE),
	(9, 6, TRUE),
	(10, 6, TRUE),
	(11, 6, TRUE),
	-- slash	
	(12, 3, TRUE),
	(13, 3, TRUE),
	(14, 3, TRUE),
	-- thrust
	(12, 2, TRUE),
	(13, 2, TRUE),
	(14, 2, TRUE),
	-- spellcast
	(12, 4, TRUE),
	(13, 4, TRUE),
	(14, 4, TRUE),
	-- bow
	(12, 5, TRUE),
	(13, 5, TRUE),
	(14, 5, TRUE);

-- insert the item types
INSERT INTO ItemType
	(ItemTypeName) VALUES
	("head"), -- 1
	("mainhand"), -- 2
	("torso"), -- 3
	("hands"), -- 4
	("legs"), -- 5
	("feet"), -- 6
	("body"); -- 7

-- insert the behavior categories
INSERT INTO BehaviorCategory 
	(BehaviorCategoryName) VALUES
	("Kill"), -- 1
	("Character"),  -- 2
	("Skill"),  -- 3
	("Damage"), -- 4 
	("Discover"); -- 5

-- insert the behavior subcategories
INSERT INTO BehaviorSubcategory 
	(BehaviorCategoryID, BehaviorSubcategoryName) VALUES
	(1, "Skeleton"), -- 1
	(2, "Deaths"), -- 2
	(2, "Steps"), -- 3
	(2, "Attacks"), -- 4
	(2, "Seconds Played"), -- 5
	(3, "Power Thrust"), -- 6
	(3, "Fire Wave"), -- 7
	(3, "Fire Arrow"), -- 8
	(3, "Heal"), -- 9
	(4, "Deal"), -- 10
	(4, "Receive"), -- 11
	(5, "Rooms"), -- 12
	(5, "Maps"); -- 13

-- insert the images associated with badges
INSERT INTO Image
	(ImageName) VALUES
	("badges/arrow.png"), -- 1
	("badges/award.png"), -- 2
	("badges/ddeath.png"), -- 3
	("badges/death.png"), -- 4
	("badges/dup.png"), -- 5
	("badges/killed.png"), -- 6
	("badges/line.png"), -- 7
	("badges/tstar.png"), -- 8
	("badges/tup.png"), -- 9
	("badges/up.png"), -- 10
	("badges/wings.png"); -- 11

-- insert the different badges (requires categories, subcategories, and images)
INSERT INTO Badge
	(BadgeName, BadgeCategory, BadgeSubcategory, BadgeCount, BadgeIcon) VALUES
	("First Kill", 1, NULL, 1, 4),
	("Killer", 1, NULL, 50, 3),
	("First Death", 2, 2, 1, 6),
	("First Step", 2, 3, 1, 1),
	("Adventurer", 5, 12, 10, 10),
	("Explorer", 5, 13, 1, 5),
	("Skillful", 3, NULL, 10, 8);
	
-- this is me
INSERT INTO User
	(UserName, UserFacebookID) VALUES
	("Logan Murphy", 1276877482); -- 1

-- these are my statistics
INSERT INTO Statistic
	(StatisticStrength, StatisticDefense, StatisticHealth, StatisticEnergy, StatisticIntelligence, StatisticResistance) VALUES
	(5, 5, 100, 100, 5, 5), -- 1 - current
	(5, 5, 100, 100, 5, 5); -- 2 - max

-- character portrait
INSERT INTO Image
	(ImageName) VALUES
	("face/FlareMaleHero1.png"); -- 12

-- this is my character
INSERT INTO `Character`
	(CharacterName, CharacterPortrait, CharacterCurrentStatisticID, CharacterMaxStatisicID, UserID, CharacterIsMale) VALUES
	("The Master", 12, 1, 2, TRUE); -- 1characterimage

-- default character images
INSERT INTO CharacterImageChoiceGroup
	(ItemTypeID, CharacterImageChoiceGroupIsMale) VALUES
	(3, TRUE), -- 1 - torso
	(5, TRUE), -- 2 - legs
	(7, TRUE), -- 3 - body
	(1, TRUE), -- 4 - head
	(6, TRUE); -- 5 - feet

INSERT INTO Image
	(ImageName) VALUES
	-- body
	("hurt/BODY_human.png"), -- 13
	("bow/BODY_human.png"), -- 14
	("slash/BODY_human.png"), -- 15
	("spellcast/BODY_human.png"), -- 16
	("thrust/BODY_human.png"), -- 17
	("walk/BODY_human.png"), -- 18
	-- feet
	("hurt/FEET_shoes_brown.png"), -- 19
	("bow/FEET_shoes_brown.png"), -- 20
	("slash/FEET_shoes_brown.png"), -- 21
	("spellcast/FEET_shoes_brown.png"), -- 22
	("thrust/FEET_shoes_brown.png"), -- 23
	("walk/FEET_shoes_brown.png"), -- 24
	-- legs
	("hurt/LEGS_pants_greenish.png"), -- 25
	("bow/LEGS_pants_greenish.png"), -- 26
	("slash/LEGS_pants_greenish.png"), -- 27
	("spellcast/LEGS_pants_greenish.png"), -- 28
	("thrust/LEGS_pants_greenish.png"), -- 29
	("walk/LEGS_pants_greenish.png"), -- 30
	-- torso
	("hurt/TORSO_leather_armor_shirt_white.png"), -- 31
	("bow/TORSO_leather_armor_shirt_white.png"), -- 32
	("slash/TORSO_leather_armor_shirt_white.png"), -- 33
	("spellcast/TORSO_leather_armor_shirt_white.png"), -- 34
	("thrust/TORSO_leather_armor_shirt_white.png"), -- 35
	("walk/TORSO_leather_armor_shirt_white.png"), -- 36
	-- head
	("hurt/HEAD_hair_blonde.png"), -- 37
	("bow/HEAD_hair_blonde.png"), -- 38
	("slash/HEAD_hair_blonde.png"), -- 39
	("spellcast/HEAD_hair_blonde.png"), -- 40
	("thrust/HEAD_hair_blonde.png"), -- 41
	("walk/HEAD_hair_blonde.png"); -- 42

-- the characters choice of images
INSERT INTO CharacterImageChoice
	(CharacterImageChoiceRows, CharacterImageChoiceColumns, AttackType, ImageID, CharacterImageChoiceGroupID) VALUES
	-- body
	(1, 6, 6, 13, 3) , -- body hurt
	(4, 13, 5, 14, 3), -- body bow
	(4, 6, 3, 15, 3), -- body slash
	(4, 7, 4, 16, 3), -- body spellcast
	(4, 8, 2, 17, 3), -- body thrust
	(4, 9, 1, 18, 3), -- body walk
	-- feet
	(1, 6, 6, 19, 5) , -- feet hurt
	(4, 13, 5, 20, 5), -- feet bow
	(4, 6, 3, 21, 5), -- feet slash
	(4, 7, 4, 22, 5), -- feet spellcast
	(4, 8, 2, 23, 5), -- feet thrust
	(4, 9, 1, 24, 5), -- feet walk
	-- legs
	(1, 6, 6, 25, 2) , -- feet hurt
	(4, 13, 5, 26, 2), -- feet bow
	(4, 6, 3, 27, 2), -- feet slash
	(4, 7, 4, 28, 2), -- feet spellcast
	(4, 8, 2, 29, 2), -- feet thrust
	(4, 9, 1, 30, 2), -- feet walk
	-- torso
	(1, 6, 6, 31, 1) , -- torso hurt
	(4, 13, 5, 32, 1), -- torso bow
	(4, 6, 3, 33, 1), -- torso slash
	(4, 7, 4, 34, 1), -- torso spellcast
	(4, 8, 2, 35, 1), -- torso thrust
	(4, 9, 1, 36, 1), -- torso walk
	-- head
	(1, 6, 6, 37, 4) , -- head hurt
	(4, 13, 5, 38, 4), -- head bow
	(4, 6, 3, 39, 4), -- head slash
	(4, 7, 4, 40, 4), -- head spellcast
	(4, 8, 2, 41, 4), -- head thrust
	(4, 9, 1, 42, 4); -- head walk

-- the characters images choice
INSERT INTO CharacterImage
	(CharacterID, CharacterImageChoiceGroupID) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5);

-- skill images
INSERT INTO Image
	(ImageName) VALUES
	("skills/thrust/normal.png"), -- 43
	("skills/resist/fire.png"), -- 44
	("skills/wave/fire.png"), -- 45
	("skills/breath/fire.png"); -- 46

-- skills in the game
INSERT INTO Skill
	(SkillName, SkillDescription, SkillIcon, AttackTypeID, SkillIsActive, SkillCooldown, SkillEnergy, SkillArea) VALUES
	("Power Thust", "A powerful thrusting attack that causes significantly more damage than usual.", 43, 2, TRUE, 5000, 10, 1), -- 1
	("Heal", "A spell that grants new life to the caster.", 44, 4, TRUE, 10000, 10, 0), -- 2
	("Fire Arrow", "The player's arrows cause fire damage.", 45, 5, TRUE, 1000, 4, RoomSize), -- 3
	("Fire Wave", "Summons a wave of fire around the caster.", 46, 4, TRUE, 1000, 4, -RoomSize); -- 4

-- these are the character's respective skills
INSERT INTO CharacterSkill
	(CharacterID, SkillID, CharacterSkillIndex, CharacterSkillExpireTime) VALUES
	(1, 1, 0, 0), -- 1
	(1, 2, 1, 0), -- 2
	(1, 3, 2, 0), -- 3
	(1, 4, 3, 0); -- 4

-- the enemies portrait
INSERT INTO Image
	(ImageName) VALUES
	("face/skeleton.png"); -- 47

-- the enemies of the game
INSERT INTO Enemy
	(EnemyPortait, EnemyName, StatisticID) VALUES
	(47, "Skeleton", ?StatisticID?); -- 1

-- enemy map image
INSERT INTO Image
	(ImageName) VALUES
	("walk/BODY_skeleton.png"), -- 48
	("slash/BODY_skeleton.png"), -- 49
	("hurt/BODY_skeleton.png"); -- 50

-- enemy  images
INSERT INTO EnemyImage
	(EnemyID, ImageID, ItemTypeID, AttackTypeID, EnemyImageRows, EnemyImageColumns) VALUES
	(1, 48, 7, 1, 4, 9), -- skeleton walk
	(1, 49, 7, 2, 4, 6), -- skeleton slash
	(1, 50, 7, 6, 1, 6); -- skeleton hurt

-- sounds of the enemy
INSERT INTO Sound
	(SoundName) VALUES
	("sound/NPC/shade/shade1"), -- 15
	("sound/NPC/shade/shade2"), -- 16
	("sound/NPC/shade/shade3"), -- 17
	("sound/NPC/shade/shade4"), -- 18
	("sound/NPC/shade/shade5"), -- 19
	("sound/NPC/shade/shade6"), -- 20
	("sound/NPC/shade/shade7"), -- 21
	("sound/NPC/shade/shade8"), -- 22
	("sound/NPC/shade/shade9"), -- 23
	("sound/NPC/shade/shade10"), -- 24
	("sound/NPC/shade/shade11"), -- 25
	("sound/NPC/shade/shade12"), -- 26
	("sound/NPC/shade/shade13"), -- 27
	("sound/NPC/shade/shade14"), -- 28
	("sound/NPC/shade/shade15"); -- 29

INSERT INTO EnemySound
	(SoundID, EnemyID, AttackTypeID) VALUES
	(15, 1, 6),
	(16, 1, 6),
	(17, 1, 6),
	(18, 1, 6),
	(19, 1, 6),
	(20, 1, 6),
	(21, 1, 6),
	(22, 1, 6),
	(23, 1, 6),
	(24, 1, 6),
	(25, 1, 6),
	(26, 1, 6),
	(27, 1, 6),
	(28, 1, 6);

INSERT INTO UserBehavior
	(UserID, BehaviorSubcategoryID) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
	(1, 8),
	(1, 9),
	(1, 10),
	(1, 11),
	(1, 12),
	(1, 13);

-- item portrait images
INSERT INTO Image
	(ImageName) VALUES
	("items/buckler.png"); -- 51

INSERT INTO ItemModel
	(ItemModelName, ItemModelArea, StatisticID, AttackTypeID, ItemModelWeight, ItemTypeID, ItemModelPortrait) VALUES
	("Buckler",  0, ?StatisticsID?, NULL, 1, 2, 51);