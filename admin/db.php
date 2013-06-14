<?php
	function connect() {
		return mysqli_connect("localhost", "root", "", "worldtactics");
	}
	
	function close($c) {
		mysqli_close($c);
	}
	
	define("NONE", 0);
	define("UP", 1);
	define("RIGHT", 2);
	define("DOWN", 4);
	define("LEFT", 8);
	define("ALL", 15);
	$USER = 1;
	$COLUMNS = 7;
	$ROWS = 7;
?>