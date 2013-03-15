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
		for(var i = 0; i < items.list.length; i++) {
			items.list[i].draw(context);
		}
	});
});