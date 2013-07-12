<?php 
	function getAllWalls($character) {
		foreach($rooms = $character->getOne("Room")->getOne("Map")->getMany("Room") as $room) {
			if($room->RoomIsDiscovered) {
				$data[] = $room->RoomWalls;
			} else {
				$data[] = $room->null;
			}
			$column = max($column, $room->RoomColumn);
			$row = max($row, $room->RoomRow);
		}		
		return json_encode(array(
			"args" => array("data" => $data, "columns" => $column + 1, "rows" => $row + 1),
			"action" => "GetAllWalls"
		));
	}
?>