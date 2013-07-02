<?php
	require "getItem.php";
	require "../admin/db.php";
	
	function getEquipment($c, $cid, $uid) {
		$stmt = mysqli_prepare($c, "
			SELECT
				ItemID
			FROM
				ItemInEquipment as iie
			INNER JOIN
				`Character` as c
			ON
				iie.CharacterID=c.CharacterID
			WHERE
				c.CharacterID=? AND c.UserID=? AND iie.ItemID IS NOT NULL
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $iid);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			$equipment[] = $iid;
		}
		mysqli_stmt_close($stmt);
		for($i = 0; $i < count($equipment); $i++) {
			$equipment[$i] = getItem($c, $equipment[$i]);
		}
		return $equipment;
	}
	
	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getEquipment($c, $cid, $USER));
	close($c);
?>