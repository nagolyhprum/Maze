<?php
	function getNameID($c, $table) {
		if($c) {
			$r = array();
			$stmt = mysqli_prepare($c, "SELECT ". $table. "Name, " . $table . "ID FROM `" . $table . "`");
			mysqli_stmt_bind_result($stmt, $name, $id);
			mysqli_stmt_execute($stmt);
			while(mysqli_stmt_fetch($stmt)) {
				$r[] = array(
					"name" => $name,
					"id" => $id
				);
			}
			mysqli_stmt_close($stmt);
			return $r;
		}
	}
	
	function asOptions($r, $value) {
		echo "<option></option>";
		foreach($r as $i) {
			echo "<option";
			if($i["id"] == $value) {
				echo " selected";
			}
			echo " value=$i[id]>$i[name]</option>";
		}
	}
?>