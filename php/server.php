<?php
	require_once("ratchet/vendor/autoload.php");

	require_once("classes/DAO.php");
	require_once("getItem.php");
	require_once("getSkill.php");
	
	require_once("getBadges.php");
	require_once("getCharacterRoomLocation.php");
	require_once("getItemsInInventory.php");
	require_once("getCharacter.php");
	require_once("getSkills.php");	
	require_once("getWalls.php");
	require_once("getTiles.php");
	require_once("getEquipment.php");
	require_once("getAllWalls.php");
	require_once("moveCharacter.php");
	require_once("getRoomEnemies.php");
	require_once("sendDamage.php");
	require_once("getItemsInRoom.php");
	
	require_once("pickupItem.php");
	require_once("equipItem.php");
	
	require_once("moveEnemy.php");
	
	
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
							getBadges($from);
							getTiles($from);
							getCharacterRoomLocation($from->character, $from);
							getItemsInInventory($from->character, $from);
							getCharacter($from->character, $from);
							getSkills($from->character, $from);
							getWalls($from->character, $from);
							getEquipment($from->character, $from);
							getAllWalls($from->character, $from);
							getRoomEnemies($from->character, $from);
							getItemsInRoom($from->character, $from);
						}						
						break;
					case "MoveCharacter" :
						$from->character-rewind();
						moveCharacter($from->character, $args, $from);
						break;
					case "SendDamage" :
						$from->character-rewind();
						sendDamage($from->character, $args, $from);
						break;
					case "EquipItem" :
						$from->character-rewind();
						equipItem($from->character, $args, $from);
						break;
					case "PickUpItem" :
						$from->character-rewind();
						pickupItem($from->character, $args, $from);
						break;
					case "MoveEnemy" :
						$from->character-rewind();
						moveEnemy($from->character, $args, $from);
						break;
				}
			}
		}

		public function onClose(ConnectionInterface $conn) {
			$conn = null;
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