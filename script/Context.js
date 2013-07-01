$(function() {
	var contextmenu, location, cellheight = canvas.padding * 2 + canvas.fontSize(), height, width, highlight;
	canvas.events.attach("click", function(l) {
		if(contextmenu) {
			var options = Object.keys(contextmenu.menu);
			contextmenu.menu[options[highlight]](contextmenu.context);
			contexts.contextmenu = contextmenu = 0;
		} else {
			highlight = 0;
			contextmenu = 0;
			location = l;
			for(var i = 0; i < contexts.length && !contextmenu; i++) {
				contextmenu = contexts[i].contains(l);
			}
			contexts.contextmenu = contextmenu;
			location.x -= 5;
			location.y -= 5;
		}
	});
	canvas.events.attach("keydown", function() {
		contexts.contextmenu = contextmenu = 0;
	});
	canvas.events.attach("mousemove", function(l) {
		if(contextmenu && (l.x < location.x || l.y < location.y || l.x >= location.x + width || l.y >= location.y + height)) {
			contexts.contextmenu = contextmenu = 0;
		} else if(contextmenu) {
			highlight = Math.floor((l.y - location.y) / cellheight);
		}
		
	});
	canvas.events.attach("draw", function() {
		canvas.drawWith(14);
		if(contextmenu) {
			var options = Object.keys(contextmenu.menu), max = 0, i; 
			for(i = 0; i < options.length; i++) {
				width = context.measureText(options[i]).width;
				if(width > max) {
					max = width;
				}				
			}
			height = cellheight * options.length;
			context.fillStyle = "gray";
			context.strokeStyle = "black";
			context.textBaseline = "middle";
			context.textAlign = "left";
			max += canvas.padding * 2;
			width = max;
			context.fillRect(location.x, location.y, max, height);
			context.fillStyle = "lightgray";
			context.fillRect(location.x, location.y  + cellheight * highlight, width, cellheight);
			for(i = 0; i < options.length; i++) {
				context.strokeText(options[i], location.x + canvas.padding, location.y + (i + 1) * cellheight - cellheight / 2, max);
			}
		}
	});
});