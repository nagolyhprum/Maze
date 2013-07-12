<?php
	function getTiles() {
		for($i = 0; $i < ROOM_ROWS; $i++) {
			for($j = 0; $j < ROOM_COLUMNS; $j++) {
				$r[$i][$j]  = array(
					"row" => 11,
					"column" => 0
				);
			}
		}
		return json_encode(array(
			"args" => $r,
			"action" => "GetTiles"
		));
	}
?>