<?php
	require "../admin/db.php";

	function getSkillMapping($c, $cid, $uid) {
		$r= array(null, null, null, null, null, null, null, null, null, null);
		$stmt = mysqli_prepare($c, "
			SELECT
				cs.CharacterSkillIndex,
				cs.SkillID
			FROM 
				`Character`	as c
			INNER JOIN
				CharacterSkill as cs
			ON
				c.CharacterID=cs.CharacterID
			WHERE
				c.CharacterID=? AND c.UserID=? AND cs.CharacterSkillIndex IS NOT NULL			
		");
		mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
		mysqli_stmt_bind_result($stmt, $index, $sid);
		mysqli_stmt_execute($stmt);
		while(mysqli_stmt_fetch($stmt)) {
			$r[($index + 9) % 10] = $sid;
		}
		mysqli_stmt_close($stmt);
		return $r;
	}
	
	
	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getSkillMapping($c, $cid, $USER));
	close($c);
?>