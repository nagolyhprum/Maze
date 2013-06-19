<?php
	require_once("../admin/db.php");

	function sendDamage($c, $cid, $uid, $skill) {
		if($skill) {
			$stmt = mysqli_prepare($c, "");
		} else { //weapon
			$stmt = mysqli_prepare($c, "			
				SELECT
					eir.EnemyInRoomRow,
					eir.EnemyInRoomColumn,
					eir.EnemyInRoomID,
					c.CharacterDirection,
					c.CharacterColumn,
					c.CharacterRow,
					cStat.StatisticStrength,
					cStat.StatisticIntelligence,
					eStat.StatisticDefense,
					eStat.StatisticResistance
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
			mysqli_stmt_execute($stmt);
			echo mysqli_affected_rows($c);
			mysqli_stmt_close($stmt);
		}
	}
	
	$cid = $_GET["cid"];
	$skill = $_GET["skill"];
	$c = connect();
	json_encode(sendDamage($c, $cid, $USER, $skill));
	close($c);
?>