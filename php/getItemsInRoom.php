<?php
	function getItemsInRoom($character, $from) {
		$items = array();
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
		$from->send(json_encode(array(
			"args" => $items,
			"action" => "GetItemsInRoom"
		)));
	}
?>