<?php
	function getEquipment($character, $from) {
		$equipment = array();
		foreach($character->getMany("ItemInEquipment") as $ce) { //get the character's equipment
			if($ce->ItemID) { //if there is an item there
				$equipment[] = getItem($ce->ItemID); //get it
			}
		}
		$from->send(json_encode(array(
			"args" => $equipment,
			"action" => "GetEquipment"
		)));
	}
?>