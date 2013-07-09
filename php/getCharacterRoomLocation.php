<?php 
	require_once("classes/DAO.php");
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$room = $character->getOne("Room");
			echo json_encode(array("column" => $room->RoomColumn, "row" => $room->RoomRow));	
		}
		DB::close();
	}
?>