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
			$stmt = mysqli_prepare($c, "DELETE FROM CharacterSkill WHERE CharacterSkillID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO CharacterSkill (CharacterID, SkillID, CharacterSkillIndex, CharacterSkillExpireTime) VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["character"], $_POST["skill"], $_POST["index"], $_POST["expiretime"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE CharacterSkill SET CharacterID=?, SkillID=?, CharacterSkillIndex=?, CharacterSkillExpireTime=? WHERE CharacterSkillID=?");
			mysqli_stmt_bind_param($stmt, "iiisi", $_POST["character"], $_POST["skill"], $_POST["index"], $_POST["expiretime"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
	$characters = getNameID($c, "Character");
	$skills = getNameID($c, "Skill");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Character Skill</h2>
		<form method="post" action="crudCharacterSkill.php">
			<div>
				Character
				<select name="character">
					<?php asOptions($characters, -1); ?>
				</select>
			</div>
			<div>
				Skill
				<select name="skill">
					<?php asOptions($skills, -1); ?>
				</select>
			</div>
			<div>
				Skill Index <input type="text" name="index"/>
			</div>
			<div>
				Expire Time <input type="text" name="expiretime"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<?php
			if($c) {
				$stmt = mysqli_prepare($c, "SELECT CharacterSkillID, CharacterSkillExpireTime, CharacterSkillIndex, SkillID, CharacterID FROM CharacterSkill");		
				mysqli_stmt_bind_result($stmt, $id, $expiretime, $index, $skill, $character);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
					<hr/>
					<form method="post" action="crudCharacterSkill.php" >
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>						
						<div>
							Character
							<select name="character">
								<?php asOptions($characters, $character); ?>
							</select>
						</div>
						<div>
							Skill
							<select name="skill">
								<?php asOptions($skills, $skill); ?>
							</select>
						</div>
						<div>
							Skill Index <input type="text" name="index" value="<?php echo $index; ?>"/>
						</div>
						<div>
							Expire Time <input type="text" name="expiretime" value="<?php echo $expiretime; ?>"/>
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