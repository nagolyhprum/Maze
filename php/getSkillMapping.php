<?php
	function getSkillMapping($character, $from) {
		$r = array(null, null, null, null, null, null, null, null, null, null);
		foreach($character->getMany("CharacterSkill") as $cs) {
			if($cs->CharacterSkillIndex !== null) {
				$r[$cs->CharacterSkillIndex] = $cs->SkillID;
			}
		}
		$from->send(json_encode(array(
			"args" => $r,
			"action" => "GetSkillMapping"
		)));
	}
?>