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
						if(cat != tools_marked.children[0].tagName) {
							var newTool = true;		// fix flyt-swaping
							for(var temp in tools_tools[tools_marked.children[0].tagName]) {
								if(tools_tools[tools_marked.children[0].tagName][temp] == tools_tools[cat][tool]) {
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
	frame = document.createElement("DIV");
	frame.id = id;
	var ev = document.createAttribute("onclick");
	ev.value = "tools_mark(this);";
	if(type == "P") {
		object.innerHTML = "Nytt text-element";
	} else if(type == "IMG") {
		object.src = "img/tools_emptyimage.png";
	} else if(type == "TABLE") {
		object.innerHTML = "<tr><td><p>Ny tabell</p></td></tr>";
	} else if(type == "UL") {
		object.innerHTML = "<li><p>Ny lista</p></li>";
	}
	frame.setAttributeNode(ev);
	//frame.onclick = function() {
	//	tools_mark(frame);
	//};
	main.appendChild(frame);
	frame.appendChild(object);
	tools_mark(frame);
	tools_cid ++;
}
function tools_editType(type, object) {
	if(type == "none") {
		obj("toolsContent").value = "";
	} else if(type == "P") {
		text = object.innerHTML;
		text = text.replace("<p>", "");
		text = text.replace("</p>", "");
		obj("toolsContent").value = text;
	} else if(type == "H1") {
		text = object.innerHTML;
		text = text.replace("<h1>", "");
		text = text.replace("</h1>", "");
		obj("toolsContent").value = text;
	} else if(type == "H2") {
		text = object.innerHTML;
		text = text.replace("<h2>", "");
		text = text.replace("</h2>", "");
		obj("toolsContent").value = text;
	} else if(type == "H3") {
		text = object.innerHTML;
		text = text.replace("<h3>", "");
		text = text.replace("</h3>", "");
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
		obj("toolsImageMaxwidth").value = tools_marked.children[0].style.maxWidth.replace("px", "");
		obj("toolsImageMaxheight").value = tools_marked.children[0].style.maxHeight.replace("px", "");
		tools_updateImage();
	}
}
function tools_change() {
	if(tools_marked !== -1) {
		eltype = tools_marked.children[0].tagName;
		if(obj("toolsContent").value == "") {
			if(eltype == "P") {
				tools_marked.innerHTML = "<p>"+obj("toolsContent").value+"</p>";
			} else if(eltype == "H1") {
				tools_marked.innerHTML = "<h1>"+obj("toolsContent").value+"</h1>";
			} else if(eltype == "H2") {
				tools_marked.innerHTML = "<h2>"+obj("toolsContent").value+"</h2>";
			} else if(eltype == "H3") {
				tools_marked.innerHTML = "<h3>"+obj("toolsContent").value+"</h3>";
			}
		} else {
			popup("Du måste fylla i text");
		}
	}
}
function tools_resetTools() {
	
}
function tools_mark(object) {
	if(object != "none") {
		tools_marked = object;
		obj("tools_current").innerHTML = "<b>Markerat:</b> "+tools_marked.id;
		tools_editType(tools_marked.children[0].tagName, object);
		for(v in tools_objects) {
			obj(tools_objects[v]).style.background = "";
		}
		object.style.background = "#FA9DAF";
		tools_showCat(tools_marked.children[0].tagName);
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
			}
		}else if(dir == "down") {
			if(nxt.id !== false) {
				obj("pageeditor").insertBefore(nxt, curr);
			}
		}
	}
}
function tools_align(align) {
	if(tools_marked != -1) {
		tools_marked.style.textAlign = align;
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
			tools_marked.style.float = "none";
		}
	}
}
function tools_maxWidth() {
	if((obj("toolsImageMaxwidth").value != "") && (obj("toolsImageMaxwidth").value != 0)) {
		tools_marked.children[0].style.maxWidth = obj("toolsImageMaxwidth").value+"px";
	} else {
		tools_marked.children[0].style.maxWidth = "";
	}
}
function tools_maxHeight() {
	if((obj("toolsImageMaxheight").value != "") && (obj("toolsImageMaxheight").value != 0)) {
		tools_marked.children[0].style.maxHeight = obj("toolsImageMaxheight").value+"px";
	} else {
		tools_marked.children[0].style.maxHeight = "";
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
	} else {
		tools_marked.children[0].src = "img/tools_emptyimage.png";
	}
}
