$(function() {
	var messages = [];
	
	alert = function(s) {
		messages.unshift(s);
		setTimeout(function() {
			messages.pop();
		}, 5000);
	};
	
	canvas.events.attach("draw", function() {
		context.fillStyle = "white";
		context.textAlign = "right";
		context.textBaseline = "bottom";
		for(var i = Math.min(5, messages.length) - 1; i >= 0; i--) {
			context.fillText(messages[i], canvas.width - 5, canvas.height - 12 * i - 5, CONSTANTS.INBETWEEN());
		}
	});
});