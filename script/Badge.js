$(function() {
	badges.visible = 0;
	var background, location = {x:0,y:0};
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		if(keycode === 66) { //b
			badges.visible = !badges.visible;
		} else {
			badges.visible = 0;
		}
	});	
	
	canvas.events.attach("mousemove", function(l) {
		location = l;
	});
	
	var margin = 10,
		cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		titlesize = 24,
		width = (cellwidth + margin * 2) * columns, 
		height = margin * 2 + titlesize + (cellheight + margin * 2) * rows,
		start = {x : canvas.width / 2 - width / 2, y : canvas.height / 2 - height / 2};
		inventory_items.visible = 0;
	canvas.events.attach("draw", function() {
		var index = 0, toDraw, i, x, y, j, badge;
		context.fillStyle = "gray";
		if(background) {
			context.fillStyle = background;
		}				
		if(badges.visible) {			
			context.save();					
			context.translate(start.x, start.y);
			context.globalAlpha = 0.8;			
			context.strokeStyle = "black";
			context.fillRect(0, 0, width, height); //container
			context.strokeRect(0, 0, width, height); //container
			context.strokeRect(margin, margin, width - margin * 2, titlesize); //title		
			for(i = 0; i < rows; i++) {
				for(j = 0; j < columns; j++, index++) {
					x = margin + j * (cellwidth + margin * 2);
					y = 3 * margin + titlesize + i * (cellheight + margin * 2);
					context.strokeRect(x, y, cellwidth, cellheight);
					if(index < badges.length) {
						badge = badges[index];
						drawBadgeIcon(badge, x, y);
						if(location.x >= start.x + x && location.y >= start.y + y && location.x <= start.x + x + cellwidth && location.y <= start.y + y + cellheight) {		
							toDraw = {
								x : start.x,
								y : start.y,
								badge : badge
							};
						}
					}
				}
			}					
			if(toDraw) {
				drawBadgeDescription(toDraw.badge, toDraw.x, toDraw.y);
			}
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.textAlign = "left";
			context.strokeText("Badges", margin * 2, margin + titlesize / 2, width - margin * 2);				
			context.globalAlpha = 1;			
			context.restore();			
		}			
	});
	
	function drawBadgeDescription(badge, x, y) {
		var  w = 150,
			text = generateText({
				text : badge.name + "\n" + badge.category + " " + (badge.subcategory || "") + " " + badge.count,
				color : "white",
				width : w - margin * 2
			}), 
			h = text.height;
		context.save();
		context.globalAlpha = 0.8;
		x = Math.min(location.x - x, canvas.width - w);
		y = Math.min(location.y - y, canvas.height - h);
		context.fillRect(x, y, w, h + margin * 2);
		context.strokeRect(x, y, w, h + margin * 2);
		context.drawImage(text, x + margin, y + margin);
		context.restore();
	}
	
	function drawBadgeIcon(badge, x, y) {
		if(badge.icon.complete) {
			context.drawImage(badge.icon, x, y, cellwidth, cellheight);
		}
		if(!badge.complete) {
			context.fillRect(x, y, cellwidth, cellheight);
		}
		context.strokeRect(x, y, cellwidth, cellheight);
	}
});