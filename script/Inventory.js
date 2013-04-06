$(function() {	
	canvas.events.attach("keydown", function(key) {
		if(key === 17) {
			var index = inventory_items.indexOf(undefined);
			if(index !== -1) {
				for(var i = 0; i < items.list.length; i++) {
					var item = items.list[i];
					if(item.location.column === character.location.column && item.location.row === character.location.row) {
						inventory_items[index] = item;		
						Sound.effect(item.sounds.move);
						items.list.splice(i, 1);
						break;
					}
				}
			}
		}
		if(key === 73) { //i
			inventory_items.visible = !inventory_items.visible;
		} else {
			inventory_items.visible = 0;
		}
	});

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
		inventory_items.visible = 0;
		
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	
	function unequip(type, index) {
		var equipped = equipment_items[type].item;
		inventory_items[index] = undefined; //remove the item
		if(equipped !== undefined) { 
			for(var i in equipped.statistics) {
				character.statistics[i].current -= equipped.statistics[i].current;
				character.statistics[i].max -= equipped.statistics[i].max;
			}
			inventory_items[index] = equipped;	
			Sound.effect(equipped.sounds.move);			
		}
		equipment_items[type].item = undefined;
	}
	
	var menu = {
		"Equip / Use" : function(c) {
			var index = inventory_items.indexOf(c), //get the index of the item to equip
				free = inventory_items.indexOf(undefined),
				i, 
				type = c.type; 
			if(c.type === "mainhand") {
				if(c.weight === 1) {
					if(equipment_items.mainhand.item && equipment_items.mainhand.item.weight === 4) {								
						if(free !== -1) {
							unequip("mainhand", free);
						} else {
							return;
						}
					}	
					unequip("offhand", index);
					type = "offhand";
				} else if(c.weight === 2) {
					if(equipment_items.offhand.item && equipment_items.offhand.item.weight === 2) {						
						unequip("offhand", index);
						type = "offhand";
					} else {
						unequip("mainhand", index);				
					}
				} else if(c.weight === 3) {
					unequip("mainhand", index);				
				} else if(c.weight === 4) {
					if(!equipment_items.offhand.item || free !== -1) {
						unequip("mainhand", index);					
						if(equipment_items.offhand.item) {
							unequip("offhand", free);
						}
					} else {
						return;
					}
				}
			}
			var equipped = c;
			for(i in equipped.statistics) {
				character.statistics[i].current += equipped.statistics[i].current;
				character.statistics[i].max += equipped.statistics[i].max;
			}
			equipment_items[type].item = c;	
			Sound.effect(equipped.sounds.move);
		},
		"Drop" : function(c) {
			inventory_items[inventory_items.indexOf(c)] = undefined;
			c.location.row = character.location.row;
			c.location.column = character.location.column;
			items.list.push(c);
			Sound.effect(c.sounds.move);
		},
		"Destroy" : function(c) {
			inventory_items[inventory_items.indexOf(c)] = undefined;
			Sound.effect(c.sounds.move);
		}
	};
	for(var i = 0; i < rows; i++) {
		for(var j = 0; j < columns; j++) {
			var x = margin + (margin * 2 + cellwidth) * j, 
				y = margin * 3 + titlesize + (margin * 2 + cellheight) * i;
			inventory_items.push(undefined);
			contexts.push({
				column : j,
				row : i,
				x : x,
				y : y,
				width : cellwidth,
				height : cellheight,
				contains : function(l) {
					if(inventory_items.visible) {
						var x = this.x + start.x, y = this.y + start.y, r = x + this.width, b = y + this.height;
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
				}
			});
		}
	}
	
	canvas.events.attach("draw", function() {
		if(inventory_items.visible) {
			start.x = canvas.width / 2 - width / 2;
			start.y = canvas.height / 2 - height / 2;
			context.save();
			context.globalAlpha = 0.8;
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
						context.drawImage(ii.portrait, x, y, cellwidth, cellheight);
					}
				}
			}
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.strokeText("Inventory", margin * 2, margin + titlesize / 2, width - margin * 2);
			context.restore();			
		}
	});
});