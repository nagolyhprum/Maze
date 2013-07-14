<?php
	function setSkillIndex($character, $args, $from) {
		$sid = $args["sid"];
		$index = $args["index"];
		$index = (max(min($index, 9), 0) + 9) % 10;
		$cs = new DAO("CharacterSkill", "CharacterID=? AND CharacterSkillIndex=?", array($character->CharacterID, $index)); //get the character skilll with the index
		if($cs->valid()) { //if there is one
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
		}
	}
?>