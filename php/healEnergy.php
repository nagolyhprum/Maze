<?php
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) { //if i get the character
			$now = currentTimeMillis();
			$heal = floor(($now - $character->CharacterLastEnergyUpdate) / 1000); //how much do i heal
			if($heal) { //if i heal
				$energy = new DAO("StatisticName", "StatisticNameValue='energy'"); //get the energy stat
				$c = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($energy->StatisticNameID, $character->CharacterCurrentStatisticID)); //get current
				$m = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($energy->StatisticNameID, $character->CharacterMaxStatisticID)); //get max
				$c->StatisticAttributeValue = min($c->StatisticAttributeValue + $heal, $m->StatisticAttributeValue); //heal
				$c->update(); //save
				$character->CharacterLastEnergyUpdate += $heal * 1000; //update
				$character->update(); //save
				echo $heal;;
			}
		}
		DB::close();
	}
	echo "0";
?>
