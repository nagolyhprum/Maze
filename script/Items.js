$(function() {
	items.events.attach("drop", function() {
		items.list = Server.getRoomItems();
	});
	room.events.attach("change", function() {
		items.list = Server.getRoomItems();
	});
	canvas.events.attach("draw", function() {
		for(var i = 0; i < items.list.length; i++) {
			items.list[i].draw(context);
		}
	});
});