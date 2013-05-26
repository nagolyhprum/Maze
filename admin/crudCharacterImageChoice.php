<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM CharacterImageChoice WHERE CharacterImageChoiceID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO CharacterImageChoice (CharacterImageChoiceColumns, CharacterImageChoiceRows, CharacterImageChoiceGroupID, AttackTypeID, ImageID) VALUES (?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iiiii", $_POST["columns"], $_POST["rows"], $_POST["characterimagechoicegroup"], $_POST["attacktype"], $_POST["image"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE CharacterImageChoice SET CharacterImageChoiceColumns=?, CharacterImageChoiceRows=?, CharacterImageChoiceGroupID=?, AttackTypeID=?, ImageID=? WHERE CharacterImageChoiceID=?");
			mysqli_stmt_bind_param($stmt, "iiiiii", $_POST["columns"], $_POST["rows"], $_POST["characterimagechoicegroup"], $_POST["attacktype"], $_POST["image"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$attacktypes = getNameID($c, "AttackType");
	$images = getNameID($c, "Image");
	$characterimagechoicegroups = getNameID($c, "CharacterImageChoiceGroup");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character Image Choice</h2>
		<form method="post" action="crudCharacterImageChoice.php" >
			<div>
				Rows
				<input name="rows" type="text"/>
			</div>
			<div>
				Columns
				<input name="columns" type="text"/>
			</div>
			<div>
				Attack Type 
				<select name="attacktype">
					<?php asOptions($attacktypes, -1); ?>
				</select>
			</div>
			<div>
				Image
				<select name="image" data-image>
					<?php asOptions($images, -1); ?>
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
				$stmt = mysqli_prepare($c, "SELECT CharacterImageChoiceRows, CharacterImageChoiceColumns, AttackTypeID, ImageID, CharacterImageChoiceGroupID FROM CharacterImageChoice");		
				mysqli_stmt_bind_result($stmt, $rows, $columns, $attacktype, $image, $characterimagechoicegroup);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
		?>
					<hr/>
					<form method="post" action="crudCharacterImageChoice.php" >
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Rows
							<input name="rows" type="text" value="<?php echo $rows; ?>"/>
						</div>
						<div>
							Columns
							<input name="columns" type="text" value="<?php echo $columns; ?>"/>
						</div>
						<div>
							Attack Type 
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
							</select>
						</div>
						<div>
							Image
							<select name="image" data-image>
								<?php asOptions($images, $image); ?>
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