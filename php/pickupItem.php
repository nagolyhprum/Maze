<?php
	//this will also drop an item
	function pickupItem($character, $from) {
		$iii = new DAO("ItemInInventory", "CharacterID=? AND ItemID IS NULL LIMIT 1", array($character->CharacterID));
		if($iii->valid()) {
			$iir = new DAO("ItemInRoom", "RoomID=? AND ItemInRoomIsActive=1 AND ItemInRoomRow=? AND ItemInRoomColumn=? LIMIT 1", array($character->RoomID, $character->CharacterRow, $character->CharacterColumn));
			if($iir->valid()) {
				$iir->ItemInRoomIsActive = 0;
				$iir->update();
				$iii->ItemID = $iir->ItemID;
				$iii->update();
			}
		}
	}
?>