<?php
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
	
	function onOpen($conn) {
		echo "Connected\n";
	}
		
	function onMessage($from, $json) {		
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
						startMap($from->character, $args, $from); //TODO
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
					moveCharacter($from->character, $args, $from);
					break;
				case "SendDamage" :
					$from->character->rewind();
					sendDamage($from->character, $args, $from);
					break;
				case "EquipItem" :
					$from->character->rewind();
					equipItem($from->character, $args, $from);
					break;
				case "PickUpItem" :
					$from->character->rewind();
					pickupItem($from->character, $from);
					break;
				case "MoveEnemy" :
					if($from->character) {
						$from->character->rewind();
						moveEnemy($from->character, $from);
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

	function onClose($conn) {
		$conn->character = null;
		echo "Disconnected\n";
	}

	set_time_limit(0);

	ob_implicit_flush();

	$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	socket_bind($server, "127.0.0.1", 8080);
	socket_listen($server, 0);
	socket_set_nonblock($server); 
	$sockets = array();
	while(true) {
		if($socket = @socket_accept($server)) {		
			$sockets[] = new Socket($socket);
			onOpen($socket);
		}	
		for($i = 0; $i < count($sockets); $i++) {
			$socket = $sockets[$i];
			if($socket->character) {
				$socket->character->rewind();
				moveEnemy($socket->character, $socket);
			}
			if($msg = $socket->receive()) {
				onMessage($socket, $msg);
			}
			if($socket->isClosed()) {
				onClose($socket);
				array_splice($sockets, $i, 1);
				--$i;
			}
		}		
		time_nanosleep(0 , 1000);
	}

	function getHeader($headers, $header) {
		if(preg_match("/$header: (.*)/i", $headers, $matches) !== false) {
			return trim($matches[1]);
		}
	}

	function decode($payload) {
		$length = ord($payload[1]) & 127;
	 
		if($length == 126) {
			$masks = substr($payload, 4, 4);
			$data = substr($payload, 8);
		} elseif($length == 127) {
			$masks = substr($payload, 10, 4);
			$data = substr($payload, 14);
		} else {
			$masks = substr($payload, 2, 4);
			$data = substr($payload, 6);
		}
	 
		$text = '';
		for ($i = 0; $i < strlen($data); ++$i) {
			$text .= $data[$i] ^ $masks[$i % 4];
		}
		return $text;
	}

	function encode($text) {
		$first = "\x01";
		$continue = "\x00";
		$first_last = "\x81";
		$last = "\x80";
		$jump = 125;
		$encoded = "";
		for($i = 0; $i < strlen($text); $i += $jump) {
			$length = min($i + $jump, strlen($text)) - $i;
			if($jump >= strlen($text)) {
				$encoded .= $first_last . chr($length) . substr($text, $i, $length);
			} else if($i + $jump >= strlen($text)) {
				$encoded .= $last . chr($length) . substr($text, $i, $length);			
			} else if($encoded) {
				$encoded .= $continue . chr($length) . substr($text, $i, $length);						
			} else {
				$encoded .= $first . chr($length) . substr($text, $i, $length);						
			}
		}
		return $encoded;
	}

	class Socket {

		private $socket;
		private $hasheaders = false;
		private $closed = false;
		private $data = array();
		public $character;
		
		public function __get($name) {
			return $this->data[$name];
		}
		
		public function __set($name, $value) {
			$this->data= $value;
		}
		
		public function __construct($socket) {
			$this->socket = $socket;
		}
		
		public function close() {
			socket_close($this->socket);
			$this->closed = true;
		}
		
		public function isClosed() {
			return $this->closed;
		}
		
		public function send($msg) {
			$msg = encode($msg);			
			socket_write($this->socket, $msg, strlen($msg));			
			if($errorcode = socket_last_error($this->socket)) {
				$errormsg = socket_strerror($errorcode);
			}
		}
		
		public function receive() {		
			if($this->hasheaders) {		
				if($msg = socket_read($this->socket, 2048)) {
					return decode($msg);
				}
				if($msg !== false) {
					socket_close($this->socket);
					$this->closed = true;
				}
			} else {
				$this->handshake();
			}
		}
		
		public function handshake() {		
			if($msg = socket_read($this->socket, 2048)) {
				$version = getHeader($msg, "Sec-WebSocket-Version");
				if($version == 13) {
					$key = getHeader($msg, "Sec-WebSocket-Key");
					$key = base64_encode(sha1($key . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));
					$talkback = "HTTP/1.1 101 Switching Protocols\r\n" .
						"Upgrade: websocket\r\n" .
						"Connection: Upgrade\r\n" .
						"Sec-WebSocket-Accept: $key\r\n\r\n";
					socket_write($this->socket, $talkback, strlen($talkback));
					$this->hasheaders = true;
				} else {
					$talkback = "HTTP/1.1 400 Bad Request\r\n" .
						"Sec-WebSocket-Version: 13\r\n\r\n";
					socket_write($this->socket, $talkback, strlen($talkback));
				}
			}
		}
	}
?>
