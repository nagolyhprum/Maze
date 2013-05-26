<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		$_POST["ismale"] = $_POST["ismale"] === "on";
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM CharacterImageChoiceGroup WHERE CharacterImageChoiceGroupID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO CharacterImageChoiceGroup (CharacterImageChoiceGroupName, ItemTypeID, CharacterImageChoiceGroupIsMale) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "sii", $_POST["name"], $_POST["itemtype"], $_POST["ismale"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE CharacterImageChoiceGroup SET CharacterImageChoiceGroupName=?, ItemTypeID=?, CharacterImageChoiceGroupIsMale=? WHERE CharacterImageChoiceGroupID=?");
			mysqli_stmt_bind_param($stmt, "siii", $_POST["name"], $_POST["itemtype"], $_POST["ismale"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$itemtypes = getNameID($c, "ItemType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character Image Choice Group</h2>
		<form method="post" action="crudCharacterImageChoiceGroup.php" >
			<div>
				Name
				<input name="name" type="text"/>
			</div>
			<div>
				Item Type 
				<select name="itemtype">
					<?php asOptions($itemtypes, -1); ?>
				</select>
			</div>
			<div>
				Is Male <input name="ismale" type="checkbox"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT CharacterImageChoiceGroupName, CharacterImageChoiceGroupID, ItemTypeID, CharacterImageChoiceGroupIsMale FROM CharacterImageChoiceGroup");		
				mysqli_stmt_bind_result($stmt, $name, $id, $itemtype, $ismale);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudCharacterImageChoiceGroup.php" >								
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Name
							<input name="name" type="text" value="<?php echo $name; ?>"/>
						</div>
						<div>
							Item Type 
							<select name="itemtype">
								<?php asOptions($itemtypes, $itemtype); ?>
							</select>
						</div>
						<div>
							Is Male <input name="ismale" type="checkbox" <?php echo $ismale ? "checked" : ""; ?>/>
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