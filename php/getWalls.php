<?php 
	function getWalls($character, $from) {
		$room = $character->getOne("Room");
		if(!$room->RoomIsDiscovered) {
			$room->RoomIsDiscovered = 1;
			$room->update();
			addBehavior($character, "Discovered", "Rooms", 1, $from);
			$undiscovered = new DAO("Room", "MapID=? AND RoomIsDiscovered=0 LIMIT 1", array($room->MapID));
			if(!$undiscovered->valid()) {
				addBehavior($character, "Discovered", "Maps", 1, $from);				
			}
		}
		$from->send(json_encode(array(
			"args" => $room->RoomWalls,
			"action" => "GetWalls"
		)));
	}
?>