$(function() {
	var inventory_context = $("#inventory_context")[0],
		ih = "";
	inventory_context["data-select"] = {
		"Equip / Use" : function(c) {
			var image = $("#equipment #" + c.item.type + " img")[0], item = c.item;
			if(image.item) {
				if(!confirm("You must first remove your current equipment. Would you like to do this?")) {
					return;
				}
				c.item = image.item;
				c.setAttribute("src", image.item.portrait);
				c.setAttribute("data-id", image.item.id);				
			} else {
				delete c.item;
				c.setAttribute("src", "");
				c.setAttribute("data-id", 0);
			}
			image.item = item;
			image.setAttribute("src", item.portrait);
			image.setAttribute("data-id", item.id);
		},
		"Drop" : function(c) {
			if(confirm("Are you sure you would like to drop that item?")) {
				c.setAttribute("src", "");
				c.setAttribute("data-id", 0);
				var item = c.item;
				item.location.row = character.location.row;
				item.location.column = character.location.column;				
				Sound.effect(item.sounds.move);
				items.list.push(item);
			}		
		},
		"Destroy" : function(c) {
			if(confirm("Are you sure you would like to destroy that item?")) {
				c.setAttribute("src", "");
				c.setAttribute("data-id", 0);
			}
		}
	};
	
	ih += "<div>Equip / Use</div>";
	ih += "<div>Drop</div>";
	ih += "<div>Destroy</div>";
	
	inventory_context.innerHTML = ih;
});