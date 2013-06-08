<?php 
	require_once("../admin/db.php");
	
	function getAllWalls($c, $uid, $cid) {
		$stmt = mysqli_prepare($c, "
			SELECT 
				s.RoomWalls,
				s.RoomIsDiscovered,
				s.RoomColumn,
				s.RoomRow
			FROM
				`Character` as c
			INNER JOIN
				Room as r
			ON
				c.RoomID=r.RoomID
			INNER JOIN 
				Room as s
			ON
				s.MapID=r.MapID
			WHERE
				c.UserID=? AND c.CharacterID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $uid, $cid);
		mysqli_stmt_bind_result($stmt, $walls, $isDiscovered, $columns, $rows);
		mysqli_stmt_execute($stmt);
		$data = array();
		$c = -1;
		$r = -1;
		while(mysqli_stmt_fetch($stmt)) {
			if($isDiscovered) {
				$data[] = $walls;
			} else {
				$data[] = null;
			}
			$c = max($columns, $c);
			$r = max($rows, $r);
		}
		mysqli_stmt_close($stmt);
		return array(
			"data" => $data,
			"columns" => $c + 1,
			"rows" => $r + 1
		);
	}

	$cid = 1;
	$c = connect();
	echo json_encode(getAllWalls($c, $USER, $cid));
	close($c);
?>