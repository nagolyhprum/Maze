function addBehavior(category, subcategory, amount) {
	behaviors[category][subcategory] += (amount || 1);
	for(var i = 0; i < badges.length; i++) {
		var b = badges[i];
		if(!b.complete) {
			var cat = b.category, scat = b.subcategory, count = 0;
			if(!scat) {
				for(var j in behaviors[cat]) {
					count += behaviors[cat][j];
				}
			} else {
				count = behaviors[cat][scat];
			}
			if(count >= b.count) {
				b.complete = 1;
				alert(b.name + " earned.");
			}
		}
	}
}

$(function() {
	var fontsize = 12, 
		width = 200, 
		height = 400,
		x = canvas.width / 2 - width / 2,
		y = canvas.height / 2 - height / 2,
		padding = 5,
		background;		
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		if(keycode === 71) { //g
			behaviors.visible = 1;
		} else {		
			behaviors.visible = 0;
		}
	});
	canvas.events.attach("draw", function() {
		if(behaviors.visible) {
			context.globalAlpha = 0.8;
			context.strokeStyle = "black";
			context.fillStyle = "gray";
			if(background) {
				context.fillStyle = background;
			}			
			context.fillRect(x, y, width, height);
			context.strokeRect(x, y, width, height);
			context.strokeRect(x + padding, y + padding, width - padding * 2, fontsize + 2 * padding);
			context.strokeStyle = "white";
			context.textAlign = "left";
			context.textBaseline = "middle";
			context.strokeText("General Statistics", x + padding * 2, y + padding + (fontsize + 2 * padding) / 2);
			var text = "";
			for(var i in behaviors) {
				if(behaviors[i] instanceof Object) {
					if(text) {
						text += "\n";
					}
					text += i;
					for(var j in behaviors[i]) {
						text += "\n    " + j + " : " + behaviors[i][j];
					}
				}
			}
			text = generateText({
				text : text,
				width : width - padding * 2,
				color : "white"
			});
			context.drawImage(text, x + padding, y + padding * 4 + fontsize);
			
			context.globalAlpha = 1;
		}
	});
});