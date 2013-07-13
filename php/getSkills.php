<?php
	function getSkills($character, $from) {
		$skills = new DAO("Skill", true);
		foreach($skills as $skill) {		
			$r[] = getSkill($character, $skill->SkillID);
		}
		$from->send(json_encode(array(
			"args" => $r,
			"action" => "GetSkills"
		)));
	}
?>