<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM ItemType WHERE ItemTypeID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO ItemType (ItemTypeName, ItemTypeDrawingOrder) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt, "si", $_POST["name"], $_POST["drawingorder"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE ItemType SET ItemTypeName=?, ItemTypeDrawingOrder=? WHERE ItemTypeID=?");
			mysqli_stmt_bind_param($stmt, "sii", $_POST["name"], $_POST["drawingorder"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Item Type</h2>
		<form method="post" action="crudItemType.php" >
			<div>
				Name <input type="text" name="name"/>
			</div>
			<div>
				Drawing Order <input type="text" name="drawingorder"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<div>
			<?php
				$stmt = mysqli_prepare($c, "SELECT ItemTypeDrawingOrder, ItemTypeName, ItemTypeID FROM ItemType");
				mysqli_stmt_bind_result($stmt, $drawingorder, $name, $id);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
						<hr/>
						<form action="crudItemType.php" method="post">
							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<div>
								Name <input type="text" name="name" value="<?php echo $name; ?>"/>
							</div>
							<div>
								Drawing Order <input type="text" name="drawingorder" value="<?php echo $drawingorder; ?>"/>
							</div>
							<div>
								<input type="submit" name="action" value="Delete"/>
								<input type="submit" name="action" value="Update"/>						
							</div>
						</form>
					<?php
				}
				mysqli_stmt_close($stmt);
			?>
		</div>
	</body>
</html>
<?php
	close($c);
?>