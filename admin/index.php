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
				<!--COMPLETE--><li><a href="crudAttackType.php">Attack Type</a></li>
				<!--AUDIO - NO NEED-->
				<!--COMPLETE BUT BEHAVED STRANGELY--><li><a href="crudBadge.php">Badge</a></li>
				<!--COMPLETE--><li><a href="crudCategory.php">Category</a></li>
				<!--MAY NEED TO ALTER ROWS AND COLUMNS--><li><a href="crudCharacter.php">Character</a></li>
				<!--COMPLETE--><li><a href="crudCharacterAudio.php">Character Audio</a></li>
				<!--COMPLETE--><li><a href="crudCharacterImage.php">Character Image</a></li>
				<!--COMPLETE--><li><a href="crudCharacterImageChoice.php">Character Image Choice</a></li>
				<!--COMPLETE--><li><a href="crudCharacterImageChoiceGroup.php">Character Image Choice Group</a></li>
				<!--COMPLETE--><li><a href="crudCharacterSkill.php">Character Skill</a></li>
				<!--COMPLETE--><li><a href="crudEnemy.php">Enemy</a></li>
				<!--COMPLETE--><li><a href="crudEnemyAudio.php">Enemy Audio</a></li>
				<!--COMPLETE--><li><a href="crudEnemyImage.php">Enemy Image</a></li>
				<!--COMPLETE--><li><a href="crudEnemyItemModel.php">Enemy Item Model</a></li>
				<!--ENEMY IN ROOM - NO NEED-->
				<!--IMAGE - NO NEED-->
				<!--ITEM - NO NEED-->
				<!--ITEM IN EQUIPMENT - NO NEED-->
				<!--ITEM IN INVENTORY - NO NEED-->
				<!--ITEM IN ROOM - NO NEED-->
				<!--COMPLETE--><li><a href="crudItemModel.php">Item Model</a></li>
				<!--COMPLETE--><li><a href="crudItemModelAudio.php">Item Model Audio</a></li>
				<!--COMPLETE--><li><a href="crudItemModelImage.php">Item Model Image</a></li>
				<!--COMPLETE--><li><a href="crudItemType.php">Item Type</a></li>
				<!--MAP - NO NEED-->
				<!--ROOM - NO NEED-->
				<!--COMPLETE--><li><a href="crudSkill.php">Skill</a></li>
				<!--COMPLETE--><li><a href="crudSkillStatistic.php">Skill Statistic</a></li>
				<!--STATISTIC - NO NEED-->
				<!--COMPLETE--><li><a href="crudSubcategory.php">Subcategory</a></li>
				<!--COMPLETE--><li><a href="crudUser.php">User</a></li>
				<!--USER BEHAVIOR - NO NEED-->
				<li><a href="crudMapModel.php">Map Model</a></li>
				<li><a href="crudRoomModel.php">Room Model</a></li>
				<li><a href="crudRoomModelInMapModel.php">Room Model in Map Model</a></li>
				<li><a href="crudEnemyInRoomModel.php">Enemy in Room Model</a></li>
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