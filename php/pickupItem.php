<?php
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$iii = new DAO("ItemInInventory", "CharacterID=? AND ItemID IS NULL LIMIT 1", array($character->CharacterID));
			if($iii->valid()) {
				$iir = new DAO("ItemInRoom", "RoomID=? AND ItemInRoomIsActive=1 AND ItemInRoomRow=? AND ItemInRoomColumn=? LIMIT 1", array($character->RoomID, $character->CharacterRow, $character->CharacterColumn));
				if($iir->valid()) {
					$iir->ItemInRoomIsActive = 0;
					$iir->update();
					$iii->ItemID = $iir->ItemID;
					$iii->update();
					echo 1;
				}
			}
		}
		echo "0";
		DB::close();
	}
?>