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
	
	class DB {
	
		private static $connection;	
		
		/*
			Connects to the databse
		*/
		public static function connect() {
			DB::$connection = mysqli_connect("localhost", "root", "root", "worldtactics");			
			return DB::$connection;
		}
		
		private static function escape($s) {
			return mysqli_real_escape_string(DB::$connection, $s);
		}
		
		/*
			Disconnects from the databse
		*/
		public static function close() {
			mysqli_close(DB::$connection);
		}
		
		public static function query($sql, $parameters, $useCache = true, $immediate = true) {
			$last = 0;
			$index = strpos($sql, "?");
			$executed = "";
			while($index !== false) {
				$executed .= substr($sql, $last, $index - $last);
				if($sql[$index + 1] == "?") {					
					$executed .= "`" . DB::escape($parameters[0]) . "`";
					++$index;
				} else if(is_numeric($parameters[0]) || is_null($parameters[0])) {					
					if(is_null($parameters[0])) {
						$parameters[0] = "null";
					}					
					$executed .= DB::escape($parameters[0]);
				} else {				
					$executed .= "'" . DB::escape($parameters[0]) . "'";
				}
				array_shift($parameters);
				$last = $index + 1;
				$index = strpos($sql, "?", $index + 1);
			}
			$executed .= substr($sql, $last, strlen($sql) - $last);
			//echo "$executed\n\n";
			return mysqli_query(DB::$connection, $executed);
		}
		
		public static function getConnection() {
			if(!DB::$connection) {
				DB::connect();
			}
			return DB::$connection;
		}
		
		public static function insertID() {		
			return mysqli_insert_id(DB::$connection);
		}
	}
	
	class DAO implements Iterator {		
		
		private $table;
		private $data = array();
		private $position = 0;			
		
		function rewind() {
			$this->position = 0;
		}

		function current() {
			return new DAO($this->table, array($this->data[$this->position]));
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
		
		public function write($dao) {
			$this->data[$this->position] = $dao->data[0];
		}
		
		/*
			Sets up the object for inserting or selection
		*/
		public function __construct($table, $condition = false, $parameters = array()) {
			$this->table = $table; 
			if($condition || is_array($condition)) { //if there is a condition then we are selecting or have already selected
				if(is_array($condition)) { //if the condition is an array then we have already selected					
					if($condition[0] instanceof DAO) {
						foreach($condition as $dao) {
							$this->data = array_merge($this->data, $dao->data);
						}
					} else {
						$this->data = $condition;
					}
					return;
				}
				if(is_numeric($condition)) { //if the condition is a number then we will set up for id selection for this table
					$parameters = array($table . "ID", $condition);
					$condition = "??=?";
				}
				array_unshift($parameters, $table);
				if($result = DB::query("SELECT * FROM ?? WHERE $condition;", $parameters)) { //get the table result
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
					}
				}
			} else { //we are attempting to do an insert and should at least provide the fields necessary
				if($result = DB::query("SHOW COLUMNS IN ??", array($table))) {					
					while($row = mysqli_fetch_assoc($result)) {
						$value = $row["Default"];
						if(is_numeric($value)) {
							$value = (double)$value;
						} else {
							$value = null;
						}
						$this->data[0][$row["Field"]] = $value;
					}
				}
			}
		}
		
		/*
			MAGIC methods that allow convenient getting, setting, testing, and debugging
		*/
		public function __get($property) {
			return $this->data[0][$property];
		}

		public function __set($property, $value) {
			$count = count($this->data);
			for($i = 0; $i < $count; $i++) {				
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
		public function getOne($foreignTable, $localColumn = false) {
			$localTable = $this->table;
			$foreignColumn = $foreignTable . "ID";
			$localColumn = $localColumn ? $localColumn : $foreignColumn;
			$selected = new DAO($foreignTable, true);
			foreach($selected as $one) { //go to one of the selected
				$r = array();
				foreach($this as $many) { //many of this
					if($many->$localColumn == $one->$foreignColumn) { //if this many column == the one foriegn column
						$many->$foreignTable = $one;
						$this->write($many);
						array_push($r, $many);
					}
				}
				$one->$localTable = new DAO($localTable, $r);
				$selected->write($one);
			}
			return $this->$foreignTable;
		}
		
		/*
			Gets all rows that have a relationship with this one in the specified table
		*/
		public function getMany($foreignTable, $localColumn = false) {
			$localTable = $this->table;
			$foreignColumn = $localColumn ? $localColumn : $localTable . "ID";
			$localColumn = $localColumn ? $localColumn : $localTable . "ID";
			$selected = new DAO($foreignTable, true);
			foreach($this as $one) {
				$r = array();
				foreach($selected as $many) {
					if($one->$foreignColumn == $many->$localColumn) {
						array_push($r, $many);
						$many->$localTable = $one;
						$selected->write($many);
					}
				}
				$one->$foreignTable = new DAO($foreignTable, $r);
				$this->write($one);
			}
			return $this->$foreignTable;
		}
		
		public function insert($generateKey = false) {
			$count = count($this->data);
			for($i = 0; $i < $count; $i++) {
				$columns = "";
				$values ="";		
				$valuesr = array();
				$columnsr = array();
				foreach($this->data[$i] as $column => $value) {
					if($column != ($this->table . "ID") && !($value instanceof DAO)) {
						if($columns) {
							$columns .= ", ";
						}
						$columns .= "??";
						$columnsr[] = $column;
						if($values) {
							$values .= ", ";
						}
						$values .= "?";
						$valuesr[] = $value;
					}
				}
				$parameters = array_merge(array($this->table), $columnsr, $valuesr);
				DB::query("INSERT INTO ?? ($columns) VALUES ($values);", $parameters, false, false);
				if($generateKey) {
					$this->data[$i][$this->table . "ID"] = DB::insertID();
				}
			}
			return $this;
		}
		
		public function update() {	
			$count = count($this->data);
			for($i = 0; $i < $count; $i++) {
				$set = "";
				$parameters = array();
				foreach($this->data[$i] as $column => $value) {
					if($column != ($this->table . "ID") && !($value instanceof DAO)) {
						if($set) {
							$set .= ", ";
						}
						$set .= "??=?";
						$parameters[] = $column;
						$parameters[] = $value;
					}
				}
				array_unshift($parameters, $this->table);
				$parameters[] = $this->table . "ID";
				$parameters[] = $this->data[$i][$this->table . "ID"];
				DB::query("UPDATE ?? SET $set WHERE ??=?;", $parameters, false, false);				
			}
			return $this;
		}
	}
		
	
	class Character extends DAO {
	
		public function __construct($condition = false, $parameters = array()) {
			if(!$condition) {
				session_start();
				$_SESSION["user"] = 1;
				parent::__construct("Character", "CharacterID=? AND UserID=?", array((double)$_GET["cid"], $_SESSION["user"]));
				session_commit();
			} else {
				parent::__construct("Character", $condition, $parameters);
			}
		}
		
		public function timeToMove($now) {
			return timeToMove($this->getStatistic("speed", $now));
		}
		
		public function getStatistic($name, $now) {
			$sn = new DAO("StatisticName", "StatisticNameValue=?", array($name));
			$csa = new DAO("StatisticAttribute", "StatisticNameID=? AND StatisticID=?", array($sn->StatisticNameID, $this->CharacterID));
			$s = $csa->StatisticAttributeValue;
			//get skill statistics
			foreach($this->getMany("CharacterSkill") as $cs) {
				if($cs->CharacterSkillIndex !== null) {
					$skill = $cs->getOne("Skill");
					foreach($skill->getMany("SkillStatistic") as $ss) {
						if($cs->CharacterSkillUsedAt + $ss->SkillStatisticDuration >= $now) {
							$statistic = new DAO("StatisticAttribute", "StatisticID=? AND StatisticNameID=?", array($ss->StatisticID, $sn->StatisticNameID));
							if($statistic->valid()) {
								$s += $statistic->StatisticAttributeValue;
							}
						}
					}
				}
			}
			//get item statistics
			foreach($this->getMany("ItemInEquipment") as $iie) {
				if($iie->ItemID !== null) {
					$im = $iie->getOne("Item")->getOne("ItemModel");
					$statistic = new DAO("StatisticAttribute", "StatisticID=? AND StatisticNameID=?", array($im->StatisticID, $sn->StatisticNameID));
					if($statistic->valid()) {
						$s += $statistic->StatisticAttributeValue;
					}
				}
			}
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