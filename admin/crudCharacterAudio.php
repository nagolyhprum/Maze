<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		$_POST["ismale"] = $_POST["ismale"] === "on";
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM CharacterAudio WHERE CharacterAudioID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO CharacterAudio (AudioID, AttackTypeID, CharacterAudioIsMale) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["audio"], $_POST["attacktype"], $_POST["ismale"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE CharacterAudio SET AudioID=?, AttackTypeID=?, CharacterAudioIsMale=? WHERE CharacterAudioID=?");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["audio"], $_POST["attacktype"], $_POST["ismale"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$audios = getNameID($c, "Audio");
	$attacktypes = getNameID($c, "AttackType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character Audio</h2>
		<form method="post" action="crudCharacterAudio.php">
			<div>
				Audio
				<select name="audio">
					<?php asOptions($audios, -1); ?>
				</select>
			</div>
			<div>
				Attack Type
				<select name="attacktype">
					<?php asOptions($attacktypes, -1); ?>
				</select>
			</div>
			<div>
				Is Male <input type="checkbox" name="ismale"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT CharacterAudioID, AudioID, AttackTypeID, CharacterAudioIsMale FROM CharacterAudio");		
				mysqli_stmt_bind_result($stmt, $id, $audio, $attacktype, $ismale);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudCharacterAudio.php">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>						
						<div>
							Audio
							<select name="audio">
								<?php asOptions($audios, $audio); ?>
							</select>
						</div>
						<div>
							Attack Type
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
							</select>
						</div>
						<div>
							Is Male <input type="checkbox" name="ismale" <?php echo $ismale ? "checked" : ""; ?>/>
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