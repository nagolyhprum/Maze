<?php
	function getItem($c, $iid) {
		$stmt = mysqli_prepare($c, "SET @iid=?;");
		mysqli_stmt_bind_param($stmt, "i", $iid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		
		mysqli_multi_query($c, "CALL getItem(@iid);");
		if($result = mysqli_store_result($c)) {
			if($r = mysqli_fetch_assoc($result)) {
				$item["attack"] = $r["AttackTypeName"];
				$item["name"] = $r["ItemModelName"];
				$item["area"] = (int)$r["ItemModelArea"];
				$item["weight"] = (int)$r["ItemModelWeight"];				
				$item["type"] = $r["ItemTypeName"];
				$item["portrait"] = $r["ImageName"];
				$item["id"] = (int)$r["ItemID"];			
			}
			mysqli_free_result($result);
		}
		mysqli_next_result($c);
		//STATISTICS
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				$item["statistics"][$r["StatisticNameValue"]] = array(
					"current" => $r["StatisticAttributeValue"],
					"max" => $r["StatisticAttributeValue"]
				);
			}
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				$item[$r["AttackTypeName"]] = array(
					"name" => $r["ImageName"],
					"rows" => (int)$r["ItemModelImageRows"],
					"columns" => (int)$r["ItemModelImageColumns"]
				);
			}
			mysqli_free_result($result);
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				$item["sounds"] = array(
					"move" => $r["AudioName"]
				);
			}
			mysqli_free_result($result);
		}
						
		while(mysqli_more_results($c) && mysqli_next_result($c)) {
			if($extraResult = mysqli_store_result($c)){
				mysqli_free_result($extraResult);
			}
		}
		
		return $item;
	}
?>