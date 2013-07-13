<?php 
	function getCharacterRoomLocation($character, $from) {
		$room = $character->getOne("Room");
		$from->send(json_encode(array(
			"args" => array(
				"column" => $room->RoomColumn, 
				"row" => $room->RoomRow
			),
			"action" => "GetCharacterRoomLocation"
		)));	
	}
?>