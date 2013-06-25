var Tween = (function() {
	function Tween() {
		this.queue = [];
		this.locked = 0;
	}

	Tween.prototype.push = function(tween) {
		this.queue.push(tween);
		return this.process();
	};

	Tween.prototype.clear = function() {
		for(var i = 0; i < this.queue.length; i++) {
			this.queue[i].isCleared = true;
		}
		return this;
	};

	Tween.prototype.process = function() {
		var me = this;
		if(!me.locked && me.queue.length) {
			me.locked = 1;
			var current = me.queue[0],
				interval = setCatchup(function() {
				if(current.isCleared || current.change() === false) {
					if(interval) {
						clearInterval(interval);
					}
					me.queue.shift();
					if(current.complete) {
						current.complete();
					}
					me.locked = 0;
					me.process();
				}
			}, current.isCleared ? 0 : current.interval);
			current.init && current.init();
		}
		return me;
	};

	Tween.prototype.isTweening = function() {
		return this.locked;
	};

	return Tween;
}());