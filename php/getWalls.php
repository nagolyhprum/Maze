<?php 
	function getWalls($character, $from) {
		$room = $character->getOne("Room");
		if(!$room->RoomIsDiscovered) {
			$room->RoomIsDiscovered = 1;
			$room->update();
		}
		$from->send(json_encode(array(
			"args" => $room->RoomWalls,
			"action" => "GetWalls"
		)));
	}
?>