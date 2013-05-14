function sendDamage(direction, skill) {
	var pos = {column : character.location.column + direction.column, row : character.location.row + direction.row},
		area = Math.abs(skill.area),
		style = skill.attack || skill.action;	
	while(pos.column >= 0 && pos.row >= 0 && pos.column < CONSTANTS.TILE.COLUMNS && pos.row < CONSTANTS.TILE.ROWS && area > 0) {
		for(var i = 0; i < enemies.length; i++) {
			var e = enemies[i];
			if(e.statistics.getCurrent("health") > 0 && e.location.column === pos.column && e.location.row === pos.row) {
				Server.attack(enemies, i, style !== "spellcast");
				return;
			}
		}
		pos.column += direction.column;
		pos.row += direction.row;
		area--;
	}
}

String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

function getDrawingOrder(type) {
	return {
		legs : 10,
		feet : 11,
		chest : 12,
		hands : 13,
		head : 14,
		mainhand : 15,
		offhand : 16
	}[type];
}

function unequip(type, index) {
	var equipped = equipment_items[type].item;
	if(index !== -1) {
		if(equipped !== undefined) {
			var sn = Statistics.getStatisticNames();
			for(var i = 0; i < sn.length; i++) {
				var name = sn[i];
				character.statistics[name].current -= equipped.statistics[name].current;
				character.statistics[name].max -= equipped.statistics[name].max;
			}
			var o = getDrawingOrder(type);
			
			character.slash[o] = undefined;
			character.walk[o] = undefined;
			character.bow[o] = undefined;
			character.spellcast[o] = undefined;
			character.thrust[o] = undefined;
			character.hurt[o] = undefined;
		
			inventory_items[index] = equipped;	
			Sound.effect(equipped.sounds.move);			
			equipment_items[type].item = undefined;
		}
	} else {
		alert("You have no room in your inventory for this item.");
	}
}

function equip(c, type) {	
	var sn = Statistics.getStatisticNames();
	for(var i = 0; i < sn.length; i++) {
		var name = sn[i];
		character.statistics[name].current += c.statistics[name].current;
		character.statistics[name].max += c.statistics[name].max;
	}
	
	var o = getDrawingOrder((c.weight === 1 && c.type === "mainhand") ? "offhand" : c.type);
	c.slash && (character.slash[o] = c.slash);
	c.walk && (character.walk[o] = c.walk);
	c.bow && (character.bow[o] = c.bow);
	c.spellcast && (character.spellcast[o] = c.spellcast);
	c.thrust && (character.thrust[o] = c.thrust);
	c.hurt && (character.hurt[o] = c.hurt);
	
	inventory_items[inventory_items.indexOf(c)] = undefined;
	equipment_items[type].item = c;	
	Sound.effect(c.sounds.move);
}

function attachEvent(ele, name, evt) {
	if(ele.addEventListener) {
		ele.addEventListener(name, evt, false);
	} else if(ele.attachEvent) {
		ele.attachEvent("on" + name, evt);
	} else {
		ele["on" + name] = evt;
	}
}

function detachEvent(element, eventName, handler) {
	if (element.addEventListener) {
		element.removeEventListener(eventName, handler, false);
	} else if (element.detachEvent) {
		element.detachEvent('on' + eventName, handler);
	} else {
		element['on' + eventName] = null;
	}
}

function clamp(input, min, max) {
	return Math.min(Math.max(input, min), max);
}

var Sound = (function() {	
	var a = new Audio(), supported = [], cache = {}, S = {};
	if(a.canPlayType) {
		if(a.canPlayType('audio/mpeg;').replace("no", "")) {
			supported.push(".mp3");
		}
		if(a.canPlayType('audio/wav;').replace("no", "")) {
			supported.push(".wav");
		}
		if(a.canPlayType('audio/ogg;').replace("no", "")) {
			supported.push(".ogg");
		}
	}
	
	S.effect = function (src, complete) {
		var c = cache[src];
		if(!c) {
			c = cache[src] = [];
		}
		var a, index = 0;		
		for(var i = 0; i < c.length && !a; i++) {
			if(c[i].paused && c[i].canplay) {
				a = c[i];
			}
		}
		if(!a) {
			a = new Audio();
			a.autoplay = true;
			c.push(a);
			attachEvent(a, "canplaythrough", function() {
				this.canplay = true;	
			});			
			a.src = S.root + src + supported[index];
			index = index + 1;
			attachEvent(a, "error", function() {
				if(index < supported.length) {
					a.src = S.root + src + supported[index];
					index = index + 1;
				}
			});		
		} else {
			a.play();
		}
		var f = function() { complete && complete(); detachEvent(this, "ended", f); };
		attachEvent(a, "ended", f);
		return function() {
			a.autoplay = false;
			a.pause();						
		};
	};
	
	S.music = function(src) {
		var stopper, f = function() {
			stopper = Sound.effect(src, f);
		};
		f();
		return function() {
			stopper();
		};
	};
	
	S.root = "./";
	
	return S;
}());

