<?php
	
	require_once("../admin/db.php");

	function sendDamage($c, $cid, $uid, $skill) {
		$return = null;
		mysqli_autocommit($c, FALSE);
		$stmt = mysqli_prepare($c, "
			UPDATE 
				`Character` as c
			INNER JOIN
				Statistic as s
			ON
				s.StatisticID=c.CharacterCurrentStatisticID
			SET
				c.CharacterCanUse=timeToMove(NOW(), s.StatisticSpeed)
			WHERE
				c.CharacterCanUse <= NOW() AND c.CharacterID=? AND c.UserID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_execute($stmt);
		$count = mysqli_affected_rows($c);
		mysqli_stmt_close($stmt);
		if($count === 1) {
			if($skill) {
				mysqli_commit($c);
				$return = array();
			} else { //weapon
				$stmt = mysqli_prepare($c, "			
					SELECT
						eir.EnemyInRoomRow,
						eir.EnemyInRoomColumn,
						eir.EnemyInRoomID,
						c.CharacterDirection,
						c.CharacterColumn,
						c.CharacterRow,
						cStat.StatisticStrength + IFNULL(
							(
								SELECT 
									sum(s.StatisticStrength)
								FROM 
									ItemInEquipment as iie
								INNER JOIN
									Item as i
								ON
									i.ItemID=iie.ItemID
								INNER JOIN
									ItemModel as im
								ON
									im.ItemModelID=i.ItemModelID
								INNER JOIN 
									Statistic as s
								ON 
									im.StatisticID=s.StatisticID 
								WHERE 
									CharacterID=?
							), 0
						) + IFNULL(
						(
							SELECT 
								sum(s.StatisticStrength)
							FROM
								`Character` as c
							INNER JOIN
								CharacterSkill as cs
							ON
								cs.CharacterID=c.CharacterID
							INNER JOIN
								Skill
							ON
								cs.SkillID=Skill.SkillID
							INNER JOIN
								SkillStatistic as ss
							ON
								Skill.SkillID=ss.SkillID
							INNER JOIN
								Statistic as s
							ON
								ss.StatisticID=s.StatisticID
							WHERE					
								cs.CharacterSkillIndex IS NOT NULL
							AND
							(
									NOT SkillIsActive
								OR 
									(SkillIsActive AND (cs.CharacterSkillIndex=? AND ? IS NOT NULL))
								OR
								(
										SkillIsActive 
									AND 
										ADDTIME(SUBTIME(cs.CharacterSkillCanUse, UNIX_TIMESTAMP(Skill.SkillCoolDown)), UNIX_TIMESTAMP(ss.SkillStatisticDuration)) >= NOW()
								)
							)
						), 0),
						cStat.StatisticIntelligence + IFNULL(
							(
								SELECT 
									sum(s.StatisticIntelligence)
								FROM 
									ItemInEquipment as iie
								INNER JOIN
									Item as i
								ON
									i.ItemID=iie.ItemID
								INNER JOIN
									ItemModel as im
								ON
									im.ItemModelID=i.ItemModelID
								INNER JOIN 
									Statistic as s
								ON 
									im.StatisticID=s.StatisticID 
								WHERE 
									CharacterID=?
							), 0
						) + IFNULL(
						(
							SELECT 
								sum(s.StatisticIntelligence)
							FROM
								`Character` as c
							INNER JOIN
								CharacterSkill as cs
							ON
								cs.CharacterID=c.CharacterID
							INNER JOIN
								Skill
							ON
								cs.SkillID=Skill.SkillID
							INNER JOIN
								SkillStatistic as ss
							ON
								Skill.SkillID=ss.SkillID
							INNER JOIN
								Statistic as s
							ON
								ss.StatisticID=s.StatisticID
							WHERE							
								cs.CharacterSkillIndex IS NOT NULL
							AND
							(
									NOT SkillIsActive
								OR 
									(SkillIsActive AND (cs.CharacterSkillIndex=? AND ? IS NOT NULL))
								OR
								(
										SkillIsActive 
									AND 
										ADDTIME(SUBTIME(cs.CharacterSkillCanUse, UNIX_TIMESTAMP(Skill.SkillCoolDown)), UNIX_TIMESTAMP(ss.SkillStatisticDuration)) >= NOW()
								)
							)
						), 0),
						eStat.StatisticDefense,
						eStat.StatisticResistance,
						im.ItemModelArea
					FROM
						ItemType as it
					INNER JOIN
						ItemModel as im
					ON
						it.ItemTypeID=im.ItemTypeID
					INNER JOIN
						Item as i
					ON
						i.ItemModelID=im.ItemModelID
					INNER JOIN
						ItemInEquipment as iie
					ON
						iie.ItemID=i.ItemID
					RIGHT JOIN
						`Character` as c
					ON
						c.CharacterID=iie.CharacterID
					INNER JOIN
						Statistic as cStat
					ON 
						cStat.StatisticID=c.CharacterCurrentStatisticID
					INNER JOIN
						EnemyInRoom as eir
					ON
						eir.RoomID=c.RoomID
					INNER JOIN
						Statistic as eStat
					ON
						eir.EnemyInRoomStatistics=eStat.StatisticID
					WHERE
						(it.ItemTypeName='mainhand' OR it.ItemTypeName IS NULL) AND c.CharacterID=? AND c.UserID=?
				");
				echo mysqli_error($c);
				mysqli_stmt_bind_param($stmt, "iiiiiiii", $cid, $skill, $skill, $cid, $skill, $skill, $cid, $uid);
				mysqli_stmt_bind_result($stmt, $eRow, $eColumn, $e, $cDirection, $cColumn, $cRow, $cStrength, $cIntelligence, $eDefense, $eResistance, $iArea);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_fetch($stmt)) {
					$character = array(
						"row" => $cRow,
						"column" => $cColumn,
						"direction" => $cDirection,
						"strength" => $cStrength,
						"intelligence" => $cIntelligence,
						"area" => $iArea === null ? 1 : $iArea
					);
					$enemies = array();
					$tiles = array();
					do {
						$tiles[$eRow][$eColumn] = $enemies[] = array(
							"row" => $eRow,
							"column" => $eColumn,
							"defense" => $eDefense,
							"resistance" => $eResistance,
							"id" => $e
						);						
					} while(mysqli_stmt_fetch($stmt));					
				}
				mysqli_stmt_close($stmt);
				mysqli_commit($c);
				$return = array("character" => $character, "enemies" => $enemies, "tiles" => $tiles);
			}
		}
		mysqli_autocommit($c, TRUE);
		return $return;
	}
	
	$cid = 1;
	$skill = 0;
	$c = connect();
	echo json_encode(sendDamage($c, $cid, $USER, $skill));
	close($c);
?>