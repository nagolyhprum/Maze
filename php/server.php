<?php
	require_once 'ratchet/vendor/autoload.php';
		
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
		}

		public function onMessage(ConnectionInterface $from, $msg) {
		}

		public function onClose(ConnectionInterface $conn) {
			$this->clients->detach($conn);
		}

		public function onError(ConnectionInterface $conn, \Exception $e) {
			$conn->close();
		}
	}

    $server = IoServer::factory(new WsServer(new WorldTactics()), 8080);

    $server->run();
?>