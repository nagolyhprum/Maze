<?php
	require_once("../admin/db.php");

	function getCharacter($c, $cid, $uid) {
		$character = array();
		//get image and name
		$stmt = mysqli_prepare($c, "
			SELECT
				c.CharacterName,
				i.ImageName,
				c.CharacterIsMale,
				c.CharacterDirection
			FROM
				`Character` as c
			INNER JOIN
				Image as i
			ON
				c.CharacterPortrait=i.ImageID
			WHERE 
				c.CharacterID=? AND c.UserID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $character["name"], $character["portrait"], $isMale, $character["direction"]["row"]);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		//get sounds
		$stmt = mysqli_prepare($c, "
			SELECT
				a.AudioName,
				at.AttackTypeName
			FROM
				CharacterAudio as ca
			INNER JOIN
				Audio as a
			ON
				ca.AudioID=a.AudioID
			INNER JOIN
				AttackType as at
			ON
				at.AttackTypeID=ca.AttackTypeID
			WHERE 
				ca.CharacterAudioIsMale=?
		");
		mysqli_stmt_bind_param($stmt, "i", $isMale);
		mysqli_stmt_bind_result($stmt, $audio, $attacktype);
		mysqli_stmt_execute($stmt);
		$sounds = array();
		while(mysqli_stmt_fetch($stmt)) {
			if(!$sounds[$attacktype]) {
				$sounds[$attacktype] = array();
			}
			$sounds[$attacktype][] = $audio;
		}
		mysqli_stmt_close($stmt);
		$character["sounds"] = $sounds;
		//statistics		
		$stmt = mysqli_prepare($c, "
			SELECT
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
				`Character` as c
			INNER JOIN
				Statistic as currs
			ON
				currs.StatisticID=c.CharacterCurrentStatisticID
			INNER JOIN
				Statistic as maxs
			ON
				maxs.StatisticID=c.CharacterCurrentStatisticID
			WHERE 
				c.CharacterID=? AND c.UserID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		$statistics = array();
		mysqli_stmt_bind_result($stmt, 
			$statistics["health"]["current"], 
			$statistics["energy"]["current"], 
			$statistics["strength"]["current"], 
			$statistics["defense"]["current"], 
			$statistics["intelligence"]["current"], 
			$statistics["resistance"]["current"], 
			$statistics["speed"]["current"], 
			$statistics["experience"]["current"], 
			$statistics["health"]["max"], 
			$statistics["energy"]["max"], 
			$statistics["strength"]["max"], 
			$statistics["defense"]["max"], 
			$statistics["intelligence"]["max"], 
			$statistics["resistance"]["max"], 
			$statistics["speed"]["max"], 
			$statistics["experience"]["max"]);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		$character["statistics"] = $statistics;
		$stmt = mysqli_prepare($c, "
			SELECT
				cic.CharacterImageChoiceRows,
				cic.CharacterImageChoiceColumns,				
				at.AttackTypeName,
				i.ImageName
			FROM
				`Character` as c
			INNER JOIN
				CharacterImage as ci
			ON
				c.CharacterID=ci.CharacterID
			INNER JOIN
				CharacterImageChoiceGroup as cicg
			ON
				ci.CharacterImageChoiceGroupID=cicg.CharacterImageChoiceGroupID
			INNER JOIN
				CharacterImageChoice as cic
			ON
				cicg.CharacterImageChoiceGroupID=cic.CharacterImageChoiceGroupID
			INNER JOIN
				AttackType as at
			ON
				at.AttackTypeID=cic.AttackTypeID
			INNER JOIN
				Image as i
			ON
				cic.ImageID=i.ImageID
			WHERE
				c.CharacterID=? AND c.UserID=?
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);		
		mysqli_stmt_bind_result($stmt, $rows, $columns, $attacktype, $image);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			if(!$character[$attacktype]) {
				$character[$attacktype] = array();
			}
			$character[$attacktype][] = array(
				"columns" => $columns,
				"rows" => $rows,
				"src" => $image
			);
		}
		mysqli_stmt_close($stmt);
		return $character;
	}
	
	$cid = 1;
	$c = connect();
	echo json_encode(getCharacter($c, $cid, $USER));
	close($c);
?>