<?php
	require_once("classes/DAO.php");	
	if(DB::connect()) { 
		$character = new Character(); //get the currently used character
		if($character->isValid()) { //if it is valid
			//get the current statistics
			foreach($character->getOne("Statistic", "CharacterCurrentStatisticID")->getMany("StatisticAttribute") as $attribute) {
				$statistics[$attribute->getOne("StatisticName")->StatisticNameValue]["current"] = $attribute->StatisticAttributeValue;
			}
			//get the max statistics
			foreach($character->getOne("Statistic", "CharacterMaxStatisticID")->getMany("StatisticAttribute") as $attribute) {
				$statistics[$attribute->getOne("StatisticName")->StatisticNameValue]["max"] = $attribute->StatisticAttributeValue;
			} 
			//get the audio
			$characteraudio = new DAO("CharacterAudio", "CharacterAudioIsMale=@0 OR CharacterAudioIsMale IS NULL", array($character->CharacterIsMale));
			foreach($characteraudio as $audio) {
				$sounds[$audio->getOne("AttackType")->AttackTypeName] = $audio->getOne("Audio")->AudioName;
			}
			//build what we have so far
			$json = array(
				"name" => $character->CharacterName,
				"portrait" => $character->getOne("Image")->ImageName,
				"display" => array("row" => $character->CharacterDirection),
				"location" => array(
					"row" => $character->CharacterRow,
					"column" => $character->CharacterColumn
				),
				"statistics" => $statistics,
				"sounds" => $sounds
			);
			//get the images
			foreach($character->getMany("CharacterImage") as $ci) {
				$cicg = $ci->getOne("CharacterImageChoiceGroup");
				foreach($cicg->getMany("CharacterImageChoice") as $cic) {
					$json[$cic->getOne("AttackType")->AttackTypeName][] = array(
						"columns" => $cic->CharacterImageChoiceColumns,
						"rows" => $cic->CharacterImageChoiceRows,
						"src" => $cic->getOne("Image")->ImageName
					);
				}
			}			
			echo json_encode($json);
		}
		DB::close();
	}
?>