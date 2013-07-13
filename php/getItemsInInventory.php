<?php
	function getItemsInInventory($character, $from) {
		foreach($character->getMany("ItemInInventory") as $iii) {
			$items[] = $iii->ItemID ? getItem($iii->ItemID) : null;
		}
		$from->send(json_encode(array(
			"args" => $items,
			"action" => "GetItemsInInventory"
		)));
	}
?>