$(function() {
	var width = 296, 
		height = 330, 
		background, 
		start = {x : 400, y : 0};
	equipment_items.visible = 0;
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	
	equipment_items.head = {
		rectangle : {
			x : width / 2 - 32,
			y : canvas.padding * 3 + canvas.padding * 2 + canvas.fontSize(),
			width : 64,
			height : 64
		},
		empty : loadImage("items/head.png")
	};
	
	equipment_items.neck = {
		rectangle : {
			x : width / 2 - 64 - canvas.padding * 2,
			y : canvas.padding * 3 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height - 32,
			width : 32,
			height : 32
		},
		empty : loadImage("items/neck.png")
	};
	
	equipment_items.chest = {
		rectangle : {
			x : width / 2 - 48,
			y : canvas.padding * 5 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height,
			width : 96,
			height : 86
		},
		empty : loadImage("items/chest.png")
	};
	
	equipment_items.mainhand = {
		rectangle : {
			x : canvas.padding,
			y : canvas.padding * 5 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height,
			width : 80,
			height : 86
		},
		empty : loadImage("items/mainhand.png")
	};
	
	equipment_items.offhand = {
		rectangle : {
			x : width - canvas.padding - 80,
			y : canvas.padding * 5 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height,
			width : 80,
			height : 86
		},
		empty : loadImage("items/offhand.png")
	};
	
	equipment_items.legs = {
		rectangle : {
			x : width / 2 - 56,
			y : canvas.padding * 7 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 112,
			height : 112
		},
		empty : loadImage("items/legs.png")
	};
	
	equipment_items.feet = {
		rectangle : {
			x : canvas.padding,
			y : canvas.padding * 7 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 72,
			height : 72
		},
		empty : loadImage("items/feet.png")
	};
	
	equipment_items.hands = {
		rectangle : {
			x : width - 72 - canvas.padding,
			y : canvas.padding * 7 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height,
			width : 72,
			height : 72
		},
		empty : loadImage("items/hands.png")
	};
	
	equipment_items.rightring = {
		rectangle : {
			x : width / 2 + canvas.padding * 3 + equipment_items.legs.rectangle.width / 2,
			y : canvas.padding * 9 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height + equipment_items.hands.rectangle.height,
			width : 30,
			height : 30
		},
		empty : loadImage("items/ring.png")
	};
	
	equipment_items.leftring = {
		rectangle : {
			x : width / 2 - canvas.padding * 3 - equipment_items.legs.rectangle.width / 2 - 30,
			y : canvas.padding * 9 + canvas.padding * 2 + canvas.fontSize() + equipment_items.head.rectangle.height + equipment_items.chest.rectangle.height + equipment_items.hands.rectangle.height,
			width : 30,
			height : 30
		},
		empty : loadImage("items/ring.png")
	};
	
	var menu = {
		"Unequip" : function(c) {
			Server.equipItem(c.item.id, function(result) {
				if(result) {
					var type = c.item.type;
					if(c === equipment_items.offhand) {
						type = "offhand";
					}
					unequip(type, inventory_items.indexOf(null));
				}
			});
		}
	};
	
	for(var i in equipment_items) {
		contexts.push({
			item : equipment_items[i],
			contains : function(l) {
				var ei = this.item;
				if(equipment_items.visible && ei.item) {
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
			equipment_items.visible = !equipment_items.visible;
		} else {
			equipment_items.visible = 0;
		}
	});
	
	canvas.events.attach("draw", function() {
		canvas.drawWith(11);
		if(equipment_items.visible) {
			start.x = canvas.width / 2 - width / 2;
			start.y = canvas.height / 2 - height / 2;
			context.save();
			context.globalAlpha = 0.8;
			context.translate(start.x, start.y);
			context.strokeStyle = "black";
			context.fillStyle = background;
			context.fillRect(0, 0, width, height);
			context.strokeRect(canvas.padding, canvas.padding, width - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize());		
			context.strokeRect(0, 0, width, height);		
			for(var i in equipment_items) {
				var ei = equipment_items[i],
					rectangle = ei.rectangle,
					empty = ei.empty,
					item = ei.item;
				if(rectangle) { //i have to do this because of visible
					if(item) {
						context.drawImage(item.portrait, rectangle.x, rectangle.y, rectangle.width, rectangle.height);
					} else if(empty.complete) {
						context.drawImage(empty, rectangle.x, rectangle.y, rectangle.width, rectangle.height);
					}
					context.strokeRect(rectangle.x, rectangle.y, rectangle.width, rectangle.height);
				}
			}
			context.strokeStyle = "white";
			context.textAlign = "left";
			context.textBaseline = "middle";
			context.fillStyle = "white";
			context.strokeText("Equipment", canvas.padding + 5, canvas.padding + (canvas.padding * 2 + canvas.fontSize()) / 2, width);
			context.restore();
		}
	});
	lock("character", function() {
		Server.getEquipment(function(equipment) {
			for(var i = 0; i < equipment.length; i++) {
				var e = new Item(equipment[i]), type = e.type;
				if(e.type === "mainhand" && e.weight === 1) {
					type = "offhand";
				}
				equip(e, type);
			}
		});
	});
});