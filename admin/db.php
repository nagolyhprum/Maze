<?php
	function connect() {
		$c = mysqli_connect("localhost", "root", "root", "worldtactics");
		echo mysqli_error($c);
		return $c;
	}
	
	function close($c) {
		mysqli_close($c);
	}
	//WALLS
	define("WALL_NONE", 0);
	define("WALL_UP", 1);
	define("WALL_RIGHT", 2);
	define("WALL_DOWN", 4);
	define("WALL_LEFT", 8);
	define("WALL_ALL", 15);
	//DIRECTIONS
	define("DIRECTION_UP", 0);
	define("DIRECTION_RIGHT", 3);
	define("DIRECTION_DOWN", 2);
	define("DIRECTION_LEFT", 1);
	//ROOM	
	define("ROOM_ROWS", 7);
	define("ROOM_COLUMNS", 7);
	//USER
	$USER = 1;
?>