var MazeGenerator = (function() {
	function table(columns, rows, value) {
		var t = [], size = rows * columns;
		for(var i = 0; i < size; i++) {
			t[(i % columns) + Math.floor(i / columns) * rows] = value;
		}
		return t;
	}

	function MazeGenerator(columns, rows) {
		this.columns = columns;
		this.rows = rows;
	}

	MazeGenerator.prototype.hasVisited = function(visited, column, row) {
		return visited[column + row * visited.columns];
	};

	MazeGenerator.prototype.visit = function(visited, column, row) {
		visited[column + row * visited.columns] = 1;
		return this;
	};

	MazeGenerator.prototype.generateMaze = function() {
		var visited = [];
		visited.columns = this.columns;
		var walls = table(this.columns, this.rows, MazeGenerator.walls.all);
		walls.columns = this.columns;
		walls.rows = this.rows;
		var toVisit = [this.generateCell(Math.floor(Math.random() * this.columns), Math.floor(Math.random() * this.rows))];
		this.visit(visited, toVisit[0].column, toVisit[0].row);
		while(toVisit.length) {
			var tv = toVisit[toVisit.length - 1], 
				direction = tv.directions.splice(Math.floor(Math.random() * tv.directions.length), 1)[0];					
			if(direction) {
				if(!this.hasVisited(visited, direction.column, direction.row)) {							
					toVisit.push(this.generateCell(direction.column, direction.row));
					this.visit(visited, direction.column, direction.row);
					walls[tv.column + tv.row * this.columns] ^= direction.remove.current;
					walls[direction.column + direction.row * this.columns] ^= direction.remove.other;
				}
			} else {
				toVisit.pop();
			}
		}
		return walls;
	};

	MazeGenerator.prototype.generateCell = function(column, row, walls) {
		var directions = [], 
			walls = walls || [], 
			columns = walls.columns || this.columns, 
			rows = walls.rows || this.rows;
		if(row > 0 && 
			!(walls && (walls[column + row * columns] & MazeGenerator.walls.top))) { //up
			directions.push({
				column : column,
				row : row - 1,
				remove : {
					current : MazeGenerator.walls.top,
					other : MazeGenerator.walls.bottom
				}						
			});
		}
		if(column + 1 < columns && 
			!(walls && (walls[column + row * columns] & MazeGenerator.walls.right))) { //right
			directions.push({
				column : column + 1,
				row : row,
				remove : {
					current : MazeGenerator.walls.right,
					other : MazeGenerator.walls.left
				}
			});
		}
		if(row + 1 < rows && 
			!(walls && (walls[column + row * columns] & MazeGenerator.walls.bottom))) { //down
			directions.push({
				column : column,
				row : row + 1,
				remove : {
					current : MazeGenerator.walls.bottom,
					other : MazeGenerator.walls.top
				}
			});
		}
		if(column > 0 && 
			!(walls && (walls[column + row * columns] & MazeGenerator.walls.left))) { //left
			directions.push({
				column : column - 1,
				row : row,
				remove : {
					current : MazeGenerator.walls.left,
					other : MazeGenerator.walls.right
				}
			});
		}
		return {
			column : column,
			row : row,
			directions : directions,
			weight : 1,
			compareTo : function(other) {
				return this.weight - other.weight;
			}
		};
	};

	MazeGenerator.prototype.generateDomElement = function(walls, cellsize, id) {
		var dom = "<div id='" + id + "' class='maze' style='border:1px solid black;float:left;width:" + (walls.columns * cellsize + walls.columns * 2) + "px;height:" + (walls.rows * cellsize + walls.rows * 2) + "px;'>";
		for(var i = 0; i < walls.length; i++) {
			if(i % walls.columns === 0) {
				dom += "<div style='clear:both;'></div>";
			}
			var style = "";
			for(var j in MazeGenerator.walls) {
				if(j !== "all") {
					if(walls[i] & MazeGenerator.walls[j]) {
						style += "border-" + j + ":1px solid black;";
					} else {						
						style += "padding-" + j + ":1px;";
					}
				}
			}
			dom += "<div class='cell' style='width:" + cellsize + "px;height:" + cellsize + "px;float:left;" + style + "'></div>";
		}
		return dom + "</div>";
	};

	MazeGenerator.walls = {
		top : 1,
		right : 2,
		bottom : 4,
		left : 8,
		all : 15
	};

	MazeGenerator.prototype.getPath = function(walls, fromColumn, fromRow, toColumn, toRow) {
		var visited = [];
		visited.columns = walls.columns;
		var toVisit = new PriorityQueue();
		var cell = this.generateCell(fromColumn, fromRow, walls),
			path = [];
		cell.parent = null;
		cell.length = 0;
		cell.weight = this.heuristics(fromColumn, fromRow, toColumn, toRow);
		toVisit.queue(cell);
		while(toVisit.length && !path.length) {
			var current = toVisit.dequeue();
			this.visit(visited, current.column, current.row);
			if(current.column === toColumn && current.row === toRow) {
				while(current) {
					path.push(current);
					current = current.parent;
				}
			} else {
				for(var i = 0; i < current.directions.length; i++) {
					var d = current.directions[i];
					if(!this.hasVisited(visited, d.column, d.row)) {
						cell = this.generateCell(d.column, d.row, walls);
						cell.length = current.length + 1;
						cell.weight = cell.length + this.heuristics(cell.column, cell.row, toColumn, toRow);
						cell.parent = current;
						toVisit.queue(cell);
					}
				}
			}
		}
		return path;
	};

	MazeGenerator.prototype.heuristics = function(fromColumn, fromRow, toColumn, toRow) {
		return Math.abs(fromColumn - toColumn) + Math.abs(fromRow - toRow);
	};

	function PriorityQueue(){}

	PriorityQueue.prototype = new Array();

	PriorityQueue.prototype.queue = function(e) {
		var index = this.push(e) - 1,
			parent = Math.floor((index + 1) / 2) - 1;
		while(parent >= 0 && this[parent].compareTo(this[index]) > 0) {
			this.swap(parent, index);
			index = parent;
			parent = Math.floor((index + 1) / 2) - 1;
		}
		return this;
	};

	PriorityQueue.prototype.swap = function(i, j) {
		var temp = this[i];
		this[i] = this[j];
		this[j] = temp;
	};

	PriorityQueue.prototype.dequeue = function() {
		var r = this.shift(),
			from = 0,
			to,
			main = this.pop();
		if(main) {
			this.unshift(main);
			var left = this[from * 2 + 1],
				right = this[from * 2 + 2];
			while((left !== undefined && main.compareTo(left) > 0) || 
				  (right !== undefined && main.compareTo(right) > 0)) {
				if((left !== undefined && main.compareTo(left) > 0) &&
				  (right !== undefined && main.compareTo(right) > 0)) {
					if(left.compareTo(right) < 0) { //go left
						to = from * 2 + 1;
					} else { //left > right
						to = from * 2 + 2;
					}
				} else if(left !== undefined && main.compareTo(left) > 0) {
					to = from * 2 + 1;
				} else if(right !== undefined && main.compareTo(right) > 0) { //main > right
					to = from * 2 + 2;
				}
				this.swap(to, from);
				from = to;
				left = this[from * 2 + 1];
				right = this[from * 2 + 2];
			}
		}
		return r;
	};
	
	return MazeGenerator;
}());