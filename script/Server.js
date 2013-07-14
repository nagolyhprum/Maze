var cid = 1, mapmodel = 1;

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
};

var Server = (function() {

	var connection = new WebSocket("ws://localhost:8080"), 
		events = new EventHandler(), 
		isLoaded = false, 
		toReceive = [], 
		toSend = [];
	
	//alerts to send and receive loading
	
	$(function() {
		isLoaded = true;
		receiveMessage();
	})
	
	connection.onopen = function() {
		events.message("Initialize", {cid : cid, mapmodel : mapmodel});
		sendMessage();
	};
	
	//for sending messages
	
	events.attach("Message", function(action, args) {
		toSend.push(JSON.stringify({action:action,args:args||true}));
		sendMessage();
	});
	
	events.message = function(action, args) {
		this.invoke("Message", [action, args]);
	};
	
	//for receiving messages
	
	connection.onmessage = function(msg) {
		toReceive.push(msg.data);
		receiveMessage();
	};
		
	function receiveMessage() {
		if(isLoaded) {
			while(toReceive.length > 0) {
				var data = toReceive.shift();
				console.log(data);
				data = JSON.parse(data);
				events.invoke(data.action, data.args instanceof Array ? [data.args] : data.args);				
			}
		}
	}
	
	function sendMessage() {		
		if(connection.readyState === 1) {
			while(toSend.length > 0) {		
				connection.send(toSend.shift());
			}
		}
	}
	/*
	toReceive.push(JSON.stringify({
		"action" : "GetCharacterBehaviors",
		"args" : {
			"Kill" : {
				"Skeleton" : 0
			},			
			"Character" : {
				"Deaths" : 0,
				"Steps" : 0,
				"Attacks" : 0,
				"Seconds Played" : 0
			},
			"Skill" : {
				"Power Thrust" : 0,
				"Fire Wave" : 0,
				"Fire Arrow" : 0,
				"Heal" : 0
			},
			"Damage" : {
				"Dealt" : 0,
				"Received" : 0
			},
			"Discover" : {
				"Rooms" : 0,
				"Maps" : 0
			}
		}
	}));
	receiveMessage();
	*/
	//end function
	/*
	var Server = {};
	
	Server.healEnergy = function() {
		ajax("php/healEnergy.php", {cid:cid});
	};
	
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

	Server.equipItem = function(iid, success) {
		ajax("php/equipItem.php", {iid:iid, cid:cid}, success);
	};
	
	Server.pickupItem = function(success) {
		ajax("php/pickupItem.php", {cid:cid}, success);
	};
	
	Server.moveEnemies = function(complete) {
		ajax("php/moveEnemy.php", {cid:cid}, complete);
	};
	
	Server.sendDamage = function(index, complete) {
		var i, j, thisRoom = room.location.row * CONSTANTS.TILE.COLUMNS + room.location.column;
		ajax("php/sendDamage.php", {cid:cid, direction:character.display.row, index:index}, function(result) {
			for(i = 0; i < result.enemies.length; i++) {
				for(j = 0; j < enemies.length; j++) {
					if(result.enemies[i].id === enemies[j].id) {
						enemies[j].damage(result.enemies[i].damage);
					}
				}
			}
			if(result.items) {
				Server.getRoomItems(function(is) {
					roomItems = is;
					items.events.invoke("drop");
				});
			}
			complete && complete();
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

	var roomItems = [];

	Server.getRoomItems = function(success) {
		ajax("php/getItemsInRoom.php", {cid:cid}, function(items) {
			if(items) {
				for(var i = 0; i < items.length; i++) {
					items[i] = new Item(items[i]);
				}
			}
			success(items || []);
		});
	};
	
	*/

	return events;
}());

//http://pousse.rapiere.free.fr/tome/
//9 x 17
//opengameart.org - lpc
var tileset = new TileSet({
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
behaviors = {placeholder:true},
badges = [];

Server.attach("GetCharacterRoomLocation", function(l) {
	room.location = l;
});

Server.attach("GetCharacterBehaviors", function(b) {
	behaviors = b;
	if(badges.length) {
		initCharacterBadges();
	}
});

Server.attach("GetCharacterBadges", function(b) {
	for(var i = 0; i < b.length; i++) {
		b[i].icon = loadImage(b[i].icon);
	}
	badges = b;
	if(!behaviors.placeholder) {
		initCharacterBadges();
	}
});

function initCharacterBadges() {
	for(var i in behaviors) {
		for(var j in behaviors[i]) {
			Server.invoke("AddBehavior", {
				category : i,
				subcategory : j,
				count : 0
			});
		}
	}
}

Server.attach("GetItemsInInventory", function(iii) {
	inventory_items = iii;
	for(var i = 0; i < iii.length; i++) {
		if(inventory_items[i]) {
			inventory_items[i] = new Item(inventory_items[i]);
		}
	}
	unlock("inventory", 1);
});

Server.attach("GetCharacter", function(c) {
	character = new Character(c);
	character.events = new EventHandler();
	unlock("character", 5);
});

Server.attach("GetSkills", function(s) {
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
});

//make sure we get skills first?

Server.attach("Reload", function() {
	window.location = "index.html";
});