<?php
	function getSkills($character) {
		$skills = new DAO("Skill", true);
		foreach($skills as $skill) {		
			$r[] = getSkill($character, $skill->SkillID);
		}
		return json_encode(array(
			"args" => $r,
			"action" => "GetSkills"
		));
	}
?>