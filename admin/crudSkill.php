<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		$_POST["isactive"] = $_POST["isactive"] === "on";
		if(!$_POST["attacktype"]) {
			$_POST["attacktype"] = NULL;
		}
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM Skill WHERE SkillID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO Skill (SkillName, SkillDescription, SkillIcon, AttackTypeID, SkillIsActive, SkillCooldown, SkillEnergy, SkillArea) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "ssiiiiii", $_POST["name"], $_POST["description"], $_POST["icon"], $_POST["attacktype"], $_POST["isactive"], $_POST["cooldown"], $_POST["energy"], $_POST["area"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE Skill SET SkillName=?, SkillDescription=?, SkillCooldown=?, SkillEnergy=?, SkillArea=?, SkillIsActive=?, SkillIcon=?, AttackTypeID=? WHERE SkillID=?");
			mysqli_stmt_bind_param($stmt, "ssiiiiiii", $_POST["name"], $_POST["description"], $_POST["cooldown"], $_POST["energy"], $_POST["area"], $_POST["isactive"], $_POST["icon"], $_POST["attacktype"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$images = getNameID($c, "Image");
	$attacktypes = getNameID($c, "AttackType");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Skill</h2>
		<form method="post" action="crudSkill.php" >
			<div>
				Name <input type="text" name="name"/>
			</div>
			<div>
				Description <input type="text" name="description"/>
			</div>
			<div>
				Cooldown <input type="text" name="cooldown"/>
			</div>
			<div>
				Energy <input type="text" name="energy"/>
			</div>
			<div>
				Area <input type="text" name="area"/>
			</div>
			<div>
				Is Active <input type="checkbox" name="isactive"/>
			</div>
			<div>
				Icon
				<select name="icon" data-image>
					<?php asOptions($images, -1); ?>
				</select>
			</div>
			<div>
				Attack Type
				<select name="attacktype">
					<?php asOptions($attacktypes, -1); ?>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT SkillID, SkillName, SkillDescription, SkillCooldown, SkillEnergy, SkillArea, SkillIsActive, SkillIcon, AttackTypeID FROM Skill");		
				mysqli_stmt_bind_result($stmt, $id, $name, $description, $cooldown, $energy, $area, $isactive, $icon, $attacktype);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudSkill.php" >
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>						
						<div>
							Name <input type="text" name="name" value="<?php echo $name; ?>"/>
						</div>
						<div>
							Description <input type="text" name="description" value="<?php echo $description; ?>"/>
						</div>
						<div>
							Cooldown <input type="text" name="cooldown" value="<?php echo $cooldown; ?>"/>
						</div>
						<div>
							Energy <input type="text" name="energy" value="<?php echo $energy; ?>"/>
						</div>
						<div>
							Area <input type="text" name="area" value="<?php echo $area; ?>"/>
						</div>
						<div>
							Is Active <input type="checkbox" name="isactive" <?php echo $isactive ? "checked" : ""; ?>/>
						</div>
						<div>
							Icon
							<select name="icon" data-image>
								<?php asOptions($images, $icon); ?>
							</select>
						</div>
						<div>
							Attack Type
							<select name="attacktype">
								<?php asOptions($attacktypes, $attacktype); ?>
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