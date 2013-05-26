<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM Category WHERE CategoryID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO Category (CategoryName) VALUES (?)");
			mysqli_stmt_bind_param($stmt, "s", $_POST["name"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE Category SET CategoryName=? WHERE CategoryID=?");
			mysqli_stmt_bind_param($stmt, "si", $_POST["name"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$categories = getNameID($c, "Category");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Category</h2>
		<form method="post" action="crudCategory.php" >
			<div>
				Name to Update to or Create <input type="text" name="name"/>
				<input type="submit" name="action" value="Create"/>
			</div>
			<div>
				Name to Update or Delete
				<select name="id">
					<?php asOptions($categories, -1); ?>
				</select>
			</div>
			<input type="submit" name="action" value="Delete"/>
			<input type="submit" name="action" value="Update"/>
		</form>
	</body>
</html>
<?php
	close($c);
?>