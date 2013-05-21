$(function() {
	canvas.events.attach("draw", function() {
		character.draw(context);
	});
	
	setCatchup(function() {
		if(character.statistics.getCurrent("energy") < character.statistics.getMax("energy")) {
			character.statistics.energy.current++;
		}
	}, 1000);
	
	canvas.events.attach("keydown", function(which) {
		if(character.tween.isTweening() || character.statistics.getCurrent("health") <= 0) return;
		var moved = 1, l = {
			column : character.location.column,
			row : character.location.row,
			collides : false
		}, horizontal = 0, vertical = 0;
		if(which === 37) { //left
			l.column--;
			character.display.row = CONSTANTS.DIRECTION.LEFT;
			horizontal = -CONSTANTS.TILE.WIDTH;
		} else if(which === 38) { //up
			l.row--;
			character.display.row = CONSTANTS.DIRECTION.UP;
			vertical = -CONSTANTS.TILE.HEIGHT;
		} else if(which === 39) { //right
			l.column++;
			character.display.row = CONSTANTS.DIRECTION.RIGHT;
			horizontal = CONSTANTS.TILE.WIDTH;
		} else if(which === 40) { //down
			l.row++;
			character.display.row = CONSTANTS.DIRECTION.DOWN;
			vertical = CONSTANTS.TILE.HEIGHT;
		} else {
			moved = 0;
			if(which === 32) {			
				if(equipment_items.mainhand.item && equipment_items.mainhand.item.area < 0) {
					sendDamage({column : 1, row : 0}, { area : equipment_items.mainhand.item.area, attack : equipment_items.mainhand.item ? equipment_items.mainhand.item.attack : "slash" });
					sendDamage({column : -1, row : 0}, { area : equipment_items.mainhand.item.area, attack : equipment_items.mainhand.item ? equipment_items.mainhand.item.attack : "slash" });
					sendDamage({column : 0, row : 1}, { area : equipment_items.mainhand.item.area, attack : equipment_items.mainhand.item ? equipment_items.mainhand.item.attack : "slash" });
					sendDamage({column : 0, row : -1}, { area : equipment_items.mainhand.item.area, attack : equipment_items.mainhand.item ? equipment_items.mainhand.item.attack : "slash"});
				} else {
					sendDamage(character.getDirection(), {
						area : equipment_items.mainhand.item ? equipment_items.mainhand.item.area : 1,
						attack : equipment_items.mainhand.item ? equipment_items.mainhand.item.attack : "slash"
					});
				}
				addBehavior("Character", "Attacks");
				character.attack();
			}
		}
		if(moved) {
			character.events.invoke("trymove", l);
			if(!l.collides) {
				var change = true;
				if(l.column === -1) {
					room.location.column--;
				} else if(l.column === CONSTANTS.TILE.COLUMNS) {
					room.location.column++;
				} else if(l.row === -1) {
					room.location.row--;
				} else if(l.row === CONSTANTS.TILE.ROWS) {
					room.location.row++;
				} else {
					change = false;
				}
				Server.moveCharacter(l);
				character.location.column = (l.column + CONSTANTS.TILE.COLUMNS) % CONSTANTS.TILE.COLUMNS;
				character.location.row = (l.row + CONSTANTS.TILE.ROWS) % CONSTANTS.TILE.ROWS;
				addBehavior("Character", "Steps");
				if(change) {			
					room.events.invoke("change");
				} else {
					character.moveBy(horizontal, vertical);
				}
			}
		}
	});
});