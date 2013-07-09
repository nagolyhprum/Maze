<?php
	require "classes/DAO.php";
	require "getSkill.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$skills = new DAO("Skill", true);
			foreach($skills as $skill) {		
				$r[] = getSkill($character, $skill->SkillID);
			}
			echo json_encode($r);
		}
		DB::close();
	}
?>