<?php
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->isValid()) {
			$iii = new DAO("ItemInInventory", "CharacterID=@0 AND ItemID IS NULL LIMIT 1", array($character->CharacterID));
			if($iii->isValid()) {
				$iir = new DAO("ItemInRoom", "RoomID=@0 AND ItemInRoomIsActive=1 AND ItemInRoomRow=@1 AND ItemInRoomColumn=@2 LIMIT 1", array($character->RoomID, $character->CharacterRow, $character->CharacterColumn));
				if($iir->isValid()) {
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