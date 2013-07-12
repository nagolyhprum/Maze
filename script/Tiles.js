var tiles;
Server.attach("GetTiles", function(t) {
	tiles = t;
});

$(function() {
	canvas.events.attach("draw", function() {
		canvas.drawWith(2);
		context.strokeStyle = "black";
		for(var i = 0; i < CONSTANTS.TILE.ROWS; i++) {
			for(var j = 0; j < CONSTANTS.TILE.COLUMNS; j++) {
				if(tileset.complete) {
					var tile = tiles[j][i],
						sx = tile.column * tileset.width,
						sy = tile.row * tileset.height,
						dx = CONSTANTS.START.X() + j * CONSTANTS.TILE.WIDTH,
						dy = CONSTANTS.START.Y() + i * CONSTANTS.TILE.HEIGHT;
					context.drawImage(
						tileset.image, 
						sx,
						sy,
						tileset.width,
						tileset.height,
						dx, 
						dy, 
						CONSTANTS.TILE.WIDTH, 
						CONSTANTS.TILE.HEIGHT);
				}
				context.strokeRect(
					CONSTANTS.START.X() + j * CONSTANTS.TILE.WIDTH, 
					CONSTANTS.START.Y() + i * CONSTANTS.TILE.HEIGHT, 
					CONSTANTS.TILE.WIDTH, 
					CONSTANTS.TILE.HEIGHT);
			}
		}
	});
});