<?php

	//WALLS
	
	define("WALL_NONE", 0);
	define("WALL_UP", 1);
	define("WALL_RIGHT", 2);
	define("WALL_DOWN", 4);
	define("WALL_LEFT", 8);
	define("WALL_ALL", 15);
	
	//DIRECTIONS
	
	define("DIRECTION_UP", 0);
	define("DIRECTION_RIGHT", 3);
	define("DIRECTION_DOWN", 2);
	define("DIRECTION_LEFT", 1);
	
	//ROOM	
	
	define("ROOM_ROWS", 7);
	define("ROOM_COLUMNS", 7);
	
	//USER
	
	$USER = 1;
	
	class DB {
		private static $connection;
		
		/*
			Connects to the databse
		*/
		public static function connect() {
			DB::$connection = mysqli_connect("localhost", "root", "root", "worldtactics");			
			return DB::$connection;
		}
		
		/*
			Disconnects from the databse
		*/
		public static function close() {
			mysqli_close(DB::$connection);
		}
		
		public static function getConnection() {
			if(!DB::$connection) {
				DB::connect();
			}
			return DB::$connection;
		}
	}
	
	class DAO implements Iterator {		
		
		private $table;
		private $data = array();
		private $isValid = false;
		private $position = 0;			
		
		function rewind() {
			$this->position = 0;
		}

		function current() {
			return new DAO($this->table, $this->data[$this->position]);
		}

		function key() {
			return $this->position;
		}

		function next() {
			++$this->position;
		}

		function valid() {
			return isset($this->data[$this->position]);
		}
		
		/*
			Sets up the object for inserting or selection
		*/
		public function __construct($table, $condition, $parameters) {
			$this->table = $table; 
			if($condition) { //if there is a condition then we are selecting or have already selected
				if(is_array($condition)) { //if the condition is an array then we have already selected
					$this->data[0] = $condition;
					return;
				}
				if(is_numeric($condition)) { //if the condition is a number then we will set up for id selection for this table
					$parameters = array($condition);
					$condition = $table . "ID=@0";
				}
				$index = "0";
				foreach($parameters as $key => $value) { //i need to escape % and then unescape
					$stmt = mysqli_prepare(DB::getConnection(), "SET @$index = ?;");
					mysqli_stmt_bind_param($stmt, is_numeric($value) ? "i" : "s", $value);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					$index++;
				}
				if($result = mysqli_query(DB::getConnection(), "SELECT * FROM `" . mysqli_real_escape_string(DB::getConnection(), $table) . "` WHERE $condition")) { //get the table result
					while($row = mysqli_fetch_assoc($result)) { //get each row
						//convert any numeric columns into numbers
						foreach($row as $key => &$value) {
							if(is_numeric($value)) {
								$value = (double)$value;
							} else if(!$value) {
								$value = null;
							}
						}
						$this->data[] = $row;
						$this->isValid = true;
					}
					mysqli_free_result($result);
				}
			} else { //we are attempting to do an insert and should at least provide the fields necessary
				if($result = mysqli_query(DB::getConnection(), "SHOW COLUMNS IN `" . mysqli_real_escape_string(DB::getConnection(), $table) . "`")) {					
					while($row = mysqli_fetch_assoc($result)) {
						$value = $row["Default"];
						if(is_numeric($value)) {
							$value = (double)$value;
						} else {
							$value = null;
						}
						$this->data[0][$row["Field"]] = $value;
					}
					mysqli_free_result($result);
				}
			}
		}
		
		/*
			MAGIC methods that allow convenient getting, setting, testing, and debugging
		*/
		public function __get($property) {
			if(substr($propery, 0, 3) === "ALL") {
				$property = substr($propery, 3);
				for($i = 0; $i < count($data); $i++) {
					$r[] = $this->data[$i]->data[$property];
				}
			} else {
				return $this->data[0][$property];
			}
		}

		public function __set($property, $value) {
			for($i = 0; $i < count($this->data); $i++) {				
				$this->data[$i][$property] = $value;
			}
		}
		
		public function __isset($property) {
			return isset($this->$data[0][$property]);
		}
		
		public function __toString() {
			return json_encode($this->data);
		}
	
		/*
			This table has the specified column which is a foreign key to the specified table
		*/
		public function getOne($table, $column) {
			$column = $column ? $column : $table . "ID";			
			for($i = 0; $i < count($this->data); $i++) {			
				$dao = new DAO($table, $this->data[$i][$column]);
				$this->data[$i][substr($column, 0, strlen($column) - 2)] = $dao;				
				$dao->data[$i][$this->table] = $this;
			}
			return $dao;
		}
		
		public function insert() {
			for($i = 0; $i < count($this->data); $i++) {
				$columns = "";
				$values ="";
				$index = "0";
				foreach($this->data[$i] as $key => $value) {
					if($key !== ($this->table . "ID") && !($value instanceof DAO)) {
						if($columns) {
							$columns .= ", ";
						}
						$columns .= "`" . mysqli_real_escape_string(DB::getConnection(), $key) . "`";
						if($values) {
							$values .= ", ";
						}
						$values .= "@$index";
						$stmt = mysqli_prepare(DB::getConnection(), "SET @$index = ?;");
						mysqli_stmt_bind_param($stmt, is_numeric($value) ? "i" : "s", $value);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						$index++;
					}
				}
				mysqli_query(DB::getConnection(), "INSERT INTO `" . mysqli_real_escape_string(DB::getConnection(), $this->table) . "` ($columns) VALUES ($values)");
				$this->data[$i][$this->table . "ID"] = mysqli_insert_id(DB::getConnection());
			}
			return $this;
		}
		
		public function update() {		
			for($i = 0; $i < count($this->data); $i++) {
				$index = "0";
				$set = "";
				foreach($this->data[$i] as $key => $value) {
					if($key !== ($this->table . "ID") && !($value instanceof DAO)) {
						if($set) {
							$set .= ", ";
						}
						$set .= "`" . mysqli_real_escape_string(DB::getConnection(), $key) . "`=@$index";
						$stmt = mysqli_prepare(DB::getConnection(), "SET @$index = ?;");
						mysqli_stmt_bind_param($stmt, is_numeric($value) ? "i" : "s", $value);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);						
						$index++;
					}
				}
				$id = $this->data[$i][$this->table . "ID"];
				$stmt = mysqli_prepare(DB::getConnection(), "SET @$index = ?;");
				mysqli_stmt_bind_param($stmt, "i", $id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				mysqli_query(DB::getConnection(), "UPDATE `" . mysqli_real_escape_string(DB::getConnection(), $this->table) . "` SET $set WHERE " . $this->table . "ID=@$index");				
			}
			return $this;
		}
		
		/*
			Gets all rows that have a relationship with this one in the specified table
		*/
		public function getMany($table, $column) {
			$column = $column ? $column : $this->table . "ID";
			$tid = $this->table;				
			for($i = 0; $i < count($this->data); $i++) {
				$dao = $this->data[$i][$table] = new DAO($table, "`" . $column . "`=@0", array($this->data[$i][$column]));				
				$dao->$tid = $this; //because i want to set all of them
			}
			return $this->data[0][$table];
		}
		
		public function isValid() {
			return $this->isValid;
		}		
		
		public function size() {
			return count($this->data);
		}
	}
		
	
	class Character extends DAO {
	
		public function __construct($condition, $parameters) {
			if(!$condition) {
				session_start();
				$_SESSION["user"] = 1;
				parent::__construct("Character", "CharacterID=@0 AND UserID=@1", array((double)$_GET["cid"], $_SESSION["user"]));
				session_commit();
			} else {
				parent::__construct("Character", $condition, $paramters);
			}
		}
		
		public function timeToMove() {
			return timeToMove($this->getStatistic("speed"));
		}
		
		public function getStatistic($name) {
			$sn = new DAO("StatisticName", "StatisticNameValue=@0", array($name));
			$csa = new DAO("StatisticAttribute", "StatisticNameID=@0 AND StatisticID=@1", array($sn->StatisticNameID, $this->CharacterID));
			$s = $csa->StatisticAttributeValue;
			return $s;
		}
	}
	
	function currentTimeMillis() {
		return round(microtime(true) * 1000);
	}
	
	function timeToMove($speed) {
		return ceil(500 / $speed * 48);
	}
	
?>