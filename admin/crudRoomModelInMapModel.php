<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM RoomModelInMapModel WHERE RoomModelInMapModelID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO RoomModelInMapModel (RoomModelID, MapModelID, RoomModelInMapModelCount) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iii", $_POST["roommodel"], $_POST["mapmodel"], $_POST["count"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE RoomModelInMapModel SET RoomModelID=?, MapModelID=?, RoomModelInMapModelCount=? WHERE RoomModelInMapModelID=?");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["roommodel"], $_POST["mapmodel"], $_POST["count"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$roommodels = getNameID($c, "RoomModel");
	$mapmodels = getNameID($c, "MapModel");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Room Model In Map Model</h2>
		<form method="post" action="crudRoomModelInMapModel.php">
			<div>
				Room Model
				<select name="roommodel">
					<?php asOptions($roommodels); ?>
				<select>
			</div>
			<div>
				Map Model
				<select name="mapmodel">
					<?php asOptions($mapmodels); ?>
				<select>
			</div>
			<div>
				Count <input type="text" name="count"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT RoomModelInMapModelID, RoomModelID, MapModelID, RoomModelInMapModelCount FROM RoomModelInMapModel");		
				mysqli_stmt_bind_result($stmt, $id, $roommodel, $mapmodel, $count);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form action="crudRoomModelInMapModel.php" method="post">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						<div>
							Room Model
							<select name="roommodel">
								<?php asOptions($roommodels, $roommodel); ?>
							<select>
						</div>
						<div>
							Map Model
							<select name="mapmodel">
								<?php asOptions($mapmodels, $mapmodel); ?>
							<select>
						</div>
						<div>
							Count <input type="text" name="count" value="<?php echo $count; ?>"/>
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