<?php
	
	require_once("../admin/db.php");
	
	require_once "classes/DAO.php";
	
	function sendDamage($character, $args, $from) {
		$data = array("enemies" => array());
		$index = (int)$args["index"];
		$direction = (int)$args["direction"];
		$direction = max(min((int)$direction, 3), 0);
		$now = currentTimeMillis();
		if($character->CharacterCanUse <= $now) {
			$area = $success = 1;
			$at = 0;
			$mainhand = new DAO("ItemType", "ItemTypeName='mainhand'");
			$left = new DAO("ItemInEquipment", "CharacterID=? AND ItemTypeID=? LIMIT 0, 1", array($character->CharacterID, $mainhand->ItemTypeID));
			if($left->ItemID) {
				$im = $left->getOne("Item")->getOne("ItemModel");
				$area = $im->ItemModelArea;
				$at = $im->getOne("AttackType")->AttackTypeName;
			}
			$right = new DAO("ItemInEquipment", "CharacterID=? AND ItemTypeID=? LIMIT 1, 1", array($character->CharacterID, $mainhand->ItemTypeID));
			if($right->ItemID) {
				$im = $right->getOne("Item")->getOne("ItemModel");
				$area = $area ? $area : $im->ItemModelArea;
				$a = $at ? $at : $im->getOne("AttackType")->AttackTypeName;
			}		
			if(is_numeric($args["index"])) {
				$cs = new DAO("CharacterSkill", "CharacterID=? AND CharacterSkillIndex=? AND CharacterSkillCanUse <= ?", array($character->CharacterID, $index, $now));
				if($cs->valid()) {
					$skill = $cs->getOne("Skill");
					$sat = $skill->getOne("AttackType")->AttackTypeName;
					if((!$sat || $sat == $at) && $skill->SkillIsActive && $skill->SkillEnergy <= $character->getStatistic("energy", $now)) {
						$cs->CharacterSkillCanUse = $now + $skill->SkillCooldown;							
						$cs->CharacterSkillUsedAt = $now;
						$cs->update();
						$energy = new DAO("StatisticName", "StatisticNameValue='energy'");							
						$e = new DAO("StatisticAttribute", "StatisticID=? AND StatisticNameID=?", array($character->CharacterCurrentStatisticID, $energy->StatisticNameID));
						$e->StatisticAttributeValue -= $skill->SkillEnergy;
						$e->update();
						DB::flush();
						//permanant skills
						$csas = $character->getOne("Statistic", "CharacterCurrentStatisticID")->getMany("StatisticAttribute");							
						foreach($skill->getMany("SkillStatistic") as $ss) {
							if($ss->SkillStatisticDuration == -1) {
								foreach($ss->getMany("StatisticAttribute", "StatisticID") as $sa) {
									foreach($csas as $csa) {
										if($csa->StatisticNameID == $sa->StatisticNameID) {
											$max = new DAO("StatisticAttribute", "StatisticID=? AND StatisticNameID=?", array($character->CharacterMaxStatisticID, $csa->StatisticNameID)); //max
											$csa->StatisticAttributeValue = min($csa->StatisticAttributeValue + $sa->StatisticAttributeValue, $max->StatisticAttributeValue);												
											$csas->write($csa);
											$changed = 1;
										}
									}
								}
							}
						}
						if($changed) {
							$csas->update();
						}
						$success = 1;
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
					$damage = $character->getStatistic("intelligence", $now);
					$sn = new DAO("StatisticName", "StatisticNameValue='resistance'");
				} else {
					$damage = $character->getStatistic("strength", $now);
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
				$dead = array();
				for($i = 0; $i < count($enemies); $i++) {
					$eir = $enemies[$i];
					$h = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($health->StatisticNameID, $eir->StatisticID));
					if($h->StatisticAttributeValue > 0) {
						$dr = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($sn->StatisticNameID, $eir->StatisticID));
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
					$ei = new DAO("EnemyItem", "EnemyID=? AND EnemyItemChance > ? ORDER BY EnemyItemChance ASC LIMIT 1", array($eir->EnemyID, $chance));
					if($ei->valid()) {
						$i = new DAO("Item");
						$i->ItemModelID = $ei->ItemModelID;
						$i->insert(true);
						$iir = new DAO("ItemInRoom");
						$iir->ItemID = $i->ItemID;
						$iir->ItemInRoomRow = $eir->EnemyInRoomRow;
						$iir->ItemInRoomColumn = $eir->EnemyInRoomColumn;
						$iir->RoomID = $character->RoomID;
						$iir->insert();
						getItemsInRoom($character, $from);
					}
				}
				$character->CharacterCanUse = $now + $character->timeToMove($now);
				$character->CharacterUsedAt = $now;
				$character->update();
			}
		}
		$from->send(json_encode(array(
			"args" => $data,
			"action" => "DamageEnemies"
		)));
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