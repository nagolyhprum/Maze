<?php
	function startMap($character, $args, $from) {
		$mapmodel = $args["mapmodel"];
		if($character->RoomID === NULL) { //make sure this character is valid
			$mapmodel = new DAO("MapModel", $mapmodel);	//get the requested mapmodel			
			if($mapmodel->valid()) { //if the map model is valid
				foreach($mapmodel->getMany("RoomModelInMapModel") as $rmimm) { //go through all of the room models in this map model				
					foreach($rmimm->getOne("RoomModel")->getMany("EnemyInRoomModel") as $eirm) { //go through all of the enemies in each room model
						$enemy = $eirm->getOne("Enemy"); //get the associated enemy
						//set up simple data
						$enemy = array(
							"enemy" => $eirm->EnemyID,
							"statistic" => $enemy->StatisticID,
							"column" => $eirm->EnemyInRoomModelColumn,
							"row" => $eirm->EnemyInRoomModelRow
						);					
						$enemies[] = $enemy;
					}
					while($rmimm->RoomModelInMapModelCount > 0) { //add the room model for each count
						$roommodel[] = $enemies;
						--$rmimm->RoomModelInMapModelCount;
					}
				}
				shuffle($roommodel); //randomize the room models
				$map = new DAO("Map"); //make the map
				$map->insert(true);			
				makeMap(0, 0, $mapmodel->MapModelRows, $mapmodel->MapModelColumns, $rooms, $visited); //prepared the rooms for adding later
				$room = new DAO("Room"); //dao for creating rooms
				$room->MapID = $map->MapID; //for this map
				//$room->RoomIsDiscovered = 1; //DEBUG
				for($room->RoomRow = 0; $room->RoomRow < $mapmodel->MapModelRows; $room->RoomRow++) { //go through all of the rows
					for($room->RoomColumn = 0; $room->RoomColumn < $mapmodel->MapModelColumns; $room->RoomColumn++) { //and columns of this map
						$room->RoomWalls = $rooms[$room->RoomRow][$room->RoomColumn]["walls"] ^ WALL_ALL; //create the room with this wall data
						$room->insert(true);
						if(!$character->RoomID) { //if this is the first room then put the character here
							$character->RoomID = $room->RoomID;
							$character->CharacterColumn = floor(ROOM_COLUMNS / 2);
							$character->CharacterRow = floor(ROOM_ROWS / 2);
							$character->CharacterLastEnergyUpdate = currentTimeMillis();
							$character->update();
							$current = $character->getOne("Statistic", "CharacterCurrentStatisticID")->getMany("StatisticAttribute");
							$max = $character->getOne("Statistic", "CharacterMaxStatisticID")->getMany("StatisticAttribute");
							foreach($current as $c) {
								foreach($max as $m) {
									if($c->StatisticNameID == $m->StatisticNameID) {
										$c->StatisticAttributeValue = $m->StatisticAttributeValue;
										$c->update();
										break;
									}
								}
							}
						} else { //otherwise put the enemies here
							$enemyinroom = new DAO("EnemyInRoom"); //dao for adding enemies
							$enemyinroom->RoomID = $room->RoomID; //into this room
							for($i = 0; $i < count($roommodel[0]); $i++) { //go through all of the simplified arrays we made earlier
								$eirm = $roommodel[0][$i];
								$enemyinroom->EnemyInRoomColumn = $eirm["column"];
								$enemyinroom->EnemyInRoomRow = $eirm["row"];
								$enemyinroom->EnemyID = $eirm["enemy"];
								$statistic = new DAO("Statistic", $eirm["statistic"]);
								$attribute = $statistic->getMany("StatisticAttribute");						
								$attribute->StatisticID = $enemyinroom->StatisticID = $statistic->insert(true)->StatisticID;
								$attribute->insert();
								$enemyinroom->insert();
							}
							array_shift($roommodel);
						}
					}
				}
			}
		}
	}
	
	function makeMap($fromrow, $fromcolumn, $rows, $columns, &$rooms, &$visited) {
		$visited[$fromrow][$fromcolumn] = true;
		$unvisited = array(WALL_UP, WALL_RIGHT, WALL_DOWN, WALL_LEFT);
		while(count($unvisited)) {
			$tocolumn = $fromcolumn;
			$torow = $fromrow;
			$direction = array_splice($unvisited, floor(mt_rand(0, count($unvisited))), 1);
			$direction = $direction[0];
			if($direction === WALL_UP) {
				$torow--;
			}
			if($direction === WALL_RIGHT) {
				$tocolumn++;
			}
			if($direction === WALL_DOWN) {
				$torow++;
			}
			if($direction === WALL_LEFT) {
				$tocolumn--;
			}
			if($torow >= 0 && $tocolumn >= 0 && $torow < $rows && $tocolumn < $columns && !$visited[$torow][$tocolumn]) {
				$rooms[$fromrow][$fromcolumn]["walls"] ^= $direction;
				$rooms[$torow][$tocolumn]["walls"] ^= oppositeDirection($direction);
				makeMap($torow, $tocolumn, $rows, $columns, $rooms, $visited);
			}
		}
	}

	function oppositeDirection($direction) {
		switch($direction) {
			case WALL_UP : return WALL_DOWN;
			case WALL_RIGHT : return WALL_LEFT;
			case WALL_DOWN : return WALL_UP;
			case WALL_LEFT : return WALL_RIGHT;
		}
	}
?>