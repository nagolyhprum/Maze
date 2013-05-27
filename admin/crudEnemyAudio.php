<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM EnemyAudio WHERE EnemyAudioID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO EnemyAudio (AudioID, EnemyID, AttackTypeID) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["audio"], $_POST["enemy"], $_POST["attacktype"]);
			mysqli_stmt_execute($stmt);
			echo mysqli_error($c);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE EnemyAudio SET AudioID=?, EnemyID=?, AttackTypeID=? WHERE EnemyAudioID=?");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["audio"], $_POST["enemy"], $_POST["attacktype"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$audios = getNameID($c, "Audio");
	$enemies = getNameID($c, "Enemy");
	$attacktypes = getNameID($c, "AttackType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Enemy Audio</h2>
		<form method="post" action="crudEnemyAudio.php">
			<div>
					Audio
					<select name="audio">
						<?php asOptions($audios, -1); ?>
					</select>
			</div>
			<div>
					Enemy
					<select name="enemy">
						<?php asOptions($enemies, -1); ?>
					</select>
			</div>
			<div>
					Attack Type
					<select name="attacktype">
						<?php asOptions($attacktypes, -1); ?>
					</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT EnemyAudioID, AudioID, EnemyID, AttackTypeID FROM EnemyAudio");		
				mysqli_stmt_bind_result($stmt, $id, $audio, $enemy, $attacktype);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudEnemyAudio.php">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>																		
						<div>
								Audio
								<select name="audio">
									<?php asOptions($audios, $audio); ?>
								</select>
						</div>
						<div>
								Enemy
								<select name="enemy">
									<?php asOptions($enemies, $enemy); ?>
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
							<input type="submit" name="action" value="Update"/>
						</div>
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