Server.attach("GetRoomEnemies", function(e) {
	var started = new Date().getTime();			
	for(var i = 0; i < e.length; i++) {
		e[i] = new Character(e[i]); //this is the only requirement
		e[i].lastTime = started;
		e[i].elapsedTime = 0;
	}
	enemies = e;
});

Server.attach("DamageEnemies", function(result) {
	var i, j;
	for(i = 0; i < result.enemies.length; i++) {
		for(j = 0; j < enemies.length; j++) {
			if(result.enemies[i].id === enemies[j].id) {
				enemies[j].damage(result.enemies[i].damage);
			}
		}
	}
});

$(function() {
	lock("character", function() {
		var sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2,
			sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2;
		canvas.events.attach("draw", function() {
			canvas.drawWith(5);
			for(var i = 0; i < enemies.length; i++) {
				enemies[i].draw(context);
			}
		});
		
		character.events.attach("trymove", function(l) {
			for(var i = 0; i < enemies.length; i++) {
				var e = enemies[i];
				if(l.row === e.location.row && l.column === e.location.column && e.statistics.health.current > 0) {
					l.collides = true;
				}
			}
		});		
	});
});

Server.attach("MoveEnemy", function(movement) {
	var seconds = 1.0 / 0, mes = movement.enemies;
	if(mes) {
		for(var i = 0; i < mes.length; i++) {
			var me = mes[i];
			for(var j = 0; j < enemies.length; j++) {
				var e = enemies[j];
				if(e.statistics.getCurrent("health") > 0) {
					if(e.id === me.id) {								
						e.tween.clear();
						if(me.column === me.lastColumn && me.row === me.lastRow) {
							e.face(character.location.column, character.location.row);
							e.attack();
						} else {
							var h = CONSTANTS.TILE.WIDTH * (me.column - me.lastColumn), 
								v = CONSTANTS.TILE.HEIGHT * (me.row - me.lastRow);									
							e.location.row = me.row;
							e.location.column = me.column;
							e.moveBy(h, v, function() {
								e.face(character.location.column, character.location.row);
							});
						}
					}
				}
			}
		}
		character.damage(character.statistics.getCurrent("health") - movement.character.health);
	}
});