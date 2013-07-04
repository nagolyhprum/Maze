<?php
	function getSkill($c, $sid, $cid, $uid) {
		$stmt = mysqli_prepare($c, "SET @sid = ?, @cid = ?, @uid = ?;");
		mysqli_stmt_bind_param($stmt, "iii", $sid, $cid, $uid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		$result = mysqli_query($c, "
			SELECT
				s.SkillID as id,
				s.SkillName as name,
				s.SkillDescription as description,
				at.AttackTypeName as `action`,
				i.ImageName as image,
				if(s.SkillIsActive, 'active', 'passive') as type,
				s.SkillArea as area,
				(cs.CharacterSkillCanUse <= NOW()) as isCool,
				s.SkillCooldown as cooldown,
				s.SkillEnergy as energy,
				UNIX_TIMESTAMP(cs.CharacterSkillCanUse) - s.SkillCooldown as lastUse
			FROM
				`Character` as c
			INNER JOIN
				CharacterSkill as cs
			ON
				c.CharacterID=cs.CharacterID
			INNER JOIN
				Skill as s
			ON
				s.SkillID=cs.SkillID
			INNER JOIN
				Image as i
			ON
				s.SkillIcon=i.ImageID
			LEFT JOIN
				AttackType as at
			ON
				at.AttackTypeID=s.AttackTypeID
			WHERE 
				s.SkillID=@sid AND c.CharacterID=@cid AND c.UserID=@uid
		");
		if($result) {
			if($row = mysqli_fetch_assoc($result)) {
				$row["image"] = array("icon" => $row["image"]);
				$row["id"] = (int)$row["id"];
				$row["area"] = (int)$row["area"];
				$row["isCool"] = (int)$row["isCool"];
				$row["cooldown"] = (int)$row["cooldown"];
				$row["energy"] = (int)$row["energy"];
			}			
			mysqli_free_result($result);
		}
		return getSkillStatistics($c, $row);
	}
	
	function getSkillStatistics($c, $skill) {
		$add = array();
		$multiply = array();
		$stmt = mysqli_prepare($c, "
			SELECT
				sn.StatisticNameValue,
				sa.StatisticAttributeValue,
				ss.SkillStatisticDuration,
				sa.StatisticID,
				ss.SkillStatisticIsAdd
			FROM
				SkillStatistic as ss
			INNER JOIN
				StatisticAttribute as sa
			ON
				ss.StatisticID=sa.StatisticID
			INNER JOIN
				StatisticName as sn
			ON
				sn.StatisticNameID=sa.StatisticNameID
			WHERE
				ss.SkillID=?
		");
		mysqli_stmt_bind_param($stmt, "i", $skill["id"]);
		mysqli_stmt_bind_result($stmt, $name, $attribute, $duration, $statistic, $isAdd);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			if($isAdd) {
				$add[$statistic][$name] = $attribute;
				$add[$statistic]["duration"] = $duration;
			} else {
				$multiply[$statistic][$name] = $attribute;
				$multiply[$statistic]["duration"] = $duration;
			}			
		}
		moveSkillStatistics("add", $skill, $add);
		moveSkillStatistics("multiply", $skill, $multiply);
		return $skill;
	}
	
	function moveSkillStatistics($value, &$skill, $statistics) {
		$skill[$value] = array();
		foreach($statistics as $s) {
			$r = array("duration" => $s["duration"]);
			unset($s["duration"]);
			foreach($s as $k=>$v) {
				$r[$k] = array(
					"current" => $v,
					"max" => $v
				);
			}
			$skill[$value][] = $r;
		}
	}
?>