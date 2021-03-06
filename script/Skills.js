$(function() {
	skills.visible = 0;
	var background, location = {x:0,y:0}, click, active = skills[0];
	loadImage("window/texture.png", function(img) {
		background = context.createPattern(img, "repeat");
	});
	canvas.events.attach("keydown", function(keycode) {
		var key = parseInt(String.fromCharCode(keycode), 10);
		if(!skills.visible) {
			performSkill(key);
		}
		if(skills.visible && active && !isNaN(key) && active.isCool) {
			Server.setSkillIndex(active.id, key, function() {
				for(var i in skillMapping) {
					var s = skillMapping[i];
					if(s && s.id === active.id) {
						delete skillMapping[i];
						break;
					}
				}
				skillMapping[(key + 9) % 10] = active;
			});
		} else if(keycode === 82) { //r
			skills.visible = !skills.visible;
		} else {
			skills.visible = 0;
		}
	});	
	
	function performSkill(key) {
		var skill = skillMapping[(key + 9) % 10], i;
		if(skill && skill.type === "active" && !character.tween.isTweening()) {
			if(skill.isCool) {
				if((equipment_items.mainhand.item && equipment_items.mainhand.item.attack === skill.action) || skill.action === null) {
					if(character.statistics.getCurrent("energy") >= skill.energy) {
						Server.sendDamage((key + 9) % 10, function() {
							addBehavior("Skill", skill.name);
							character.statistics.energy.current -= skill.energy;
							character.attack(skill.action || "spellcast");
							for(i = 0; i < skill.add.length; i++) {
								character.statistics.add(skill.add[i], true);
							}
							for(i = 0; i < skill.multiply.length; i++) {
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
							for(i = 0; i < skill.add.length; i++) {
								remove(skill.add[i]);
							}
							for(i = 0; i < skill.multiply.length; i++) {
								remove(multiply.add[i]);
							}
						});
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
	
	lock("skills", function() {
		Server.getSkillMapping(function(sm) {
			skillMapping = sm;
		});
	});
	
	canvas.events.attach("mousemove", function(l) {
		location = l;
	});

	canvas.events.attach("click", function(l) {
		click = l;
	});
	
	var cellwidth = CONSTANTS.TILE.WIDTH, 
		cellheight = CONSTANTS.TILE.HEIGHT, 
		rows = 4, 
		columns = 6, 
		width = (cellwidth + canvas.padding * 2) * columns, 
		height = canvas.padding * 2 + canvas.padding * 2 + canvas.fontSize() + (cellheight + canvas.padding * 2) * rows,
		start = {x : canvas.width / 2 - width / 2, y : canvas.height / 2 - height / 2};
		inventory_items.visible = 0;
	canvas.events.attach("draw", function() {
		canvas.drawWith(12);
		context.fillStyle = "gray";
		if(background) {
			context.fillStyle = background;
		}				
		var index = 0, toDraw, i, x, y, j, skill;
		if(skills.visible) {			
			context.save();					
			context.translate(start.x, start.y);
			context.globalAlpha = 0.8;			
			context.strokeStyle = "black";
			context.fillRect(0, 0, width, height); //container
			context.strokeRect(0, 0, width, height); //container
			context.strokeRect(canvas.padding, canvas.padding, width - canvas.padding * 2, canvas.padding * 2 + canvas.fontSize()); //title		
			for(i = 0; i < rows; i++) {
				for(j = 0; j < columns; j++, index++) {
					x = canvas.padding + j * (cellwidth + canvas.padding * 2);
					y = 3 * canvas.padding + canvas.padding * 2 + canvas.fontSize() + i * (cellheight + canvas.padding * 2);
					if(active && skills[index] && active === skills[index]) {	
						context.strokeStyle = "yellow";
						context.strokeRect(x, y, cellwidth, cellheight);
						context.strokeStyle = "black";
					} else {
						context.strokeRect(x, y, cellwidth, cellheight);
					}
					if(index < skills.length) {
						skill = skills[index];
						drawSkillIcon(skill, x, y);
						if(location.x >= start.x + x && location.y >= start.y + y && location.x <= start.x + x + cellwidth && location.y <= start.y + y + cellheight) {		
							toDraw = {
								x : start.x,
								y : start.y,
								skill : skill
							};
						}
						if(click && click.x >= start.x + x && click.y >= start.y + y && click.x <= start.x + x + cellwidth && click.y <= start.y + y + cellheight) {
							active = skill;
						}
					}
				}
			}					
			if(toDraw) {
				drawSkillDescription(toDraw.skill, toDraw.x, toDraw.y);
			}
			context.strokeStyle = "white";
			context.textBaseline = "middle";
			context.textAlign = "left";
			context.fillStyle = "white";
			context.fillText("Skills", canvas.padding * 2, canvas.padding * 2 + canvas.fontSize() / 2, width - canvas.padding * 2);				
			context.globalAlpha = 1;			
			context.restore();			
		}			
		context.strokeStyle = "black";			
		toDraw = 0;
		for(i = 0; i < 10; i++) {
			x = i * cellwidth + canvas.padding + i * canvas.padding;
			y = canvas.height - cellheight - canvas.padding;
			context.fillRect(x, y, cellwidth, cellheight);
			if(skillMapping[i]) {			
				drawSkillIcon(skillMapping[i], x, y);
				if(location && location.x >= x && location.y >= y && location.x <= x + cellwidth && location.y <= y + cellheight) {						
					toDraw = {
						x : 0,
						y : 0,
						skill : skillMapping[i]
					};
				}
			}
			context.strokeRect(x, y, cellwidth, cellheight);
		}
		if(toDraw) {
			drawSkillDescription(toDraw.skill, toDraw.x, toDraw.y);
		}
		click = 0;
	});
	
	function drawSkillDescription(skill, x, y) {
		var  w = 150,
			text = generateText({
				text : skill.name + "\n" + skill.description,
				color : "white",
				width : w - 2 * canvas.padding,
				font : context.font
			}), 
			h = text.height;
		context.save();
		context.globalAlpha = 0.8;
		x = Math.min(location.x - x, canvas.width - w);
		y = Math.min(location.y - y, canvas.height - h);
		context.fillRect(x, y, w, h + canvas.padding * 2);
		context.strokeRect(x, y, w, h + canvas.padding * 2);
		context.drawImage(text, x + canvas.padding, y + canvas.padding);
		context.restore();
	}
	
	function drawSkillIcon(skill, x, y) {
		context.drawImage(skill.image.icon, x, y, cellwidth, cellheight);
		skill.isCool = (skill.lastUse + skill.cooldown) <= new Date().getTime();
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