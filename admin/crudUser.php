<?php
	require_once("db.php");
	require_once("Helper.php");
	$c = connect();
	if($c) {
		if($_POST["action"] === "Delete") {		
			$stmt = mysqli_prepare($c, "DELETE FROM User WHERE UserID=?");
			mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Create") {
			$stmt = mysqli_prepare($c, "INSERT INTO User (UserName, UserFacebookID) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt, "si", $_POST["name"], $_POST["fbid"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} else if($_POST["action"] === "Update") {
			$stmt = mysqli_prepare($c, "UPDATE User SET UserName=?, UserFacebookID=? WHERE UserID=?");
			mysqli_stmt_bind_param($stmt, "sii", $_POST["name"], $_POST["fbid"], $_POST["id"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	}
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<script type="text/javascript" src="script/template.js"></script>
	</head>
	<body>
		<h2>User</h2>
		<form method="post" action="crudUser.php" >
			<div>
				Name <input type="text" name="name"/>
			</div>
			<div>
				Facebook ID <input type="text" name="fbid"/>
			</div>
			<div>
				<input type="submit" name="action" value="Create"/>
			</div>
		</form>
		<div>
			<?php
				$stmt = mysqli_prepare($c, "SELECT UserFacebookID, UserName, UserID FROM User");
				mysqli_stmt_bind_result($stmt, $fbid, $name, $id);
				mysqli_stmt_execute($stmt);
				while(mysqli_stmt_fetch($stmt)) {
					?>
						<hr/>
						<form action="crudUser.php" method="post">
							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<div>
								Name <input type="text" name="name" value="<?php echo $name; ?>"/>
							</div>
							<div>
								Facebook ID <input type="text" name="fbid" value="<?php echo $fbid; ?>"/>
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
		</div>
	</body>
</html>
<?php
	close($c);
?>