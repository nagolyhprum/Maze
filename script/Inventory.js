$(function() {
	var inventory = $("#ui #inventory")[0], rows = 4, columns = 6, ih = "<div class='title'>Inventory</div>", i, j;	
	for(i = 0; i < rows; i++) {
		ih += "<div class='row'>";
		for(j = 0; j < columns; j++) {
			ih +=
			"<div class='column'>" +
				"<img data-context='inventory_context' data-id='0' src='' alt=''/>" +
			"</div>";
		}
		ih += "</div>";
	}
	
	
	//I need to make sure there is an item
	//property for items being held before 
	//the game was loaded
	function pickUpItem(item) {
		var slot = $("#inventory [data-id='0']")[0];
		if(slot) {
			slot.item = item;
			slot.setAttribute("data-id", item.id);
			slot.setAttribute("src", item.portrait);
			Sound.effect(item.sounds.move);
			return true;
		}		
	}
	
	inventory.innerHTML = ih;
	canvas.events.attach("keydown", function(key) {
		if(key === 17) { //ctrl
			for(var i = 0; i < items.list.length; i++) {
				var item = items.list[i];
				if(item.location.column === character.location.column && item.location.row === character.location.row) {
					if(pickUpItem(item)) {
						items.list.splice(i, 1);
						break;
					}
				}
			}
		}
	});
});