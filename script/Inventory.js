$(function() {	
	canvas.events.attach("keydown", function(key) {
		if(key === 17) {
			for(var i = 0; i < items.list.length; i++) {
				var item = items.list[i];
				if(item.location.column === character.location.column && item.location.row === character.location.row) {
					items.list.splice(i, 1);
					inventory_items.push(item);
					break;
				}
			}
		}
	});

	function pickUpItem(item) {
		if(inventory_items.length < columns * rows) {
			inventory_items.push(item);			
		}
	}
		
	var start = {x : 0, y : 100},
		margin = 5,
		cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		background,
		titlesize = 24,
		width = (cellwidth + margin * 2) * columns, 
		height = margin * 2 + titlesize + (cellheight + margin * 2) * rows;
		
	inventory_items.max = columns * rows;
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	var menu = {
		"Equip / Use" : function(c) {
			inventory_items.splice(inventory_items.indexOf(c), 1);
			if(equipment_items[c.type].item) {
				inventory_items.push(equipment_items[c.type].item);
			}
			equipment_items[c.type].item = c;
		},
		"Drop" : function(c) {
			inventory_items.splice(inventory_items.indexOf(c), 1);
			c.location.row = character.location.row;
			c.location.column = character.location.column;
			items.list.push(c);
		},
		"Destroy" : function(c) {
			inventory_items.splice(inventory_items.indexOf(c), 1);
		}
	};
	for(var i = 0; i < rows; i++) {
		for(var j = 0; j < columns; j++) {
			var x = margin + (margin * 2 + cellwidth) * j, 
				y = margin * 3 + titlesize + (margin * 2 + cellheight) * i;
			contexts.push({
				column : j,
				row : i,
				x : x,
				y : y,
				width : cellwidth,
				height : cellheight,
				contains : function(l) {
					var x = this.x + start.x, y = this.y + start.y, r = x + this.width, b = y + height;
					if(l.x >= x && l.y >= y && l.x <= r && l.y <= b) {
						var item = inventory_items[this.column + this.row * columns];
						if(item) {
							return {
								context : item,
								menu : menu
							};
						}
					}
				}
			});
		}
	}			
	
	canvas.events.attach("draw", function() {
		context.save();
		context.font = "12px Times New Roman";
		context.translate(start.x, start.y);
		context.strokeStyle = "black";
		context.fillStyle = background;
		context.fillRect(0, 0, width, height); //container
		context.strokeRect(0, 0, width, height); //container
		context.strokeRect(margin, margin, width - margin * 2, titlesize); //title				
		for(var i = 0; i < rows; i++) {
			for(var j = 0; j < columns; j++) {
				var x = margin + (margin * 2 + cellwidth) * j, 
					y = margin * 3 + titlesize + (margin * 2 + cellheight) * i,
					ii = inventory_items[j + i * columns];
				context.strokeRect(x, y, cellwidth, cellheight);
				if(ii) {
					ii.location.x = x;
					ii.location.y = y;
					ii.drawInventory(context);
				}
			}
		}
		context.strokeStyle = "white";
		context.textBaseline = "middle";
		context.strokeText("Inventory", margin * 2, margin + titlesize / 2, width - margin * 2);
		context.restore();
	});
});