var cid = 1;

var Server = (function() {
	var Server = {};
	
	Server.getSkillMapping = function(success) {
		ajax("php/getSkillMapping.php", {cid:cid}, function(sm) {
			for(var i = 0; i < sm.length; i++) {
				if(sm[i]) {
					for(var j = 0; j < skills.length; j++) {
						if(sm[i] === skills[j].id) {
							sm[i] = skills[j];
							break;
						}
					}
				}
			}
			success(sm);
		});
	};
	
	Server.setSkillIndex = function(sid, index, success) {
		ajax("php/setSkillIndex.php", {sid:sid,index:index,cid:cid}, success);
	};
	
	Server.getEquipment = function(success) {
		ajax("php/getEquipment.php", {cid:cid}, success);
	};

	Server.equipItem = function(iid, success) {
		ajax("php/equipItem.php", {iid:iid, cid:cid}, success);
	};
	
	Server.getItemsInInventory = function(complete) {
		ajax("php/getItemsInInventory.php", {cid:cid}, complete);
	};
	
	Server.pickupItem = function(success) {
		ajax("php/pickupItem.php", {cid:cid}, success);
	};
	
	Server.moveEnemies = function(complete) {
		ajax("php/moveEnemy.php", {cid:cid}, complete);
	};
	
	Server.sendDamage = function(sid, complete) {
		sid = sid || "";
		var i, j, thisRoom = room.location.row * CONSTANTS.TILE.COLUMNS + room.location.column;
		ajax("php/sendDamage.php", {cid:cid, direction:character.display.row, skill:sid}, function(result) {
			for(i = 0; i < result.enemies.length; i++) {
				for(j = 0; j < enemies.length; j++) {
					if(result.enemies[i].id === enemies[j].id) {
						enemies[j].damage(result.enemies[i].damage);
					}
				}
			}
			if(result.items) {
				for(i = 0; i < result.items.length; i++) {		
					Server.getRoomItems(result.items[i], function(item) {
						(roomItems[thisRoom] = roomItems[thisRoom] || []).push(item);
						items.events.invoke("drop");
					});
				}
			}
			complete && complete();
		});
	};
	
	Server.getTiles = function() {
		var r = [], s;
		for(var i = 0; i < CONSTANTS.TILE.ROWS; i++) {
			r.push(s = []);
			for(var j = 0; j < CONSTANTS.TILE.COLUMNS; j++) {
				s.push({
					row : 11,
					column : 0
				});
			}
		}
		return r;
	};

	Server.getWalls = function(success) {
		ajax("php/getWalls.php", {cid : cid}, success);
	};

	Server.getAllWalls = function(success) {
		ajax("php/getAllWalls.php", {cid:cid}, success);
	};

	Server.getCharacterRoomLocation = function(success) {
		ajax("php/getCharacterRoomLocation.php", {cid:cid}, success);
	};

	Server.getCharacter = function(success) {
		ajax("php/getCharacter.php", {cid:cid}, function(data) {
			success(new Character(data));
		});
	};

	Server.getRoomEnemies = function(success) {
		ajax("php/getRoomEnemies.php", {cid:cid}, function(e) {
			var started = new Date().getTime();			
			for(var i = 0; i < e.length; i++) {
				e[i] = new Character(e[i]); //this is the only requirement
				e[i].lastTime = started;
				e[i].elapsedTime = 0;
			}
			success(e);
		});
	};

	Server.moveCharacter = function(l, success) {
		var current = {column : character.location.column, row : character.location.row};
		ajax("php/moveCharacter.php", {cid:cid,row:l.row,column:l.column}, function(data) {
			if(!data) {
				character.tween.clear();
				character.location.row = current.row;
				character.location.column = current.column;
			}
			success();
		});
	};

	//@DEPRECATED
	Server.attack = function(enemies, index, physical) {
		var thisRoom = room.location.row * CONSTANTS.TILE.COLUMNS + room.location.column,
			e = enemies[index],
			row = e.location.row,
			column = e.location.column,
			d = 0;
		if(physical) {
			d = Math.max(character.statistics.getCurrent("strength") - e.statistics.getCurrent("defense"), 0);
		} else {
			d = Math.max(character.statistics.getCurrent("intelligence") - e.statistics.getCurrent("resistance"), 0);
		}
		e.damage(d, function() {
			var item = randomItem(column, row);
			character.statistics.experience.current += this.statistics.experience.current;
			addBehavior("Kill", e.name);
			if(character.statistics.experience.current >= character.statistics.experience.max) {
				alert("Level Up!");
				character.level++;
				statisticsPoints += 5;
				character.statistics.health.max += 10;
				character.statistics.energy.max += 10;
				character.statistics.health.current = character.statistics.health.max;
				character.statistics.energy.current = character.statistics.energy.max;
				character.statistics.experience.max *= 2;
			}
			(roomItems[thisRoom] = roomItems[thisRoom] || []).push(item);
			items.events.invoke("drop");
		}, function() {
			enemies.splice(enemies.indexOf(e), 1);
		});
	};

	function randomItem(column, row) {
		var val = Math.random();
		if(val > 0.5) {
			return randomArmor(column, row);
		} else if(val >= 0) {
			return randomWeapon(column, row);
		} else {
			return randomJewelery(column, row);
		}
	}

	function randomJewelery(column, row) {
		return randomArmor(column, row);
	}

	function randomWeapon(column, row) {
		var r = [{
				portrait : "buckler",
				weight : 1,
				strength : 0,
				defense : 5,
				speed : 0,
				name : "Buckler",
				walk : {
					src : "walk/WEAPON_shield_cutout_body.png",
					rows : 4,
					columns : 9
				}
			}, {
				attack : "slash",
				portrait : "dagger",
				weight : 2,
				strength : 5,
				defense : 0,
				speed : 0,
				name : "Dagger",
				area : 1,
				slash :  {
					src : "slash/WEAPON_dagger.png",
					rows : 4,
					columns : 6
				}
			}, {
				attack : "bow",
				portrait : "shortbow",
				weight : 3,
				strength : 3,
				defense : 0,
				speed : 3,
				name : "Short Bow",
				area : Math.max(CONSTANTS.TILE.ROWS, CONSTANTS.TILE.COLUMNS),
				bow :  {
					src : "bow/WEAPON_bow.png",
					rows : 4,
					columns : 13
				}
			}, {
				attack : "spellcast",
				portrait : "wand",
				weight : 2,
				strength : 0,
				defense : 0,
				speed : 0,
				energy : 5,
				intelligence : 10,
				name : "Wand",
				area : -1,
				spellcast :  {
					src : "spellcast/HEAD_skeleton_eye_glow.png",
					rows : 4,
					columns : 6
				}
			}, {
				attack : "thrust",
				portrait : "longsword",
				weight : 4,
				strength : 10,
				defense : 0,
				speed : 0,
				energy : 0,
				name : "Long Sword",
				area : 2,
				thrust :  {
					src : "thrust/WEAPON_spear.png",
					rows : 4,
					columns : 8
				}
			}],
			item = r[Math.floor(Math.random() * r.length)];
		return new Item({
			attack : item.attack,
			name : item.name,
			area : item.area,
			weight : item.weight,
			type : "mainhand",
			portrait : "items/" + item.portrait + ".png",
			id : 1,
			//require relationships
			slash : item.slash,
			walk : item.walk,
			thrust : item.thrust,
			bow : item.bow,
			spellcast : item.spellcast,
			statistics : {
				strength : {
					current : item.strength,
					max : item.strength
				},
				intelligence : {
					current : item.intelligence,
					max : item.intelligence
				},
				defense : {
					current : item.defense,
					max : item.defense
				},
				speed : {
					current : item.speed,
					max : item.speed
				},
				energy : {
					current : item.energy,
					max : item.energy
				}
			},
			sounds : {
				move : ["sound/inventory/coin"]
			},
			location : {
				column : column,
				row : row
			}
		});
	}

	function randomArmor(column, row) {
		var weight = ["cloth", "hide", "leather", "chain", "steel"],
			part = ["head", "feet", "hands", "legs", "chest"],
			item = ["cloth", "head"];

		while(item[0] === "cloth" && item[1] === "head") {
			item[2] = Math.floor(Math.random() * weight.length);
			item[0] = weight[item[2]];
			item[1] = part[Math.floor(Math.random() * part.length)];
		}
		return new Item({
			slash : {
				src : "slash/" + item[1] + ".png",
				rows : 4,
				columns : 6
			},
			walk : {
				src : "walk/" + item[1] + ".png",
				rows : 4,
				columns : 9
			},
			thrust : {
				src : "thrust/" + item[1] + ".png",
				rows : 4,
				columns : 8
			},
			bow : {
				src : "bow/" + item[1] + ".png",
				rows : 4,
				columns : 13
			},
			spellcast : {
				src : "spellcast/" + item[1] + ".png",
				rows : 4,
				columns : 7
			},


			name : item[0] + " " + item[1],
			sounds : {
				move : ["sound/inventory/coin"]
			},
			type : item[1],
			portrait : "items/" + item[0] + "-" + item[1] + ".png",
			id : 1,
			location : {
				column : column,
				row : row
			},
			statistics : {
				defense : {
					current : item[2] + 1,
					max : item[2] + 1
				},
				speed : {
					current : 4 - item[2],
					max : 4 - item[2]
				}
			}
		});
	}

	var roomItems = [];

	Server.getRoomItems = function(iirid, success) {
		ajax("php/getItemsInRoom.php", {iirid:iirid, cid:cid}, function(items) {
			if(items) {
				for(var i = 0; i < items.length; i++) {
					items[i] = new Item(items[i]);
				}
			}
			success(items || []);
		});
	};

	Server.getSkills = function(success) {
		ajax("php/getSkills.php", {cid:cid}, success);
	};
	
	Server.getBehaviors = function() {
		return {
			Kill : {
				Skeleton : 0
			},			
			Character : {
				Deaths : 0,
				Steps : 0,
				Attacks : 0,
				"Seconds Played" : 0
			},
			Skill : {
				"Power Thrust" : 0,
				"Fire Wave" : 0,
				"Fire Arrow" : 0,
				Heal : 0
			},
			Damage : {
				Dealt : 0,
				Received : 0
			},
			Discover : {
				Rooms : 0,
				Maps : 0
			}
		};
	};
	
	Server.getBadges = function() {
		return [
			{
				name : "First Kill",
				category : "Kill",
				count : 1,
				icon : loadImage("badges/death.png")
			},
			{
				name : "Killer",
				category : "Kill",
				count : 50,
				icon : loadImage("badges/ddeath.png")
			},
			{
				name : "First Death",
				category : "Character",
				subcategory : "Deaths",
				count : 1,
				icon : loadImage("badges/killed.png")
			},
			{
				name : "First Step",
				category : "Character",
				subcategory : "Steps",
				count : 1,
				icon : loadImage("badges/arrow.png")
			},
			{
				name : "Adventurer",
				category : "Discover",
				subcategory : "Rooms",
				count : 10,
				complete : 1,
				icon : loadImage("badges/up.png")
			},
			{
				name : "Explorer",
				category : "Discover",
				subcategory : "Maps",
				count : 1,
				icon : loadImage("badges/dup.png")
			},
			{
				name : "Skillful",
				category : "Skill",
				count : 10,
				icon : loadImage("badges/tstar.png")
			}
		];
	};

	return Server;
}());

