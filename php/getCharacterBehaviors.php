<?php
	function getCharacterBehaviors($character, $from) {		
		foreach($character->getMany("UserBehavior", "UserID") as $ub) {
			$subcategory = $ub->getOne("Subcategory");
			$category = $subcategory->getOne("Category");
			$behaviors[$category->CategoryName][$subcategory->SubcategoryName] = $ub->UserBehaviorCount;
		}
		$from->send(json_encode(array(
			"args" => $behaviors,
			"action" => "GetCharacterBehaviors"
		)));
	}
?>