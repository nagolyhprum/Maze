<?php
	require "../admin/db.php";
	require "getItem.php";
	
	function getItemsInRoom($c, $cid, $uid) {
		$stmt = mysqli_prepare($c, "
			SELECT
				iii.ItemID
			FROM
				`Character` as c
			INNER JOIN
				ItemInInventory as iii
			ON
				c.CharacterID=iii.CharacterID
			WHERE
				c.CharacterID=? AND c.UserID=?
			ORDER BY
				iii.ItemInInventoryRow, 
				iii.ItemInInventoryColumn
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $iiiid);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			$items[] = $iiiid;
		}
		mysqli_stmt_close($stmt);
		for($i = 0; $i < count($items); $i++) {
			$items[$i] = getItem($c, $items[$i]);
		}
		return $items;
	}
		
	$cid = $_GET["cid"];	
	$c = connect();
	echo json_encode(getItemsInRoom($c, $cid, $USER));
	close($c);
?>