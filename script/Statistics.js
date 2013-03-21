$(function() {
	var statistics = $("#ui #statistics")[0], ih = "<div class='title'>Statistics</div>";
	ih += "<div id='name'><span>" + character.name + "</span></div>";
	ih += "<div id='image'><img src='" + character.portrait + "' alt='?' /></div>";
	for(var i in character.statistics) {
		ih += "<div class='stat' class='" + i + "'>";
			ih += "<div class='name'>" + i[0].toUpperCase() + i.substring(1) + "</div>";
			ih += "<div class='max'>" + character.statistics[i].max + "</div>";		
			ih += "<div class='current'>" + character.statistics[i].current + "</div>";
		ih += "</div>";
	}
	statistics.innerHTML = ih;
})