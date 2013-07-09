<?php
	require_once("classes/DAO.php");
	if(DB::connect()) {
		$character = new Character();
		if($character->valid()) {		
			$enemies = array();
			$health = new DAO("StatisticName", "StatisticNameValue='health'");
			foreach($character->getOne("Room")->getMany("EnemyInRoom") as $re) {				
				$h = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($health->StatisticNameID, $re->StatisticID));
				if($h->StatisticAttributeValue > 0) {
					$e = $re->getOne("Enemy");				
					
					$enemy = array(
						"id" => $re->EnemyInRoomID,
						"name" => $e->EnemyName,
						"location" => array(
							"column" => $re->EnemyInRoomColumn,
							"row" => $re->EnemyInRoomRow
						),
						"display" => array(
							"row" => $re->EnemyInRoomDirection
						)
					);
					foreach($re->getMany("StatisticAttribute", "StatisticID") as $sa) {
						$enemy["statistics"][$sa->getOne("StatisticName")->StatisticNameValue]["current"] = $sa->StatisticAttributeValue;
					}
					foreach($e->getMany("StatisticAttribute", "StatisticID") as $sa) {
						$enemy["statistics"][$sa->getOne("StatisticName")->StatisticNameValue]["max"]	= $sa->StatisticAttributeValue;
					}
					foreach($e->getMany("EnemyImage") as $ei) {
						$enemy[$ei->getOne("AttackType")->AttackTypeName][] = array(
							"columns" => $ei->EnemyImageColumns,
							"rows" => $ei->EnemyImageRows,
							"src" => $ei->getOne("Image")->ImageName
						);
					}
					foreach($e->getMany("EnemyAudio") as $ea) {
						$enemy["sounds"][$ea->getOne("AttackType")->AttackTypeName][] = $ea->getOne("Audio")->AudioName;
					}
					$enemies[] = $enemy;
				}
			}
			echo json_encode($enemies);
		}
		DB::close();
	}
?>