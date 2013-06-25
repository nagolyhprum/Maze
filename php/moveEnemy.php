<?php
	require_once("../admin/db.php");
	
	function moveEnemy($c, $cid, $uid) {
		$stmt = mysqli_prepare($c, "SET @cid=?, @uid=?");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		if($result = mysqli_query($c, "CALL getEnemyAssultInfo(@cid, @uid)")) {
			if($r = mysqli_fetch_assoc($result)) {
				$character = array(
					"row" => (int)$r["CharacterRow"],
					"column" => (int)$r["CharacterColumn"],
					"health" => (int)$r["StatisticHealth"],
					"defense" => (int)$r["StatisticDefense"],
					"resistance" => (int)$r["StatisticResistance"]					
				);
				$cts = (int) $r["cts"];
				do {
					$tiles[$r["EnemyInRoomRow"]][$r["EnemyInRoomColumn"]] = $enemies[] = array(
						"row" => (int)$r["EnemyInRoomRow"],
						"column" => (int)$r["EnemyInRoomColumn"],
						"lastRow" => (int)$r["EnemyInRoomRow"],
						"lastColumn" => (int)$r["EnemyInRoomColumn"],
						"strength" => (int)$r["StatisticStrength"],
						"intelligence" => (int)$r["StatisticIntelligence"],
						"timeToMove" => (int)$r["timeToMove"],
						"canUse" => $r["EnemyInRoomCanUse"],
						"id" => (int)$r["EnemyInRoomID"],
						"started" => $r["EnemyInRoomCanUse"]
					);					
				} while($r = mysqli_fetch_assoc($result));
				do {
					$again = 0;
					for($i = 0; $i < count($enemies); $i++) {
						$e = $enemies[$i];
						if($e["canUse"] < $cts) {
							$e["canUse"] += $e["timeToMove"];
							if(abs($e["row"] - $character["row"]) + abs($e["column"] - $character["column"]) === 1) {
								$sDamage = $e["strength"] - ($e["strength"] * $character["defense"] / 100.0);
								$iDamage = $e["intelligence"] - ($e["intelligence"] * $character["resistance"] / 100.0);
								if($sDamage < $iDamage) {
									$character["health"] -= $sDamage;
								} else {
									$character["health"] -= $iDamage;
								}
							} else {
								$next = getNextMove($tiles, $e, $character);
								unset($tiles[$e["row"]][$e["column"]]);
								$e["lastRow"] = $e["row"];
								$e["lastColumn"] = $e["column"];
								$e["row"] = $next["row"];
								$e["column"] = $next["column"];
							}
							$again = 1;
						}
						$enemies[$i] = $tiles[$e["row"]][$e["column"]] = $e;
					}
				} while($again && $character["health"] > 0);
								
				while(mysqli_more_results($c) && mysqli_next_result($c)) {
					if($extraResult = mysqli_store_result($c)){
						mysqli_free_result($extraResult);
					}
				}
				
				$stmt = mysqli_prepare($c, "
					UPDATE
						EnemyInRoom
					SET
						EnemyInRoomRow=?,
						EnemyInRoomColumn=?,
						EnemyInRoomCanUse=FROM_UNIXTIME(?)
					WHERE
						EnemyInRoomID=?					
				");
				mysqli_stmt_bind_param($stmt, "iiii", $row, $column, $canUse, $id);
				for($i = 0; $i < count($enemies); $i++) {
					$e = $enemies[$i];
					$row = $e["row"];
					$column = $e["column"];
					$canUse = $e["canUse"];
					$id = $e["id"];
					mysqli_stmt_execute($stmt);
				}				
				mysqli_stmt_close($stmt);
				$stmt = mysqli_prepare($c, "
					UPDATE
						`Character` as c
					INNER JOIN
						Statistic as s
					ON
						s.StatisticID=c.CharacterCurrentStatisticID
					SET
						s.StatisticHealth = ?,
						c.RoomID = 
						(
							CASE
								WHEN s.StatisticHealth > 0 THEN c.RoomID
								ELSE NULL
							END
						)
					WHERE
						c.CharacterID=? AND c.UserID=?
				");
				mysqli_stmt_bind_param($stmt, "iii", $character["health"], $cid, $uid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			mysqli_free_result($result);
		}
		return array(
			"character" => $character,
			"enemies" => $enemies,
			"cts" => $cts
		);
	}
	
	$cid = 1;
	$c = connect();
	echo json_encode(moveEnemy($c, $cid, $USER));
	close($c);
	
	class LocationPQ extends SplPriorityQueue { 
	
		private $goal;
		
		public function __construct($location) {
			$this->goal = $location;
		}
		
		public function compare($location1, $location2) { 
			return $this->distance($location1) - $this->distance($location2);
		} 
		
		public function distance($location) {
			return (ROOM_COLUMNS * ROOM_ROWS) - (abs($location["column"] - $this->goal["column"]) + abs($location["row"] - $this->goal["row"]));
		}
	}

	function getNextMove($tiles, $start, $end) {
		$pq = new LocationPQ($end);
		$pq->insert($start, $start);
		while(!$pq->isEmpty()) {
			$current = $pq->extract();
			$r = $current["row"];
			$c = $current["column"];
			if($r === $end["row"] && $c === $end["column"]) {
				while(!$current["parent"]["id"]) {
					$current = $current["parent"];
				}
				return $current;
			}
			if(!$visited[$r + 1][$c] && !$tiles[$r + 1][$c] && $r + 1 < ROOM_ROWS) {
				$pq->insert(array("row" => $r + 1, "column" => $c, "parent" => $current), array("column" => $c, "row" => $r + 1));
				$visited[$r + 1][$c] = 1;
			}
			if(!$visited[$r - 1][$c] && !$tiles[$r - 1][$c] && $r - 1 >= 0) {
				$pq->insert(array("row" => $r - 1, "column" => $c, "parent" => $current), array("column" => $c, "row" => $r - 1));
				$visited[$r - 1][$c] = 1;
			}
			if(!$visited[$r][$c + 1] && !$tiles[$r][$c + 1] && $c + 1 < ROOM_COLUMNS) {
				$pq->insert(array("row" => $r, "column" => $c + 1, "parent" => $current), array("column" => $c + 1, "row" => $r));
				$visited[$r][$c + 1] = 1;
			}
			if(!$visited[$r][$c - 1] && !$tiles[$r][$c - 1] && $c - 1 >= 0) {
				$pq->insert(array("row" => $r, "column" => $c - 1, "parent" => $current), array("column" => $c - 1, "row" => $r));
				$visited[$r][$c - 1] = 1;
			}
		}
	}
?>