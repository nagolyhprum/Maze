<?php
	function healEnergy($character, $from) {
		$now = currentTimeMillis();
		$heal = floor(($now - $character->CharacterLastEnergyUpdate) / 1000); //how much do i heal
		if($heal) { //if i heal
			$energy = new DAO("StatisticName", "StatisticNameValue='energy'"); //get the energy stat
			$c = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($energy->StatisticNameID, $character->CharacterCurrentStatisticID)); //get current
			$m = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($energy->StatisticNameID, $character->CharacterMaxStatisticID)); //get max
			$old = $c->StatisticAttributeValue;			
			$c->StatisticAttributeValue = min($c->StatisticAttributeValue + $heal, $m->StatisticAttributeValue); //heal
			if($c->StatisticAttributeValue > $old) {
				$c->update(); //save
				$from->send(json_encode(array(
					"args" => $c->StatisticAttributeValue,
					"action" => "HealEnergy"
				)));
			}
			$character->CharacterLastEnergyUpdate += $heal * 1000; //update
			$character->update(); //save
		}
	}
?>
