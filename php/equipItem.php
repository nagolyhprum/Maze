<?php	
	function equipItem($character, $args, $from) {
		$iid = (int)$args["iid"];	
		$iii = new DAO("ItemInInventory", "ItemID=? AND CharacterID=?", array($iid, $character->CharacterID));
		$free = new DAO("ItemInInventory", "ItemID IS NULL AND CharacterID=? LIMIT 1", array($character->CharacterID));
		if($iii->valid()) { //if the item is in the inventory then we are equipping
			$im = $iii->getOne("Item")->getOne("ItemModel");
			$left = new DAO("ItemInEquipment", "CharacterID=? AND ItemTypeID=? ORDER BY ItemID DESC LIMIT 1", array($character->CharacterID, $im->ItemTypeID));
			$right = new DAO("ItemInEquipment", "CharacterID=? AND ItemTypeID=? ORDER BY ItemID DESC LIMIT 1, 1", array($character->CharacterID, $im->ItemTypeID));
			if($right->valid()) { //then we are equipping an item
				if($im->ItemModelWeight === 3 && (($left->ItemID && $right->ItemID && $free->valid()) || ($left->ItemID && !$right->ItemID))) { //this is two handed
					$iii->ItemID = $left->ItemID;
					$iii->update();
					$free->ItemID = $right->ItemID;
					$free->update();
					$left->ItemID = $iid;
					$left->update();
				} else { //then we are equipping a one hander
					if($left->ItemID && $left->getOne("Item")->getOne("ItemModel")->ItemModelWeight === $im->ItemModelWeight) {	//the code looks the same but it must fail before i try other code
						$iii->ItemID = $left->ItemID;
						$iii->update();
						$left->ItemID = $iid;
						$left->update();
					} else if($right->ItemID && $right->getOne("Item")->getOne("ItemModel")->ItemModelWeight === $im->ItemModelWeight) {						
						$iii->ItemID = $right->ItemID;
						$iii->update();
						$right->ItemID = $iid;
						$right->update();
					} else if(!$left->ItemID) {		
						$iii->ItemID = $left->ItemID;
						$iii->update();
						$left->ItemID = $iid;
						$left->update();
					} else if(!$right->ItemID) {
						$iii->ItemID = $right->ItemID;
						$iii->update();
						$right->ItemID = $iid;
						$right->update();
					}
				}
			} else { //otherwise it is just a normal equipment
				$iii->ItemID = $left->ItemID;
				$iii->update();
				$left->ItemID = $iid;
				$left->update();
			}
		} else if($free->valid()) { //other wise we are unequipping
			$iie = new DAO("ItemInEquipment", "CharacterID=? AND ItemID=?", array($character->CharacterID, $iid));
			$free->ItemID = $iie->ItemID;
			$free->update();
			$iie->ItemID = null;
			$iie->update();
		}
	}
	
?>