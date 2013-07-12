<?php
	require("classes/DAO.php");

	function getBadges() {
		if(DB::connect()) {
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
		}
		
		return json_encode(array(
			"action" => "GetCharacterBadges",
			"args" => $json			
		));
	}
?>