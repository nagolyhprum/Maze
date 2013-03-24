$(function() {
	var contexts = $("#context > div"), dependent;
	
	for(var i = 0; i < contexts.length; i++) {
		attachEvent(contexts[i], "mouseout", vanish);
		attachEvent(contexts[i], "click", select);
	}
	
	var contextDependent = $("[data-context]");
	for(var i = 0; i < contextDependent.length; i++) {
		attachEvent(contextDependent[i], "click", openContextMenu);
	}
	
	function select(e) {
		var e = e.toElement || e.relatedTarget;
		e.parentNode["data-select"][e.innerHTML](dependent);
		e.parentNode.style.zIndex = -1;
	}
	
	function vanish(e) {
		e = e.toElement || e.relatedTarget;
		while(e) {
			if(e === this) {
				return;
			}
			e = e.parentNode;			   
		}
		this.style.zIndex = -1;
	}
	
	function openContextMenu(evt) {
		var dep = evt.target, context = $("#" + dep.getAttribute("data-context"))[0], x = evt.pageX, y = evt.pageY;
		dependent = dep;
		context.style.zIndex = 1;
		context.style.left = (x - 5) + "px";
		context.style.top = (y - 5) + "px";
	}
});