<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE i, s FROM ItemModel as i INNER JOIN Statistic as s ON i.StatisticID=s.StatisticID WHERE ItemModelID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$statistic = createStatistic($c, "");
			$stmt = mysqli_prepare($c, "INSERT INTO ItemModel (ItemModelName, ItemModelArea, StatisticID, AttackTypeID, ItemModelWeight, ItemTypeID, ItemModelPortrait) VALUES (?, ?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "siiiiii", $_POST["name"], $_POST["area"], $statistic, $_POST["attacktype"], $_POST["weight"], $_POST["itemtype"], $_POST["portrait"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Item Model") {
			$stmt = mysqli_prepare($c, "UPDATE ItemModel SET ItemModelName=?, ItemModelArea=?, AttackTypeID=?, ItemModelWeight=?, ItemTypeID=?, ItemModelPortrait=? WHERE ItemModelID=?");
			mysqli_stmt_bind_param($stmt, "siiiiii", $_POST["name"], $_POST["area"], $_POST["attacktype"], $_POST["weight"], $_POST["itemtype"], $_POST["portrait"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Statistic") {
			updateStatistic($c, "");
		}
	}
	$attacktypes = getNameID($c, "AttackType");
	$itemtypes = getNameID($c, "ItemType");
	$images = getNameID($c, "Image");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Item Model</h2>
		<form method="post" action="crudItemModel.php" >
			<div>
				Name <input type="text" name="name"/>
			</div>
			<div>
				Area <input type="text" name="area"/>
			</div>
			<div>
				Weight <input type="text" name="weight"/>
			</div>
			<div>
				Attack Type 
				<select name="attacktype">
					<?php asOptions($attacktypes); ?>
				</select>
			</div>
			<div>
				Item Type 
				<select name="itemtype">
					<?php asOptions($itemtypes); ?>
				</select>
			</div>
			<div>
				Portrait 
				<select name="portrait">
					<?php asOptions($images); ?>
				</select>
			</div>
			<h3>Statistic</h3>
			<?php createStatisticForm($c, ""); ?>
			<div>				
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				for($i = 0;;$i++) {
					$stmt = mysqli_prepare($c, "
						SELECT 
							ItemModelID,
							ItemModelName,
							ItemModelArea,
							ItemModelWeight,
							AttackTypeID,
							ItemTypeID,		
							ImageID,
							StatisticID
						FROM 
							ItemModel
						LIMIT
							?, 1
					");	
					mysqli_stmt_bind_param($stmt, "i", $i);
					mysqli_stmt_bind_result($stmt, $id, $name, $area, $weight, $attacktype, $itemtype, $portrait, $statistic);
					mysqli_stmt_execute($stmt);
					if(!mysqli_stmt_fetch($stmt)) {
						break;
					}
						?>
						<hr/>
						<form action="crudItemModel.php" method="post">
							<input name="id" type="hidden" value="<?php echo $id; ?>"/>
							<div>
								Name <input type="text" name="name" value="<?php echo $name; ?>"/>
							</div>
							<div>
								Area <input type="text" name="area" value="<?php echo $area; ?>"/>
							</div>
							<div>
								Weight <input type="text" name="weight" value="<?php echo $weight; ?>"/>
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
								Portrait 
								<select name="portrait">
									<?php asOptions($images, $portrait); ?>
								</select>
							</div>
							<div>
								<input type="submit" name="action" value="Delete"/>
								<input type="submit" name="action" value="Update Item Model"/>
							</div>
						</form>		
						<h3>Statistic</h3>			
						<?php 
					mysqli_stmt_close($stmt);
					updateStatisticForm($c, $statistic, ""); 				
				}
			}
		?>
	</body>
</html>
<?php
	close($c);
?>