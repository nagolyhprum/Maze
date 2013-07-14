<?php
	require_once("db.php");
	require_once("Helper.php");
	require_once("crudStatistic.php");
	$c = connect();
	if($c) {
		$_POST["isadd"] = $_POST["isadd"] === "on";
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "
				DELETE ss, s FROM 
					SkillStatistic as ss
				INNER JOIN
					Statistic as s
				ON
					ss.StatisticID=s.StatisticID
				WHERE 
					SkillStatisticID=?
			");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$statistic = createStatistic($c, "");
			$stmt = mysqli_prepare($c, "INSERT INTO SkillStatistic (StatisticID, SkillID, SkillStatisticIsAdd, SkillStatisticDuration) VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "iiii", $statistic, $_POST["skill"], $_POST["isadd"], $_POST["duration"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Skill Statistic") {
			$stmt = mysqli_prepare($c, "UPDATE SkillStatistic SET SkillID=?, SkillStatisticIsAdd=?, SkillStatisticDuration=? WHERE SkillStatisticID=?");
			mysqli_stmt_bind_param($stmt, "iiii", $_POST["skill"], $_POST["isadd"], $_POST["duration"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update Statistic") {
			updateStatistic($c, "");
		}
	}
	$skills = getNameID($c, "Skill");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>Skill Statistic</h2>
		<form method="post" action="crudSkillStatistic.php">
			<div>
				Skill
				<select name="skill">
					<?php asOptions($skills); ?>
				</select>
			</div>
			<div>
				Duration <input type="text" name="duration"/>
			</div>
			<div>
				Is Add <input type="checkbox" name="isadd"/>
			</div>
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
							SkillStatisticID,
							SkillID,
							SkillStatisticIsAdd,
							SkillStatisticDuration,						
							StatisticID
						FROM 
							SkillStatistic as ss
						LIMIT ?, 1
					");		
					mysqli_stmt_bind_param($stmt, "i", $i);
					mysqli_stmt_bind_result($stmt, $id, $skill, $isadd, $duration, $statistic);
					mysqli_stmt_execute($stmt);
					if(!mysqli_stmt_fetch($stmt)) {
						break;
					}
					?>
					<hr/>
					<form action="crudSkillStatistic.php" method="post">
						<input name="id" type="hidden" value="<?php echo $id; ?>"/>										
						<div>
							Skill
							<select name="skill">
								<?php asOptions($skills, $skill); ?>
							</select>
						</div>
						<div>
							Duration <input type="text" name="duration" value="<?php echo $duration; ?>"/>
						</div>
						<div>
							Is Add <input type="checkbox" name="isadd" <?php echo $isadd ? "checked" : ""; ?>/>
						</div>
						<input type="submit" name="action" value="Delete"/>
						<input type="submit" name="action" value="Update Skill Statistic"/>
					</form>
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