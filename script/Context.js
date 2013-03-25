$(function() {
	var contextmenu, padding = 5, location, cellheight = padding * 2 + 12, height, width, highlight;
	canvas.events.attach("click", function(l) {
		if(contextmenu) {
			var options = Object.keys(contextmenu.menu);
			contextmenu.menu[options[highlight]](contextmenu.context);
			contextmenu = 0;
		} else {
			highlight = 0;
			contextmenu = 0;
			location = l;
			for(var i = 0; i < contexts.length && !contextmenu; i++) {
				contextmenu = contexts[i].contains(l);
			}
		}
	});
	canvas.events.attach("mousemove", function(l) {
		if(contextmenu && (l.x < location.x || l.y < location.y || l.x >= location.x + width || l.y >= location.y + height)) {
			contextmenu = 0;
		} else if(contextmenu) {
			highlight = Math.floor((l.y - location.y) / cellheight);
		}
		
	});
	canvas.events.attach("draw", function() {
		if(contextmenu) {
			var options = Object.keys(contextmenu.menu);
			context.font = "12px Times New Roman";
			var max = 0; 
			for(var i = 0; i < options.length; i++) {
				width = context.measureText(options[i]).width;
				if(width > max) {
					max = width;
				}				
			}
			height = cellheight * options.length;
			context.fillStyle = "gray";
			context.strokeStyle = "black";
			context.textbaseline = "textBaseline";
			max += padding * 2;
			width = max;
			context.fillRect(location.x, location.y, max, height);
			context.fillStyle = "lightgray";
			context.fillRect(location.x, location.y  + cellheight * highlight, width, cellheight);
			for(var i = 0; i < options.length; i++) {
				context.strokeText(options[i], location.x + padding, location.y + (i + 1) * cellheight - cellheight / 2, max);
			}
		}
	});
});