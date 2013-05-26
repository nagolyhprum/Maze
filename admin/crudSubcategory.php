<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM Subcategory WHERE SubcategoryID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO Subcategory (SubcategoryName, CategoryID) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt, "si", $_POST["name"], $_POST["category"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE Subcategory SET SubcategoryName=? , CategoryID WHERE SubcategoryID=?");
			mysqli_stmt_bind_param($stmt, "si", $_POST["name"], $_POST["category"], $_POST["id"]);
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
		<h2>Subcategory</h2>
		<form method="post" action="crudSubcategory.php" >
			<div>
				Category
				<select name="category">
					<?php asOptions($categories, -1); ?>
				</select>
			</div>
			<div>
				Subcategory
				<input type="text" name="name"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			$stmt = mysqli_prepare($c, "SELECT CategoryID, SubcategoryName, SubcategoryID FROM Subcategory");
			mysqli_stmt_bind_result($stmt, $category, $name, $id);
			mysqli_stmt_execute($stmt);
			while(mysqli_stmt_fetch($stmt)) {
				?>
					<hr/>
					<form action="crudSubcategory" method="post">
						<input type="hidden" value="<?php echo $id; ?>" name="id"/>
						<div>
							Category
							<select name="category">
								<?php asOptions($categories, $category); ?>
							</select>
						</div>
						<div>
							Subcategory <input type="text" name="name" value="<?php echo $name; ?>"/>
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
	</body>
</html>
<?php
	close($c);
?>