<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM MapModel WHERE MapModelID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO MapModel (MapModelName, ImageID, MapModelRows, MapModelColumns) VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "siii", $_POST["name"], $_POST["image"], $_POST["rows"], $_POST["columns"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE MapModel SET MapModelName=?, ImageID=?, MapModelRows=?, MapModelColumns=? WHERE MapModelID=?");
			mysqli_stmt_bind_param($stmt, "siiii", $_POST["name"], $_POST["image"], $_POST["rows"], $_POST["columns"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$images = getNameID($c, "Image");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Map Model</h2>
		<form method="post" action="crudMapModel.php">
			<div>
				Name <input type="text" name="name"/>				
			</div>			
			<div>
				Rows <input type="text" name="rows"/>				
			</div>	
			<div>
				Columns <input type="text" name="columns"/>				
			</div>	
			<div>
				Image
				<select name="image" data-image>
					<?php asOptions($images); ?>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT MapModelID, MapModelName, MapModelRows, MapModelColumns, ImageID FROM MapModel");		
				mysqli_stmt_bind_result($stmt, $id, $name, $rows, $columns, $image);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form action="crudMapModel.php" method="post">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Name <input type="text" name="name" value="<?php echo $name; ?>"/>				
						</div>			
						<div>
							Rows <input type="text" name="rows" value="<?php echo $rows; ?>"/>				
						</div>	
						<div>
							Columns <input type="text" name="columns" value="<?php echo $columns; ?>"/>				
						</div>	
						<div>
							Image
							<select name="image" data-image>
								<?php asOptions($images, $image); ?>
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