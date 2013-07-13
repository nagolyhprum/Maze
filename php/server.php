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
							$from->send(getBadges());
							$from->send(getTiles());
							$from->send(getCharacterRoomLocation($from->character));
							$from->send(getItemsInInventory($from->character));
							$from->send(getCharacter($from->character));
							$from->send(getSkills($from->character));
							$from->send(getWalls($from->character));
							$from->send(getEquipment($from->character));
							$from->send(getAllWalls($from->character));
						}						
						break;
					case "MoveCharacter" :
						$from->character-rewind();
						moveCharacter($from->character, $args, $from);
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