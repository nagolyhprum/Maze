-- insert the attack types
INSERT INTO AttackType 
	(AttackTypeName) VALUES
	("thrust"), 
	("slash"), 
	("spellcast"), 
	("bow");

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
	("Logan Murphy", 1276877482);