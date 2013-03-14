$(function() {
	var stats = "",
		sx = canvas.width / 2 - CONSTANTS.WIDTH() / 2,
		sy = canvas.height / 2 - CONSTANTS.HEIGHT() / 2;
	for(var i in character.statistics) {
		if(stats) {
			stats += "\n";
		}
		stats += i + " " + character.statistics[i].current + " / " + character.statistics[i].max;		
	}
})