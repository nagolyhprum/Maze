$(function() {
	Sound.root = "audio/";
	Sound.music("music/dungeon");

	canvas = $("#screen")[0];
	canvas.events = new EventHandler();
	context = canvas.getContext("2d");
	attachEvent(canvas, "click", function(e) {
		var bb = canvas.getBoundingClientRect();
		canvas.events.invoke("click", [{ 
			x : (e.pageX - bb.left) * (canvas.width / canvas.clientWidth), 
			y : (e.pageY - bb.top) * (canvas.height / canvas.clientHeight)
		}]);
	});
	
	canvas.events.attach("click", function(location) {
		Blood({
			location : location
		});
	});
	
	var down = [];
	attachEvent(canvas, "keydown", function(e) {
		if(!down[e.which]) {
			canvas.events.invoke("keydown", e.which);
			down[e.which] = 1;
		}
		e.preventDefault();
	});
	attachEvent(canvas, "keyup", function(e) {
		canvas.events.invoke("keyup", e.which);
		down[e.which] = 0;
		e.preventDefault();
	});
	
	function frame() {
		tick();
		requestAnimFrame(frame);
		if(background && background.complete) {
			context.drawImage(background, 0, 0, canvas.width, canvas.height);
		}
		canvas.events.invoke("draw");
	}
		
	var tick = (function() {
		window.setTimeout = function(f, t) {
			var id = index++;
			r[id] = {
				f : f,
				t : t,
				r : t
			};
			return id;
		};		
		window.setInterval = function(f, t) {
			var id = index++;
			r[id] = {
				f : f,
				t : t,
				r : t,
				i : true
			};
			return id;
		};		
		window.setCatchup = function(f, t) {
			var id = index++;
			r[id] = {
				f : f,
				t : t,
				r : t,
				i : true,
				c : true
			};
			return id;
		};		
		window.clearTimeout = function(id) {
			delete r[id];
		};
		window.clearInterval = function(id) {
			delete r[id];
		};
		var time = new Date().getTime(), r = {}, index = 0;		
		return function() {
			var now = new Date().getTime(), passed = now - time;
			time = now;
			for(var i in r) {
				if(r.hasOwnProperty(i)) {
					if((r[i].r -= passed) <= 0) {						
						var f = r[i].f;
						if(r[i].i) {
							if(r[i].c) {
								while(r[i] && (r[i].r < 0)) {
									r[i].r += r[i].t;
									f && f();
								}
							} else {
								r[i].r = r[i].t;
								f && f();
							}
						} else {
							f && f();
							delete r[i];
						}
					}
				}
			}
		};		
	}());
	
	frame();
});