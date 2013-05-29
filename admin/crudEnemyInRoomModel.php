<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM EnemyInRoomModel WHERE EnemyInRoomModelID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO EnemyInRoomModel (EnemyID, RoomModelID, EnemyInRoomModelDirection, EnemyInRoomModelRow, EnemyInRoomModelColumn) VALUES (?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iiiii", $_POST["enemy"], $_POST["roommodel"], $_POST["direction"], $_POST["row"], $_POST["column"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE EnemyInRoomModel SET EnemyID=?, RoomModelID=?, EnemyInRoomModelDirection=?, EnemyInRoomModelRow=?, EnemyInRoomModelColumn=? WHERE EnemyInRoomModelID=?");
			mysqli_stmt_bind_param($stmt, "iiiiii", $_POST["enemy"], $_POST["roommodel"], $_POST["direction"], $_POST["row"], $_POST["column"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$roommodels = getNameID($c, "RoomModel");
	$enemies = getNameID($c, "Enemy");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Enemy In Room Model</h2>
		<form method="post" action="crudEnemyInRoomModel.php">
			<div>
				Enemy
				<select name="enemy">
					<?php asOptions($enemies); ?>
				</select>
			</div>
			<div>
				Room Model
				<select name="roommodel">
					<?php asOptions($roommodels); ?>
				</select>
			</div>
			<div>
				Row <input type="text" name="row"/>
			</div>
			<div>
				Column <input type="text" name="column"/>
			</div>
			<div>
				Direction <input type="text" name="direction"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT EnemyInRoomModelID, EnemyID, RoomModelID, EnemyInRoomModelDirection, EnemyInRoomModelRow, EnemyInRoomModelColumn FROM EnemyInRoomModel");		
				mysqli_stmt_bind_result($stmt, $id, $enemy, $roommodel, $direction, $row, $column);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form action="crudEnemyInRoomModel.php" method="post">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Enemy
							<select name="enemy">
								<?php asOptions($enemies, $enemy); ?>
							</select>
						</div>
						<div>
							Room Model
							<select name="roommodel">
								<?php asOptions($roommodels, $roommodel); ?>
							</select>
						</div>
						<div>
							Row <input type="text" name="row" value="<?php echo $row; ?>"/>
						</div>
						<div>
							Column <input type="text" name="column" value="<?php echo $column; ?>"/>
						</div>
						<div>
							Direction <input type="text" name="direction" value="<?php echo $direction; ?>"/>
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