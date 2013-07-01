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
	
	var cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		width = (cellwidth + canvas.padding * 2) * columns, 
		height = canvas.padding * 2 + (canvas.padding * 2 + canvas.fontSize()) + (cellheight + canvas.padding * 2) * rows,
		start = {x : canvas.width / 2 - width / 2, y : canvas.height / 2 - height / 2};
		inventory_items.visible = 0;
	canvas.events.attach("draw", function() {
		canvas.drawWith(17);
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
			context.strokeRect(canvas.padding, canvas.padding, width - canvas.padding * 2, (canvas.padding * 2 + canvas.fontSize())); //title		
			for(i = 0; i < rows; i++) {
				for(j = 0; j < columns; j++, index++) {
					x = canvas.padding + j * (cellwidth + canvas.padding * 2);
					y = 3 * canvas.padding + (canvas.padding * 2 + canvas.fontSize()) + i * (cellheight + canvas.padding * 2);
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
			context.fillStyle = "white";
			context.fillText("Badges", canvas.padding * 2, canvas.padding + (canvas.padding * 2 + canvas.fontSize()) / 2, width - canvas.padding * 2);				
			context.globalAlpha = 1;			
			context.restore();			
		}			
	});
	
	function drawBadgeDescription(badge, x, y) {
		var  w = 150,
			text = generateText({
				text : badge.name + "\n" + badge.category + " " + (badge.subcategory || "") + " " + badge.count,
				font : context.font,
				color : "white",
				width : w - canvas.padding * 2
			}), 
			h = text.height;
		context.save();
		context.globalAlpha = 0.8;
		x = Math.min(location.x - x, canvas.width - w);
		y = Math.min(location.y - y, canvas.height - h);
		context.fillRect(x, y, w, h + canvas.padding * 2);
		context.strokeRect(x, y, w, h + canvas.padding * 2);
		context.drawImage(text, x + canvas.padding, y + canvas.padding);
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