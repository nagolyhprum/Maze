Server.attach("AddBehavior", function(args) {
	var category = args.category,
		subcategory = args.subcategory,
		count = args.count, i = 0, j, b, cat, scat, total;
	for(; i < badges.length; i++) {
		b = badges[i];
		cat = b.category;
		scat = b.subcategory;
		total = 0;
		if(cat === category && (scat === subcategory || scat === null)) {
			if(!scat) {
				for(j in behaviors[cat]) {
					total += behaviors[cat][j];
				}
			} else {
				total = behaviors[cat][scat];
			}
			if(total < b.count && total + count >= b.count) {
				b.complete = 1;
				alert(b.name + " earned.");
			} else if(total >= b.count) {
				b.complete = 1;
			}
		}
	}
	behaviors[category][subcategory] += count;
});

$(function() {
	var	width = 200, 
		height = 400,
		x = canvas.width / 2 - width / 2,
		y = canvas.height / 2 - height / 2,
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
		canvas.drawWith(16);
		if(behaviors.visible) {
			context.globalAlpha = 0.8;
			context.strokeStyle = "black";
			context.fillStyle = "gray";
			if(background) {
				context.fillStyle = background;
			}			
			context.fillRect(x, y, width, height);
			context.strokeRect(x, y, width, height);
			context.strokeRect(x + canvas.padding, y + canvas.padding, width - canvas.padding * 2, canvas.fontSize() + 2 * canvas.padding);
			context.strokeStyle = "white";
			context.textAlign = "left";
			context.textBaseline = "middle";
			context.strokeText("General Statistics", x + canvas.padding * 2, y + canvas.padding + (canvas.fontSize() + 2 * canvas.padding) / 2);
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
				width : width - canvas.padding * 2,
				color : "white",
				font : context.font
			});
			context.drawImage(text, x + canvas.padding, y + canvas.padding * 4 + canvas.fontSize());
			
			context.globalAlpha = 1;
		}
	});
});