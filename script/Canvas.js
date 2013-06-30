$(function() {
	canvas = $("#screen")[0];
	canvas.events = new EventHandler();
	context = canvas.getContext("2d");
	context.font = "12px Times New Roman";
	attachEvent(canvas, "click", function(e) {
		var bb = canvas.getBoundingClientRect();
		canvas.events.invoke("click", [{ 
			x : (e.pageX - bb.left) * (canvas.width / canvas.clientWidth), 
			y : (e.pageY - bb.top) * (canvas.height / canvas.clientHeight)
		}]);
	});
	attachEvent(canvas, "mousemove", function(e) {
		var bb = canvas.getBoundingClientRect();
		canvas.events.invoke("mousemove", [{ 
			x : (e.pageX - bb.left) * (canvas.width / canvas.clientWidth), 
			y : (e.pageY - bb.top) * (canvas.height / canvas.clientHeight)
		}]);
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
		
	var tick = (function() {
		window.setTimeout = function(f, t) {
			if(t <= 0) {
				f();
			} else if(Math.abs(t) !== 1/0) {			
				var id = index;
				index++;
				r[id] = {
					f : f,
					t : t,
					r : t
				};
				return id;
			}
			return -1;
		};		
		window.setInterval = function(f, t) {
			if(Math.abs(t) !== 1/0) {			
				var id = index;
				index++;
				r[id] = {
					f : f,
					t : t,
					r : t,
					i : true
				};
				return id;
			}
			return -1;
		};		
		window.setCatchup = function(f, t) {
			if(Math.abs(t) !== 1/0) {			
				var id = index++;
				r[id] = {
					f : f,
					t : t,
					r : t,
					i : true,
					c : true
				};
				return id;
			}
			return -1;
		};		
		window.clearTimeout = function(id) {
			delete r[id];
		};
		window.clearInterval = function(id) {
			delete r[id];
		};
		var time = new Date(), r = {}, index = 0;		
		return function() {
			var now = new Date(), passed = now - time;
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
	
	context.font = "16px Sans-Serif";
	canvas.padding = 5;	
	canvas.fontSize = function() {
		return parseInt(context.font, 10);
	};
	
	function frame() {
		requestAnimFrame(frame);
		tick();
		if(background && background.complete) {
			context.drawImage(background, 0, 0, canvas.width, canvas.height);
		}
		canvas.events.invoke("draw");
	}
	
	frame();
	
	setInterval(function() {
		addBehavior("Character", "Seconds Played");
	}, 1000);
	
	function randomSound() {
		Sound.effect("sound/scream/scream" + (1 + Math.floor(Math.random() * 5)));
		setTimeout(randomSound, 5000 + 5000 * Math.random());
	}

	randomSound();
});