<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		$_POST["ismale"] = $_POST["ismale"] === "on";
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM CharacterImage WHERE CharacterImageID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO CharacterImage (CharacterID, CharacterImageChoiceGroupID) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt, "ii", $_POST["character"], $_POST["characterimagechoicegroup"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE CharacterImage SET CharacterID=?, CharacterImageChoiceGroupID=? WHERE CharacterImageID=?");
			mysqli_stmt_bind_param($stmt, "siii", $_POST["character"], $_POST["characterimagechoicegroup"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$characters = getNameID($c, "Character");
	$characterimagechoicegroups = getNameID($c, "CharacterImageChoiceGroup");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character Image</h2>
		<form method="post" action="crudCharacterImage.php" >
			<div>
				Character
				<select name="character">
					<?php asOptions($characters, -1); ?>
				</select>
			</div>
			<div>
				Character Image Choice Group
				<select name="characterimagechoicegroup">
					<?php asOptions($characterimagechoicegroups, -1); ?>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT CharacterImageID, CharacterID, CharacterImageChoiceGroupID FROM CharacterImage");		
				mysqli_stmt_bind_result($stmt, $id, $character, $characterimagechoicegroup);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudCharacterImage.php" >
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Character
							<select name="character">
								<?php asOptions($characters, $character); ?>
							</select>
						</div>
						<div>
							Character Image Choice Group
							<select name="characterimagechoicegroup">
								<?php asOptions($characterimagechoicegroups, $characterimagechoicegroup); ?>
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