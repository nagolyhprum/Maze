<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		$_POST["ismale"] = $_POST["ismale"] === "on";
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "
				DELETE 
					c, cs, ms 
				FROM 
					`Character` as c 
				INNER JOIN 
					Statistic as ms
				ON
					c.CharacterMaxStatisticID=ms.StatisticID
				INNER JOIN
					Statistic as cs
				ON
					c.CharacterCurrentStatisticID=cs.StatisticID
				WHERE
					CharacterID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$current = createStatistic($c, "");
			$max = createStatistic($c, "");			
			$stmt = mysqli_prepare($c, "INSERT INTO `Character` (CharacterName, CharacterPortrait, CharacterCurrentStatisticID, CharacterMaxStatisticID, UserID, CharacterIsMale) VALUES (?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "siiiii", $_POST["name"], $_POST["portrait"], $current, $max, $_POST["user"], $_POST["ismale"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Character") {
			$stmt = mysqli_prepare($c, "UPDATE Character SET CharacterName=?, CharacterIsMale=?, CharacterPortrait=?, UserID=? WHERE CharacterID=?");
			mysqli_stmt_bind_param($stmt, "siiii", $_POST["name"], $_POST["ismale"], $_POST["portrait"], $_POST["user"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Statistic") {
			updateStatistic($c, "");
		}
	}
	$images = getNameID($c, "Image");
	$users = getNameID($c, "User");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character</h2>
		<form method="post" action="crudCharacter.php" >
			<div>
				Name <input type="text" name="name"/>
			</div>
			<div>
				Portrait 
				<select name="portrait" data-image>
					<?php asOptions($images, -1); ?>
				</select>
			</div>
			<div>
				User 
				<select name="user">
					<?php asOptions($users, -1); ?>
				</select>
			</div>
			<div>
				Is Male <input type="checkbox" name="ismale"/>
			</div>
			<h3>Statistic</h3>
			<?php createStatisticForm($c, ""); ?>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				for($i = 0;; $i++) {
					$stmt = mysqli_prepare($c, "
					SELECT 
						CharacterID, 
						CharacterName, 
						ImageID, 
						UserID, 
						CharacterIsMale,				
						CharacterMaxStatisticID,
						CharacterCurrentStatisticID
					FROM 
						`Character`
					LIMIT
						?, 1");	
					mysqli_stmt_bind_param($stmt, "i", $i);
					mysqli_stmt_bind_result($stmt, $id, $name, $portrait, $user, $ismale, $max, $current);
					mysqli_stmt_execute($stmt);
					if(!mysqli_stmt_fetch($stmt)) {
						break;
					}
					?>
					<hr/>
					<form action="crudCharacter.php" method="post">
						<div>									
							<input name="id" type="hidden" value="<?php echo $id; ?>"/>
						</div>
						<div>
							Name <input type="text" name="name" value="<?php echo $name;?>"/>
						</div>
						<div>
							Portrait 
							<select name="portrait" data-image>
								<?php asOptions($images, $portrait); ?>
							</select>
						</div>
						<div>
							User 
							<select name="user">
								<?php asOptions($users, $user); ?>
							</select>
						</div>
						<div>
							Is Male <input type="checkbox" name="ismale" <?php echo $ismale ? "checked" : ""; ?>/>
						</div>
						<input type="submit" name="action" value="Delete"/>
						<input type="submit" name="action" value="Update Character"/>
					</form>
					<h3>Current</h3>
					<?php 					
						mysqli_stmt_close($stmt);
						updateStatisticForm($c, $current, ""); ?>
					<h3>Max</h3>
					<?php 
						updateStatisticForm($c, $max, ""); 
				}
			}
		?>
	</body>
</html>
<?php
	close($c);
?>