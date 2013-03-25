$(function() {
	var width = 300, titlesize = 22, margin = 5, start = {x:0,y:0}, background, statistics = Object.keys(new Statistics());	
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("draw", function() {
		var height = titlesize + margin * 2 + width / 2 + statistics.length * (margin * 2 + titlesize);
		context.save();
		context.font = "12px Times New Roman";
		context.translate(start.x, start.y);
		context.strokeStyle = "black";
		context.fillStyle = background;
		context.fillRect(0, 0, width, height); //container
		context.strokeRect(0, 0, width, height); //container
		context.strokeRect(margin, margin, width - margin * 2, titlesize); //title
		
		var cellwidth = width / 2, cellheight = cellwidth;
		context.strokeRect(margin, margin * 3 + titlesize, cellwidth - margin * 2, cellheight - margin * 2); //left cell
		context.strokeRect(width - cellwidth + margin, margin * 3 + titlesize, cellwidth - margin * 2, cellheight - margin * 2); //right cell
		if(character.portrait.complete) {
			context.drawImage(character.portrait, width - cellwidth + margin, margin * 3 + titlesize, cellwidth - margin * 2, cellwidth - margin * 2);
		}
		context.fillStyle = "white";		
		context.textBaseline = "middle";
		cellwidth = width / 4;
		for(var i = 0; i < statistics.length; i++) {
			context.textAlign = 'right';
			
			context.fillText(statistics[i][0].toUpperCase() + statistics[i].substring(1), cellwidth - margin, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, width);
			context.strokeRect(margin, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
			
			context.textAlign = 'center';
			
			context.fillText(character.statistics[statistics[i]].max, cellwidth + cellwidth / 2, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, cellwidth - margin * 2);
			context.strokeRect(margin + cellwidth, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
			
			context.fillText(character.statistics[statistics[i]].current, 2 * cellwidth + cellwidth / 2, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize) + titlesize / 2, cellwidth - margin * 2);
			context.strokeRect(margin + 2 * cellwidth, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
			
			context.strokeRect(margin + 3 * cellwidth, titlesize + margin * 3 + cellheight + i * (margin * 2 + titlesize), cellwidth - margin * 2, titlesize);
		}
		context.textAlign = 'left';
		context.fillText("Statistics", margin * 2, margin + titlesize / 2, width);
		context.restore();
	});
});