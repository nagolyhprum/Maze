var attachEvent = (function() {
	return function(ele, name, evt) {
		if(ele.addEventListener) {
			ele.addEventListener(name, evt, false);
		} else if(ele.attachEvent) {
			ele.attachEvent("on" + name, evt);
		} else {
			ele["on" + name] = evt;
		}
	};
}());

var loadImage = (function() {
	var images = {}, events = {};
	return function(src, complete) {
		src = loadImage.root + src;
		var image = images[src], event = events[src];
		if(!image) {
			image = images[src] = new Image();
			image.src = src;
		}
		if(complete) {
			if(image.complete) {
				complete(image);
			} else if(event) {
				event.attach("load", complete);
			} else {
				event = events[src] = new EventHandler();
				event.attach("load", complete);
				attachEvent(image, "load", function() {
					events[src].invoke("load", [image]);
				});
			}
		}
		return image;
	};
}());

loadImage.root = "images/";

var TileSet = function(args) {
	var me = this;
	args = args || {};
	me.rows = args.rows || 1;
	me.columns = args.columns || 1;
	args.location = args.location || {};
	me.location = { 
		row : args.location.row || 0, 
		column : args.location.column || 0, 
		x : args.location.x || 0, 
		y : args.location.y || 0 
	};
	args.display = args.display || {};
	me.display = { 
		row : args.display.row || 0, 
		column : args.display.column || 0 
	};
	me.src = args.src;
	this.image = loadImage(args.src, function(image) {
		me.width = image.width / me.columns;
		me.height = image.height / me.rows;
		me.complete = 1;
	});
};

TileSet.prototype.draw = function(context, x, y, w, h) {
	context.drawImage(this.image,
		this.display.column * this.width,
		this.display.row * this.height,
		this.width,
		this.height,
		x, y, w, h
	);
};

var $ = (function() {
	var onload = new EventHandler();
	
	function hasLoaded() {
		return document.body && document.body.readyState === "complete";
	}
	
	function $(f) {
		var to = typeof f;
		if(to === "function") {
			if(hasLoaded()) {
				f();
			} else {
				onload.attach("load", f);
			}
		} else if(to === "string") {
			return document.querySelectorAll(f);
		}
	}
	
	if(hasLoaded()) {
		onload.invoke("load");
	} else {
		attachEvent(window, "load", function() {
			onload.invoke("load");
		});
	}
	return $;
}());

var requestAnimFrame = (function(){
	return  window.requestAnimationFrame || 
		window.webkitRequestAnimationFrame || 
		window.mozRequestAnimationFrame || 
		window.oRequestAnimationFrame || 
		window.msRequestAnimationFrame || 
		function(callback){
			window.setTimeout(callback, 1000 / 60);
		};
}());

var getSign = (function() {
	return function(x) {
		return x ? x / Math.abs(x) : 0;
	};
}());

function Statistics(args) {

	args = args || {};
	args.health = args.health || {};
	args.energy = args.energy || {};
	args.experience = args.experience || {};	
	args.speed = args.speed || {};
	this.health = {
		max : args.health.max || 0,
		current : args.health.current || 0
	};
	this.energy = {
		max : args.energy.max || 0,
		current : args.energy.current || 0
	};
	this.experience = {
		max : args.experience.max || 0,
		current : args.experience.current || 0
	};
	this.speed = {
		max : args.speed.max || 1,
		current : args.speed.current || 1
	};
}

function Character(args) {
	this.tween = new Tween();
	args = args || {};
	this.events = new EventHandler();
	this.walk = args.walk || [];
	this.attack = args.attack || [];
	this.hurt = args.hurt || [];
	this.active = this.walk;
	this.id = args.id;
	args.location = args.location || {};
	this.location = {
		column : args.location.column || 0,
		row : args.location.row || 0,
		x : args.location.x || 0,
		y : args.location.y || 0
	};
	args.display = args.display || {};
	this.display = {
		row : args.display.row || 0,
		column : args.display.column || 0
	};
	this.statistics = new Statistics(args.statistics);
};

