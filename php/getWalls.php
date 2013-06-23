<?php 
	require_once("../admin/db.php");
	
	function getWalls($c, $uid, $cid) {
		$stmt = mysqli_prepare($c, "SELECT getWalls(?, ?)");
		mysqli_stmt_bind_param($stmt, "ii", $uid, $cid);		
		mysqli_stmt_bind_result($stmt, $walls);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $walls;
	}

	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getWalls($c, $USER, $cid));
	close($c);
?>