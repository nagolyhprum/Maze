<?php
	require_once("../admin/db.php");

	function getCharacter($c, $cid, $uid) {
		mysqli_multi_query($c, "CALL getCharacter(" . mysqli_real_escape_string($c, $cid) . ", " . mysqli_real_escape_string($c, $uid) . ")");
		if($result = mysqli_store_result($c)) {
			$r = mysqli_fetch_assoc($result);
			$character["name"] = $r["CharacterName"]; 
			$character["portrait"] = $r["ImageName"];			
			$character["display"]["row"] = (int) $r["CharacterDirection"];
			$character["location"] = array("row" => (int) $r["CharacterRow"], "column" => (int) $r["CharacterColumn"]);
			$character["statistics"] = $statistics;
			mysqli_free_result($result);
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				$character["statistics"][$r["StatisticNameValue"]]["current"] = $r["StatisticAttributeValue"];
			}
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {
				$character["statistics"][$r["StatisticNameValue"]]["max"] = $r["StatisticAttributeValue"];
			}
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {
			while($r = mysqli_fetch_assoc($result)) {				
				$sounds[$r["AttackTypeName"]][] = $r["AudioName"];
			}
			$character["sounds"] = $sounds;
			mysqli_free_result($result);
		}
		mysqli_next_result($c);
		if($result = mysqli_store_result($c)) {			
			while($r = mysqli_fetch_assoc($result)) {				
				$character[$r["AttackTypeName"]][] = array(
					"columns" => (int) $r["CharacterImageChoiceColumns"],
					"rows" => (int) $r["CharacterImageChoiceRows"],
					"src" => $r["ImageName"]
				);
			}
			mysqli_free_result($result);
		}
		return $character;
	}
	
	$cid = $_GET["cid"];
	$c = connect();
	echo json_encode(getCharacter($c, $cid, $USER));
	close($c);
?>