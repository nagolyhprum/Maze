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
		throw "Please use events.message instead.";
	});
	
	events.message = function(action, args) {
		toSend.push(JSON.stringify({action:action,args:args||true}));
		sendMessage();
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
				//console.log(data);
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
	canvas.load("Initialize");
	Server.message("Initialize", {cid : cid, mapmodel : mapmodel});
});