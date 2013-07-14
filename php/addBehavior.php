<?php
	function addBehavior($character, $category, $subcategory, $count, $from) {
		if($count > 0) {
			$category = new DAO("Category", "CategoryName=?", array($category));
			$subcategory = new DAO("Subcategory", "SubcategoryName=? AND CategoryID=?", array($subcategory, $category->CategoryID));
			if($category->valid() && $subcategory->valid()) {			
				$ub = new DAO("UserBehavior", "SubcategoryID=? AND UserID=?", array($subcategory->SubcategoryID, $character->CharacterID));
				if($ub->valid()) {
					$ub->UserBehaviorCount += $count;
					$ub->update();
					$from->send(json_encode(array(
						"args" => array(
							"count" => $count,
							"category" => $category->CategoryName,
							"subcategory" => $subcategory->SubcategoryName
						),
						"action" => "AddBehavior"
					)));
					return;
				}
			}
		}
		echo "Something went wrong with $category, $subcategory.\n";
	}
?>