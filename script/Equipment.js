$(function() {
	var width = 296, height = 325, background, margin = 5, titlesize = 22, start = {x : 400, y : 0}, visible = 0;
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	
	equipment_items.head = {
		rectangle : {
			x : width / 2 - 32,
			y : margin * 3 + titlesize,
			width : 64,
			height : 64
		},
		empty : loadImage("items/head.png")
	};
	
	equipment_items.neck = {
		rectangle : {
			x : width / 2 - 64 - margin * 2,
			y : margin * 3 + titlesize + equipment_items.head.rectangle.height - 32,
			width : 32,
			height : 32
		},
		empty : loadImage("items/neck.png")
	};
	
	equipment_items.chest = {
		rectangle : {
			x : width / 2 - 48,
			y : margin * 5 + titlesize + equipment_items.head.rectangle.height,
			width : 96,
			height : 86
		},
		empty : loadImage("items/chest.png")
	};
	
	equipment_items.mainhand = {
		rectangle : {
			x : margin,
			y : margin * 5 + titlesize + equipment_items.head.rectangle.height,
			width : 80,
			height : 86
		},
		empty : loadImage("items/mainhand.png")
	};
	
	equipment_items.offhand = {
		rectangle : {
			x : width - margin - 80,
			y : margin * 5 + titlesize + equipment_items.head.rectangle.height,
			width : 80,
			height : 86
		},
		empty : loadImage("items/offhand.png")
	};
	
	equipment_items.legs = {
		rectangle : {
			x : width / 2 - 56,
			y : margin * 7 + titlesize + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 112,
			height : 112
		},
		empty : loadImage("items/legs.png")
	};
	
	equipment_items.feet = {
		rectangle : {
			x : margin,
			y : margin * 7 + titlesize + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 72,
			height : 72
		},
		empty : loadImage("items/feet.png")
	};
	
	equipment_items.hands = {
		rectangle : {
			x : width - 72 - margin,
			y : margin * 7 + titlesize + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 72,
			height : 72
		},
		empty : loadImage("items/hands.png")
	};
	
	equipment_items.rightring = {
		rectangle : {
			x : width / 2 + margin * 3 + equipment_items.legs.rectangle.width / 2,
			y : margin * 9 + titlesize + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height + equipment_items.hands.rectangle.height,
			width : 30,
			height : 30
		},
		empty : loadImage("items/ring.png")
	};
	
	equipment_items.leftring = {
		rectangle : {
			x : width / 2 - margin * 3 - equipment_items.legs.rectangle.width / 2 - 30,
			y : margin * 9 + titlesize + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height + equipment_items.hands.rectangle.height,
			width : 30,
			height : 30
		},
		empty : loadImage("items/ring.png")
	};
	
	var menu = {
		"Unequip" : function(c) {
			if(inventory_items.length < inventory_items.max) {
				var item = c.item;
				for(var i in item.statistics) {
					character.statistics[i].current -= item.statistics[i].current;
					character.statistics[i].max -= item.statistics[i].max;
				}
				inventory_items.push(c.item);
				delete c.item;
			}
		}
	};
	
	for(var i in equipment_items) {
		contexts.push({
			item : equipment_items[i],
			contains : function(l) {
				var ei = this.item;
				if(visible && ei.item) {
					var x = start.x + ei.rectangle.x, y = start.y + ei.rectangle.y, b = y + ei.rectangle.height, r = x + ei.rectangle.width;
					if(l.x >= x && l.y >= y && l.x <= r && l.y <= b) {
						return {
							context : ei,
							menu : menu							
						};
					}
				}
			}
		});
	}
	
	canvas.events.attach("keydown", function(keycode) {
		if(keycode === 69) { //e
			visible = !visible;
		} else {
			visible = 0;
		}
	});
	
	canvas.events.attach("draw", function() {
		if(visible) {
			start.x = canvas.width / 2 - width / 2;
			start.y = canvas.height / 2 - height / 2;
			context.save();
			context.globalAlpha = 0.8;
			context.translate(start.x, start.y);
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, width, height);
			context.strokeRect(margin, margin, width - margin * 2, titlesize);		
			context.strokeRect(0, 0, width, height);		
			for(var i in equipment_items) {
				var ei = equipment_items[i],
					rectangle = ei.rectangle,
					empty = ei.empty,
					item = ei.item;
				if(item) {
					item.location.x = rectangle.x;
					item.location.y = rectangle.y;
					item.drawEquipment(context, rectangle.width, rectangle.height);
				} else if(empty.complete) {
					context.drawImage(empty, rectangle.x, rectangle.y, rectangle.width, rectangle.height);
				}
				context.strokeRect(rectangle.x, rectangle.y, rectangle.width, rectangle.height);
			}
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.strokeText("Equipment", margin + 5, margin + titlesize / 2, width);
			context.globalAlpha = 1;
			context.restore();
		}
	});
});