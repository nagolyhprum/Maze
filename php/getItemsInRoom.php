<?php
	require_once("classes/DAO.php");
	require "getItem.php";
	
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			foreach($character->getMany("ItemInRoom", "RoomID") as $iir) {
				if($iir->ItemInRoomIsActive) {
					$item = getItem($iir->ItemID);
					$item["location"] = array(
						"column" => $iir->ItemInRoomColumn,
						"row" => $iir->ItemInRoomRow
					);
					$items[] = $item;
				}
			}
			echo json_encode($items);
		}
		DB::close();
	}

?>