<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="script/jquery.js"></script>
		<style type="text/css">
			body {
				width : 640px;
				margin : auto;
			}
			#actions {
				width : 200px;
				float : left;
			}
			
			#actions ul {
				padding : 0;
				margin : 0;
			}
			
			#viewer {
				width : 440px;
				float : left;
			}
			
			#viewer iframe {
				width : 440px;
				height : 440px;
				border : none;
			}
		</style>
	</head>
	<body>
		<div id="actions">
			<ul>
				<li><a href="crudAttackType.php">Attack Type</a></li>
				<li><a href="crudBadge.php">Badge</a></li>
				<li><a href="crudCategory.php">Category</a></li>
				<li><a href="crudCharacter.php">Character</a></li>
				<li><a href="crudCharacterAudio.php">Character Audio</a></li>
				<li><a href="crudCharacterImage.php">Character Image</a></li>
				<li><a href="crudCharacterImageChoice.php">Character Image Choice</a></li>
				<li><a href="crudCharacterImageChoiceGroup.php">Character Image Choice Group</a></li>
				<li><a href="crudCharacterSkill.php">Character Skill</a></li>
				<li><a href="crudEnemy.php">Enemy</a></li>					
				<li><a href="crudEnemyAudio.php">Enemy Audio</a></li>				
				<li><a href="crudEnemyImage.php">Enemy Image</a></li>				
				
				<li><a href="crudItemType.php">Item Type</a></li>
				<li><a href="crudSkill.php">Skill</a></li>
				<li><a href="crudSubcategory.php">Subcategory</a></li>
				<li><a href="crudUser.php">User</a></li>
			</ul>
		</div>
		<div id="viewer">
			<iframe>IFrame not supported.</iframe>
		</div>
		<script type="text/javascript">
			var viewer = $("#viewer iframe")[0];
			$("a").click(function(e) {
				e.preventDefault();
				viewer.src = this.href;
			});
		</script>
	</body>
</html>