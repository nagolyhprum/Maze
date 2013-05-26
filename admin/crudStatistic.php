<?php
	function createStatisticForm($prefix) {
		?>
			<div>
				Health <input type="text" name="<?php echo $prefix; ?>health"/>
			</div>
			<div>
				Energy <input type="text" name="<?php echo $prefix; ?>energy"/>
			</div>
			<div>
				Strength <input type="text" name="<?php echo $prefix; ?>strength"/>
			</div>
			<div>
				Defense <input type="text" name="<?php echo $prefix; ?>defense"/>
			</div>
			<div>
				Intelligence <input type="text" name="<?php echo $prefix; ?>intelligence"/>
			</div>
			<div>
				Resistance <input type="text" name="<?php echo $prefix; ?>resistance"/>				
			</div>
		<?php
	}
	
	function createStatistic($c, $prefix) {
		$stmt = mysqli_prepare($c, "INSERT INTO Statistic (StatisticHealth, StatisticEnergy, StatisticStrength, StatisticDefense, StatisticIntelligence, StatisticResistance) VALUES (?, ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt, "iiiiii", $_REQUEST[$prefix . "health"], $_REQUEST[$prefix . "energy"], $_REQUEST[$prefix . "strength"], $_REQUEST[$prefix . "defense"], $_REQUEST[$prefix . "intelligence"], $_REQUEST[$prefix . "resistance"]);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return mysqli_insert_id($c);
	}
	
	function updateStatisticForm($obj, $prefix) {
		?>
		<form method="post" action="./">
			<input type="hidden" name="id" value="<?php echo $obj["id"]; ?>"/>
			<div>
				Health <input type="text" name="<?php echo $prefix; ?>health" value="<?php echo $obj["health"]; ?>"/>
			</div>
			<div>
				Energy <input type="text" name="<?php echo $prefix; ?>energy" value="<?php echo $obj["energy"]; ?>"/>
			</div>
			<div>
				Strength <input type="text" name="<?php echo $prefix; ?>strength" value="<?php echo $obj["strength"]; ?>"/>
			</div>
			<div>
				Defense <input type="text" name="<?php echo $prefix; ?>defense" value="<?php echo $obj["defense"]; ?>"/>
			</div>
			<div>
				Intelligence <input type="text" name="<?php echo $prefix; ?>intelligence" value="<?php echo $obj["intelligence"]; ?>"/>
			</div>
			<div>
				Resistance <input type="text" name="<?php echo $prefix; ?>resistance" value="<?php echo $obj["resistance"]; ?>"/>				
			</div>
			<input type="submit" value="Update Statistic"/>
		</form>
		<?php
	}
	
	function updateStatistic($c, $prefix) {
		$stmt = mysqli_prepare($c, "UPDATE Statistic SET StatisticHealth=?, StatisticEnergy=?, StatisticStrength=?, StatisticDefense=?, StatisticIntelligence=?, StatisticResistance=? WHERE StatisticID=?");
		mysqli_stmt_bind_param($stmt, "iiiiiii", $_REQUEST["health"], $_REQUEST["energy"], $_REQUEST["strength"], $_REQUEST["defense"], $_REQUEST["intelligence"], $_REQUEST["resistance"], $_REQUEST["id"]);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
?>