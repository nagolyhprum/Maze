<?php 
	require_once("classes/DAO.php");
	
	if(DB::connect()) { 
		$character = new Character(); //get the active character
		if($character->isValid()) { //if the character is valid
			$room = $character->getOne("Room");
			if(!$room->RoomIsDiscovered) {
				$room->RoomIsDiscovered = 1;
				$room->update();
			}
			echo $room->RoomWalls; //print the character's current room's wall data
		}
		DB::close(); 
	}
?>