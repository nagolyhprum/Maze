$(function() {
	skills.visible = 0;
	var background, location = {x:0,y:0}, click, active;
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		var key = parseInt(String.fromCharCode(keycode));
		if(skills.visible && active && !isNaN(key)) {
			skillMapping[key] = active;
		} else if(keycode === 82) { //r
			skills.visible = !skills.visible;
		} else {
			skills.visible = 0;
		}
	});	

	var skillMapping = [];	
	
	canvas.events.attach("mousemove", function(l) {
		location = l;
	});

	canvas.events.attach("click", function(l) {
		click = l;
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
			context.translate(start.x, start.y);
			context.globalAlpha = 0.8;			
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, width, height); //container
			context.strokeRect(0, 0, width, height); //container
			context.strokeRect(margin, margin, width - margin * 2, titlesize); //title						
			var index = 0;
			for(var i = 0; i < rows; i++) {
				for(var j = 0; j < columns; j++, index++) {
					var x = margin + j * (cellwidth + margin * 2), y = 3 * margin + titlesize + i * (cellheight + margin * 2);
					context.strokeRect(x, y, cellwidth, cellheight);
					if(index < skills.length) {
						var skill = skills[index];
						context.drawImage(skill.image.icon, x, y, cellwidth, cellheight);
						if(location.x >= start.x + x && location.y >= start.y + y && location.x <= start.x + x + cellwidth && location.y <= start.y + y + cellheight) {		
							var text = generateText({
								text : skills[index].description,
								color : "white",
								width : 100
							});
							context.fillRect(location.x - start.x, location.y - start.y, 100, text.height + margin * 4);
							context.strokeRect(location.x - start.x, location.y - start.y, 100, text.height + margin * 4);
							context.drawImage(text, location.x - start.x, location.y - start.y);
						}
						if(click && click.x >= start.x + x && click.y >= start.y + y && click.x <= start.x + x + cellwidth && click.y <= start.y + y + cellheight) {
							active = skill;
						}
					}
				}
			}
			
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.textAlign = "left";
			context.strokeText("Skills", margin * 2, margin + titlesize / 2, width - margin * 2);				
			context.globalAlpha = 1;			
			context.restore();			
		}
		
		for(var i = 0; i < 10; i++) {
			var x = i * cellwidth + margin + i * margin, y = canvas.height - cellheight - margin;
			context.strokeRect(x, y, cellwidth, cellheight);
			context.fillRect(x, y, cellwidth, cellheight);
			if(skillMapping[i]) {			
				context.drawImage(skillMapping[i].image.icon, x, y, cellwidth, cellheight);
			}
		}
		
		click = 0;
	});
});