<?php
	require_once("../admin/db.php");

	function getRoomEnemies($c, $uid, $cid) {
		//get primary enemy statistics
		$stmt = mysqli_prepare($c, "
			SELECT 
				EnemyInRoomID,
				EnemyInRoomColumn,
				EnemyInRoomRow,
				EnemyInRoomDirection,
				EnemyName,
				AttackTypeName,
				currs.StatisticHealth,
				currs.StatisticEnergy,
				currs.StatisticStrength,
				currs.StatisticDefense,
				currs.StatisticIntelligence,
				currs.StatisticResistance,
				currs.StatisticSpeed,
				currs.StatisticExperience,
				maxs.StatisticHealth,
				maxs.StatisticEnergy,
				maxs.StatisticStrength,
				maxs.StatisticDefense,
				maxs.StatisticIntelligence,
				maxs.StatisticResistance,
				maxs.StatisticSpeed,
				maxs.StatisticExperience
			FROM
				EnemyInRoom as eir
			INNER JOIN
				`Character` as c
			ON
				c.RoomID=eir.RoomID
			INNER JOIN
				Enemy as e
			ON
				e.EnemyID=eir.EnemyID
			INNER JOIN
				AttackType as at
			ON
				e.AttackTypeID=at.AttackTypeID
			INNER JOIN
				Statistic as currs
			ON
				eir.EnemyInRoomStatistics=currs.StatisticID
			INNER JOIN
				Statistic as maxs
			ON
				e.StatisticID=maxs.StatisticID
			WHERE
				c.UserID=? AND c.CharacterID=? AND currs.StatisticHealth>0");		
		mysqli_stmt_bind_result($stmt, 
			$id, 
			$column, 
			$row, 
			$direction, 
			$name, 
			$attackstyle,
			$current["health"], 
			$current["energy"], 
			$current["strength"], 
			$current["defense"], 
			$current["intelligence"], 
			$current["resistance"], 
			$current["speed"], 
			$current["experience"], 
			$max["health"], 
			$max["energy"], 
			$max["strength"], 
			$max["defense"], 
			$max["intelligence"], 
			$max["resistance"], 
			$max["speed"], 
			$max["experience"]);
		mysqli_stmt_bind_param($stmt, "ii", $uid, $cid);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			$enemies[] = array(
				"id" => $id,
				"name" => $name,
				"attackstyle" => $attackstyle,
				"location" => array(
					"column" => $column,
					"row" => $row
				),
				"display" => array(
					"row" => $direction
				),
				"statistics" => array(
					"strength" => array(
						"current" => $current["strength"],
						"max" => $max["strength"]
					),
					"defense" => array(
						"current" => $current["defense"],
						"max" => $max["defense"]
					),
					"intelligence" => array(
						"current" => $current["intelligence"],
						"max" => $max["intelligence"]
					),
					"resistance" => array(
						"current" => $current["resistance"],
						"max" => $max["resistance"]
					),
					"health" => array(
						"current" => $current["health"],
						"max" => $max["health"]
					),
					"energy" => array(
						"current" => $current["energy"],
						"max" => $max["energy"]
					),
					"speed" => array(
						"current" => $current["speed"],
						"max" => $max["speed"]
					),
					"experience" => array(
						"current" => $current["experience"],
						"max" => $max["experience"]
					)
				)
			);
		}
		mysqli_stmt_close($stmt);
		//get images
		$stmt = mysqli_prepare($c, "
			SELECT
				ei.EnemyImageColumns,
				ei.EnemyImageRows,
				i.ImageName,
				at.AttackTypeName
			FROM
				EnemyInRoom as eir
			INNER JOIN
				EnemyImage as ei
			ON
				eir.EnemyID=ei.EnemyID
			INNER JOIN
				Image as i
			ON 
				i.ImageID=ei.ImageID
			INNER JOIN
				AttackType as at
			ON
				ei.AttackTypeID=at.AttackTypeID
			WHERE
				eir.EnemyInRoomID=?");
		mysqli_stmt_bind_param($stmt, "i", $eirid);
		mysqli_stmt_bind_result($stmt, $columns, $rows, $image, $attacktype);
		for($i = 0; $i < count($enemies); $i++) {
			$eirid = $enemies[$i]["id"];
			mysqli_execute($stmt);		
			while(mysqli_stmt_fetch($stmt)) {
				$enemies[$i][$attacktype][] = array(
					"columns" => $columns,
					"rows" => $rows,
					"src" => $image
				);
			}
		}
		mysqli_stmt_close($stmt);
		//get enemy audio
		$stmt = mysqli_prepare($c, "
		SELECT
			AudioName,
			AttackTypeName
		FROM
			Audio as a
		INNER JOIN
			EnemyAudio as ea
		ON 
			ea.AudioID=a.AudioID
		INNER JOIN
			EnemyInRoom as eir
		ON 
			eir.EnemyID=ea.EnemyID
		INNER JOIN
			AttackType as at
		ON
			at.AttackTypeID=ea.AttackTypeID
		WHERE
			eir.EnemyInRoomID=?");
		mysqli_stmt_bind_param($stmt, "i", $eirid);
		mysqli_stmt_bind_result($stmt, $audio, $attacktype);
		for($i = 0; $i < count($enemies); $i++) {
			$eirid = $enemies[$i]["id"];
			mysqli_stmt_execute($stmt);
			while(mysqli_stmt_fetch($stmt)) {
				$enemies[$i]["sounds"][$attacktype][] = $audio;
			}
		}
		mysqli_stmt_close($stmt);
		return $enemies ? $enemies : array();
	}
	
	$cid = 1;
	$c = connect();
	echo json_encode(getRoomEnemies($c, $USER, $cid));
	close($c);
?>