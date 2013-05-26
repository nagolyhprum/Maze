<?php
	require_once("db.php");
	$c = connect();
	$stmt = mysqli_prepare($c, "SELECT ImageName FROM Image WHERE ImageID=?");
	mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
	mysqli_Stmt_bind_result($stmt, $name);
	mysqli_stmt_execute($stmt);
	if(mysqli_stmt_fetch($stmt)) {
		$ext = substr($name, strlen($name) - 3);
		if($ext === "png") {
			header("Content-type: image/png");
		} else if($ext === "jpg") {
			header("Content-type: image/jpeg");
		}
		echo file_get_contents("../" . $name);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($c);
?>