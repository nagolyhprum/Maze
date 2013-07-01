$(function() {
	lock("character", function() {
		var sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2,
			sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2;
		var foreground = loadImage("health/foreground_gray.png"),
			background = loadImage("health/background.png");
		canvas.events.attach("draw", function() {
			canvas.drawWith(9);
			var h_rat = character.statistics.getCurrent("health") / character.statistics.getMax("health"),
				e_rat = character.statistics.getCurrent("energy") / character.statistics.getMax("energy"),
				exp = character.statistics.getCurrent("experience") / character.statistics.getMax("experience");
			drawBar("red", 10, sy - CONSTANTS.TILE.HEIGHT, CONSTANTS.INBETWEEN(), 25, h_rat);
			drawBar("blue", 10, sy - CONSTANTS.TILE.HEIGHT + 35, CONSTANTS.INBETWEEN(), 25, e_rat);
			drawBar("green", 10, sy - CONSTANTS.TILE.HEIGHT + 70, CONSTANTS.INBETWEEN(), 25, exp);
			for(var i = 0; i < enemies.length; i++) {
				var l = enemies[i].location,
					s = enemies[i].statistics,
					current = s.getCurrent("health");
				if(current > 0) {
					drawBar(
						"red",
						sx + 5 + l.column * CONSTANTS.TILE.WIDTH + l.x, 
						sy +  l.row * CONSTANTS.TILE.HEIGHT + l.y, 
						CONSTANTS.TILE.WIDTH - 10, 
						10, 
						current / s.getMax("health"));
				}
			}
		});
		
		function drawBar(color, x, y, w, h, r) {
			r = Math.min(Math.max(0, r), 1);
			context.fillStyle = color;
			var rw = w / background.width, rh = h / background.height;
			context.drawImage(background, x, y, w, h);
			context.fillRect(x + 12 * rw, y + 8 * rh, (w - 24 * rw) * r, 15 * rh);
			context.drawImage(foreground, x, y, w, h);
		}
	});
});