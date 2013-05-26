<?php
	function connect() {
		return mysqli_connect("localhost", "root", "", "worldtactics");
	}
	
	function close($c) {
		mysqli_close($c);
	}
?>