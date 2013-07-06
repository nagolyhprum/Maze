<?php
	class DB {
		private static $connection;
		
		/*
			Connects to the databse
		*/
		public static function connect() {
			return DB::$connection = mysqli_connect("localhost", "root", "root", "worldtactics");			
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

	class DAO {
		
		private $table;
		private $data;
		
		/*
			Sets up the object for inserting or selection
		*/
		public function __construct($table, $condition, $parameters) {
			$this->table = $table;
			if($condition) {		
				if(is_numeric($condition)) {
					$parameters = array("id" => $condition);
					$condition = $table . "ID=%id%";
				}
				$stmt = "SELECT * FROM `" . mysqli_real_escape_string(DB::getConnection(), $table) . "` WHERE $condition";
				foreach($parameters as $key => $value) {	
					if(is_numeric($value)) {
						$stmt = str_replace("%$key%", mysqli_real_escape_string(DB::getConnection(), $value), $stmt);
					} else {
						$stmt = str_replace("%$key%", "\"" . mysqli_real_escape_string(DB::getConnection(), $value) . "\"", $stmt);
					}
				}
				$result = mysqli_query(DB::getConnection(), $stmt);
				$this->data = mysqli_fetch_assoc($result);
				foreach($this->data as $key => &$value) {
					if(is_numeric($value)) {
						$value = (int)$value;
					}
				}
				mysqli_free_result($result);
			} else {
				$stmt = "SHOW COLUMNS IN `" . mysqli_real_escape_string(DB::getConnection(), $table) . "`";
				$result = mysqli_query(DB::getConnection(), $stmt);
				while($row = mysqli_fetch_assoc($result)) {
					$value = $row["Default"];
					if(is_numeric($value)) {
						$value = (int)$value;
					}
					$this->data[$row["Field"]] = $value;
				}
				mysqli_free_result($result);
			}
		}
		
		/*
			MAGIC methods that allow convenient getting, setting, testing, and debugging
		*/
		public function __get($property) {
			return $this->data[$property];
		}

		public function __set($property, $value) {
			if(isset($this->$data[$property])) {
				$this->$data[$property] = $value;
			}
		}
		
		public function __isset($property) {
			return isset($this->$data[$property]);
		}
		
		public function __toString() {
			return json_encode($this->data);
		}
	
		/*
			This table has the specified column which is a foreign key to the specified table
		*/
		public function getOne($table, $column) {
			$column = $column ? $column : $table . "ID";
			return $this->data[substr($column, 0, strlen($column) - 2)] = new DAO($table, $this->$column);
		}
		
		/*
			Gets all rows that have a relationship with this one in the specified table
		*/
		public function getAll($table, $column) {
			$column = $column ? $column : get_class($this) . "id";
		}
	}
	
	class Character extends DAO {
	
		public function __construct($condition, $parameters) {
			if(!$condition) {
				session_start();
				$_SESSION["user"] = 1;
				parent::__construct("Character", "CharacterID=%cid% AND UserID=%uid%", array("cid" => $_GET["cid"], "uid" => $_SESSION["user"]));
				session_commit();
			} else {
				parent::__construct("Character", $condition, $paramters);
			}
		}
		
		public function isValid() {
			return $this->CharacterID ? true : false;
		}
	}
?>