$(function() {
	skills.visible = 0;
	var background, location = {x:0,y:0}, click, active = skills[0];
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		var key = parseInt(String.fromCharCode(keycode));
		if(!skills.visible) {
			performSkill(key);
		}
		if(skills.visible && active && !isNaN(key) && active.type === "active") {
			skillMapping[(key + 9) % 10] = active;
		} else if(keycode === 82) { //r
			skills.visible = !skills.visible;
		} else {
			skills.visible = 0;
		}
	});	
	
	function performSkill(key) {
		var skill = skillMapping[(key + 9) % 10];
		if(skill && !character.tween.isTweening()) {
			if(skill.isCool) {
				if(equipment_items.mainhand.item && equipment_items.mainhand.item.attack === skill.action) {
					if(character.statistics.getCurrent("energy") >= skill.energy) {
						character.statistics.energy.current -= skill.energy;
						character.attack();
						for(var i = 0; i < skill.add.length; i++) {
							character.statistics.add(skill.add[i]);
						}
						for(var i = 0; i < skill.multiply.length; i++) {
							character.statistics.multiply(skill.multiply[i]);
						}
						if(skill.area > 0) { //then it is a linear skill
							sendDamage(character.getDirection(), skill);
						} else if(skill.area < 0) { //then it is a circular skill							
							sendDamage({column : 1, row : 0}, skill);
							sendDamage({column : -1, row : 0}, skill);
							sendDamage({column : 0, row : 1}, skill);
							sendDamage({column : 0, row : -1}, skill);
						}  //otherwise this is a self skill
						skill.lastUse = new Date().getTime();
						skill.isCool = false;
						setTimeout(function() {
							skill.isCool = true;
						}, skill.cooldown);					
						for(var i = 0; i < skill.add.length; i++) {
							remove(skill.add[i]);
						}
						for(var i = 0; i < skill.multiply.length; i++) {
							remove(multiply.add[i]);
						}
					} else {
						alert("Not enough energy.");
					}
				} else {
					alert("That weapon cannot be used for this skill.");
				}
			} else {
				alert("That skill is still cooling off.");
			}
		}
	}	
	
	function remove(s) {
		setTimeout(function() {
			character.statistics.remove(s);			
		}, s.duration);
	}

	var skillMapping = [];	
	
	canvas.events.attach("mousemove", function(l) {
		location = l;
	});

	canvas.events.attach("click", function(l) {
		click = l;
	});
	
	var margin = 5,
		cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		background,
		titlesize = 24,
		width = (cellwidth + margin * 2) * columns, 
		height = margin * 2 + titlesize + (cellheight + margin * 2) * rows;
		inventory_items.visible = 0,
		start = {x : canvas.width / 2 - width / 2, y : canvas.height / 2 - height / 2};
	canvas.events.attach("draw", function() {
		context.fillStyle = "gray";
		if(background) {
			context.fillStyle = background;
		}
		if(skills.visible) {			
			context.save();					
			context.translate(start.x, start.y);
			context.globalAlpha = 0.8;			
			context.strokeStyle = "black";
			context.fillRect(0, 0, width, height); //container
			context.strokeRect(0, 0, width, height); //container
			context.strokeRect(margin, margin, width - margin * 2, titlesize); //title						
			var index = 0;
			for(var i = 0; i < rows; i++) {
				for(var j = 0; j < columns; j++, index++) {
					var x = margin + j * (cellwidth + margin * 2), y = 3 * margin + titlesize + i * (cellheight + margin * 2);
					if(active && skills[index] && active === skills[index]) {	
						context.strokeStyle = "yellow";
						context.strokeRect(x, y, cellwidth, cellheight);
						context.strokeStyle = "black";
					} else {
						context.strokeRect(x, y, cellwidth, cellheight);
					}
					if(index < skills.length) {
						var skill = skills[index];
						drawSkillIcon(skill, x, y);
						if(location.x >= start.x + x && location.y >= start.y + y && location.x <= start.x + x + cellwidth && location.y <= start.y + y + cellheight) {		
							drawSkillDescription(skill, start.x, start.y);
						}
						if(click && click.x >= start.x + x && click.y >= start.y + y && click.x <= start.x + x + cellwidth && click.y <= start.y + y + cellheight) {
							active = skill;
						}
					}
				}
			}					
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.textAlign = "left";
			context.strokeText("Skills", margin * 2, margin + titlesize / 2, width - margin * 2);				
			context.globalAlpha = 1;			
			context.restore();			
		}			
		context.strokeStyle = "black";
		for(var i = 0; i < 10; i++) {
			var x = i * cellwidth + margin + i * margin, y = canvas.height - cellheight - margin;
			context.fillRect(x, y, cellwidth, cellheight);
			if(skillMapping[i]) {			
				drawSkillIcon(skillMapping[i], x, y);
			}
			context.strokeRect(x, y, cellwidth, cellheight);
		}
		for(var i = 0; i < 10; i++) {
			var x = i * cellwidth + margin + i * margin, y = canvas.height - cellheight - margin;
			if(skillMapping[i]) {						
				if(location && location.x >= x && location.y >= y && location.x <= x + cellwidth && location.y <= y + cellheight) {						
					drawSkillDescription(skillMapping[i], 0, 0);
				}
			}
		}
		click = 0;
	});
	
	function drawSkillDescription(skill, x, y) {
		var  w = 100,
			text = generateText({
				text : skill.description,
				color : "white",
				width : 100
			}), 
			h = text.height;
		x = Math.min(location.x - x, canvas.width - w);
		y = Math.min(location.y - y, canvas.height - h);
		context.fillRect(x, y, w, h);
		context.strokeRect(x, y, w, h);
		context.drawImage(text, x + margin, y);
	}
	
	function drawSkillIcon(skill, x, y) {
		context.drawImage(skill.image.icon, x, y, cellwidth, cellheight);
		if(!skill.isCool) {
			context.save();
			context.beginPath();
			context.rect(x, y, cellwidth, cellheight);
			context.clip();
			context.closePath();
			var w = cellwidth / 2,
				h = cellheight / 2, 
				now = new Date().getTime(), 
				r = Math.sqrt(w * w + h * h),
				p = (now - skill.lastUse) / skill.cooldown;
			context.beginPath();
			context.moveTo(x + w, y + h);
			context.lineTo(x + w, y);			
			context.arc(x + w, y + h, r, -Math.PI / 2, -Math.PI / 2 + 2 * Math.PI * p, true);			
			context.globalAlpha = 0.8;
			context.fill();
			context.closePath();
			context.restore();
		}
		context.strokeRect(x, y, cellwidth, cellheight);
	}
});