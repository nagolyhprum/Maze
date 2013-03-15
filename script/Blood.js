var Blood = (function() {
	function Blood(obj) { //location must be defined
		var count = obj.count || 500,
			colors = obj.colors || BLOOD_RED,
			max_speed = obj.speed || 10,
			size = obj.size || 5;
		for(var i = 0; i < count; i++) {
			var rad = 2 * Math.PI * Math.random(), speed = Math.random() * max_speed;
			particles.push({
				color : colors[Math.floor(colors.length * Math.random())],
				size : Math.ceil(size * Math.random()),
				location : {
					x : obj.location.x,
					y : obj.location.y
				},
				velocity : {
					x : Math.cos(rad) * speed,
					y : Math.sin(rad) * speed
				}
			});
		}
	}	
	
	var stains = [], stains_canvas, stains_context, particles = [];
	$(function() {
		canvas.events.attach("draw", function() {			
			for(var i = particles.length - 1; i >= 0; i--) {
				var p = particles[i], l = p.location, v = p.velocity;			
				if(Math.abs(v.x) + Math.abs(v.y) < 1 || l.x <= CONSTANTS.START.X() || l.y <= CONSTANTS.START.Y() || l.x >= CONSTANTS.START.X() + stains_canvas.width || l.y >= CONSTANTS.START.Y() + stains_canvas.height) {
					particles.splice(i, 1);
					stains_context.fillStyle = p.color;
					stains_context.fillRect(l.x - CONSTANTS.START.X(), l.y - CONSTANTS.START.Y(), p.size, p.size);
				} else {
					context.fillStyle = p.color;
					context.fillRect(l.x, l.y, p.size, p.size);
					l.x += v.x;
					l.y += v.y;
					v.x /= 1.1;
					v.y /= 1.1;
				}
			}
			context.drawImage(stains_canvas, CONSTANTS.START.X(), CONSTANTS.START.Y());
		});
		
		room.events.attach("change", function() {
			var row = stains[room.location.row] = (stains[room.location.row] || []),
				column = row[room.location.column];
			if(!column) {
				column = document.createElement("canvas");
				column.width = CONSTANTS.TILE.WIDTH * CONSTANTS.TILE.COLUMNS;
				column.height = CONSTANTS.TILE.HEIGHT * CONSTANTS.TILE.ROWS;
			}
			row[room.location.column] = stains_canvas = column;
			stains_context = column.getContext("2d");
		});
	});

	var BLOOD_RED = [
		"rgba(102, 000, 000, 0.25)",
		"rgba(220, 020, 060, 0.25)",
		"rgba(139, 000, 000, 0.25)",
		"rgba(128, 000, 000, 0.25)",
		"rgba(204, 017, 000, 0.25)"
	];
	
	return Blood;
}());