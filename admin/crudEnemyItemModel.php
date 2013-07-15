<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM EnemyItemModel WHERE EnemyItemModel=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {	
			$stmt = mysqli_prepare($c, "INSERT INTO EnemyItemModel (EnemyID, ItemModelID, EnemyItemModelChance) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["enemy"], $_POST["itemmodel"], $_POST["chance"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Character") {
			$stmt = mysqli_prepare($c, "UPDATE EnemyItemModel SET EnemyID=?, ItemModelID=?, EnemyItemModelChance=? WHERE EnemyItemModelID=?");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["enemy"], $_POST["itemmodel"], $_POST["chance"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$itemmodels = getNameID($c, "ItemModel");
	$enemies = getNameID($c, "Enemy");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Enemy Item Model</h2>
		<form method="post" action="crudEnemyItemModel.php" >
			<div>
				Enemy 
				<select name="enemy">
				<?php echo asOptions($enemies); ?>
				</select>
			</div>
			<div>
				Item Model
				<select name="itemmodel">
				<?php echo asOptions($itemmodels); ?>
				</select>
			</div>
			<div>
				Chance <input type="text" name="chance"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
	
		<?php 
			$stmt = mysqli_prepare($c, "
				SELECT
					EnemyItemModelChance,
					EnemyID,
					ItemModelID
				FROM
					EnemyItemModel
			");
			mysqli_stmt_bind_result($stmt, $chance, $enemy, $itemmodel);
			mysqli_stmt_execute($stmt);
			while(mysqli_stmt_fetch($stmt)) {
		?>
		<form method="post" action="crudEnemyItemModel.php" >
			<div>
				Enemy 
				<select name="enemy">
				<?php echo asOptions($enemies, $enemy); ?>
				</select>
			</div>
			<div>
				Item Model
				<select name="itemmodel">
				<?php echo asOptions($itemmodels, $itemmodel); ?>
				</select>
			</div>
			<div>
				Chance <input type="text" name="chance" value="<?php echo $chance; ?>"/>
			</div>
			<div>
				<input type="submit" name="action" value="Update"/>
			</div>
		</form>
		<?php 
			}
		?>
	</body>
</html>
<?php
	close($c);
?>