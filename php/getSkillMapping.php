<?php
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$r = array(null, null, null, null, null, null, null, null, null, null);
			foreach($character->getMany("CharacterSkill") as $cs) {
				if($cs->CharacterSkillIndex !== null) {
					$r[$cs->CharacterSkillIndex] = $cs->SkillID;
				}
			}
			echo json_encode($r);
		}
		DB::close();
	}
?>