//http://pousse.rapiere.free.fr/tome/
//9 x 17
//opengameart.org - lpc
var CONSTANTS = {
	TILE : {
		WIDTH : 48,
		HEIGHT : 48,
		ROWS : 7,
		COLUMNS : 7,
		MIDDLE : {
			ROW : function() {
				return Math.floor(CONSTANTS.TILE.ROWS / 2);
			},
			COLUMN : function() {
				return Math.floor(CONSTANTS.TILE.COLUMNS / 2);
			}
		}
	},
	WIDTH : function() {
		return CONSTANTS.TILE.WIDTH * CONSTANTS.TILE.COLUMNS;
	},
	HEIGHT : function() {
		return CONSTANTS.TILE.HEIGHT * CONSTANTS.TILE.ROWS;
	},
	WALL : {
		NONE : 0,
		TOP : 1,
		RIGHT : 2,
		BOTTOM : 4,
		LEFT : 8,
		ALL : 15
	},
	DIRECTION : {
		UP : 0,
		RIGHT : 3,
		DOWN : 2,
		LEFT : 1
	},
	INBETWEEN : function() {
		return canvas.width / 2 - ((CONSTANTS.TILE.ROWS + 2) * CONSTANTS.TILE.WIDTH) / 2 - 20;
	},
	START : {
		X : function() {
			return canvas.width / 2 - CONSTANTS.WIDTH() / 2;
		},
		Y : function() {
			return canvas.height / 2 - CONSTANTS.HEIGHT() / 2;
		}
	},
	MAX_WEIGHT : 4
},
tileset = new TileSet({
	columns : 9,
	rows : 16,
	src : "tiles.gif"
}),
statisticsPoints = 0,
skills = [],
canvas,
context,
background = loadImage("background.jpg"),
character = {},
contexts = [],
room = {
	location : {column:0,row:0},
	events : new EventHandler()
},
items = {
	list : [],
	events : new EventHandler()
},
inventory_items = [],
equipment_items = {},
enemies = [],
behaviors = Server.getBehaviors(),
badges = Server.getBadges();

Server.getCharacterRoomLocation(function(l) {
	room.location = l;
});

Server.getItemsInInventory(function(iii) {
	inventory_items = iii;
	for(var i = 0; i < iii.length; i++) {
		if(inventory_items[i]) {
			inventory_items[i] = new Item(inventory_items[i]);
		}
	}
	unlock("inventory", 1);
});

Server.getCharacter(function(c) {
	character = c;
	character.events = new EventHandler();
	unlock("character", 4);
});

Server.getSkills(function(s) {
	var i = 0, j, r;
	for(; i < s.length; i++) {
		s[i].image.icon = loadImage(s[i].image.icon);
		r = s[i].add;
		for(j = 0; j < r.length; j++) {
			r[j] = new Statistics(r[j]);
		}
		r = s[i].multiply;
		for(j = 0; j < r.length; j++) {
			r[j] = new Statistics(r[j]);
		}
	}
	skills = s;
	unlock("skills", 1);
});