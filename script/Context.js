$(function() {
	var contexts = $("#context > div");
	
	for(var i = 0; i < contexts.length; i++) {
		attachEvent(contexts[i], "mouseout", function(e) {
			e = e.toElement || e.relatedTarget;
			while(e) {
				if(e === this) {
					return;
				}
				e = e.parentNode;			   
			}
			this.style.zIndex = -1;
		});
	}
	
	var contextDependent = $("[data-context]");
	for(var i = 0; i < contextDependent.length; i++) {
		attachEvent(contextDependent[i], "click", openContextMenu);
	}
	
	function openContextMenu(evt) {
		var dep = evt.target, context = $("#" + dep.getAttribute("data-context"))[0], x = evt.pageX, y = evt.pageY;
		context.dependent = dep;
		context.style.zIndex = 1;
		context.style.left = x + "px";
		context.style.top = y + "px";
	}
});