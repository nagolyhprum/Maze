<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM EnemyImage WHERE EnemyImageID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO EnemyImage (EnemyID, ImageID, AttackTypeID, ItemTypeID, EnemyImageRows, EnemyImageColumns) VALUES (?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iiiiii", $_POST["enemy"], $_POST["image"], $_POST["attacktype"], $_POST["itemtype"], $_POST["rows"], $_POST["columns"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE EnemyImage SET EnemyID=?, ImageID=?, AttackTypeID=?, ItemTypeID=?, EnemyImageRows=?, EnemyImageColumns=? WHERE EnemyImageID=?");
			mysqli_stmt_bind_param($stmt, "iiiiiii", $_POST["enemy"], $_POST["image"], $_POST["attacktype"], $_POST["itemtype"], $_POST["rows"], $_POST["columns"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$images = getNameID($c, "Image");
	$enemies = getNameID($c, "Enemy");
	$attacktypes = getNameID($c, "AttackType");
	$itemtypes = getNameID($c, "ItemType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Enemy Image</h2>
		<form method="post" action="crudEnemyImage.php">
			<div>
				Enemy
				<select name="enemy">
					<?php asOptions($enemies, -1); ?>
				</select>
			</div>
			<div>
				Image
				<select name="image" data-image>
					<?php asOptions($images, -1); ?>
				</select>
			</div>
			<div>
				Attack Type
				<select name="attacktype">
					<?php asOptions($attacktypes, -1); ?>
				</select>
			</div>
			<div>
				Item Type
				<select name="itemtype">
					<?php asOptions($itemtypes, -1); ?>
				</select>
			</div>
			<div>
				Rows <input type="text" name="rows"/>
			</div>
			<div>
				Columns <input type="text" name="columns"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT EnemyImageID, EnemyID, ImageID, AttackTypeID, ItemTypeID, EnemyImageRows, EnemyImageColumns FROM EnemyImage");		
				mysqli_stmt_bind_result($stmt, $id, $enemy, $image, $attacktype, $itemtype, $rows, $columns);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudEnemyImage.php">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>																		
						<div>
							Enemy
							<select name="enemy">
								<?php asOptions($enemies, $enemy); ?>
							</select>
						</div>
						<div>
							Image
							<select name="image" data-image>
								<?php asOptions($images, $image); ?>
							</select>
						</div>
						<div>
							Attack Type
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
							</select>
						</div>
						<div>
							Item Type
							<select name="itemtype">
								<?php asOptions($itemtypes, $itemtype); ?>
							</select>
						</div>
						<div>
							Rows <input type="text" name="rows" value="<?php echo $rows; ?>"/>
						</div>
						<div>
							Columns <input type="text" name="columns" value="<?php echo $columns; ?>"/>
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