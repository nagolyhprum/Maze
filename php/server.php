<?php
	require("ratchet/vendor/autoload.php");
	require("classes/DAO.php");
	require("getItem.php");
	require("getSkill.php");	
	require("getBadges.php");
	require("getCharacterRoomLocation.php");
	require("getItemsInInventory.php");
	require("getCharacter.php");
	require("getSkills.php");	
	require("getWalls.php");
	require("getTiles.php");
	require("getEquipment.php");
	require("getAllWalls.php");
	require("moveCharacter.php");
	require("getRoomEnemies.php");
	require("sendDamage.php");
	require("getItemsInRoom.php");	
	require("pickupItem.php");
	require("equipItem.php");	
	require("moveEnemy.php");	
	require("getCharacterBehaviors.php");	
	require("startMap.php");
	require("addBehavior.php");
	require("healEnergy.php");
	require("reload.php");
	require("getSkillMapping.php");
	require("setSkillIndex.php");
	
	DB::connect();
	
	$character = new Character("CharacterID=?", array(1));
	
	use Ratchet\Server\IoServer;
	use Ratchet\WebSocket\WsServer;
	use Ratchet\MessageComponentInterface;
	use Ratchet\ConnectionInterface;

	class WorldTactics implements MessageComponentInterface {
	
		protected $clients;

		public function __construct() {
			$this->clients = new \SplObjectStorage;		
		}

		public function onOpen(ConnectionInterface $conn) {
			$this->clients->attach($conn);
			echo "Connected\n";
		}

		public function onMessage(ConnectionInterface $from, $json) {
			$json = json_decode($json, true);
			$action = $json["action"];
			$args = $json["args"];
			if($action && $args) {
				switch($action) {
					case "Initialize" :	
						global $character;
						$character->rewind();					
						if($character->valid()) {
							$from->character = $character;
							startMap($from->character, $args, $from);
							getBadges($from);
							getTiles($from);
							getCharacterBehaviors($from->character, $from);
							getCharacterRoomLocation($from->character, $from);
							getItemsInInventory($from->character, $from);
							getCharacter($from->character, $from);
							getSkills($from->character, $from);
							getWalls($from->character, $from);
							getEquipment($from->character, $from);
							getRoomEnemies($from->character, $from);
							getItemsInRoom($from->character, $from);
							getAllWalls($from->character, $from);
							getSkillMapping($from->character, $from);
						}						
						break;
					case "MoveCharacter" :
						$from->character->rewind();
						moveEnemy($from->character, $args, $from);
						$from->character->rewind();
						moveCharacter($from->character, $args, $from);
						break;
					case "SendDamage" :
						$from->character->rewind();
						moveEnemy($from->character, $args, $from);
						$from->character->rewind();
						sendDamage($from->character, $args, $from);
						break;
					case "EquipItem" :
						$from->character->rewind();
						equipItem($from->character, $args, $from);
						break;
					case "PickUpItem" :
						$from->character->rewind();
						pickupItem($from->character, $args, $from);
						break;
					case "MoveEnemy" :
						if($from->character) {
							$from->character->rewind();
							moveEnemy($from->character, $args, $from);
						}
						break;
					case "SetSkillIndex" :
						$from->character->rewind();
						setSkillIndex($from->character, $args, $from);
						break;
				}
				if($from->character) {
					$from->character->rewind();
					healEnergy($from->character, $from);
				}
			}
		}

		public function onClose(ConnectionInterface $conn) {
			$conn->character = null;
			$this->clients->detach($conn);
			echo "Disconnected\n";
		}

		public function onError(ConnectionInterface $conn, \Exception $e) {
			$conn->close();
		}
	}

    $server = IoServer::factory(new WsServer(new WorldTactics()), 8080);

    $server->run();
?>