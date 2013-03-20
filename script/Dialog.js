$(function() {
	var border = 
		'<div class="top"></div>' +
		'<div class="topright"></div>' +
		'<div class="right"></div>' +
		'<div class="bottomright"></div>' +
		'<div class="bottom"></div>' +
		'<div class="bottomleft"></div>' +
		'<div class="left"></div>' +
		'<div class="topleft"></div>',
		ui = $("#ui > div");
		
	for(var i = 0; i < ui.length; i++) {
		ui[i].innerHTML += border;
	}
		
	
});