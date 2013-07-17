Server.attach("HealEnergy", function(args) {
	character.statistics.energy.current = args;
});

$(function() {
	lock("character", function() {	
		canvas.events.attach("draw", function() {
			canvas.drawWith(8);
			character.draw(context);
		});
				
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
					Server.message("SendDamage", {
						direction : character.display.row
					});
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
					character.location.column = (l.column + CONSTANTS.TILE.COLUMNS) % CONSTANTS.TILE.COLUMNS;
					character.location.row = (l.row + CONSTANTS.TILE.ROWS) % CONSTANTS.TILE.ROWS;
					if(!change) {
						character.moveBy(horizontal, vertical);
					} else {
						canvas.load("ChangeRoom");
					}
					Server.message("MoveCharacter", l);
				}
			}
		});
	});
});