<?php
	function createStatisticForm($c, $prefix) {	
		if($table = mysqli_query($c, "SELECT StatisticNameValue, StatisticNameID FROM StatisticName")) {
			while($row = mysqli_fetch_assoc($table)) {
			?>
			<div>
				<?php echo $row["StatisticName"]; ?> 
				<input type="text" name="<?php echo $prefix . "_" . $row["StatisticName"] . "_" . $row["StatisticNameID"]; ?>"/>
			</div>
			<?php
			}
		}
	}
	
	function createStatistic($c, $prefix) {
		mysqli_query($c, "INSERT INTO Statistic (StatisticIsActive) VALUES (1)");
		$statistic = mysqli_insert_id($c);
		$stmt = mysqli_prepare($c, "INSERT INTO StatisticAttribute (StatisticID, StatisticAttributeValue, StatisticNameID) VALUES (?, ?, ?)");
		mysqli_stmt_bind_param($c, "iii", $statistic, $value, $name);
		foreach($_REQUEST as $key => $value) {
			$r = explode($key, "_");
			if(count($r) === 3 && $r[0] === $prefix) {
				$name = $r[2];
				mysqli_stmt_execute($stmt);	
			}
		}
		mysqli_stmt_close($stmt);
		return $statistic;
	}
	
	function updateStatisticForm($c, $statistic, $prefix) {
		?>		
		<form method="post">
			<?php
				$stmt = mysqli_prepare($c, "
					SELECT	
						StatisticAttributeID,
						StatisticAttributeValue,
						StatisticNameValue
					FROM
						StatisticName as sn
					INNER JOIN
						StatisticAttribute as sa
					ON
						sn.StatisticNameID=sa.StatisticNameID
					WHERE
						StatisticID=?
				");
				mysqli_stmt_bind_param($stmt, "i", $statistic);
				mysqli_stmt_bind_result($stmt, $id, $attr, $name);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<div>
						<?php echo $name; ?>
						<input type="text" name="<?php echo $prefix . "_" . $name . "_" . $id; ?>" value="<?php echo $attr; ?>"/>
					</div>
					<?php
				}
			?>
			<input type="submit" name="action" value="Update Statistic"/>
		</form>
		<?php
	}
	
	function updateStatistic($c, $prefix) {
		mysqli_prepare($c, "
			UPDATE
				StatisticAttribute
			SET
				StatisticAttributeValue = ?
			WHERE
				StatisticAttributeID = ?
		");
		mysqli_stmt_bind_param($stmt, "ii", $value, $id);
		foreach($_REQUEST as $key => $value) {
			$r = explode($key);
			if(count($r) === 3 && $r[1] === $prefix) {
				$id = $r[2];
				mysqli_stmt_execute($stmt);
			}
		}
		mysqli_stmt_close($stmt);
	}
?>