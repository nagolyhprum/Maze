<?php
	require_once("../admin/db.php");

	function moveCharacter($c, $cid, $uid, $column, $row) {
		mysqli_query($c, "CALL setGlobals()");
		$stmt = mysqli_prepare($c, "SELECT moveCharacter(?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt, "iiii", $column, $row, $cid, $uid);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $count;
	}
	
	$c = connect();
	$row = $_GET["row"];
	$column = $_GET["column"];
	$cid = $_GET["cid"];
	echo json_encode(moveCharacter($c, $cid, $USER, $column, $row));
	close($c);
?>