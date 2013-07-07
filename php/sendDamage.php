<?php
	
	require_once("../admin/db.php");
	
	require_once "classes/DAO.php";
	
	
	$index = (int)$_GET["index"];
	$direction = (int)$_GET["direction"];
	$direction = max(min((int)$direction, 3), 0);
	
	if(DB::connect()) {
		$character = new Character();
		if($character->isValid()) {
			$now = currentTimeMillis();
			if($character->CharacterCanUse <= $now) {
				$area = $at = $success = 1;
				$mainhand = new DAO("ItemType", "ItemTypeName='mainhand'");
				$left = new DAO("ItemInEquipment", "CharacterID=@0 AND ItemTypeID=@1 LIMIT 0, 1", array($character->CharacterID, $mainhand->ItemTypeID));
				if($left->ItemID) {
					$im = $left->getOne("Item")->getOne("ItemModel");
					$area = $im->ItemModelArea;
					$at = $im->getOne("AttackType")->AttackTypeName;
				}
				$right = new DAO("ItemInEquipment", "CharacterID=@0 AND ItemTypeID=@1 LIMIT 1, 1", array($character->CharacterID, $mainhand->ItemTypeID));
				if($right->ItemID) {
					$im = $right->getOne("Item")->getOne("ItemModel");
					$area = $area ? $area : $im->ItemModelArea;
					$a = $at ? $at : $im->getOne("AttackType")->AttackTypeName;
				}					
				if($index) {
					$cs = new DAO("CharacterSkill", "CharacterID=@0 AND CharacterSkillIndex=@1", array($character->CharacterID, $index));
					if($cs->isValid() && $cs->CharacterSkillCanUse <= $now) {
						$skill = $cs->getOne("Skill");
						$sat = $skill->getOne("AttackType")->AttackTypeName;
						if(!$sat || $sat === $at) { //TODO MAKE SURE I HAVE ENOUGH ENERGY AND THEN SPEND THAT ENERGY
							$cs->CharacterSkillCanUse += $skill->SkillCooldown;							
							$cs->update();
							//TODO ADD PERMANANT STATISTICS
						} else {
							$success = 0;
						}
					} else {
						$success = 0;
					}
				} 
				if(!$at) {
					$at = "slash";
					$area = 1;
				}
				if($success) {
					$health = new DAO("StatisticName", "StatisticNameValue='health'");
					if($at === "spellcast") {
						$damage = $character->getStatistic("intelligence");
						$sn = new DAO("StatisticName", "StatisticNameValue='resistance'");
					} else {
						$damage = $character->getStatistic("strength");
						$sn = new DAO("StatisticName", "StatisticNameValue='defense'");
					}
					if($area != 0) {
						foreach($character->getOne("Room")->getMany("EnemyInRoom") as $eir) {
							$tiles[$eir->EnemyInRoomRow][$eir->EnemyInRoomColumn] = $eir;
						}					
					}
					if($area > 0) { //straight
						switch($direction) {
							case DIRECTION_UP : 
								getAssultedEnemy($enemies, $tiles, $character->CharacterRow - 1, $character->CharacterColumn, -1, 0, $area);
								break;
							case DIRECTION_LEFT : 
								getAssultedEnemy($enemies, $tiles, $character->CharacterRow, $character->CharacterColumn - 1, 0, -1, $area);
								break;
							case DIRECTION_DOWN : 
								getAssultedEnemy($enemies, $tiles, $character->CharacterRow + 1, $character->CharacterColumn, 1, 0, $area);
								break;
							case DIRECTION_RIGHT : 
								getAssultedEnemy($enemies, $tiles, $character->CharacterRow, $character->CharacterColumn + 1, 0, 1, $area);
								break;
						}
					} else if($area < 0) { //around							
						$area = abs($area);
						getAssultedEnemy($enemies, $tiles, $character->CharacterRow + 1, $character->CharacterColumn, 1, 0, $area);
						getAssultedEnemy($enemies, $tiles, $character->CharacterRow - 1, $character->CharacterColumn, -1, 0, $area);
						getAssultedEnemy($enemies, $tiles, $character->CharacterRow, $character->CharacterColumn + 1, 0, 1, $area);
						getAssultedEnemy($enemies, $tiles, $character->CharacterRow, $character->CharacterColumn - 1, 0, -1, $area);
					}
					$data = array("enemies" => array(), "items" => array());
					for($i = 0; $i < count($enemies); $i++) {
						$eir = $enemies[$i];
						$h = new DAO("StatisticAttribute", "StatisticNameID=@0 AND StatisticID=@1", array($health->StatisticNameID, $eir->StatisticID));
						if($h->StatisticAttributeValue > 0) {
							$dr = new DAO("StatisticAttribute", "StatisticNameID=@0 AND StatisticID=@1", array($sn->StatisticNameID, $eir->StatisticID));
							$d = ceil($damage - $damage * $dr->StatisticAttributeValue / 100);
							$h->StatisticAttributeValue = max(0, $h->StatisticAttributeValue - $d);
							$h->update();
							if($h->StatisticAttributeValue <= 0) {
								$dead[] = $eir;
							}
							$data["enemies"][] = array(
								"id" => $eir->EnemyInRoomID,
								"damage" => $d
							);
						}
					}
					foreach($dead as $eir) {						
						$chance = mt_rand(0, 100);
						$ei = new DAO("EnemyItem", "EnemyID=@0 AND EnemyItemChance > @1 ORDER BY EnemyItemChance ASC LIMIT 1", array($eir->EnemyID, $chance));
						if($ei->isValid()) {
							$i = new DAO("Item");
							$i->ItemModelID = $ei->ItemModelID;
							$i->insert();
							$iir = new DAO("ItemInRoom");
							$iir->ItemID = $i->ItemID;
							$iir->ItemInRoomRow = $eir->EnemyInRoomRow;
							$iir->ItemInRoomColumn = $eir->EnemyInRoomColumn;
							$iir->RoomID = $character->RoomID;
							$iir->insert();
							$data["items"][] = $iir->ItemInRoomID;
						}
					}
					$character->CharacterCanUse += $character->timeToMove();
					$character->update();
					echo json_encode($data);
				}
			}
		}
		DB::close();
	}

	function sendDamage($c, $cid, $uid, $skill, $direction) {
			//do stuff with skills
			mysqli_multi_query($c, "CALL getItemSkillInfo(@cid, @uid, @ind)");
			$result = mysqli_store_result($c);
			$info = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			while(mysqli_more_results($c) && mysqli_next_result($c)) {
				if($extraResult = mysqli_store_result($c)){
					mysqli_free_result($extraResult);
				}
			}
			if($skill && (($info["itemAttack"] === $info["skillAttack"]) || !$info["skillAttack"])) {
				$stmt = mysqli_prepare($c, "
					UPDATE
						`Character` as c
					INNER JOIN
						CharacterSkill as cs						
					ON
						cs.CharacterID=cs.CharacterID
					INNER JOIN
						Skill as s
					ON
						s.SkillID=cs.SkillID
					INNER JOIN
						StatisticAttribute as sa
					ON
						sa.StatisticID=c.CharacterCurrentStatisticID
					INNER JOIN
						StatisticName as sn
					ON
						sn.StatisticNameID=sa.StatisticNameID
					SET
						cs.CharacterSkillCanUse=getCurrentTimeMillis()+s.SkillCooldown,
						sa.StatisticAttributeValue = sa.StatisticAttributeValue - s.SkillEnergy
					WHERE
						c.UserID=? 
							AND 
						c.CharacterID=? 
							AND 
						CharacterSkillIndex=? 
							AND 
						CharacterSkillCanUse <= getCurrentTimeMillis() 
							AND 
						getCharacterCurrentStatistic(c.CharacterCurrentStatisticID, 'energy') >= s.SkillEnergy	
							AND
						sn.StatisticNameValue='energy'
				");				
				mysqli_stmt_bind_param($stmt, "iii", $uid, $cid, $skill);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			} 
			if(!$skill || ($skill && mysqli_affected_rows($c))) {
				$skill = $skill ? $skill : "null";
				mysqli_multi_query($c, "CALL getCharacterEnemyInfo(@cid, @uid)");				
				if($result = mysqli_store_result($c)) {
					if($r = mysqli_fetch_assoc($result)) {
						$character = array(
							"row" => (int)$r["CharacterRow"],
							"column" => (int)$r["CharacterColumn"],
							"direction" => (int)$r["CharacterDirection"],
							"strength" => (int)$r["StatisticStrength"],
							"intelligence" => (int)$r["StatisticIntelligence"],
							"area" => (int)($info["sid"] ? $info["skillArea"] : $info["itemArea"]),
							"attack" => ($info["sid"] ? $info["skillAttack"] : $info["itemAttack"])
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
									getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow - 1, $character->CharacterColumn, -1, 0, $character["area"]);
									break;
								case DIRECTION_LEFT : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow, $character->CharacterColumn - 1, 0, -1, $character["area"]);
									break;
								case DIRECTION_DOWN : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow + 1, $character->CharacterColumn, 1, 0, $character["area"]);
									break;
								case DIRECTION_RIGHT : 
									getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow, $character->CharacterColumn + 1, 0, 1, $character["area"]);
									break;
							}
						} else if($character["area"] < 0) { //around							
							getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow + 1, $character->CharacterColumn, 1, 0, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow - 1, $character->CharacterColumn, -1, 0, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow, $character->CharacterColumn + 1, 0, 1, $character["area"]);
							getAssultedEnemy($enemies["enemies"], $tiles, $character->CharacterRow, $character->CharacterColumn - 1, 0, -1, $character["area"]);
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
			} else { //reset character
			}
			return $return ? $return : array("enemies" => array(), "items" => array());
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
?>