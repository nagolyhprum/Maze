<?php
	require_once("../admin/db.php");

	function moveCharacter($c, $cid, $uid, $column, $row) {
		global $COLUMNS, $ROWS;
		$HALF_COLUMNS = floor($COLUMNS / 2);
		$HALF_ROWS = floor($ROWS / 2);
		$stmt = mysqli_prepare($c, "
			UPDATE
				`Character` as c
			INNER JOIN
				Room as r
			ON
				r.RoomID=c.RoomID
			LEFT JOIN
				EnemyInRoom as eir
			ON
				eir.RoomID=c.RoomID			
			SET
				c.CharacterDirection=
				(
					CASE 
						WHEN c.CharacterColumn - ? = -1 THEN " . DIRECTION_RIGHT . "
						WHEN c.CharacterRow - ? = -1 THEN " . DIRECTION_DOWN . "
						WHEN c.CharacterColumn - ? = 1 THEN " . DIRECTION_LEFT . "
						WHEN c.CharacterRow - ? = 1 THEN " . DIRECTION_UP . "
						ELSE -1
					END
				),
				c.CharacterColumn=?,
				c.CharacterRow=?
			WHERE
				c.CharacterID=? AND c.UserID=? -- the users character
			AND 
				(ABS(c.CharacterColumn - ?) + ABS(c.CharacterRow - ?) = 1) -- can only move one cell
			AND 
				eir.EnemyInRoomID IS NULL -- there are no enemies
			AND -- make sure they are still in the room
			(
					(? >= 0 AND ? >= 0 AND ? < $COLUMNS AND ? < $ROWS) -- in the room
				OR
					(? = -1 AND ? = $HALF_ROWS AND r.RoomWalls & " . WALL_LEFT . " = 0) -- going to the left room
				OR
					(? = $COLUMNS AND ? = $HALF_ROWS AND r.RoomWalls & " . WALL_RIGHT . " = 0) -- going to the right room
				OR
					(? = $HALF_COLUMNS AND ? = -1 AND r.RoomWalls & " . WALL_UP . " = 0) -- going to the top room
				OR
					(? = $HALF_COLUMNS AND ? = $ROWS AND r.RoomWalls & " . WALL_DOWN . " = 0) -- going to the bottom room
			)
			");
		echo mysqli_error($c);
		mysqli_stmt_bind_param($stmt, "iiiiiiiiiiiiiiiiiiiiii", 
			$column, $row, $column, $row, //direction logic
			$column, $row, //set the column and row
			$cid, $uid, //this character and user
			$column, $row, //check the distance of the movement
			$column, $row, $column, $row, //in the map
			$column, $row, //going left
			$column, $row, //going right
			$column, $row, //going top
			$column, $row); //going bottom
		mysqli_stmt_execute($stmt);
		$count = mysqli_affected_rows($c);
		mysqli_stmt_close($stmt);
		if($count === 1) {
			changeRooms($c);
		}
		return $count;
	}
	
	function changeRooms($c) {
	}
	
	$c = connect();
	$row = $_GET["row"];
	$column = $_GET["column"];
	$cid = $_GET["cid"];
	echo json_encode(moveCharacter($c, $cid, $USER, $column, $row));
	close($c);
?>