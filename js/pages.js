// --- Toolbox ---
// Tools for the pageeditor
var tools_marked = -1;
var tools_cid = 0;
var tools_min = false;
var tools_heightvar = 0;
var tools_objects = [];
var tools_cats = [];
var tools_tools = {
	"all": [],
	"P": [],
	"A": [],
	"H1": [],
	"H2": [],
	"H3": [],
	"IMG": [],
	"TABLE": [],
	"UL": []
};
function tools_save() {
	alert("save");
}
function tools_loadTool(object, cat) {
	if(cat.search(" ") !== -1) {
		for(var v in cat.split(" ")) {
			tools_tools[cat.split(" ")[v]].push(object);
		}
	} else {
		tools_tools[cat].push(object);
	}
}
function tools_changeTools() {
	var disabled = [];
	if(tools_marked !== -1) {
		for(var cat in tools_tools) {
			if(cat !== "all") {
				for(var tool in tools_tools[cat]) {
					var found = false;
					for(var c in disabled) {
						if(disabled[c] == tools_tools[cat][tool]) {
							found = true;
						}
					}
					if(found != true) {
						if(cat != tools_marked.vars.type) {
							var newTool = true;		// fix flyt-swaping
							for(var temp in tools_tools[tools_marked.vars.type]) {
								if(tools_tools[tools_marked.vars.type][temp] == tools_tools[cat][tool]) {
									newTool = false;
								}
							}
							if(newTool === true) {
								tools_disable(tools_tools[cat][tool]);
								disabled.push(tools_tools[cat][tool]);
							}
						} else {
							tools_undisable(tools_tools[cat][tool]);
						}
					}
				}
			}
		}
	} else {
		for(var v in tools_tools) {
			if(v !== "all") {
				for(var tool in tools_tools[v]) {
					tools_disable(tools_tools[v][tool]);
				}
			}
		}
		for(var v in tools_tools["all"]) {
			tools_undisable(tools_tools["all"][v]);
		}
	}
}
function tools_undisable(object) {
	if(object.classList.contains("disabledTool") == true) {
		if(object.tagName == "TR") {
			object.style.display = "table-row";
			setTimeout(function() {
				object.classList.remove("disabledTool");
			}, 1);
		} else {
			object.classList.remove("disabledTool");
		}
	}
}
function tools_disable(object) {
	if(object.classList.contains("disabledTool") != true) {
		if(object.tagName == "TR") {
			setTimeout(function(){
				object.style.display = "none";
			}, 210);
		}
		object.classList.add("disabledTool");
	}
}
function tools_minmax() {
	if(tools_min == false) {
		tools_heightvar = obj("pageeditmenu").style.height;
		obj("pageeditmenu").style.height = "38px";
		obj("pageeditmenu").style.overflowY = "hidden";
		tools_min = true;
	} else {
		obj("pageeditmenu").style.height = tools_heightvar;
		obj("pageeditmenu").style.overflowY = "auto";
		tools_min = false;
	}
}
function tools_create(type) {
	var main = obj("pageeditor");
	var object = document.createElement(type);
	var id = "el"+tools_cid;
	tools_objects.push(id);
	var ev = document.createAttribute("onclick");
	if(type == "A") {
		ev.value = "tools_mark(this); tools_followLink();";
	} else {
		ev.value = "tools_mark(this);";
	}
	var vars = {
		type: type,
		obj: "this"
	};
	if(type == "P") {
		object.innerHTML = "Nytt text-element";
	} else if(type == "A") {
		object.innerHTML = "Ny länk";
		vars.followLink = false;
	} else if(type == "IMG") {
		vars.obj = "child";
		frame = document.createElement("DIV");
		object.src = "img/tools_emptyimage.png";
		var sub = document.createElement("P");
		sub.classList.add("subtext");
		frame.classList.add("img");
	} else if(type == "TABLE") {
		object.innerHTML = "<tr><td><p>Ny tabell</p></td></tr>";
		vars.border = false;
		vars.borderColor = "#000";
		vars.borderWidth = "1";
	} else if(type == "UL") {
		object.innerHTML = "<li><p>Ny lista</p></li>";
	}
	if(type != "IMG") {
		object.vars = vars;
		object.setAttributeNode(ev);
		object.id = id;
		main.appendChild(object);
		tools_mark(object);
	} else {
		frame.vars = vars;
		frame.setAttributeNode(ev);
		frame.id = id;
		main.appendChild(frame);
		frame.appendChild(object);
		frame.appendChild(sub);
		tools_mark(frame);
	}
	tools_cid ++;
}
function tools_editType(type, object) {
	if(type == "none") {
		obj("toolsContent").value = "";
	} else if(type == "P") {
		text = object.innerHTML;
		obj("toolsContent").value = text;
	} else if(type == "A") {
		text = object.innerHTML;
		obj("toolsContent").value = text;
	} else if(type == "H1") {
		text = object.innerHTML;
		obj("toolsContent").value = text;
	} else if(type == "H2") {
		text = object.innerHTML;
		obj("toolsContent").value = text;
	} else if(type == "H3") {
		text = object.innerHTML;
		obj("toolsContent").value = text;
	} else if(type == "IMG") {
		var chosen = 0;
		var src = tools_marked.children[0].src
		for(var c = 0; c < obj("toolsImageUrl").options.length; c++) {
			if(obj("toolsImageUrl").options[c].value == src.substr(-obj("toolsImageUrl").options[c].value.length)) {
				chosen = c;
			}
		}
		obj("toolsImageUrl").selectedIndex = chosen;
		obj("toolsImageMaxwidth").value = tools_marked.style.maxWidth.replace("px", "");
		tools_updateImage();
	}
}
function tools_change() {
	if(tools_marked !== -1) {
		if(obj("toolsContent").value != "") {
			tools_marked.innerHTML = obj("toolsContent").value;
		} else {
			popup("Du måste fylla i text");
		}
	}
}
function tools_changeLink() {
	if(tools_marked !== -1) {
		if(obj("toolsLink").value != "") {
			if(obj("toolsLink").value.length > 3) {
				if((obj("toolsLink").value.substr(0, 4) != "http") && (obj("toolsLink").value.substr(0, 3) != "ftp") && (obj("toolsLink").value.substr(0, 4) != "mail")) {
					obj("toolsLink").value = "http://"+obj("toolsLink").value;
					setTimeout(function(){ tools_changeLink(); }, 200);
				} else {
					tools_marked.href = obj("toolsLink").value;
				}
			} else {
				tools_marked.href = obj("toolsLink").value;
			}
		} else {
			tools_marked.removeAttribute("href");
			popup("Länken är tom");
		}
	}
}
function tools_followLink() {
	if(tools_marked.vars.type == "A") {
		if(tools_marked.href != "") {
			if(tools_marked.vars.followLink == true) {
				tools_marked.vars.followLink = false;
			} else {
				popup("Är du säker på att du vill följa denna länken? Klicka igen.");
				tools_marked.vars.followLink = true;
				event.preventDefault();
				return false;
			}
		}
	}
}
function tools_resetTools() {
	
}
function tools_mark(object) {
	if(object != "none") {
		tools_marked = object;
		obj("tools_current").innerHTML = "<b>Markerat:</b> "+tools_marked.id;
		tools_editType(tools_marked.vars.type, object);
		for(v in tools_objects) {
			obj(tools_objects[v]).style.background = "";
		}
		object.style.background = "#FA9DAF";
		tools_showCat(tools_marked.vars.type);
	} else {
		tools_marked = -1;
		obj("tools_current").innerHTML = "Välj ett element";
		tools_editType("none", "");
		tools_showCat("none");
	}
	tools_changeTools();
}
function tools_del() {
	if(tools_marked !== -1) {
		for(v in tools_objects) {
			if(tools_objects[v] == tools_marked.id) {
				delete tools_objects[v];
			}
		}
		obj("pageeditor").removeChild(tools_marked);
		tools_mark("none");
	} else {
		popup("Inget markerat");
	}
}
function tools_move(dir) {
	if(tools_marked !== -1) {
		var pos = 0;
		var pre = false;
		var nxt = false;
		var curr = false;
		for(var v in obj("pageeditor").children) {
			for(var v2 in tools_objects) {
				if(v == tools_objects[v2]) {
					if(curr !== false) {
						if(nxt === false) {
							nxt = obj(v);
						}
					}
					if(v == tools_marked.id) {
						curr = obj(v);
					}
					if(curr === false) {
						pre = obj(v);
					}
					pos++;
				}
			}
		}
		if(pre === false) {
			pre = {"id": false};
		}
		if(nxt === false) {
			nxt = {"id": false};
		}
		if(dir == "up") {
			if(pre.id !== false) {
				obj("pageeditor").insertBefore(curr, pre);
			} else {
				popup("Redan först");
			}
		}else if(dir == "down") {
			if(nxt.id !== false) {
				obj("pageeditor").insertBefore(nxt, curr);
			} else {
				popup("Redan sist");
			}
		}
	}
}
function tools_align(align) {
	if(tools_marked != -1) {
		tools_marked.style.textAlign = align;
	}
}
function tools_displayType(display) {
	if(tools_marked != -1) {
		tools_marked.style.display = display;
	}
}
function tools_float(floatTo) {
	if(tools_marked != -1) {
		if(floatTo != "none") {
			tools_marked.style.float = floatTo;
			if(floatTo == "left") {
				tools_marked.style.clear = "right";
			} else if(floatTo == "right") {
				tools_marked.style.clear = "left";
			}
		} else {
			if(tools_marked.style.float == "none") {
				popup("Elementet flyter redan inte");
			} else {
				tools_marked.style.float = "none";
			}
		}
	}
}
function tools_maxWidth() {
	if((obj("toolsImageMaxwidth").value != "") && (obj("toolsImageMaxwidth").value != 0)) {
		tools_marked.style.maxWidth = obj("toolsImageMaxwidth").value+"px";
	} else {
		tools_marked.style.maxWidth = "";
	}
}
function tools_tableRow(type) {
	if(type == "add") {
		var row = tools_marked.insertRow(-1);
		var fcell = row.insertCell(-1);
		fcell.innerHTML = "<p>Ny cell</p>";
		for(var c = 1; c < tools_marked.rows[0].cells.length; c++) {
			var cell = row.insertCell(-1);
			cell.innerHTML = "<p>Ny cell</p>";
		}
	} else {
		tools_marked.deleteRow(-1);
		if(tools_marked.rows.length == 0) {
			tools_del();
		}
	}
	tools_updTableBorders();
}
function tools_tableCell(type) {
	if(type == "add") {
		for(var v in tools_marked.rows) {
			if((v != "length") && (v != "item") && (v != "namedItem")) {
				var row = tools_marked.rows[v];
				var cell = row.insertCell(-1);
				cell.innerHTML = "<p>Ny cell</p>";
			}
		}
	} else {
		for(var c = 0; c < tools_marked.rows.length; c++) {
			tools_marked.rows[c].deleteCell(-1);
		}
		if(tools_marked.rows[0].cells.length == 0) {
			tools_del();
		}
	}
	tools_updTableBorders();
}
function tools_updTableBorders() {
	if(tools_marked.vars.border == true) {
		var style = tools_marked.vars.borderWidth+"px solid "+tools_marked.vars.borderColor;
		for(var row = 0; row < tools_marked.rows.length; row++) {
			for(var cell = 0; cell < tools_marked.rows[row].cells.length; cell++) {
				var theCell = tools_marked.rows[row].cells[cell];
				theCell.style.border = style;
			}
		}
	} else {
		for(var row = 0; row < tools_marked.rows.length; row++) {
			for(var cell = 0; cell < tools_marked.rows[row].cells.length; cell++) {
				tools_marked.rows[row].cells[cell].style.border = "none";
			}
		}
	}
}
function tools_tableBorder(type) {
	if(type == "add") {
		if(tools_marked.vars.border == true) {
			popup("Tabellen har redan kanter");
		} else {
			tools_marked.vars.border = true;
		}
	} else {
		if(tools_marked.vars.border == false) {
			popup("Tabellen saknar redan kanter");
		} else {
			tools_marked.vars.border = false;
		}
	}
	tools_updTableBorders();
}
function tools_list(todo) {
	if(todo == "add") {
		var li = document.createElement("LI");
		li.innerHTML = "<p>Punkt</p>";
		tools_marked.appendChild(li);
	} else {
		if(tools_marked.children.length == 1) {
			tools_del();
		} else {
			tools_marked.removeChild(tools_marked.children[tools_marked.children.length-1]);
		}
	}
}

function tools_showCat(cat) {
	for(var v in tools_cats) {
		
	}
}
function tools_getAllObjects(type) {
	if (typeof(type)==='undefined') type = "";
	var objects = [];
	for(var v in obj("pageeditor").children) {
		for(var v2 in tools_objects) {
			if(type != "") {
				if(obj("pageeditor").children[v].tagName == type) {
					objects.push(obj("pageeditor").children[v]);
				}
			} else {
				objects.push(obj("pageeditor").children[v]);
			}
		}
	}
	return objects;
}
function tools_updateImage() {
	if(obj("toolsImageUrl").value != "false") {
		tools_marked.children[0].src = obj("toolsImageUrl").value;
		for(var c in subtextsIndex) {
			if(subtextsIndex[c] == obj("toolsImageUrl").value) {
				tools_marked.children[1].innerHTML = subtexts[c];
			}
		}
	} else {
		tools_marked.children[0].src = "img/tools_emptyimage.png";
	}
}
