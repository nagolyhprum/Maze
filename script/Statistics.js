$(function() {
	var width = 300,
		start = {x:0,y:0},
		background,
		statistics = Statistics.getStatisticNames(),
		visible = 0,
		height = canvas.padding * 2 + canvas.fontSize() + canvas.padding * 2 + width / 2 + statistics.length * (canvas.padding * 2 + canvas.padding * 2 + canvas.fontSize()),
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
		if(keycode === 67) { //s
			visible = !visible;
		} else {
			visible = 0;
		}
		mousemove = 0;
	});

	canvas.events.attach("draw", function() {
		canvas.drawWith(13);
		context.save();
		context.globalAlpha = 0.8;
		if(visible) {
			drawCharacterStatistics();
		} else if (!contexts.contextmenu && mousemove){
			drawItemStatistics(getHover());
			if(!equipment_items.visible && !inventory_items.visible && !skills.visible && !behaviors.visible && !badges.visible) {
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
				var type = item.type;
				if(type === "mainhand") {
					if(item.weight === 1 && !(equipment_items.mainhand.item && equipment_items.mainhand.item.weight === 4)) {
						type = "offhand";
					}
				}				
				equipped = equipment_items[type].item;
				if(equipped) {
					final_width *= 2;
				}
			}

			context.save();
			context.translate(
				clamp(location.x, 0, canvas.width - final_width),
				clamp(location.y, 0, canvas.height - height));
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, final_width, height); //container
			context.strokeRect(0, 0, final_width, height); //container
			drawStatistics(item, "Item");
			if(equipped) {
				context.translate(width, 0);
				drawStatistics(equipped, "Equipped");
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
		return false;
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
		drawStatistics(character, "Character");
		context.restore();
	}

	function drawStatistics(obj, name) {

		context.strokeRect(canvas.padding, canvas.padding, width - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize()); //title

		var cellwidth = width / 2, cellheight = cellwidth;
		context.strokeRect(canvas.padding, canvas.padding * 3 + canvas.padding * 2 + canvas.fontSize(), cellwidth - canvas.padding * 2, cellheight - canvas.padding * 2); //left cell
		context.strokeRect(width - cellwidth + canvas.padding, canvas.padding * 3 + canvas.padding * 2 + canvas.fontSize(), cellwidth - canvas.padding * 2, cellheight - canvas.padding * 2); //right cell
		if(obj.portrait.complete) {
			context.drawImage(obj.portrait, width - cellwidth + canvas.padding, canvas.padding * 3 + canvas.padding * 2 + canvas.fontSize(), cellwidth - canvas.padding * 2, cellwidth - canvas.padding * 2);
		}

		context.fillStyle = "white";
		//name
		context.textAlign = "right";
		context.textBaseline = "bottom";
		context.fillText(obj.name, cellwidth - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize() + cellheight, cellwidth);
		//end name
		context.textBaseline = "middle";
		cellwidth = width / 3;
		for(var i = 0; i < statistics.length; i++) {
			context.textAlign = 'right';

			var y = canvas.padding +
				canvas.padding +
				canvas.fontSize() + 
				canvas.padding + 
				canvas.padding + 
				canvas.padding + 
				cellheight + 
				canvas.padding + 
				//canvas.padding + 
				canvas.fontSize() / 2 + 
				i * (canvas.padding * 4 + canvas.fontSize());
			context.fillText(statistics[i][0].toUpperCase() + statistics[i].substring(1), cellwidth - canvas.padding * 2, y, width);
			context.strokeRect(canvas.padding, canvas.padding * 2 + canvas.fontSize() + canvas.padding * 3 + cellheight + i * (canvas.padding * 2 + canvas.padding * 2 + canvas.fontSize()), cellwidth - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize());

			context.textAlign = 'center';

			context.fillText(obj.statistics.getMax(statistics[i]), cellwidth + cellwidth / 2, y, cellwidth - canvas.padding * 2);
			context.strokeRect(canvas.padding + cellwidth, canvas.padding * 2 + canvas.fontSize() + canvas.padding * 3 + cellheight + i * (canvas.padding * 2 + canvas.padding * 2 + canvas.fontSize()), cellwidth - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize());

			context.fillText(obj.statistics.getCurrent(statistics[i]), 2 * cellwidth + cellwidth / 2, y, cellwidth - canvas.padding * 2);
			context.strokeRect(canvas.padding + 2 * cellwidth, canvas.padding * 2 + canvas.fontSize() + canvas.padding * 3 + cellheight + i * (canvas.padding * 2 + canvas.padding * 2 + canvas.fontSize()), cellwidth - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize());
		}
		context.textAlign = "left";
		context.fillText(name + " Statistics", canvas.padding * 2, canvas.padding * 2 + canvas.fontSize() / 2, width);
	}
});