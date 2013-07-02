<?php
	require "../admin/db.php";
	
	function equipItem($c, $cid, $uid, $iiiid) {
		$stmt = mysqli_prepare($c, "SELECT equipItem(?, ?, ?);");
		mysqli_stmt_bind_param($stmt, "iii", $uid, $cid, $iiiid);
		mysqli_stmt_bind_result($stmt, $result);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $result;
	}
	
	$cid = $_GET["cid"];
	$iiiid = $_GET["iiiid"];	
	$c = connect($c);
	echo json_encode(equipItem($c, $cid, $USER, $iiiid));
	close($c);
?>