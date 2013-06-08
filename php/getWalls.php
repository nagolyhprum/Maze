<?php 
	require_once("../admin/db.php");
	
	function getWalls($c, $uid, $cid) {
		$stmt = mysqli_prepare($c, "
			SELECT 
				r.RoomWalls
			FROM
				`Character` as c
			INNER JOIN
				Room as r
			ON
				c.RoomID=r.RoomID
			WHERE
				c.UserID=? AND c.CharacterID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $uid, $cid);
		mysqli_stmt_bind_result($stmt, $walls);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $walls;
	}

	$cid = 1;
	$c = connect();
	echo json_encode(getWalls($c, $USER, $cid));
	close($c);
?>