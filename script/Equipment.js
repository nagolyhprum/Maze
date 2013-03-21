$(function() {
	var equipment = $("#equipment")[0], ih = "<div class='title'>Equipment</div>";
	ih += "<div id='items'>"
		ih += "<div id='head' class='item'><img alt=''/></div>";
		ih += "<div id='chest' class='item'><img alt=''/></div>";
		ih += "<div id='mainhand' class='item'><img alt=''/></div>";
		ih += "<div id='offhand' class='item'><img alt=''/></div>";
		ih += "<div id='legs' class='item'><img alt=''/></div>";
		ih += "<div id='feet' class='item'><img alt=''/></div>";
		ih += "<div id='hands' class='item'><img alt=''/></div>";
		ih += "<div id='rightring' class='item'><img alt=''/></div>";
		ih += "<div id='leftring' class='item'><img alt=''/></div>";
		ih += "<div id='neck' class='item'><img alt=''/></div>";
	ih += "</div>";
	
	equipment.innerHTML = ih;
});