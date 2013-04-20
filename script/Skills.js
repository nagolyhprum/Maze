$(function() {
	skills.visible = 0;
	var background;
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		if(keycode === 82) { //r
			skills.visible = !skills.visible;
		} else {
			skills.visible = 0;
		}
	});			
	
	var margin = 5,
		cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		background,
		titlesize = 24,
		width = (cellwidth + margin * 2) * columns, 
		height = margin * 2 + titlesize + (cellheight + margin * 2) * rows;
		inventory_items.visible = 0,
		start = {x : canvas.width / 2 - width / 2, y : canvas.height / 2 - height / 2};
	canvas.events.attach("draw", function() {
		if(skills.visible) {			
			context.save();
			context.globalAlpha = 0.8;						
			context.translate(start.x, start.y);
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, width, height); //container
			context.strokeRect(0, 0, width, height); //container
			context.strokeRect(margin, margin, width - margin * 2, titlesize); //title			
			
			var index = 0;
			for(var i = 0; i < rows; i++) {
				for(var j = 0; j < columns; j++, index++) {
					var x = margin + j * (cellwidth + margin * 2), y = 3 * margin + titlesize + i * (cellheight + margin * 2);
					if(index < skills.length) {
						var skill = skills[index];
						context.drawImage(skill.image.icon, x, y, cellwidth, cellheight);
					}
					context.strokeRect(x, y, cellwidth, cellheight);
				}
			}
			
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.textAlign = "left";
			context.strokeText("Skills", margin * 2, margin + titlesize / 2, width - margin * 2);				
			context.restore();
		}
	});
});