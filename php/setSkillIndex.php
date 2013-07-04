<?php
	require "../admin/db.php";

	function setSkillIndex($c, $cid, $uid, $sid, $index) {
		$stmt = mysqli_prepare($c, "CALL setSkillIndex(?, ?, ?, ?);");
		mysqli_stmt_bind_param($stmt, "iiii", $cid, $uid, $sid, $index);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return 1;
	}
	
	$cid = $_GET["cid"];
	$sid = $_GET["sid"];
	$index = $_GET["index"];
	
	$c = connect();
	echo json_encode(setSkillIndex($c, $cid, $USER, $sid, $index));
	close($c);
?>