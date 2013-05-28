<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM ItemModelImage WHERE ItemModelImageID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO ItemModelImage (ImageID, ItemModelID, AttackTypeID, ItemModelImageColumns, ItemModelImageRows) VALUES (?, ?, ?, ?, ?)");
			echo mysqli_error($c);
			mysqli_stmt_bind_param($stmt, "iiiii", $_POST["image"], $_POST["itemmodel"], $_POST["attacktype"], $_POST["columns"], $_POST["rows"]);
			mysqli_stmt_execute($stmt);
			echo mysqli_error($c);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE ItemModelImage SET ImageID=?, ItemModelID=?, AttackTypeID=?, ItemModelImageColumns=?, ItemModelImageRows=? WHERE ItemModelImageID=?");
			mysqli_stmt_bind_param($stmt, "iiiiii", $_POST["image"], $_POST["itemmodel"], $_POST["attacktype"], $_POST["columns"], $_POST["rows"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$images = getNameID($c, "Image");
	$itemmodels = getNameID($c, "ItemModel");
	$attacktypes = getNameID($c, "AttackType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Image Model Image</h2>
		<form method="post" action="crudItemModelImage.php">
			<div>
				Image
				<select name="image" data-image>
					<?php asOptions($images); ?>
				</select>
			</div>
			<div>
				Item Model
				<select name="itemmodel">
					<?php asOptions($itemmodels); ?>
				</select>
			</div>
			<div>
				Attack Type
				<select name="attacktype">
					<?php asOptions($attacktypes); ?>
				</select>
			</div>
			<div>
				Columns <input type="text" name="columns"/>				
			</div>
			<div>
				Rows <input type="text" name="rows"/>				
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT ItemModelImageID, ImageID, ItemModelID, AttackTypeID, ItemModelImageColumns, ItemModelImageRows FROM ItemModelImage");		
				mysqli_stmt_bind_result($stmt, $id, $image, $itemmodel, $attacktype, $columns, $rows);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudItemModelImage.php">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>																								
						<div>
							Image
							<select name="image" data-image>
								<?php asOptions($images, $image); ?>
							</select>
						</div>
						<div>
							Item Model
							<select name="itemmodel">
								<?php asOptions($itemmodels, $itemmodel); ?>
							</select>
						</div>
						<div>
							Attack Type
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
							</select>
						</div>
						<div>
							Columns <input type="text" name="columns" value="<?php echo $columns; ?>"/>				
						</div>
						<div>
							Rows <input type="text" name="rows" value="<?php echo $rows; ?>"/>				
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