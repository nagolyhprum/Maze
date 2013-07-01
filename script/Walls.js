$(function() {
	var walls,
		tile = {
			column : 6,
			row : 11
		};
	room.events.attach("change", function() {
		Server.getWalls(function(w) {
			walls = w;
		});
	});
	lock("character", function() {
		character.events.attach("trymove", function(l) {
			var mr = CONSTANTS.TILE.MIDDLE.ROW(),
				mc = CONSTANTS.TILE.MIDDLE.COLUMN();
			l.collides = l.collides || 
				l.column === -1 && l.row === mr && walls & CONSTANTS.WALL.LEFT || 
				l.column === -1 && l.row !== mr;
			l.collides = l.collides || 
				l.column === CONSTANTS.TILE.COLUMNS && l.row === mr && walls & CONSTANTS.WALL.RIGHT || 
				l.column === CONSTANTS.TILE.COLUMNS && l.row !== mr;		
			l.collides = l.collides || 
				l.row === -1 && l.column === mc && walls & CONSTANTS.WALL.TOP || 
				l.row === -1 && l.column !== mc;
			l.collides = l.collides || 
				l.row === CONSTANTS.TILE.ROWS && l.column === mc && walls & CONSTANTS.WALL.BOTTOM || 
				l.row === CONSTANTS.TILE.ROWS && l.column !== mc;
				
		});
	});
	
	function drawHorizontalWalls() {
		var sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2 - CONSTANTS.TILE.WIDTH,
			sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2 - CONSTANTS.TILE.HEIGHT,
			mid = Math.floor((CONSTANTS.TILE.ROWS + 2) / 2);
		for(var i = 0; i < CONSTANTS.TILE.ROWS + 2; i++) {
			if(i !== mid || (walls & CONSTANTS.WALL.LEFT)) {
				context.drawImage(tileset.image,
					tileset.width * tile.column,
					tileset.height * tile.row,
					tileset.width,
					tileset.height,
					sx,
					sy + i * CONSTANTS.TILE.HEIGHT,
					CONSTANTS.TILE.WIDTH,
					CONSTANTS.TILE.HEIGHT);
			}
			if(i !== mid || (walls & CONSTANTS.WALL.RIGHT)) {
				context.drawImage(tileset.image,
					tileset.width * tile.column,
					tileset.height * tile.row,
					tileset.width,
					tileset.height,
					sx + CONSTANTS.WIDTH() + CONSTANTS.TILE.WIDTH,
					sy + i * CONSTANTS.TILE.HEIGHT,
					CONSTANTS.TILE.WIDTH,
					CONSTANTS.TILE.HEIGHT);
			}
		}
	}
	
	function drawVerticalWalls() {
		var sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2,
			sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2 - CONSTANTS.TILE.HEIGHT,
			mid = Math.floor(CONSTANTS.TILE.COLUMNS / 2);
		for(var i = 0; i < CONSTANTS.TILE.COLUMNS; i++) {
			if(i !== mid || (walls & CONSTANTS.WALL.TOP)) {
				context.drawImage(tileset.image,
					tileset.width * tile.column,
					tileset.height * tile.row,
					tileset.width,
					tileset.height,
					sx + i * CONSTANTS.TILE.WIDTH,
					sy,
					CONSTANTS.TILE.WIDTH,
					CONSTANTS.TILE.HEIGHT);
			}
			if(i !== mid || (walls & CONSTANTS.WALL.BOTTOM)) {
				context.drawImage(tileset.image,
					tileset.width * tile.column,
					tileset.height * tile.row,
					tileset.width,
					tileset.height,
					sx + i * CONSTANTS.TILE.WIDTH,
					sy + CONSTANTS.TILE.HEIGHT + CONSTANTS.HEIGHT(),
					CONSTANTS.TILE.WIDTH,
					CONSTANTS.TILE.HEIGHT);
			}
		}
	}
	
	canvas.events.attach("draw", function() {
		canvas.drawWith(6);
		drawHorizontalWalls();
		drawVerticalWalls();
	});
});