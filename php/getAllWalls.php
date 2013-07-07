<?php 
	require_once("classes/DAO.php");
	
	if(DB::connect()) {
		$character = new Character();
		if($character->isValid()) {
			foreach($rooms = $character->getOne("Room")->getOne("Map")->getMany("Room") as $room) {
				if($room->RoomIsDiscovered) {
					$data[] = $room->RoomWalls;
				} else {
					$data[] = $room->null;
				}
				$column = max($column, $room->RoomColumn);
				$row = max($row, $room->RoomRow);
			}
			
			echo json_encode(array("data" => $data, "columns" => $column + 1, "rows" => $row + 1));
		}
		DB::close();
	}
	
?>