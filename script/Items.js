$(function() {
	var count = 0;
	Server.attach("GetItemsInRoom", function(list) {
		for(var i = 0; i < list.length; i++) {
			list[i] = new Item(list[i]);
		}
		items.list = list;			
		while(count < list.length) {
			var move = list[count].sounds.move;
			Sound.effect(move[Math.floor(Math.random() * move.length)]);
			count++;
		}
	});	
	canvas.events.attach("draw", function() {
		canvas.drawWith(4);
		for(var i = items.list.length - 1; i >= 0; i--) {
			var item = items.list[i], l = item.location, start = CONSTANTS.START, size = CONSTANTS.TILE;
			if(items.list[i].portrait.complete) {
				context.drawImage(items.list[i].portrait, start.X() + l.column * size.WIDTH, start.Y() + l.row * size.HEIGHT, size.WIDTH, size.HEIGHT);
			}
		}
	});
});