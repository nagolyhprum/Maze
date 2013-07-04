<?php
	require "../admin/db.php";
	require "getSkill.php";

	function getAllSkills($c, $cid, $uid) {
		$table = mysqli_query($c, "SELECT SkillID FROM Skill");
		if($table) {
			while($row = mysqli_fetch_assoc($table)) {
				$r[] = $row["SkillID"];
			}
			mysqli_free_result($table);
		}
		for($i = 0; $i < count($r); $i++) {
			$r[$i] = getSkill($c, $r[$i], $cid, $uid);
		}
		return $r;
	}
	
	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getAllSkills($c, $cid, $USER));
	close($c);
?>