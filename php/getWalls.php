<?php 
	function getWalls($character) {
		$room = $character->getOne("Room");
		if(!$room->RoomIsDiscovered) {
			$room->RoomIsDiscovered = 1;
			$room->update();
		}
		return json_encode(array(
			"args" => $room->RoomWalls,
			"action" => "GetWalls"
		));
	}
?>