Character.prototype.draw = function(ctx) {
	for(var i = 0; i < this.active.length; i++) {
		var tile = this.active[i];
		if(tile.complete) {
			ctx.drawImage(
				tile.image,
				this.display.column * tile.width,
				this.display.row * tile.height,
				tile.width,
				tile.height,
				CONSTANTS.START.X() + this.location.column * CONSTANTS.TILE.WIDTH + this.location.x,
				CONSTANTS.START.Y() + this.location.row * CONSTANTS.TILE.HEIGHT + this.location.y,
				CONSTANTS.TILE.WIDTH,
				CONSTANTS.TILE.HEIGHT
			);
		}
	}		
};

var SPEED = 100, SLEEP = 500;

Character.prototype.timeToMove = function() {
	return Math.ceil(SPEED / this.statistics.speed.current * CONSTANTS.TILE.WIDTH) + SLEEP;
};

Character.prototype.moves = function() {
	var time = new Date().getTime(), timeToMove = this.timeToMove(), moves;
	this.elapsedTime += time - this.lastTime;
	this.lastTime = time;
	moves = Math.floor(this.elapsedTime / timeToMove);
	this.elapsedTime = this.elapsedTime % timeToMove;
	return moves;
};

Character.prototype.moveBy = function(horizontal, vertical, complete) {
	var me = this;
	this.tween.push({
		init : function() {
			me.location.x = -horizontal;
			me.location.y = -vertical;
		},
		change : function() {
			me.location.x += getSign(horizontal);
			me.location.y += getSign(vertical);
			me.display.column = Math.max((me.display.column + 1) % me.active[0].columns, 1);
			return Math.abs(me.location.x) + Math.abs(me.location.y) !== 0;
		},
		interval : SPEED / this.statistics.speed.current,
		complete : function() {
			me.display.column = me.location.x = me.location.y = 0;
			setTimeout(complete, SLEEP);
		}
	});
};

Character.prototype.slash = function(complete) {
	var me = this, column = -1;
	this.tween.push({
		init : function() {
			me.display.column = 0;
			me.active = me.attack;
		},
		change : function() {
			column++;
			me.display.column = Math.floor(column / CONSTANTS.TILE.WIDTH * me.active[0].columns);
			return column !== CONSTANTS.TILE.WIDTH;
		},
		interval : SPEED / this.statistics.speed.current,
		complete : function() {
			me.active = me.walk;
			me.display.column = 0;
			setTimeout(complete, SLEEP);
		}
	});
};

Character.prototype.face = function(column, row) {
	if(Math.abs(this.location.column - column) > Math.abs(this.location.row - row)) {
		if(this.location.column > column) {
			this.display.row = CONSTANTS.DIRECTION.LEFT;
		} else if(this.location.column < column) {
			this.display.row = CONSTANTS.DIRECTION.RIGHT;
		}
	} else {
		if(this.location.row > row) {
			this.display.row = CONSTANTS.DIRECTION.UP;
		} else if(this.location.row < row) {
			this.display.row = CONSTANTS.DIRECTION.DOWN;
		}
	}
};

Character.prototype.die = function(complete) {
	var me = this;
	this.tween.push({
		init : function () {
			me.active = me.hurt;
			me.display = { row : 0, column : 0 };
		},
		change : function() {
			return ++me.display.column !== me.active[0].columns;
		},
		interval : 100,
		complete : complete
	});
};

Character.prototype.wait = function(complete) {
	this.tween.push({
		change : function() {
			return false;
		},
		interval : 10,
		complete : complete
	});
};

function Item(args) {
	args = args || {};
	this.x = args.x || 0;
	this.y = args.y || 0;
	this.image = new TileSet(args.image);
	this.statistics = new Statistics(args.statistics);
}

Item.prototype.draw = function(context) {
	this.image.draw(context, this.x, this.y, CONSTANTS.TILE.WIDTH, CONSTANTS.TILE.HEIGHT);
};