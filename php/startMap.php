<?php
	require_once("../admin/db.php");

	function createMap($c) {
		$stmt = mysqli_prepare($c, "INSERT INTO Map");
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return mysqli_insert_id($c);		
	}
	
	function getMapModel($c, $id) {
		$mapmodel = array();
		$stmt = mysqli_prepare($c, "SELECT MapModelRows, MapModelColumns FROM MapModel WHERE MapModelID=?");
		mysqli_stmt_bind_param($stmt, "i", $id);
		mysqli_stmt_bind_result($stmt, $mapmodel["rows"], $mapmodel["columns"]);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		return $mapmodel;
	}	
	
	function getRoomModelInMapModel($c, $id) {
		$roommodels = array();
		$stmt = mysqli_prepare($c, "SELECT RoomModelID, RoomModelInMapModelCount FROM RoomModelInMapModel WHERE MapModelID=?");
		mysqli_stmt_bind_param($stmt, "i", $id);
		mysqli_stmt_bind_result($stmt, $room, $count);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			while($count > 0) {
				$roommodels[] = $room;
				$count--;
			}
		}
		mysqli_stmt_close($stmt);
		return $roommodels;
	}
	
	function getEnemyInRoomModel($c, $rooms) {
		$enemies = array();
		$stmt = mysqli_prepare($c, "
			SELECT 
				StatisticID, 
				eirm.EnemyID, 
				EnemyInRoomModelDirection, 
				EnemyInRoomModelRow, 
				EnemyInRoomModelColumn 
			FROM 
				EnemyInRoomModel as eirm
			INNER JOIN
				Enemy as e
			ON
				eirm.EnemyID=e.EnemyID
			WHERE 
				RoomModelID=?");
		mysqli_stmt_bind_param($stmt, "i", $room);
		mysqli_stmt_bind_result($stmt, $statistics, $enemy, $direction, $row, $column);
		for($i = 0; $i < count($rooms); $i++) {
			if(!$enemies["" . $rooms[$i]]) {
				$r = array();
				$room = $rooms[$i];
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					$r[] = array(
						"statistics" => $statistics,
						"enemy" => $enemy,
						"row" => $row,
						"column" => $column,
						"direction" => $direction
					);
				}
				$enemies["" . $rooms[$i]] = $r;
			}
		}
		mysqli_stmt_close($stmt);
		return $enemies;
	}
	
	function shouldMakeMapForCharacter($c, $user, $character) {
		$return = false;
		$stmt = mysqli_prepare($c, "
			SELECT 
				RoomID
			FROM 
				`Character` as c
			INNER JOIN
				User as u
			ON
				u.UserID=c.UserID
			WHERE
				c.UserID=? AND c.CharacterID=?");
		mysqli_stmt_bind_param($stmt, "ii", $user, $character);
		mysqli_stmt_bind_result($stmt, $id);
		mysqli_stmt_execute($stmt);
		if(mysqli_stmt_fetch($stmt)) {
			$return = $id === NULL;
		}
		mysqli_stmt_close($stmt);
		return $return;
	}
	
	function createMapWithMapModel($c, $user, $character, $mapmodel) {
		if(shouldMakeMapForCharacter($c, $user, $character)) {
			$mapmodel = getMapModel($c, $mapmodel);
			$roommodelinmapmodel = getRoomModelInMapModel($c, $mapmodel);
			$enemyinroommodel = getEnemyInRoomModel($c, $roommodelinmapmodel);		
			$rooms = array();
			$visited = array();
			for($i = 0; $i < $mapmodel["rows"]; $i++) {
				$rooms[$i] = array();
				$visited[$i] = array();
				for($j = 0; $j < $mapmodel["columns"]; $j++) {
					$rooms[$i][$j] = array(
						"walls" => WALL_ALL,
						"enemies" => array()
					);
					if($i !==  0 || $j !== 0) {
						$roommodel = array_splice($roommodelinmapmodel, mt_rand(0, count($roommodelinmapmodel) - 1), 1);
						$eirm = $enemyinroommodel["" . $roommodel[0]];
						for($k = 0; $k < count($eirm); $k++) {
							$rooms[$i][$j]["enemies"][] = array(
								"row" => $eirm[$k]["row"],
								"column" => $eirm[$k]["column"],
								"direction" => $eirm[$k]["direction"],
								"statistics" => cloneStatistics($c, $eirm[$k]["statistics"]),
								"enemy" => $eirm[$k]["enemy"]
							);
						}						
					}
					$visited[$i][$j] = false;
				}
			}
			makeMap(0, 0, $mapmodel["rows"], $mapmodel["columns"], $rooms, $visited);			
			//insert into the map
			$stmt = mysqli_prepare($c, "INSERT INTO Map(MapIsActive) VALUES (1)");			
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$map = mysqli_insert_id($c);
			//insert into the room in map
			$stmt = mysqli_prepare($c, "INSERT INTO Room (RoomWalls, MapID, RoomColumn, RoomRow, RoomIsDiscovered) VALUES (?, ?, ?, ?, 0)");
			mysqli_stmt_bind_param($stmt, "iiii", $walls, $map, $column, $row);
			for($row = 0; $row < $mapmodel["rows"]; $row++) {			
				for($column = 0; $column < $mapmodel["columns"]; $column++) {
					$walls = $rooms[$row][$column]["walls"];
					mysqli_stmt_execute($stmt);
					$rooms[$row][$column]["id"] = mysqli_insert_id($c);
				}
			}
			mysqli_stmt_close($stmt);
			//place the character in 0, 0
			$stmt = mysqli_prepare($c, "
				UPDATE 
					`character` as c
				INNER JOIN
					StatisticAttribute as maxs
				ON
					maxs.StatisticID=c.CharacterMaxStatisticID
				INNER JOIN
					StatisticAttribute as curs
				ON
					curs.StatisticID=c.CharacterCurrentStatisticID
				SET 
					c.CharacterColumn=" . floor(ROOM_COLUMNS / 2) . ", 
					c.CharacterRow=" . floor(ROOM_ROWS / 2) . ", 
					c.RoomID=?, 
					c.CharacterDirection=" . DIRECTION_DOWN . ", 
					c.CharacterDirection=2,
					curs.StatisticAttributeValue = maxs.StatisticAttributeValue
				WHERE 
					c.CharacterID=? AND curs.StatisticNameID=maxs.StatisticNameID");
			mysqli_stmt_bind_param($stmt, "ii", $rooms[0][0]["id"], $character);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			//update the character statistics and skills
			//TODO
			//insert into the enemy in room
			$stmt = mysqli_prepare($c, "INSERT INTO EnemyInRoom (EnemyInRoomStatistics, EnemyID, RoomID, EnemyInRoomColumn, EnemyInRoomRow, EnemyInRoomDirection) VALUES (?, ?, ?, ?, ?, ?)");	
			mysqli_stmt_bind_param($stmt, "iiiiii", $statistics, $enemy, $room, $column, $row, $direction);
			for($r = 0; $r < $mapmodel["rows"]; $r++) {
				for($col = 0; $col < $mapmodel["columns"]; $col++) {
					$room = $rooms[$r][$col]["id"];
					for($i = 0; $i < count($rooms[$r][$col]["enemies"]); $i++) {
						$e = $rooms[$r][$col]["enemies"][$i];
						$statistics = $e["statistics"];
						$enemy = $e["enemy"];
						$column = $e["column"];
						$row = $e["row"];
						$direction = $e["direction"];
						mysqli_stmt_execute($stmt);
					}
				}
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	function cloneStatistics($c, $id) {	
		mysqli_query($c, "INSERT INTO Statistic(StatisticIsActive) VALUES (1)");
		$newID = mysqli_insert_id($c);
		$stmt = mysqli_prepare($c, "
			INSERT INTO 
				StatisticAttribute
				(					
					StatisticNameID,
					StatisticAttributeValue,
					StatisticID
				) 
			SELECT 				
				StatisticNameID,
				StatisticAttributeValue,
				?
			FROM 
				StatisticAttribute
			WHERE 
				StatisticID=?");
		mysqli_stmt_bind_param($stmt, "ii", $newID, $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return $newID;
	}
	
	function oppositeDirection($direction) {
		switch($direction) {
			case WALL_UP : return WALL_DOWN;
			case WALL_RIGHT : return WALL_LEFT;
			case WALL_DOWN : return WALL_UP;
			case WALL_LEFT : return WALL_RIGHT;
		}
	}
	
	function makeMap($fromrow, $fromcolumn, $rows, $columns, &$rooms, &$visited) {
		$visited[$fromrow][$fromcolumn] = true;
		$unvisited = array(WALL_UP, WALL_RIGHT, WALL_DOWN, WALL_LEFT);
		while(count($unvisited)) {
			$tocolumn = $fromcolumn;
			$torow = $fromrow;
			$direction = array_splice($unvisited, floor(mt_rand(0, count($unvisited))), 1);
			$direction = $direction[0];
			if($direction === WALL_UP) {
				$torow--;
			}
			if($direction === WALL_RIGHT) {
				$tocolumn++;
			}
			if($direction === WALL_DOWN) {
				$torow++;
			}
			if($direction === WALL_LEFT) {
				$tocolumn--;
			}
			if($torow >= 0 && $tocolumn >= 0 && $torow < $rows && $tocolumn < $columns && !$visited[$torow][$tocolumn]) {
				$rooms[$fromrow][$fromcolumn]["walls"] ^= $direction;
				$rooms[$torow][$tocolumn]["walls"] ^= oppositeDirection($direction);
				makeMap($torow, $tocolumn, $rows, $columns, $rooms, $visited);
			}
		}
	}
	
	$character = 1;
	$mapmodel = 1;
	$c = connect();
	createMapWithMapModel($c, $USER, $character, $mapmodel);
	close($c);
?>