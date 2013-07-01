$(function() {
	var walls = {data:[],columns:0,rows:0}, alpha = 0;
	Server.getAllWalls(function(w) {
		walls = w;
		room.events.invoke("change");
	});
	setInterval(function() {
		alpha += Math.PI / 10;
		alpha %= (2 * Math.PI);
	}, 100);
	canvas.events.attach("draw", function() {
		canvas.drawWith(7);
		context.save();
		context.translate(canvas.width - CONSTANTS.INBETWEEN() - 10, 10);
		context.strokeStyle = "black";
		context.fillStyle = "rgba(255, 255, 255, 0.5)";
		context.fillRect(0, 0, CONSTANTS.INBETWEEN(), CONSTANTS.INBETWEEN());
		var cellw = CONSTANTS.INBETWEEN() / walls.columns,
			cellh = CONSTANTS.INBETWEEN() / walls.rows;
		for(var i = 0; i < walls.data.length; i++) {
			var d = walls.data[i],
				column = i % walls.columns,
				row = Math.floor(i / walls.rows);
			if(d !== null) {
				context.fillRect(cellw * column, cellh * row, cellw, cellh);
			}
			if(d & CONSTANTS.WALL.TOP) {
				context.strokeRect(cellw * column, cellh * row, cellw, 1);
			}
			if(d & CONSTANTS.WALL.RIGHT) {
				context.strokeRect(cellw * column + cellw, cellh * row, 1, cellh);
			}
			if(d & CONSTANTS.WALL.BOTTOM) {
				context.strokeRect(cellw * column, cellh * row + cellh, cellw, 1);
			}
			if(d & CONSTANTS.WALL.LEFT) {
				context.strokeRect(cellw * column, cellh * row, 1, cellh);
			}
		}
		var cw = cellw / 4, ch = cellh / 4;
		context.fillStyle = "rgba(255, 0, 0, " + ((1 + Math.sin(alpha)) / 4 + 0.5) + ")";
		context.fillRect(
			room.location.column * cellw + cellw / 2 - cw / 2, 
			room.location.row * cellh + cellh / 2 - ch / 2, 
		cw - 1, ch - 1);
		context.restore();
	});
	room.events.attach("change", function() {
		if(!walls.data[room.location.column + room.location.row * walls.columns]) {			
			Server.getWalls(function(w) {
				walls.data[room.location.column + room.location.row * walls.columns] = w;
				addBehavior("Discover", "Rooms");
			});
		}
		for(var i = 0; i < walls.columns * walls.rows; i++) {
			if(!walls.data[i]) {
				return;
			}
		}
		if(walls.data.length) {
			addBehavior("Discover", "Maps");
		}
	}).invoke("change");
});