<?php
	function getSkill($character, $sid) {
		$cs = new DAO("CharacterSkill", "CharacterID=? AND SkillID=?", array($character->CharacterID, $sid));
		$s = $cs->getOne("Skill");
		$at = $s->getOne("AttackType");
		$skill = array(
			"image" => array("icon" => $s->getOne("Image")->ImageName),
			"id" => $sid,
			"area" => $s->SkillArea,
			"isCool" => $cs->CharacterSkillCanUse <= currentTimeMillis(),
			"cooldown" => $s->SkillCooldown,
			"energy" => $s->SkillEnergy,
			"name" => $s->SkillName,
			"description" => $s->SkillDescription,
			"type" => $s->SkillIsActive ? "active" : "passive",
			"lastUse" => $cs->CharacterSkillCanUse - $s->SkillCooldown,
			"multiply" => array(),
			"add" => array(),
			"action" => $at ? $at->AttackTypeName : null
		);
		
		foreach($s->getMany("SkillStatistic") as $ss) {
			$r = array();
			foreach($ss->getMany("StatisticAttribute", "StatisticID") as $sa) {
				$r[$sa->getOne("StatisticName")->StatisticNameValue] = array(
					"current" => $sa->StatisticAttributeValue,
					"max" => $sa->StatisticAttributeValue
				);
			}
			$r["duration"] = $ss->SkillStatisticDuration;
			$skill[$ss->SkillStatisticIsAdd ? "add" : "multiply"][] = $r;
		}
		
		return $skill;
	}	
?>