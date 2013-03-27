$(function() {
	var count = 0;
	items.events.attach("drop", function() {
		items.list = Server.getRoomItems();
		while(count < items.list.length) {
			var move = items.list[count].sounds.move;
			Sound.effect(move[Math.floor(Math.random() * move.length)]);
			count++;
		}
	});
	room.events.attach("change", function() {
		items.list = Server.getRoomItems();
		count = items.list.length;
	});
	canvas.events.attach("draw", function() {
		for(var i = items.list.length - 1; i >= 0; i--) {
			var item = items.list[i], l = item.location, start = CONSTANTS.START, size = CONSTANTS.TILE;
			context.drawImage(items.list[i].portrait, start.X() + l.column * size.WIDTH, start.Y() + l.row * size.HEIGHT, size.WIDTH, size.HEIGHT);
		}
	});
});