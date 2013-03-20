$(function() {
	var inventory = $("#ui #inventory")[0], rows = 4, columns = 6, ih = "<div class='title'>Inventory</div>", i, j;	
	for(i = 0; i < rows; i++) {
		ih += "<div class='row'>";
		for(j = 0; j < columns; j++) {
			ih +=
			"<div class='column'>" +
				"<img data-id='0' src='' alt=''/>" +
			"</div>";
		}
		ih += "</div>";
	}
	inventory.innerHTML = ih;
});