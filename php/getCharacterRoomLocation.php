<?php 
	require_once("../admin/db.php");

	function getCharacterRoomLocation($c, $cid, $uid) {
		$stmt = mysqli_prepare($c, "
			SELECT 
				CharacterColumn, 
				CharacterRow 
			FROM 
				`Character`
			WHERE 
				CharacterID=? AND UserID=?");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $column, $row);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return array("column" => $column, "row" => $row);
	}
	
	$cid = 1;
	$c = connect();
	echo json_encode(getCharacterRoomLocation($c, $cid, $USER));
	close($c);
?>