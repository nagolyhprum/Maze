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
				AttackTypeName
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
			WHERE
				c.UserID=? AND c.CharacterID=? AND getStatistic(eir.EnemyInRoomStatistics, 'health') > 0");		
		mysqli_stmt_bind_result($stmt, $id, $column, $row, $direction, $name, $attackstyle);
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
				)
			);
		}
		mysqli_stmt_close($stmt);
		//get current statistics
		$stmt = mysqli_prepare($c, "
			SELECT
				sn.StatisticNameValue,
				IFNULL(sa.StatisticAttributeValue, 0)
			FROM
				StatisticAttribute as sa
			INNER JOIN
				EnemyInRoom as eir
			ON
				eir.EnemyInRoomStatistics=sa.StatisticID				
			RIGHT JOIN			
				StatisticName as sn
			ON
				sn.StatisticNameID=sa.StatisticNameID
			WHERE 
				eir.EnemyInRoomID=? OR eir.EnemyInRoomID IS NULL
		");
		mysqli_stmt_bind_param($stmt, "i", $eirid);
		mysqli_stmt_bind_result($stmt, $name, $attr);
		for($i = 0; $i < count($enemies); $i++) {
			$eirid = $enemies[$i]["id"];
			mysqli_stmt_execute($stmt);
			while(mysqli_stmt_fetch($stmt)) {	
				$statistics[$name]["current"] = $attr;
			}
			$enemies[$i]["statistics"] = $statistics;
		}
		mysqli_stmt_close($stmt);
		//get max statistics
		$stmt = mysqli_prepare($c, "
			SELECT
				sn.StatisticNameValue,
				IFNULL(sa.StatisticAttributeValue, 0)
			FROM
				EnemyInRoom as eir
			INNER JOIN
				Enemy as e
			ON
				eir.EnemyID=e.EnemyID
			INNER JOIN
				StatisticAttribute as sa
			ON
				sa.StatisticID=e.StatisticID
			RIGHT JOIN
				StatisticName as sn
			ON
				sn.StatisticNameID=sa.StatisticNameID
			WHERE 
				eir.EnemyInRoomID=? OR eir.EnemyInRoomID IS NULL
		");
		mysqli_stmt_bind_param($stmt, "i", $eirid);
		mysqli_stmt_bind_result($stmt, $name, $attr);
		for($i = 0; $i < count($enemies); $i++) {
			$eirid = $enemies[$i]["id"];
			mysqli_stmt_execute($stmt);
			$statistics = $enemies[$i]["statistics"];
			while(mysqli_stmt_fetch($stmt)) {	
				$statistics[$name]["max"] = $attr;
			}
			$enemies[$i]["statistics"] = $statistics;
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