Sound.root = "audio/";
Sound.music("music/dungeon");

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

function TileSet(args) {
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
}

TileSet.prototype.draw = function(context, x, y, w, h) {
	context.drawImage(this.image,
		this.display.column * this.width,
		this.display.row * this.height,
		this.width,
		this.height,
		x, y, w, h);
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
				return true;
			} else {
				onload.attach("load", f);
				return false;
			}
		} else if(to === "string") {
			return document.querySelectorAll(f);
		} else {
			return false;
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

function getSign(x) {
	return x ? x / Math.abs(x) : 0;
}
	
var Statistics = (function() {
	var stats = ["health", "energy", "experience", "strength", "defense", "intelligence", "resistance", "speed"];
	var f = function(args) {
		args = args || {};
		for(var i = 0; i < stats.length; i++) {
			var stat = stats[i];
			args[stat] = args[stat] || {};
			this[stat] = {
				max : args[stat].max || 0,
				current : args[stat].current || 0
			};
		}
		this.duration = args.duration;
		this._add = [];
		this._multiply = [];
	};
	
	f.getStatisticNames = function() {
		return stats;
	};
	
	f.prototype.remove = function(s) {
		var i = this._add.indexOf(s);
		if(i !== -1) {
			this._add.splice(i, 1);
		}
		i = this._multiply.indexOf(s);
		if(i !== -1) {
			this._multiply.splice(i, 1);
		}
	};
		
	f.prototype.getMax = function(name) {
		var stat = this[name].max, i = 0;
		for(; i < this._add.length; i++) {
			stat += this._add[i][name].max;
		}
		for(i = 0; i < this._multiply.length; i++) {
			stat += stat * this._multiply[i][name].max;
		}
		return stat;
	};

	f.prototype.getCurrent = function(name) {
		var stat = this[name].current, i = 0;
		for(; i < this._add.length; i++) {
			stat += this._add[i][name].current;
		}
		for(i = 0; i < this._multiply.length; i++) {
			stat += stat * this._multiply[i][name].current;
		}
		return stat;
	};

	f.prototype.add = function(s, perm) {
		if(perm && s.duration === 1/0) {
			for(var i = 0; i < stats.length; i++) {
				this[stats[i]].current = Math.min(s[stats[i]].current + this[stats[i]].current, this[stats[i]].max);
			}
		} else {
			this._add.push(s);
		}
	};

	f.prototype.multiply = function(s) {
		this._multiply.push(s);
	};
	return f;
}());

function Character(args) {
	this.tween = new Tween();
	args = args || {};
	this.events = new EventHandler();
	this.attackstyle = args.attackstyle || "slash";
	this.walk = args.walk || [];
	this.bow = args.bow || [];
	this.spellcast = args.spellcast || [];
	this.thrust = args.thrust || [];
	this.slash = args.slash || [];
	this.hurt = args.hurt || [];
	this.active = this.walk;
	this.id = args.id;
	this.name = args.name;
	this.portrait = loadImage(args.portrait);
	args.location = args.location || {};
	this.level = args.level || 1;
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
	
	//SOUND
	
	args.sounds = args.sounds || {};	
	this.sounds = {
		slash : args.sounds.slash || [],
		hurt : args.sounds.hurt || []
	};
}

Character.prototype.draw = function(ctx) {
	for(var i = 0; i < this.active.length; i++) {
		var tile = this.active[i];		
		if(tile && tile.complete) {
			ctx.drawImage(
				tile.image,
				this.display.column * tile.width,
				this.display.row * tile.height,
				tile.width,
				tile.height,
				CONSTANTS.START.X() + this.location.column * CONSTANTS.TILE.WIDTH + this.location.x,
				CONSTANTS.START.Y() + this.location.row * CONSTANTS.TILE.HEIGHT + this.location.y,
				CONSTANTS.TILE.WIDTH,
				CONSTANTS.TILE.HEIGHT);
		}
	}		
};

var SPEED = 150, SLEEP = 500;

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

var WALK = [
	"sound/walk/stepstone_1",
	"sound/walk/stepstone_2",
	"sound/walk/stepstone_3",
	"sound/walk/stepstone_4",
	"sound/walk/stepstone_5",
	"sound/walk/stepstone_6",
	"sound/walk/stepstone_7",
	"sound/walk/stepstone_8"
];

Character.prototype.moveBy = function(horizontal, vertical, complete) {
	var me = this;
	Sound.effect(WALK[Math.floor(WALK.length * Math.random())]);
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

Character.prototype.attack = function(complete) {
	var me = this, column = -1;
	Sound.effect(this.sounds.slash[Math.floor(this.sounds.slash.length * Math.random())]);
	this.tween.push({
		init : function() {
			me.display.column = 0;
			me.active = me[(me === character && equipment_items.mainhand.item) ? equipment_items.mainhand.item.attack : me.attackstyle];
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

var BLOOD = [
	"sound/blood/blood1",
	"sound/blood/blood2",
	"sound/blood/blood3",
	"sound/blood/blood4"
];

Character.prototype.damage = function(damage, killed, complete) {
	if(damage > 0) {
		var s = this.statistics;
		if(s.getCurrent("health") > 0) {
			Sound.effect(BLOOD[Math.floor(BLOOD.length * Math.random())]);
			new Blood({
				location : {
					x : CONSTANTS.START.X() + this.location.column * CONSTANTS.TILE.WIDTH + CONSTANTS.TILE.WIDTH / 2,
					y : CONSTANTS.START.Y() + this.location.row * CONSTANTS.TILE.WIDTH + CONSTANTS.TILE.HEIGHT / 2
				}
			});
			Sound.effect(this.sounds.hurt[Math.floor(this.sounds.hurt.length * Math.random())]);
			s.health.current -= damage;
			if(s.getCurrent("health") <= 0) {
				var me = this;
				killed && killed.call(this);
				this.die(complete);
			}
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
			me.display.column = me.display.column + 1;
			return me.display.column !== me.active[0].columns;
		},
		interval : 100,
		complete : function() {
			complete && complete.call(me);
		}
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
	args.location = args.location || {};
	
	args.walk && (this.walk = new TileSet(args.walk));
	args.spellcast && (this.spellcast = new TileSet(args.spellcast));
	args.bow && (this.bow = new TileSet(args.bow));
	args.slash && (this.slash = new TileSet(args.slash));
	args.thrust && (this.thrust = new TileSet(args.thrust));
	this.area = args.area || 1;
	this.attack = args.attack || "slash";
	this.location = {
		row : args.location.row || 0,
		column : args.location.column || 0,
		x : args.location.x || 0,
		y : args.location.y || 0
	};
	this.weight = args.weight || 0;
	this.type = args.type;
	this.portrait = loadImage(args.portrait);
	this.statistics = new Statistics(args.statistics);
	this.id = args.id;
	this.name = args.name;
	args.sounds = args.sounds || {};
	this.sounds = {
		move : args.sounds.move || []
	};
}

function generateText(obj) {
    var canvas = document.createElement("canvas"),
        context = canvas.getContext("2d"),
        processing = 0,
        maxWidth = 0;
    text = obj.text.split("\n");
    while (processing < text.length) {
        var toTake = context.measureText(text[processing]).width,
            pushed = 0;
        while (toTake > obj.width) {
            var current = text[processing],
                io = current.lastIndexOf(" ");
            if (io === -1) break;
            var next = current.substring(io + 1),
                revised = current.substring(0, io);
            text[processing] = revised;
            if (pushed > 0) {
                text[processing + 1] = next + " " + text[processing + 1];
            } else {
                text.splice(processing + 1, 0, next);
            }
            pushed++;
			toTake = context.measureText(revised).width;
        }
        processing++;       
        if (toTake > maxWidth) {
            maxWidth = toTake;
        }
    }
    var font = obj.font || context.font;
    var size = parseInt(font, 10);
    canvas.width = maxWidth;
    canvas.height = text.length * size + (size / 3);
    context.font = font;
    context.fillStyle = obj.color || "black";
    context.textBaseline = "top";
    context.textAlign = "left";
    for (var i = 0; i < text.length; i++) {
        context.fillText(text[i], 0, i * size, obj.width);
    }
    return canvas;
}

Character.prototype.getDirection = function() {	
	var direction = {column : 0, row : 0}, d = this.display.row;
	if(d === CONSTANTS.DIRECTION.UP) {
		direction.row--;
	} else if(d === CONSTANTS.DIRECTION.RIGHT) {
		direction.column++;
	} else if(d === CONSTANTS.DIRECTION.DOWN) {
		direction.row++;
	} else if(d === CONSTANTS.DIRECTION.LEFT) {
		direction.column--;
	}
	return direction;
};