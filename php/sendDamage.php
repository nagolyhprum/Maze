<?php
	
	require_once("../admin/db.php");

	function sendDamage($c, $cid, $uid, $skill, $direction) {
		$return = null;
		$stmt = mysqli_prepare($c, "
			UPDATE 
				`Character` as c
			INNER JOIN
				Statistic as s
			ON
				s.StatisticID=c.CharacterCurrentStatisticID
			SET
				c.CharacterCanUse=timeToMove(NOW(), s.StatisticSpeed),
				c.CharacterDirection = ?
			WHERE
				c.CharacterCanUse <= NOW() AND c.CharacterID=? AND c.UserID=?
		");
		$direction = max(min((int)$direction, 3), 0);
		mysqli_stmt_bind_param($stmt, "iii", $direction, $cid, $uid);
		mysqli_stmt_execute($stmt);
		$count = mysqli_affected_rows($c);
		mysqli_stmt_close($stmt);
		if($count === 1) {
			if($skill) {
				$return = array();
			} else { //weapon
				$skill = $skill ? $skill : "null";
				mysqli_multi_query($c, "CALL getCharacterAssultInfo(" . mysqli_real_escape_string($c, $cid) . ", " . mysqli_real_escape_string($c, $uid) . ", " . mysqli_real_escape_string($c, $skill) . ")");
				if($result = mysqli_store_result($c)) {
					if($r = mysqli_fetch_assoc($result)) {
						$character = array(
							"row" => (int)$r["CharacterRow"],
							"column" => (int)$r["CharacterColumn"],
							"direction" => (int)$r["CharacterDirection"],
							"strength" => (int)$r["StatisticStrength"],
							"intelligence" => (int)$r["StatisticIntelligence"],
							"area" => (int)$r["ItemModelArea"],
							"attack" => $r["AttackTypeName"]
						);
						do {
							$tiles[$r["EnemyInRoomRow"]][$r["EnemyInRoomColumn"]] = array(
								"health" => (int)$r["StatisticHealth"],
								"row" => (int)$r["EnemyInRoomRow"],
								"column" => (int)$r["EnemyInRoomColumn"],
								"defense" => (int)$r["StatisticDefense"],
								"resistance" => (int)$r["StatisticResistance"],
								"id" => (int)$r["EnemyInRoomID"]
							);						
						} while($r = mysqli_fetch_assoc($result));	
						mysqli_free_result($result);
						
						while(mysqli_more_results($c) && mysqli_next_result($c)) {
							if($extraResult = mysqli_store_result($c)){
								mysqli_free_result($extraResult);
							}
						}
						if($character["area"] > 0) { //straight
							switch($character["direction"]) {
								case DIRECTION_UP : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character["row"] - 1, $character["column"], -1, 0, $character["area"]);
									break;
								case DIRECTION_LEFT : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character["row"], $character["column"] - 1, 0, -1, $character["area"]);
									break;
								case DIRECTION_DOWN : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character["row"] + 1, $character["column"], 1, 0, $character["area"]);
									break;
								case DIRECTION_RIGHT : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character["row"], $character["column"] + 1, 0, 1, $character["area"]);
									break;
							}
						} else if($character["area"] < 0) { //around							
							getAssultedEnemy($enemies["enemies"], $tiles, $character["row"] + 1, $character["column"], 1, 0, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character["row"] - 1, $character["column"], -1, 0, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character["row"], $character["column"] + 1, 0, 1, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character["row"], $character["column"] - 1, 0, -1, $character["area"]);
						}
						if(count($enemies["enemies"])) {
							$stmt = mysqli_prepare($c, "call damageEnemy(?, ?)");
							mysqli_stmt_bind_param($stmt, "ii", $eid, $damage);
							for($i = 0; $i < count($enemies["enemies"]); $i++) {
								$e = $enemies["enemies"][$i];
								$eid = $e["id"];
								if($character["attack"] === "spellcast") {
									$damage = max(0, ceil($character["intelligence"] - $character["intelligence"] * ($e["resistance"] / 100)));
								} else {		
									$damage = max(0, ceil($character["strength"] - $character["strength"] * ($e["defense"] / 100)));						
								}
								$enemies["enemies"][$i]["damage"] = $damage;
								if($enemies["enemies"][$i]["health"] <= $damage) {
									$dead[] = $enemies["enemies"][$i];
								}
								mysqli_stmt_execute($stmt);
							}
							mysqli_stmt_close($stmt);
						}
						if(count($dead)) {
							$stmt = mysqli_prepare($c, "SELECT dropItem(?);");
							mysqli_stmt_bind_param($stmt, "i", $eid);
							mysqli_stmt_bind_result($stmt, $iid);
							for($i = 0; $i < count($dead); $i++) {
								$eid = $dead[$i]["id"];								
								mysqli_stmt_execute($stmt);
								if(mysqli_stmt_fetch($stmt)) {
									$enemies["items"][] = $iid;
								}
							}
							mysqli_stmt_close($stmt);						
						}
					}
					$return = $enemies;
				}
			}
		}
		return $return ? $return : array();
	}
	
	function getAssultedEnemy(&$enemies, $tiles, $row, $column, $moveRow, $moveColumn, $area) {	
		while($row >= 0 && $row < ROOM_ROWS && $column >= 0 && $column < ROOM_COLUMNS && $area > 0) {
			if($tiles[$row][$column]) {
				$enemies[] = $tiles[$row][$column];
				return;
			}
			$row += $moveRow;
			$column += $moveColumn;
			$area--;
		}
	}
	
	$cid = $_GET["cid"];
	$skill = $_GET["skill"];
	$direction = $_GET["direction"];
	$c = connect();
	echo json_encode(sendDamage($c, $cid, $USER, $skill, $direction));
	close($c);
?>