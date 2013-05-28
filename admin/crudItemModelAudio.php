<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM ItemModelAudio WHERE ItemModelAudioID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO ItemModelAudio (ItemModelID, AudioID) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt, "ii", $_POST["itemmodel"], $_POST["audio"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE ItemModelAudio SET ItemModelID=?, AudioID=? WHERE ItemModelAudioID=?");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["itemmodel"], $_POST["audio"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$itemmodels = getNameID($c, "ItemModel");
	$audios = getNameID($c, "Audio");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Item Model Audio</h2>
		<form method="post" action="crudItemModelAudio.php">
			<div>
				Item Model
				<select name="itemmodel">
					<?php asOptions($itemmodels); ?>
				</select>
			</div>
			<div>
				Audio
				<select name="audio">
					<?php asOptions($audios); ?>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT ItemModelAudioID, ItemModelID, AudioID FROM ItemModelAudio");		
				mysqli_stmt_bind_result($stmt, $id, $itemmodel, $audio);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form action="crudItemModelAudio.php" method="post">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Item Model
							<select name="itemmodel">
								<?php asOptions($itemmodels, $itemmodel); ?>
							</select>
						</div>
						<div>
							Audio
							<select name="audio">
								<?php asOptions($audios, $audio); ?>
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