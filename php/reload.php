<?php
	function reload($from) {
		$from->send(json_encode(array(
			"action" => "Reload"
		)));
	}
?>