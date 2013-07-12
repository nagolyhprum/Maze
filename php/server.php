<?php
	require_once("ratchet/vendor/autoload.php");

	require_once("getBadges.php");
	
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
			echo "connected\n";
		}

		public function onMessage(ConnectionInterface $from, $json) {
			$json = json_decode($json, true);
			$action = $json["action"];
			$args = $json["args"];
			if($action && $args) {
				switch($action) {
					case "Initialize" :
						$from->send(getBadges());
						echo "Sending the badges.";
						break;
				}
			}
		}

		public function onClose(ConnectionInterface $conn) {
			$this->clients->detach($conn);
			echo "disconnected\n";
		}

		public function onError(ConnectionInterface $conn, \Exception $e) {
			$conn->close();
		}
	}

    $server = IoServer::factory(new WsServer(new WorldTactics()), 8080);

    $server->run();
?>