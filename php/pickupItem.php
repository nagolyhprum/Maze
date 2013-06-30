<?php
	require "../admin/db.php";

	function pickupItem($c, $cid, $uid) {
		$stmt = mysqli_prepare($c, "SELECT pickupItem(?, ?)");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $success);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $success;
	}
	
	$cid = $_GET["cid"];
	
	$c = connect();
	echo json_encode(pickupItem($c, $cid, $USER));
	close($c);

?>