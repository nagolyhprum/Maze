<?php
	require "classes/DAO.php";
	$column = (int)$_GET["column"];
	$row = (int)$_GET["row"];
	$sofarsogood = 1;
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {
			$now = currentTimeMillis();
			if($character->CharacterCanMove <= $now && ((abs($row - $character->CharacterRow) + abs($column - $character->CharacterColumn)) == 1)) {
				foreach($character->getOne("Room")->getMany("EnemyInRoom") as $eir) {
					if($eir->EnemyInRoomRow === $row && $eir->EnemyInRoomColumn === $column) {					
						$name = new DAO("StatisticName", "StatisticNameValue='health'");
						$health = new DAO("StatisticAttribute", "StatisticID=? AND StatisticNameID=?", array($eir->StatisticID, $name->StatisticNameID));
						if($health->StatisticAttributeValue > 0) {
							$sofarsogood = 0;
						}
						break;
					}				
				}
				if($sofarsogood) {
					$room = $character->getOne("Room"); //get the current room
					if(
						($row >= 0 && $row < ROOM_ROWS && $column >= 0 && $column < ROOM_COLUMNS)  //in bounds
							|| 
						(!($room->RoomWalls & WALL_UP) && $row == -1 && $column == floor(ROOM_COLUMNS / 2)) //going up
							|| 
						(!($room->RoomWalls & WALL_DOWN) && $row == ROOM_ROWS && $column == floor(ROOM_COLUMNS / 2)) //going down
							|| 
						(!($room->RoomWalls & WALL_LEFT) && $row == floor(ROOM_ROWS / 2) && $column == -1) //going left
							|| 
						(!($room->RoomWalls & WALL_RIGHT) && $row == floor(ROOM_ROWS / 2) && $column == ROOM_COLUMNS) //going right
					) {
						//change rooms logic
						if($column === ROOM_COLUMNS) {
							$column = 0;
							$room->RoomColumn++;
						} else if($column === -1) {
							$column = ROOM_COLUMNS - 1;
							$room->RoomColumn--;
						} else if($row === ROOM_ROWS) {
							$row = 0;
							$room->RoomRow++;
						} else if($row === -1) {
							$row = ROOM_ROWS - 1;
							$room->RoomRow--;
						}
						//get the new room
						$room = new DAO("Room", "RoomRow=? AND RoomColumn=? AND MapID=?", array($room->RoomRow, $room->RoomColumn, $room->MapID));
						if($room->RoomID != $character->RoomID) {
							$eir = $room->getMany("EnemyInRoom");
							$eir->EnemyInRoomCanUse = $now;
							$eir->EnemyInRoomUsedAt = $now;
							$eir->update();
							$character->RoomID = $room->RoomID;
						} else {
							$character->CharacterCanUse = $now + $character->timeToMove();
						}
						$character->CharacterUsedAt = $now;
						$character->CharacterRow = $row;
						$character->CharacterColumn = $column;						
						$character->update();
						echo 1;
					}					
				}
			}			
		}
		DB::close();
	}
	echo "0";
?>