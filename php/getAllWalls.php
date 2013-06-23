<?php 
	require_once("../admin/db.php");
	
	function getAllWalls($c, $uid, $cid) {
		mysqli_multi_query($c, "CALL getAllWalls(" . mysqli_real_escape_string($c, $cid) . ", " . mysqli_real_escape_string($c, $uid) . ")");
		$column = $row = -1;
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				if($r["RoomIsDiscovered"]) {
					$data[] = (int) $r["RoomWalls"];
				} else {
					$data[] = null;
				}
				$column = max($r["RoomColumn"], $column);
				$row = max($r["RoomRow"], $row);
			}
			mysqli_free_result($result);
		}
		return array("data" => $data, "columns" => $column + 1, "rows" => $row + 1);
	}

	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getAllWalls($c, $USER, $cid));
	close($c);
?>