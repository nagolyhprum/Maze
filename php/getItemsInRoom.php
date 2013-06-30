<?php
	require "../admin/db.php";
	require "getItem.php";

	function getItemsInRoom($c, $uid, $cid, $iirid) {
		$stmt = mysqli_prepare($c, "
			SELECT
				iir.ItemInRoomColumn,
				iir.ItemInRoomRow,
				i.ItemID
			FROM
				ItemInRoom as iir
			INNER JOIN
				Item as i
			ON
				iir.ItemID=i.ItemID
			INNER JOIN
				`Character` as c
			ON
				c.RoomID=iir.RoomID
			WHERE
				c.CharacterID=? AND c.UserID=? AND iir.ItemInRoomIsActive AND (iir.ItemInRoomID=? OR ?=-1)");
		mysqli_stmt_bind_param($stmt, "iiii", $cid, $uid, $iirid, $iirid);
		mysqli_stmt_bind_result($stmt, $column, $row, $iid);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			$items[] = array(
				"id" => $iid,
				"row" => $row,
				"column" => $column
			);
		}
		mysqli_stmt_close($stmt);		
		for($i = 0; $i < count($items); $i++) {
			$item = getItem($c, $items[$i]["id"]);
			$item["location"]["column"] = $items[$i]["column"];
			$item["location"]["row"] = $items[$i]["row"];
			$items[$i] = $item;
		}
		
		return $items;
	}
	
	$cid = $_GET["cid"];
	$iirid = $_GET["iirid"];
	$c = connect();
	echo json_encode(getItemsInRoom($c, $USER, $cid, $iirid));
	close($c);
?>