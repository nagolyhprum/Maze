<?php
	require "../admin/db.php";
	
	function equipItem($c, $cid, $uid, $iiiid) {
		$stmt = mysqli_prepare($c, "CALL equipItem(?, ?, ?);");
		mysqli_stmt_bind_param($stmt, "iii", $uid, $cid, $iiiid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);		
		return 1;
	}
	
	$cid = $_GET["cid"];
	$iiiid = $_GET["iiiid"];	
	$c = connect($c);
	echo json_encode(equipItem($c, $cid, $USER, $iiiid));
	close($c);
?>