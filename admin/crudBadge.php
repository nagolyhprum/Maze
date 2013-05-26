<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if(!$_POST["category"]) {
			$_POST["category"] = NULL;
		}
		if(!$_POST["subcategory"]) {
			$_POST["subcategory"] = NULL;
		}
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM Badge WHERE BadgeID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO Badge (BadgeName, CategoryID, SubcategoryID, BadgeCount, BadgeIcon) VALUES (?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "siiii", $_POST["name"], $_POST["category"], $_POST["subcategory"], $_POST["count"], $_POST["icon"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE Badge SET BadgeName=?, CategoryID=?, SubcategoryID=?, BadgeCount=?, BadgeIcon=? WHERE BadgeID=?");
			mysqli_stmt_bind_param($stmt, "siiiii", $_POST["name"], $_POST["category"], $_POST["subcategory"], $_POST["count"], $_POST["icon"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$categories = getNameID($c, "Category");
	$subcategories = getNameID($c, "Subcategory");
	$images = getNameID($c, "Image");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Badge</h2>
		<form method="post" action="crudBadge.php" >
			<div>
				Name <input name="name" type="text"/>
			</div>
			<div>
				Count <input name="count" type="text"/>
			</div>
			<div>
				Category
				<select name="category">
					<?php asOptions($categories, -1); ?>
				</select>
			</div>
			<div>
				Subcategoy
				<select name="subcategory">
					<?php asOptions($subcategories, -1); ?>
				</select>									
			</div>
			<div>
				Icon
				<select name="icon" data-image>
					<?php asOptions($images, -1); ?>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT BadgeID, BadgeName, BadgeCount, CategoryID, SubcategoryID, BadgeIcon FROM Badge LIMIT ?, 10");		
				$start = $_GET["start"];
				mysqli_stmt_bind_param($stmt, "i", $start);
				mysqli_stmt_bind_result($stmt, $id, $name, $count, $category, $subcategory, $icon);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form action="crudBadge.php" method="post">
						<div>									
							<input name="id" type="hidden" value="<?php echo $id; ?>"/>
							<div>
								Name <input name="name" type="text" value="<?php echo $name; ?>"/>
							</div>
							<div>
								Count <input name="count" type="text" value="<?php echo $count; ?>"/>
							</div>
							<div>
								Category 
								<select name="category">
									<?php asOptions($categories, $category); ?>
								</select>
							</div>
							<div>
								Subcategory 
								<select name="subcategory">
									<?php asOptions($subcategories, $subcategory); ?>
								</select>									
							</div>
							<div>
								Icon
								<select name="icon" data-image>
									<?php asOptions($images, $icon); ?>
								</select>
							</div>
						</div>
						<input type="submit" name="action" value="Delete"/>
						<input type="submit" name="action" value="Update"/>
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