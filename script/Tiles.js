$(function() {
	var offset = {
			x : canvas.width / 2 - CONSTANTS.WIDTH() / 2,
			y : canvas.height / 2 - CONSTANTS.HEIGHT() / 2
		};
	var tiles;
	room.events.attach("change", function() {
		tiles = Server.getTiles();
	});
	canvas.events.attach("draw", function() {
		for(var i = 0; i < CONSTANTS.TILE.ROWS; i++) {
			for(var j = 0; j < CONSTANTS.TILE.COLUMNS; j++) {
				if(tileset.complete) {
					var tile = tiles[j][i],
						sx = tile.column * tileset.width,
						sy = tile.row * tileset.height,
						dx = offset.x + j * CONSTANTS.TILE.WIDTH,
						dy = offset.y + i * CONSTANTS.TILE.HEIGHT;
					context.drawImage(
						tileset.image, 
						sx,
						sy,
						tileset.width,
						tileset.height,
						dx, 
						dy, 
						CONSTANTS.TILE.WIDTH, 
						CONSTANTS.TILE.HEIGHT
					);
				}
				context.strokeRect(
					offset.x + j * CONSTANTS.TILE.WIDTH, 
					offset.y + i * CONSTANTS.TILE.HEIGHT, 
					CONSTANTS.TILE.WIDTH, 
					CONSTANTS.TILE.HEIGHT
				);
			}
		}
	});
});