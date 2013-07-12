<?php 
	function getCharacterRoomLocation($character) {
		$room = $character->getOne("Room");
		return json_encode(array(
			"args" => array(
				"column" => $room->RoomColumn, 
				"row" => $room->RoomRow
			),
			"action" => "GetCharacterRoomLocation"
		));	
	}
?>