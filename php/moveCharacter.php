<?php
	require_once("../admin/db.php");

	function moveCharacter($c, $cid, $uid, $column, $row) {
		$HALF_COLUMNS = floor(ROOM_COLUMNS / 2);
		$HALF_ROWS = floor(ROOM_ROWS / 2);
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
				eir.RoomID=c.RoomID	AND eir.EnemyInRoomColumn=? AND eir.EnemyInRoomRow=? 
			-- top
			LEFT JOIN
				Room as topRoom
			ON
				topRoom.MapID=r.MapID AND topRoom.RoomColumn=r.RoomColumn AND topRoom.RoomRow=r.RoomRow-1 AND r.RoomWalls & " . WALL_UP . " = 0
			-- right
			LEFT JOIN
				Room as rightRoom
			ON
				rightRoom.MapID=r.MapID AND rightRoom.RoomColumn=r.RoomColumn+1 AND rightRoom.RoomRow=r.RoomRow AND r.RoomWalls & " . WALL_RIGHT . " = 0
			-- bottom
			LEFT JOIN
				Room as bottomRoom
			ON
				bottomRoom.MapID=r.MapID AND bottomRoom.RoomColumn=r.RoomColumn AND bottomRoom.RoomRow=r.RoomRow+1 AND r.RoomWalls & " . WALL_DOWN . " = 0
			-- left
			LEFT JOIN
				Room as leftRoom
			ON
				leftRoom.MapID=r.MapID AND leftRoom.RoomColumn=r.RoomColumn-1 AND leftRoom.RoomRow=r.RoomRow AND r.RoomWalls & " . WALL_LEFT . " = 0
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
				c.CharacterRow=?,
				c.RoomID=
				(
					CASE
						WHEN c.CharacterRow=-1 THEN topRoom.RoomID 
						WHEN c.CharacterColumn=" . ROOM_COLUMNS . " THEN rightRoom.RoomID
						WHEN c.CharacterRow=" . ROOM_ROWS . " THEN bottomRoom.RoomID
						WHEN c.CharacterColumn=-1 THEN leftRoom.RoomID
						ELSE c.RoomID
					END
				),
				c.CharacterRow=
				(
					CASE
						WHEN c.CharacterRow = -1 THEN " . (ROOM_ROWS - 1) . "
						WHEN c.CharacterRow = " . ROOM_ROWS . " THEN 0
						ELSE c.CharacterRow
					END
				),
				c.CharacterColumn=
				(
					CASE
						WHEN c.CharacterColumn = -1 THEN " . (ROOM_COLUMNS - 1) . "
						WHEN c.CharacterColumn = " . ROOM_COLUMNS . " THEN 0
						ELSE c.CharacterColumn
					END
				)
			WHERE
				c.CharacterID=? AND c.UserID=? -- the users character
			AND 
				(ABS(c.CharacterColumn - ?) + ABS(c.CharacterRow - ?) = 1) -- can only move one cell
			AND 
				eir.EnemyInRoomID IS NULL -- there are no enemies
			AND -- make sure they are still in the room
			(
					(? >= 0 AND ? >= 0 AND ? < " . ROOM_COLUMNS . " AND ? < " . ROOM_ROWS . ") -- in the room
				OR
					(? = -1 AND ? = $HALF_ROWS AND r.RoomWalls & " . WALL_LEFT . " = 0) -- going to the left room
				OR
					(? = " . ROOM_COLUMNS . " AND ? = $HALF_ROWS AND r.RoomWalls & " . WALL_RIGHT . " = 0) -- going to the right room
				OR
					(? = $HALF_COLUMNS AND ? = -1 AND r.RoomWalls & " . WALL_UP . " = 0) -- going to the top room
				OR
					(? = $HALF_COLUMNS AND ? = " . ROOM_ROWS . " AND r.RoomWalls & " . WALL_DOWN . " = 0) -- going to the bottom room
			)
			");
		echo mysqli_error($c);
		mysqli_stmt_bind_param($stmt, "iiiiiiiiiiiiiiiiiiiiiiii", 
			$column, $row, //test for enemies
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
	
	/*
	
	*/
?>