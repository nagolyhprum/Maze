<?php
	require "classes/DAO.php";
	$sid = $_GET["sid"];
	$index = $_GET["index"];
	$index = (max(min($index, 9), 0) + 9) % 10;
	if(DB::connect()) { //connect
		$character = new Character(); //get character
		if($character->valid()) { //if this is a valid character			
			$cs = new DAO("CharacterSkill", "CharacterID=? AND CharacterSkillIndex=?", array($character->CharacterID, $index)); //get the character skilll with the index
			if($cs->isValid()) { //if there is one
				if($cs->CharacterSkillCanUse <= currentTimeMillis()) { //see if i can unequip it, then do it
					$cs->CharacterSkillIndex = null;
					$cs->update();
					$todo = 1;
				}
			} else { //or the skill index is not bound
				$todo = 1;
			}
			if($todo) { //then i will bind the new skill
				$cs = new DAO("CharacterSkill", "CharacterID=? AND SkillID=?", array($character->CharacterID, $sid));
				$cs->CharacterSkillIndex = $index;
				$cs->update();
				echo 1;
			}
			echo "0";
		}
		DB::close();
	}
?>