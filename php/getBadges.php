<?php
	function getBadges($from) {
		$badges = new DAO("Badge", true);
		foreach($badges as $badge) {
			$json[] = array(
				"name" => $badge->BadgeName,
				"category" => $badge->getOne("Category")->CategoryName,
				"subcategory" => $badge->getOne("Subcategory")->SubcategoryName,
				"count" => $badge->BadgeCount,
				"icon" => $badge->getOne("Image")->ImageName
			);
		}
		
		$from->send(json_encode(array(
			"action" => "GetCharacterBadges",
			"args" => $json			
		)));
	}
?>