<?php
	require "getItem.php";
	require "classes/DAO.php";
	if(DB::connect()) {
		$character = new Character();
		if($character->isValid()) {
			foreach($character->getMany("ItemInInventory") as $iii) {
				$items[] = $iii->ItemID ? getItem($iii->ItemID) : null;
			}
			echo json_encode($items);
		}
		DB::close();
	}
?>