<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "
				DELETE 
					e, s 
				FROM 
					Enemy as e 
				INNER JOIN
					Statistic as s
				ON
					e.StatisticID=s.StatisticID
				WHERE 
					e.EnemeyID=?
			");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$statistic = createStatistic($c, "");
			$stmt = mysqli_prepare($c, "INSERT INTO Enemy (EnemyPortrait, EnemyName, StatisticID, AttackTypeID) VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "isii", $_POST["portrait"], $_POST["name"], $statistic, $_POST["attacktype"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Enemy") {
			$stmt = mysqli_prepare($c, "UPDATE Enemy SET EnemyPortrait=?, EnemyName=?, AttackTypeID=? WHERE EnemyID=?");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["portrait"], $_POST["name"], $_POST["attacktype"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Statistic") {
			updateStatistic($c, "");
		}
	}
	$images = getNameID($c, "Image");
	$attacktypes = getNameID($c, "AttackType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Enemy</h2>
		<form method="post" action="crudEnemy.php">
			<div>
				<div>
					Name <input type="text" name="name"/>
				</div>
				<div>
					Portrait
					<select name="portrait" data-image>
						<?php asOptions($images, -1); ?>
					</select>
				</div>
				<div>
					Attack Type
					<select name="attacktype">
						<?php asOptions($attacktypes, -1); ?>
					</select>
				</div>
				<?php createStatisticForm(""); ?>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "
					SELECT 
						e.EnemyID,
						e.EnemyName,
						e.EnemyPortrait,
						e.AttackTypeID,
						
						s.StatisticHealth,
						s.StatisticEnergy,
						s.StatisticStrength,
						s.StatisticDefense,
						s.StatisticIntelligence,
						s.StatisticResistance
					FROM 
						Enemy as e 
					INNER JOIN
						Statistic as s
					ON
						e.StatisticID=s.StatisticID					
				");		
				$statistic = array();
				mysqli_stmt_bind_result($stmt, $id, $name, $portrait, $attacktype, $statistic["health"], $statistic["energy"], $statistic["strength"], $statistic["defense"], $statistic["intelligence"], $statistic["resistance"]);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudEnemy.php">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>																		
						<div>
							Name <input type="text" name="name" value="<?php echo $name; ?>"/>
						</div>
						<div>
							Portrait
							<select name="portrait" data-image>
								<?php asOptions($images, $portrait); ?>
							</select>
						</div>
						<div>
							Attack Type
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
							</select>
						</div>
						<div>
							<input type="submit" name="action" value="Delete"/>
							<input type="submit" name="action" value="Update Enemy"/>
						</div>
						<?php updateStatisticForm($statistic, ""); ?>
					</form>
					<?php
				}
				mysqli_stmt_close($stmt);
			}
		?>
	</body>
</html>
<?php
	close($c);
?>