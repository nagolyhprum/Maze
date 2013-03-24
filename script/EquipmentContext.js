$(function() {
	var equipment_context = $("#equipment_context")[0], ih = "", equipment = $("#equipment #items .item img");
	equipment_context.onselect = {
		"Unequip" : function(c) {			
			var slot = $("#inventory [data-id='0']")[0];
			if(slot) {
				var item = c.item;
				slot.item = item;
				slot.setAttribute("data-id", item.id);
				slot.setAttribute("src", item.portrait);
				
				delete c.item;
				c.setAttribute("data-id", 0);
				c.setAttribute("src", "");
				
				for(var i in item.statistics) {
					character.statistics[i].current -= item.statistics[i].current;
					character.statistics[i].max -= item.statistics[i].max;
				}
				character.updateStatistics();
				
				Sound.effect(item.sounds.move);
				return true;
			}		
		}
	};
	ih += "<div>Unequip</div>";
	equipment_context.innerHTML = ih;
	
	for(var i = 0; i < equipment.length; i++) {
		equipment[i].setAttribute("data-context", "equipment_context");
	}
});