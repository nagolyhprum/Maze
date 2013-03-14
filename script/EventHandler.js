var EventHandler = (function() {
	function EventHandler(evt) {
		this.events = {};
		if(evt && evt.events) {
			for(var i in evt.events) {
				this.events[i] = evt.events[i].slice(0);
			}
		}
	}
	
	EventHandler.prototype.invoke = function(n, args) {
		args = args instanceof Array ? args : [args];
		var r = this.events[n];
		if(!r) {
			return this;
		}
		for(var i = 0; i < r.length; i++) {
			r[i].apply(undefined, args);
		}
		return this;
	};

	EventHandler.prototype.attach = function(n, e) {
		(this.events[n] = (this.events[n] || [])).push(e);
		return this;
	};

	EventHandler.prototype.detach = function(n, e) {
		var r = this.events[n];
		if(!r) {
			return this;
		}
		for(var i = 0; i < r.length; i++) {
			if(r[i] === e) {
				r.splice(i, 1);
				break;
			}
		}
		return this;
	};
	
	return EventHandler;
}());