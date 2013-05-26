<?php
	function endsWith($haystack, $needle) {
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}
		return (substr($haystack, -$length) === $needle);
	}
	function listFolderFiles($dir){
		$r = array();
		$ffs = scandir($dir);
		foreach($ffs as $ff){
			if($ff != '.' && $ff != '..') {
				if(!endsWith($ff, ".DS_Store")) { 
					if(is_dir("$dir/$ff")) {
						$r = array_merge($r, listFolderFiles("$dir/$ff"));
					} else {
						$r[] = "$dir/$ff";
					}
				}
			}
		}
		return $r;
	}	
	$c = mysqli_connect("localhost", "root", "", "worldtactics");
	//image
	$stmt = mysqli_prepare($c, "INSERT INTO Image (ImageName) VALUES (?)");
	mysqli_stmt_bind_param($stmt, "s", $image);
	foreach(listFolderFiles("images") as $image) {
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	//sound
	$stmt = mysqli_prepare($c, "INSERT INTO Audio (AudioName) VALUES (?)");
	mysqli_stmt_bind_param($stmt, "s", $audio);
	foreach(listFolderFiles("audio") as $audio) {
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($c);
?>