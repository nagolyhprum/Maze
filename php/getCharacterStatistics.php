<?php
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$now = currentTimeMillis();
			echo json_encode(array(
				"health" => $character->getStatistic("health", $now),
				"energy" => $character->getStatistic("energy", $now),
				"experience" => $character->getStatistic("experience", $now),
				"speed" => $character->getStatistic("speed", $now),
				"strength" => $character->getStatistic("strength", $now),
				"defense" => $character->getStatistic("defense", $now),
				"intelligence" => $character->getStatistic("intelligence", $now),
				"resistance" => $character->getStatistic("resistance", $now),
			));
		}
	}
?>