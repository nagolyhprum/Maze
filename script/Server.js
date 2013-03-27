var Server = (function() {
	var Server = {};
	
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
	
	var rows = 5,
		columns = 5,
		mg = new MazeGenerator(columns, rows),
		walls = mg.generateMaze();
	
	Server.getWalls = function() {
		return walls[room.location.row * columns + room.location.column];
	};
	
	Server.getAllWalls = function() {
		var data = [];
		for(var i = 0; i < walls.length; i++) {
			data[i] = undefined;
		}
		return {
			data : data,
			rows : rows,
			columns : columns
		};
	};
	
	Server.getCharacterRoomLocation = function() {
		return {
			row : 0,
			column : 0
		};
	};
	
	Server.getCharacter = function() {
		return new Character({
			portrait : "face/FlareMaleHero1.png",
			name : "Logan",
			sounds : {
				slash : ["sound/battle/swing1", "sound/battle/swing2", "sound/battle/swing3"],
				hurt : [
					"sound/grunts/grunt1",
					"sound/grunts/grunt2",
					"sound/grunts/grunt3",
					"sound/grunts/grunt4",
					"sound/grunts/grunt5",
					"sound/grunts/grunt6",
					"sound/grunts/grunt7",
					"sound/grunts/grunt8",
					"sound/grunts/grunt9",
					"sound/grunts/grunt10",
					"sound/grunts/grunt11"
				],
				walk : []
			},
			statistics : {
				health : {
					max : 50,
					current : 50
				},
				speed : {
					current : 25,
					max : 25
				},
				experience : {
					current : 0,
					max : 100
				}
			},
			display : { row : 2 },
			walk : [
				new TileSet({
					columns : 9, 
					rows : 4, 
					src : "walkcycle/BODY_male.png"
				}),
				new TileSet({
					columns : 9, 
					rows : 4, 
					src : "walkcycle/LEGS_pants_greenish.png"
				}),
				new TileSet({
					columns : 9, 
					rows : 4, 
					src : "walkcycle/TORSO_robe_shirt_brown.png"
				})
			],
			hurt : [
				new TileSet({
					columns : 6, 
					rows : 1, 
					src : "hurt/BODY_male.png"
				}),
				new TileSet({
					columns : 6, 
					rows : 1, 
					src : "hurt/LEGS_pants_greenish.png"
				}),
				new TileSet({
					columns : 6, 
					rows : 1, 
					src : "hurt/TORSO_robe_shirt_brown.png"
				})
			],
			attack : [
				new TileSet({
					columns : 6, 
					rows : 4, 
					src : "slash/BODY_human.png"
				}),
				new TileSet({
					columns : 6, 
					rows : 4, 
					src : "slash/LEGS_pants_greenish.png"
				}),
				new TileSet({
					columns : 6, 
					rows : 4, 
					src : "slash/TORSO_robe_shirt_brown.png"
				}),
				new TileSet({
					columns : 6, 
					rows : 4, 
					src : "slash/WEAPON_dagger.png"
				})
			]
		});
	};
	
	var enemies = [];
	$(function() {
		var id = 1;
		for(var i = 0; i < rows * columns; i++) {
			if(1) {
				enemies[i] = [
					new Character({
						walk : [new TileSet({
							columns : 9, 
							rows : 4, 
							src : "walkcycle/BODY_skeleton.png"
						})],
						attack : [new TileSet({
							columns : 6, 
							rows : 4, 
							src : "slash/BODY_skeleton.png"
						})],
						hurt : [new TileSet({
							columns : 6, 
							rows : 1, 
							src : "hurt/BODY_skeleton.png"
						})],
						id : id++,
						location : {
							row : CONSTANTS.TILE.MIDDLE.ROW() - 2,
							column : CONSTANTS.TILE.MIDDLE.COLUMN(),
							x : 0,
							y : 0
						},
						display : {
							row : 0,
							column : 0
						},
						statistics : {
							health : {
								max : 3,
								current : 3
							},
							speed : {
								current : 10,
								max : 10
							},
							experience : {
								current : 5,
								max : 5
							}
						},
						sounds : {
							slash : ["sound/battle/swing1", "sound/battle/swing2", "sound/battle/swing3"],
							hurt : [
								"sound/NPC/shade/shade1",
								"sound/NPC/shade/shade2",
								"sound/NPC/shade/shade3",
								"sound/NPC/shade/shade4",
								"sound/NPC/shade/shade5",
								"sound/NPC/shade/shade6",
								"sound/NPC/shade/shade7",
								"sound/NPC/shade/shade8",
								"sound/NPC/shade/shade9",
								"sound/NPC/shade/shade10",
								"sound/NPC/shade/shade11",
								"sound/NPC/shade/shade12",
								"sound/NPC/shade/shade13",
								"sound/NPC/shade/shade14",
								"sound/NPC/shade/shade15"
							]
						}
					}),
					new Character({
						walk : [new TileSet({
							columns : 9, 
							rows : 4, 
							src : "walkcycle/BODY_skeleton.png"
						})],
						attack : [new TileSet({
							columns : 6, 
							rows : 4, 
							src : "slash/BODY_skeleton.png"
						})],
						hurt : [new TileSet({
							columns : 6, 
							rows : 1, 
							src : "hurt/BODY_skeleton.png"
						})],
						id : id++,
						location : {
							row : CONSTANTS.TILE.MIDDLE.ROW(),
							column : CONSTANTS.TILE.MIDDLE.COLUMN() - 2,
							x : 0,
							y : 0
						},
						display : {
							row : 0,
							column : 0
						},
						statistics : {
							health : {
								max : 3,
								current : 3
							},
							speed : {
								current : 10,
								max : 10
							},
							experience : {
								current : 5,
								max : 5
							}
						},
						sounds : {
							slash : ["sound/battle/swing1", "sound/battle/swing2", "sound/battle/swing3"],
							hurt : [
								"sound/NPC/shade/shade1",
								"sound/NPC/shade/shade2",
								"sound/NPC/shade/shade3",
								"sound/NPC/shade/shade4",
								"sound/NPC/shade/shade5",
								"sound/NPC/shade/shade6",
								"sound/NPC/shade/shade7",
								"sound/NPC/shade/shade8",
								"sound/NPC/shade/shade9",
								"sound/NPC/shade/shade10",
								"sound/NPC/shade/shade11",
								"sound/NPC/shade/shade12",
								"sound/NPC/shade/shade13",
								"sound/NPC/shade/shade14",
								"sound/NPC/shade/shade15"
							]
						}
					}),
					new Character({
						walk : [new TileSet({
							columns : 9, 
							rows : 4, 
							src : "walkcycle/BODY_skeleton.png"
						})],
						attack : [new TileSet({
							columns : 6, 
							rows : 4, 
							src : "slash/BODY_skeleton.png"
						})],
						hurt : [new TileSet({
							columns : 6, 
							rows : 1, 
							src : "hurt/BODY_skeleton.png"
						})],
						id : id++,
						location : {
							row : CONSTANTS.TILE.MIDDLE.ROW() + 2,
							column : CONSTANTS.TILE.MIDDLE.COLUMN(),
							x : 0,
							y : 0
						},
						display : {
							row : 0,
							column : 0
						},
						statistics : {
							health : {
								max : 3,
								current : 3
							},
							speed : {
								current : 10,
								max : 10
							},
							experience : {
								current : 5,
								max : 5
							}
						},
						sounds : {
							slash : ["sound/battle/swing1", "sound/battle/swing2", "sound/battle/swing3"],
							hurt : [
								"sound/NPC/shade/shade1",
								"sound/NPC/shade/shade2",
								"sound/NPC/shade/shade3",
								"sound/NPC/shade/shade4",
								"sound/NPC/shade/shade5",
								"sound/NPC/shade/shade6",
								"sound/NPC/shade/shade7",
								"sound/NPC/shade/shade8",
								"sound/NPC/shade/shade9",
								"sound/NPC/shade/shade10",
								"sound/NPC/shade/shade11",
								"sound/NPC/shade/shade12",
								"sound/NPC/shade/shade13",
								"sound/NPC/shade/shade14",
								"sound/NPC/shade/shade15"
							]
						}
					})
				];
			} else {
				enemies[i] = [];
			}
		}
	});
	
	Server.getRoomEnemies = function() {
		var e = enemies[room.location.column + room.location.row * columns],
			started = new Date().getTime();
		for(var i = 0; i < e.length; i++) {
			e[i].lastTime = started;
			e[i].elapsedTime = 0;
		}
		return e;
	};
	
	Server.moveCharacter = function(l) {
	};
	
	Server.attack = function(d) {
		var es = enemies[room.location.column + room.location.row * columns];
		var row = character.location.row, column = character.location.column;
		if(d === CONSTANTS.DIRECTION.UP) {
			row--;
		} else if(d === CONSTANTS.DIRECTION.LEFT) {
			column--;
		} else if(d === CONSTANTS.DIRECTION.DOWN) {
			row++;
		} else if(d === CONSTANTS.DIRECTION.RIGHT) {
			column++;
		}
		for(var i = 0; i < es.length; i++) {
			var l = es[i].location;
			if(l.row === row && l.column === column) {
				var thisRoom = room.location.row * CONSTANTS.TILE.COLUMNS + room.location.column;
				es[i].damage(1, function() {
					var item = randomItem();
					character.statistics.experience.current += this.statistics.experience.current;
					(roomItems[thisRoom] = roomItems[thisRoom] || []).push(new Item({
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
							strength : {
								current : item[2],
								max : item[2]
							},
							defense : {
								current : item[2],
								max : item[2]
							},
							speed : {
								current : item[2],
								max : item[2]
							}
						},
						ground : {							
							rows : 3,
							columns : 5,
							src : "drops.png",							
							display : {
								column : Math.floor(Math.random() * 5),
								row : Math.floor(Math.random() * 3)
							}
						}
					}));					
					items.events.invoke("drop");
				}, function() {
					es.splice(es.indexOf(this), 1);
				});
			}
		}
	};
	
	function randomItem() {
		var weight = ["cloth", "hide", "leather", "chain", "steel"],
			part = ["head", "feet", "hands", "legs", "chest"],
			item = ["cloth", "head"];
			
		while(item[0] === "cloth" && item[1] === "head") {
			item[2] = Math.floor(Math.random() * weight.length);
			item[0] = weight[item[2]];
			item[1] = part[Math.floor(Math.random() * part.length)];			
		}
		return item;
	}
	
	var roomItems = [];
	
	Server.getRoomItems = function() {
		return roomItems[room.location.row * CONSTANTS.TILE.COLUMNS + room.location.column] || [];
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
		LEFT : 1,
		DOWN : 2,
		RIGHT : 3
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
	}
}, 
tileset = new TileSet({
	columns : 9, 
	rows : 16, 
	src : "tiles.gif"
}),
canvas,
context,
background = loadImage("background.jpg"),
character = Server.getCharacter(),
contexts = [],
room = {
	location : Server.getCharacterRoomLocation(),
	events : new EventHandler()
},
items = {
	list : Server.getRoomItems(),
	events : new EventHandler()
},
inventory_items = [],
equipment_items = {},
enemies = [];