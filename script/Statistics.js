$(function() {
	var width = 300, 
		titlesize = 22, 
		margin = 5, 
		start = {x:0,y:0}, 
		background, 
		statistics = Object.keys(new Statistics()), 
		visible = 0,
		height = titlesize + margin * 2 + width / 2 + statistics.length * (margin * 2 + titlesize),
		location = {x:0,y:0},
		mousemove = 0;
		
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	
	canvas.events.attach("mousemove", function(l) {
		location = l;
		mousemove = 1;
	});
	
	canvas.events.attach("keydown", function(keycode) {
		if(keycode === 83) { //s
			visible = !visible;
		} else {
			visible = 0;
		}
		mousemove = 0;
	});
	
	canvas.events.attach("draw", function() {
		context.save();
		context.globalAlpha = 0.8;
		if(visible) {
			drawCharacterStatistics();
		} else if (!contexts.contextmenu){
			drawItemStatistics(getHover());
			if(mousemove && !equipment_items.visible && !inventory_items.visible) {
				var column = Math.floor((location.x - CONSTANTS.START.X()) / CONSTANTS.TILE.WIDTH),
					row = Math.floor((location.y - CONSTANTS.START.Y()) / CONSTANTS.TILE.HEIGHT);
				for(var i = 0; i < items.list.length; i++) {
					var item = items.list[i], l = item.location;
					if(l.column === column && l.row === row) {
						drawItemStatistics(item);
						break;
					}
				}
			}
		}
		context.restore();
	});
	
	function drawItemStatistics(item) {	
		if(item) {
			var equipped, final_width = width;
			if(equipment_items.visible) {
				item = item.item;
			} else {
				equipped = equipment_items[item.type].item;
				if(equipped) {
					final_width *= 2;
				}
			}
			
			context.save();
			context.translate(
				clamp(location.x, 0, canvas.width - final_width), 
				clamp(location.y, 0, canvas.height - height)
			);
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, final_width, height); //container
			context.strokeRect(0, 0, final_width, height); //container
			drawStatistics(item);
			if(equipped) {
				context.translate(width, 0);
				drawStatistics(equipped);
			}
			context.restore();
		}
	}
	
	function getHover() {
		for(var i = 0; i < contexts.length; i++) {
			var context = contexts[i].contains(location);
			if(context) {
				return context.context;
			}
		}		
	}
	
	function drawCharacterStatistics() {
		start.x = canvas.width / 2 - width / 2;
		start.y = canvas.height / 2 - height / 2;
		context.save();
		context.translate(start.x, start.y);
		context.strokeStyle = "black";
		context.fillStyle = background;
		context.fillRect(0, 0, width, height); //container
		context.strokeRect(0, 0, width, height); //container
		drawStatistics(character);	
		context.restore();
	}
	
	function drawStatistics(obj) {	
		
		context.strokeRect(margin, margin, width - margin * 2, titlesize); //title
		
		var cellwidth = width / 2, cellheight = cellwidth;
		context.strokeRect(margin, margin * 3 + titlesize, cellwidth - margin * 2, cellheight - margin * 2); //left cell
		context.strokeRect(width - cellwidth + margin, margin * 3 + titlesize, cellwidth - margin * 2, cellheight - margin * 2); //right cell
		if(obj.portrait.complete) {
			context.drawImage(obj.portrait, width - cellwidth + margin, margin * 3 + titlesize, cellwidth - margin * 2, cellwidth - margin * 2);
		}
		
		context.fillStyle = "white";	
		//name				
		context.textAlign = 'right';
		context.textBaseline = "bottom";
		context.fillText(obj.name, cellwidth - margin * 2, titlesize + cellheight, cellwidth);
		//end name	
		context.textBaseline = "middle";
		cellwidth = width / 3;
		for(var i = 0; i < statistics.length; i++) {
			context.textAlign = 'right';
			
			context.fillText(statistics[i][0].toUpperCase() + statistics[i].substring(1), cellwidth - margin * 2, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, width);
			context.strokeRect(margin, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
			
			context.textAlign = 'center';
			
			context.fillText(obj.statistics[statistics[i]].max, cellwidth + cellwidth / 2, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, cellwidth - margin * 2);
			context.strokeRect(margin + cellwidth, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
			
			context.fillText(obj.statistics[statistics[i]].current, 2 * cellwidth + cellwidth / 2, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, cellwidth - margin * 2);
			context.strokeRect(margin + 2 * cellwidth, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);				
		}
		context.textAlign = 'left';
		context.fillText("Statistics", margin * 2, margin + titlesize / 2, width);
	}
});