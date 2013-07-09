<?php
	require "getItem.php";
	require "classes/DAO.php";
	if(DB::connect()) { //connect
		$character = new Character(); //get character
		if($character->valid()) { //if valid character
			foreach($character->getMany("ItemInEquipment") as $ce) { //get the character's equipment
				if($ce->ItemID) { //if there is an item there
					$equipment[] = getItem($ce->ItemID); //get it
				}
			}
			echo json_encode($equipment ? $equipment : array());
		}
		DB::close();
	}
?>