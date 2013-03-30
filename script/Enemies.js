$(function() {
	var sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2,
		sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2;
	canvas.events.attach("draw", function() {
		for(var i = 0; i < enemies.length; i++) {
			enemies[i].draw(context);
		}
	});
	
	room.events.attach("change", function() {
		enemies = Server.getRoomEnemies();
		moveEnemies();
	});
	
	character.events.attach("trymove", function(l) {
		for(var i = 0; i < enemies.length; i++) {
			var e = enemies[i];
			if(l.row === e.location.row && l.column === e.location.column && e.statistics.health.current > 0) {
				l.collides = true;
			}
		}
	});
	
	function moveEnemies() {
		for(var i = enemies.length - 1; i >= 0; i--) {
			var e = enemies[i];
			move(e);
		}
	}
	
	function move(e) {
		if(enemies.indexOf(e) != -1) {
			var action, moves = e.moves();
			if(moves === 0) {
				action = function() {
					e.wait(function() {
						move(e);
					});
				};
			}
			while(moves > 0 && character.statistics.health.current > 0) {
				moves--;
				var map = [], mg = new MazeGenerator(CONSTANTS.TILE.COLUMNS, CONSTANTS.TILE.ROWS), i;
				map.columns = CONSTANTS.TILE.COLUMNS;
				map.rows = CONSTANTS.TILE.ROWS;
				for(i = 0; i < CONSTANTS.TILE.ROWS * CONSTANTS.TILE.COLUMNS; i++) {
					map[i] = 0;
				}
				for(i = 0; i < enemies.length; i++) {
					if(e !== enemies[i]) {
						if(enemies[i].statistics.health.current > 0) {
							var obs = enemies[i].location;
							map[obs.column + obs.row * CONSTANTS.TILE.COLUMNS] = CONSTANTS.WALL.ALL;
						}
					}
				}
				if(e.statistics.health.current > 0) {
					var path = mg.getPath(map, e.location.column, e.location.row, character.location.column, character.location.row);
					if(path.length > 2) {
						var p = path[path.length - 2];
						var h = (p.column - e.location.column) * CONSTANTS.TILE.WIDTH, 
							v = (p.row - e.location.row) * CONSTANTS.TILE.HEIGHT;
						e.face(p.column, p.row);
						e.location.column = p.column;
						e.location.row = p.row;
						action = function() {
							e.moveBy(h, v, function() {
								e.face(character.location.column, character.location.row);
								move(e);
							});
						};
					} else if(Math.abs(character.location.column - e.location.column) + 
							  Math.abs(character.location.row - e.location.row) === 1) {
						character.damage(1);
						e.face(character.location.column, character.location.row);
						action = function() {
							e.slash(function() {
								move(e);
							});
						};
					} else {
						action = function() {
							e.wait(function() {
								move(e);
							});
						};
					}
				}
			}
			action && action();
		}
	}
});