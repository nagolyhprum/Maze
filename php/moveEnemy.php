<?php
	require "classes/DAO.php";
	
	if(DB::connect()) {
		$character = new Character();
		if($character->isValid()) {
			$now = currentTimeMillis();
			$enemies = new DAO("EnemyInRoom", "RoomID=@0 AND EnemyInRoomCanUse <= @1 ORDER BY abs(@2 - EnemyInRoomRow) + abs(@3 - EnemyInRoomColumn) ASC", array($character->RoomID, $now, $character->CharacterRow, $character->CharacterColumn));			
			if($enemies->isValid()) {
				$strength = new DAO("StatisticName", "StatisticNameValue='strength'");
				$intelligence = new DAO("StatisticName", "StatisticNameValue='intelligence'");
				$speed = new DAO("StatisticName", "StatisticNameValue='speed'");
				$health = new DAO("StatisticName", "StatisticNameValue='health'");
				foreach($enemies as $enemy) {
					$h = new DAO("StatisticAttribute", "StatisticID=@0 AND StatisticNameID=@1", array($enemy->StatisticID, $health->StatisticNameID));
					if($h->StatisticAttributeValue > 0) {
						$tiles[$enemy->EnemyInRoomRow][$enemy->EnemyInRoomColumn] = 1;				
						$es[] = $enemy;
					}
				}			
				$h = new DAO("StatisticAttribute", "StatisticID=@0 AND StatisticNameID=@1", array($character->CharacterCurrentStatisticID, $health->StatisticNameID));	
				$health = $character->getStatistic("health");
				$defense = $character->getStatistic("defense");
				$resistance = $character->getStatistic("resistance");		
				$damage = 0;
				do {
					$again = 0;
					for($i = 0; $i < count($es); $i++) {
						$enemy = $es[$i];
						if($enemy->EnemyInRoomCanUse <= $now) {
							$s = new DAO("StatisticAttribute", "StatisticID=@0 AND StatisticNameID=@1", array($enemy->StatisticID, $speed->StatisticNameID));
							$enemy->EnemyInRoomCanUse += timeToMove($s->StatisticAttributeValue);
							if(abs($character->CharacterRow - $enemy->EnemyInRoomRow) + abs($character->CharacterColumn - $enemy->EnemyInRoomColumn) == 1) { //then attack
								$data[$i] = array(
									"lastRow" => $enemy->EnemyInRoomRow,
									"lastColumn" => $enemy->EnemyInRoomColumn,
									"row" => $enemy->EnemyInRoomRow,
									"column" => $enemy->EnemyInRoomColumn,
									"id" => $enemy->EnemyInRoomID
								);
								$str = new DAO("StatisticAttribute", "StatisticID=@0 AND StatisticNameID=@1", array($enemy->StatisticID, $strength->StatisticNameID));
								$str = ceil($str->StatisticAttributeValue - ($str->StatisticAttributeValue * $defense / 100));
								$int = new DAO("StatisticAttribute", "StatisticID=@0 AND StatisticNameID=@1", array($enemy->StatisticID, $intelligence->StatisticNameID));
								$int = ceil($int->StatisticAttributeValue - ($int->StatisticAttributeValue * $resistance / 100));
								$damage += max($str, $int);
							} else { //then move
								$next = getNextMove($tiles, array("row" => $enemy->EnemyInRoomRow, "column" => $enemy->EnemyInRoomColumn), array("row" => $character->CharacterRow, "column" => $character->CharacterColumn));								
								$tiles[$enemy->EnemyInRoomRow][$enemy->EnemyInRoomColumn] = 0;
								$data[$i] = array(
									"lastRow" => $enemy->EnemyInRoomRow,
									"lastColumn" => $enemy->EnemyInRoomColumn,
									"row" => ($enemy->EnemyInRoomRow = $next["row"]),
									"column" => ($enemy->EnemyInRoomColumn = $next["column"]),
									"id" => $enemy->EnemyInRoomID
								);
								$tiles[$enemy->EnemyInRoomRow][$enemy->EnemyInRoomColumn] = 1;
							}
							$again = 1;
						}
						$es[$i] = $enemy;
					}		
				} while($again && ($health - $damage) > 0);				
				$h->StatisticAttributeValue -= $damage;
				$h->update();
				foreach($es as $e) {
					$e->EnemyInRoomUsedAt = $now;
					$e->update();
				}
			}			
			echo json_encode(array("character" => array("health" => $health - $damage), "enemies" => $data, "cts" => $now));
		}
		DB::close();
	}
	
	class LocationPQ extends SplPriorityQueue { 
	
		private $goal;
		
		public function __construct($location) {
			$this->goal = $location;
		}
		
		public function compare($location1, $location2) { 
			return $this->distance($location1) - $this->distance($location2);
		} 
		
		public function distance($location) {
			return (ROOM_COLUMNS * ROOM_ROWS) - (abs($location["column"] - $this->goal["column"]) + abs($location["row"] - $this->goal["row"]));
		}
	}

	function getNextMove($tiles, $start, $end) {
		$pq = new LocationPQ($end);
		$pq->insert($start, $start);
		while(!$pq->isEmpty()) {
			$current = $pq->extract();
			$r = $current["row"];
			$c = $current["column"];
			if($r == $end["row"] && $c == $end["column"]) {
				while($current["parent"]["parent"]) {
					$current = $current["parent"];
				}
				return $current;
			}
			if(!$visited[$r + 1][$c] && !$tiles[$r + 1][$c] && $r + 1 < ROOM_ROWS) {
				$pq->insert(array("row" => $r + 1, "column" => $c, "parent" => $current), array("column" => $c, "row" => $r + 1));
				$visited[$r + 1][$c] = 1;
			}
			if(!$visited[$r - 1][$c] && !$tiles[$r - 1][$c] && $r - 1 >= 0) {
				$pq->insert(array("row" => $r - 1, "column" => $c, "parent" => $current), array("column" => $c, "row" => $r - 1));
				$visited[$r - 1][$c] = 1;
			}
			if(!$visited[$r][$c + 1] && !$tiles[$r][$c + 1] && $c + 1 < ROOM_COLUMNS) {
				$pq->insert(array("row" => $r, "column" => $c + 1, "parent" => $current), array("column" => $c + 1, "row" => $r));
				$visited[$r][$c + 1] = 1;
			}
			if(!$visited[$r][$c - 1] && !$tiles[$r][$c - 1] && $c - 1 >= 0) {
				$pq->insert(array("row" => $r, "column" => $c - 1, "parent" => $current), array("column" => $c - 1, "row" => $r));
				$visited[$r][$c - 1] = 1;
			}
		}		
	}
?>