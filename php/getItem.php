<?php
	function getItem($iid) {
		$item = new DAO("Item", $iid);
		$im = $item->getOne("ItemModel");
		$item = array(
			"attack" => $im->getOne("AttackType")->AttackTypeName,
			"name" => $im->ItemModelName,
			"area" => $im->ItemModelArea,
			"weight" => $im->ItemModelWeight,
			"type" => $im->getOne("ItemType")->ItemTypeName,
			"portrait" => $im->getOne("Image")->ImageName,
			"id" => $iid
		);
		foreach($im->getMany("StatisticAttribute", "StatisticID") as $sa) {			
			$item["statistics"][$sa->getOne("StatisticName")->StatisticNameValue] = array(
				"current" => $sa->StatisticAttributeValue,
				"max" => $sa->StatisticAttributeValue
			);
		}
		foreach($im->getMany("ItemModelImage") as $imi) {
			$item[$imi->getOne("AttackType")->AttackTypeName] = array(
				"src" => $imi->getOne("Image")->ImageName,
				"rows" => $imi->ItemModelImageRows,
				"columns" => $imi->ItemModelImageColumns
			);
		}
		foreach($im->getMany("ItemModelAudio") as $ima) {
			$item["sounds"] = array(
				"move" => $ima->getOne("Audio")->AudioName
			);
		}
		return $item;
	}
?>