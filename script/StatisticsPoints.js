$(function() {
	var canAdd = ["Strength", "Defense", "Intelligence", "Resistance", "Speed"],
		width = CONSTANTS.INBETWEEN(),
		height = (canvas.fontSize() + canvas.padding * 4) * (canAdd.length + 1),
		x = 10,
		y = canvas.height - height - CONSTANTS.TILE.HEIGHT - 20,
		background,
		location;
	
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	
	canvas.events.attach("click", function(l) {
		location = l;
	});
	
	canvas.events.attach("draw", function() {
		canvas.drawWith(15);
		if(statisticsPoints > 0) {
			context.fillStyle = "gray";
			context.strokeStyle = "black";
			if(background) {
				context.fillStyle = background;
			}
			context.fillRect(x, y, width, height);
			context.strokeRect(x, y, width, height);
											
			context.textAlign = "center";
			context.textBaseline = "middle";
			
			var dx = x + canvas.padding, dy = y + canvas.padding, w = width - canvas.padding * 2, h = canvas.fontSize() + canvas.padding * 2;
			context.strokeRect(dx, dy, w, h);			
			context.strokeText(statisticsPoints + "SP To Spend", dx + w / 2, dy + h / 2);
			
			for(var i = 0; i < canAdd.length; i++) {
				dx = x + canvas.padding;
				dy = y + (canvas.fontSize() + canvas.padding * 4) * (i + 1) + canvas.padding;
				context.strokeRect(dx, dy, w, h);
				context.strokeText(canAdd[i], dx + w / 2, dy + h / 2);
				if(location && location.x >= dx && location.y >= dy && location.x <= dx + w && location.y <= dy + h) {
					character.statistics[canAdd[i].toLowerCase()].current++; 
					character.statistics[canAdd[i].toLowerCase()].max++;
					statisticsPoints--;
				}
			}
			location = 0;
		}
	});
});