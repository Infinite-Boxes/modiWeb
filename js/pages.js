// --- Toolbox ---
// Tools for the pageeditor
var pageContainer = "pageeditor";
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
	"UL": [],
	"DIV": [],
	"MOD": []
};
var tools_link2follow = "";
var tools_parent = false;
var tools_loading = false;
var tools_codeEditing = false;
var tools_editMode = "GUI";
function tools_init() {
	tools_load();
	tools_changeTools();
	obj(pageContainer).classList.add("pageeditor");
}
function tools_save() {
	popup("Sparar sidan...");
	tools_mark("none");
	for(var c = 0; c < obj(pageContainer).children.length; c++) {
		var o = obj(pageContainer).children[c];
		if(o.classList.contains("marked")) {
			o.classList.remove("marked");
		}
		if(o.classList.length === 0) {
			o.removeAttribute("class");
		}
		tools_stripEvents(o);
		o.removeAttribute("id");
		o.removeAttribute("tabindex");
		if(o.tagName == "DIV") {
			if(typeof o.vars.moduleName != "undefined") {
				o.innerHTML = "!MOD! "+o.vars.moduleName+" !ENDMOD!";
			}
		}
		tools_enableEvents(o);
	}
	var toSend = obj(pageContainer).innerHTML;
	
	ajax("functions/savepage.php", "POST", "tools_saved", "", "id="+pageId+"&content="+toSend);
	tools_load();
}
function tools_saved(msg) {
	popup(msg, 1000);
}
function tools_load() {
	for(var c = 0; c < obj(pageContainer).children.length; c++) {
		var o = obj(pageContainer).children[c];
		o.id = "el"+c;
		o.vars = [];
		o.tabIndex = c+1;
		tools_disableEvents(o);
		if(o.tagName == "P") {
			o.vars.type = "P";
		} else if(o.tagName == "H1") {
			o.vars.type = "H1";
		} else if(o.tagName == "H2") {
			o.vars.type = "H2";
		} else if(o.tagName == "H3") {
			o.vars.type = "H3";
		} else if(o.tagName == "DIV") {
			if(o.classList.contains("img") == true) {
				o.vars.type = "IMG";
			} else if(o.innerHTML.substring(0, 5) == "!MOD!"){
				o.vars.type = "MOD";
				var mod = o.innerHTML.substring(6, o.innerHTML.length-9);
				o.vars.moduleName = mod;
				tools_fillSnippet(o.id, mod);
			} else {
				o.vars.type = "DIV";
			}
		} else if(o.tagName == "TABLE") {
			o.vars.type = "TABLE";
			o.vars.editMode = false;
			o.vars.editMode = false;
		} else if(o.tagName == "UL") {
			o.vars.type = "UL";
		} else if(o.tagName == "A") {
			o.vars.type = "A";
		}
		var ev = document.createAttribute("onclick");
		var ev2 = document.createAttribute("onfocus");
		//alert(o.onclick);
		if(o.vars.type == "A") {
			ev.value = "tools_mark(this); tools_followLink();";
		} else {
			ev.value = "tools_mark(this);";
		}
		ev2.value = "tools_mark(this);";
		o.setAttributeNode(ev);
		o.setAttributeNode(ev2);
	}
	tools_disable(obj("tools_code"));
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
		tools_undisable(obj("tools_editTools"));
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
		tools_disable(obj("tools_editTools"));
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
			object.style.display = "inline";
			setTimeout(function() {
				object.classList.remove("disabledTool");
			}, 1);
		}
	}
}
function tools_disable(object) {
	if(object.classList.contains("disabledTool") != true) {
		setTimeout(function(){
			object.style.display = "none";
		}, 210);
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
	var main = obj(pageContainer);
	var object = document.createElement(type);
	var id = "el"+obj(pageContainer).children.length;
	object.setAttribute("tabIndex", obj(pageContainer).children.length+1);
	tools_objects.push(id);
	var ev = document.createAttribute("onclick");
	if(type == "A") {
		ev.value = "tools_mark(this); tools_followLink();";
	} else {
		ev.value = "tools_mark(this);";
	}
	var vars = {
		type: type,
		events: [],
		obj: "this"
	};
	if(type == "P") {
		object.innerHTML = "Nytt text-element";
	} else if(type == "A") {
		object.innerHTML = "Ny länk";
		object.target = "_blank";
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
		vars.editMode = false;
	} else if(type == "UL") {
		object.innerHTML = "<li><p>Ny lista</p></li>";
		vars.editMode = false;
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
}
function tools_createCode() {
	var main = obj(pageContainer);
	var object = document.createElement("DIV");
	var id = "el"+obj(pageContainer).children.length;
	tools_objects.push(id);
	var ev = document.createAttribute("onclick");
	ev.value = "tools_mark(this);";
	var vars = {
		type: "DIV",
		obj: "this"
	};
	object.innerHTML = "Kod";
	object.vars = vars;
	object.setAttributeNode(ev);
	object.id = id;
	main.appendChild(object);
	tools_mark(object);
	tools_editCode();
}
function tools_createSnippet() {
	var main = obj(pageContainer);
	var object = document.createElement("DIV");
	var id = "el"+obj(pageContainer).children.length;
	tools_objects.push(id);
	var ev = document.createAttribute("onclick");
	ev.value = "tools_mark(this);";
	var vars = {
		type: "MOD",
		obj: "this",
		moduleName: "false"
	};
	object.innerHTML = "*Modul*";
	object.vars = vars;
	object.setAttributeNode(ev);
	object.id = id;
	object.classList.add("module");
	main.appendChild(object);
	tools_mark(object);
}
function tools_requestSnippet() {
	var mod = obj("moduleList").value;
	if(mod == "") {
		tools_marked.innerHTML = "*modul*";
		tools_marked.vars.moduleName = "false";
	} else {
		tools_marked.vars.moduleName = mod;
		ajax("functions/toolsloadsnippet.php?mod="+mod, "GET", "tools_updateSnippet", mod);
	}
}
function tools_updateSnippet(txt, mod) {
	if(tools_marked !== -1) {
		if(txt != "") {
			tools_marked.innerHTML = txt;
			for(var c = 0; c < tools_marked.children.length; c++) {
				tools_stripEvents(tools_marked.children[c]);
			}
		} else {
			tools_marked.innerHTML = "*"+mod+"-modul*";
		}
	}
}
function tools_fillSnippet(object, mod) {
	ajax("functions/toolsloadsnippet.php?mod="+mod, "GET", "tools_fillSnippet2", [object, mod]);
}
function tools_fillSnippet2(txt, args) {
	if(txt != "") {
		obj(args[0]).innerHTML = txt;
		for(var c = 0; c < obj(args[0]).children.length; c++) {
			tools_stripEvents(obj(args[0]).children[c]);
		}
	} else {
		obj(args[0]).innerHTML = "*"+args[1]+"-modul*";
		obj(args[0]).vars.moduleName = args[1];
	}
}
function tools_editType(type, object) {
	if(tools_marked !== -1) {
		if(type == "none") {
			obj("toolsContent").value = "";
		} else if(type == "P") {
			text = tools_innerHTML(object);
			obj("toolsContent").value = text;
		} else if(type == "A") {
			text = tools_innerHTML(object);
			obj("toolsContent").value = text;
			obj("toolsLink").value = object.getAttribute("href");
			tools_updLinkSelect();
			tools_updLinkTarget();
		} else if(type == "H1") {
			text = tools_innerHTML(object);
			obj("toolsContent").value = text;
		} else if(type == "H2") {
			text = tools_innerHTML(object);
			obj("toolsContent").value = text;
		} else if(type == "H3") {
			text = tools_innerHTML(object);
			obj("toolsContent").value = text;
		} else if(type == "IMG") {
			var chosen = 0;
			var src = tools_marked.children[0].src;
			for(var c = 0; c < obj("toolsImageUrl").options.length; c++) {
				if(obj("toolsImageUrl").options[c].value == src.substr(-obj("toolsImageUrl").options[c].value.length)) {
					chosen = c;
				}
			}
			obj("toolsImageUrl").selectedIndex = chosen;
			obj("toolsImageMaxwidth").value = tools_marked.style.maxWidth.replace("px", "");
			tools_updateImage();
		} else if(type == "DIV") {
			if(typeof object.vars.moduleName !== "undefined") {
				for(var c = 0; c < obj("moduleList").options.length; c++) {
					if(obj("moduleList").options[c].value == object.vars.moduleName) {
						chosen = c;
					}
				}
				obj("moduleList").selectedIndex = chosen;
			}
		}
		if(type != "all") {
			var marg = object.style.margin;
			if(marg == false) {
				marg = "0px 0px 0px 0px";
			}
			marg = marg.split(" ");
			var margStr = [];
			if(marg.length == 1) {
				var size = marg[0].substring(0, marg[0].length-2);
				for(var c = 0; c < 4; c++) {
					margStr[c] = size;
				}
			} else {
				for(var c in marg) {
					margStr[c] = marg[c].substring(0, marg[c].length-2);
				}
			}
			for(var c = 0; c < 4; c++) {
				if(typeof margStr[c] === "undefined") {
					margStr[c] = 0;
				}
			}
			obj("tool_marginu").value = margStr[0];
			obj("tool_marginr").value = margStr[1];
			obj("tool_margind").value = margStr[2];
			obj("tool_marginl").value = margStr[3];
		}
	}
}
function tools_change() {
	if(tools_marked !== -1) {
		if(obj("toolsContent").value != "") {
			tools_marked.innerHTML = obj("toolsContent").value;
			tools_disableEvents(tools_marked);
		} else {
			popup("Du måste fylla i text");
		}
		tools_updateCodearea();
	}
}
function tools_detailEdit() {
	if(tools_marked !== -1) {
		if(tools_marked.vars.editMode == false) {
			if(tools_marked.vars.type == "TABLE") {
				for(var r = 0; r < tools_marked.rows.length; r++) {
					for(var c = 0; c < tools_marked.rows[r].cells.length; c++) {
						var str = tools_marked.rows[r].cells[c].innerHTML;
						tools_marked.rows[r].cells[c].innerHTML = "<input type='text' value='"+str+"' />";
						if(str == "") {
							var size = 1;
						} else {
							var size = Math.round(str.length*0.9);
						}
						if(size > 50) {
							size = 50;
						}
						tools_marked.rows[r].cells[c].children[0].size = size;
					}
				}
				tools_marked.vars.editMode = true;
			} else if(tools_marked.vars.type == "UL") {
				for(var c = 0; c < tools_marked.children.length; c++) {
					var str = tools_marked.children[c].innerHTML;
					tools_marked.children[c].innerHTML = "<input type='text' value='"+str+"' />";
					if(str == "") {
						size = 1;
					} else {
						sise = Math.round(str.length*0.9);
					}
					tools_marked.children[c].size = str.length;
				}
				tools_marked.vars.editMode = true;
			}
		} else {
			popup("Redigerar redan objektet");
		}
	}
}
function tools_detailEditSave() {
	if(tools_marked !== -1) {
		if(tools_marked.vars.editMode == true) {
			if(tools_marked.vars.type == "TABLE") {
				for(var r = 0; r < tools_marked.rows.length; r++) {
					for(var c = 0; c < tools_marked.rows[r].cells.length; c++) {
						var str = tools_marked.rows[r].cells[c].children[0].value;
						tools_marked.rows[r].cells[c].innerHTML = str;
					}
				}
				tools_marked.vars.editMode = false;
			} else if(tools_marked.vars.type == "UL") {
				for(var c = 0; c < tools_marked.children.length; c++) {
					var str = tools_marked.children[c].children[0].value;
					tools_marked.children[c].innerHTML = str;
				}
				tools_marked.vars.editMode = false;
			}
		}
		tools_updateCodearea();
	}
}
function tools_changeLink() {
	if(tools_marked !== -1) {
		if(obj("toolsLink").value !== "") {
			tools_marked.setAttribute("href", obj("toolsLink").value);
		} else {
			tools_marked.removeAttribute("href");
			popup("Länken är tom");
		}
		tools_updLinkSelect();
		tools_updateCodearea();
	}
}
function tools_updLinkSelect() {
	if(tools_marked !== -1) {
		var selected = 0;
		for(var c = 0; c < obj("tool_linkList").options.length; c++) {
			var var2 = obj("tool_linkList").options.item(c).value;
			if(var2 !== "NULL") {
				if(obj("toolsLink").value === var2) {
					selected = c;
				}
			}
		}
		obj("tool_linkList").selectedIndex = selected;
	}
}
function tools_selectLink() {
	if(tools_marked !== -1) {
		if(obj("tool_linkList").value !== "NULL") {
			obj("toolsLink").value = obj("tool_linkList").value;
		} else {
			obj("toolsLink").value = "";
		}
		tools_changeLink();
	}
}
function tools_linkTarget() {
	if(tools_marked !== -1) {
		tools_marked.target = obj("tool_linkTarget").value;
	}
}
function tools_updLinkTarget() {
	if(tools_marked !== -1) {
		if(typeof tools_marked.target !== "undefined") {
			obj("tool_linkTarget").value = tools_marked.target;
		}
	}
}
function tools_followLink() {
	if(tools_marked !== -1) {
		if(tools_marked.vars.type == "A") {
			if(tools_marked.href != "") {
				if(tools_link2follow == tools_marked) {
					tools_link2follow = "";
				} else {
					popup("Vill du följa denna länken? Klicka då igen.");
					tools_link2follow = tools_marked;
					setTimeout(function() {
						tools_link2follow = "";
						popup("Länk ej följd");
					}, 1500);
					event.preventDefault();
					return false;
				}
			}
		}
	}
}
function tools_mark(object) {
	if(tools_loading == false) {
		if(object != "none") {
			tools_marked = object;
			obj("tools_current").innerHTML = "<b>Markerat:</b> "+tools_marked.id;
			tools_editType(tools_marked.vars.type, object);
			for(var c = 0; c < obj(pageContainer).children.length; c++) {
				if(obj(pageContainer).children[c].classList.contains("marked")) {
					obj(pageContainer).children[c].classList.remove("marked");
				}
			}
			object.classList.add("marked");
			if(object.style.fontWeight !== "bold") {
				setCheckbox("tool_bold", false);
			} else {
				setCheckbox("tool_bold", true);
			}
			if(object.style.fontStyle !== "italic") {
				setCheckbox("tool_italic", false);
			} else {
				setCheckbox("tool_italic", true);
			}
			if(object.style.fontFamily !== "") {
				tools_updateFontlist(object.style.fontFamily);
			} else {
				tools_updateFontlist("");			// asd aspd kasp odkapofdk paoskd fpoaskf d
			}
			if(object.vars.type === "IMG") {
				
			}
			if(object.vars.type == "DIV") {
				tools_editCode(true);
			} else if(object.vars.type == "MOD") {
				tools_editCode(false);
			} else {
				if(tools_codeEditing == true) {
					tools_editCode(true);
				} else {
					tools_editCode(false);
				}
			}
		} else {
			tools_marked = -1;
			obj("tools_current").innerHTML = "Välj ett element";
			tools_editType("none", "");
		}
		tools_changeTools();
		tools_updateCodearea();
	} else {
		popup("Laddar modul");
	}
}
function tools_del() {
	if(tools_marked !== -1) {
		obj(pageContainer).removeChild(tools_marked);
		tools_mark("none");
		tools_editCode(false);
		tols_codeEditing = false;
	} else {
		popup("Inget markerat");
	}
}
function tools_move(dir) {
	if(tools_marked !== -1) {
		var pos = 0;
		for(var c = 0; c < obj(pageContainer).children.length; c++) {
			if(obj(pageContainer).children[c] == tools_marked) {
				var co = obj(pageContainer).children[c];
				if(dir == "up") {
					if(c == 0) {
						popup("Redan först");
					} else {
						obj(pageContainer).insertBefore(co, obj(pageContainer).children[c-1]);
						return;
					}
				} else if(dir == "down") {
					if(c == obj(pageContainer).children.length-1) {
						popup("Redan sist");
					} else {
						obj(pageContainer).insertBefore(obj(pageContainer).children[c+1], co);
						return;
					}
				}
			}
		}
	} else {
		popup("Inget markerat");
	}
}
function tools_updColor() {
	if(tools_marked !== -1) {
		var col = obj("tool_color").value;
		if(col !== "") {
			tools_marked.style.color = col;
			if((col.length === 7) && (col[0] === "#")) {
				obj("tool_colorPick").value = col;
			}
		} else {
			tools_marked.style.color = "";
			obj("tool_colorPick").value = "#000000";
		}
	}
}
function tools_updColorPick() {
	if(tools_marked !== -1) {
		var col = obj("tool_colorPick").value;
		if(col !== "") {
			tools_marked.style.color = col;
			obj("tool_color").value = col;
		} else {
			tools_marked.style.color = "";
			obj("tool_color").value = "";
		}
	}
}
function tools_align(align) {
	if(tools_marked !== -1) {
		tools_marked.style.textAlign = align;
		tools_updateCodearea();
	}
}
function tools_changeFont(object) {
	if(tools_marked !== -1) {
		tools_marked.style.fontFamily = object.value;
	}
}
function tools_updateFontlist(font) {
	if(tools_marked !== -1) {
		if(font !== "") {
			var c = 0;
			for(var c1 = 0; c1 < obj("tool_font").children.length; c1++) {
				for(var c2 = 0; c2 < obj("tool_font").children[c1].children.length; c2++) {
					if(obj("tool_font").children[c1].children[c2].value === font) {
						obj("tool_font").selectedIndex = c;
					}
					c++;
				}
			}
		} else {
			obj("tool_font").selectedIndex = 10;
		}
	}
}
function tools_style(type) {
	if(tools_marked !== -1) {
		switch(type) {
			case "bold":
				if(tools_marked.style.fontWeight !== "bold"){
					tools_marked.style.fontWeight = "bold";
				} else {
					tools_marked.style.fontWeight = "";
				}
				break;
			case "italic":
				if(tools_marked.style.fontStyle !== "italic"){
					tools_marked.style.fontStyle = "italic";
				} else {
					tools_marked.style.fontStyle = "";
				}
				break;
		}
	}
}
function tools_imgAlt(o) {
	if(tools_marked !== -1) {
		switch(tools_marked.children.length) {
			case 1:
				tools_addRemoveAlt(true);
				break;
			case 2:
				tools_addRemoveAlt(false);
				break;
		}
	}
}
function tools_addRemoveAlt(way) {
	if(way === true) {
		if(typeof tools_marked.children[1] === "undefined") {
			var p = document.createElement("P");
			p.classList.add("subtext");
			tools_marked.appendChild(p);
		}
		for(var c in subtextsIndex) {
			if(subtextsIndex[c] == obj("toolsImageUrl").value) {
				tools_marked.children[1].innerHTML = subtexts[c];
			}
		}
	} else {
		if(typeof tools_marked.children[1] !== "undefined") {
			tools_marked.removeChild(tools_marked.children[1]);
		}
	}
}
function tools_imgContainer(o) {
	if(tools_marked !== -1) {
		switch(tools_marked.classList.contains("containerFreeImg")) {
			case true:
				tools_marked.classList.remove("containerFreeImg");
				break;
			case false:
				tools_marked.classList.add("containerFreeImg");
				break;
		}
	}
}
function tools_textSize(size) {
	if(tools_marked !== -1) {
		var str = tools_marked.innerHTML;
		
		var main = obj(pageContainer);
		var object = document.createElement(size);
		var id = tools_marked.id//"el"+tools_cid;
		//tools_objects.push(id);
		var ev = document.createAttribute("onclick");
		ev.value = "tools_mark(this);";
		var vars = {
			type: size,
			obj: "this"
		};
		object.innerHTML = str;
		object.vars = vars;
		object.setAttributeNode(ev);
		object.id = id;
		var atts = ["fontWeight", "fontStyle", "fontFamily", "textAlign", "float", "display"];
		for(var c in atts) {
			object.style[atts[c]] = tools_marked.style[atts[c]];
		}
		main.appendChild(object);
		obj(pageContainer).replaceChild(object, tools_marked);
		tools_mark(object);
		tools_updateCodearea();
	}
}
function tools_displayType(display) {
	if(tools_marked != -1) {
		tools_marked.style.display = display;
		tools_updateCodearea();
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
		tools_updateCodearea();
	}
}
function tools_maxWidth() {
	if(tools_marked != -1) {
		if((obj("toolsImageMaxwidth").value != "") && (obj("toolsImageMaxwidth").value != 0)) {
			tools_marked.style.maxWidth = obj("toolsImageMaxwidth").value+"px";
		} else {
			tools_marked.style.maxWidth = "";
		}
		tools_updateCodearea();
	}
}
function tools_tableRow(type) {
	if(tools_marked != -1) {
		if(type == "add") {
			var row = tools_marked.insertRow(-1);
			var fcell = row.insertCell(-1);
			if(tools_marked.vars.editMode == true) {
				fcell.innerHTML = "<input type='text' value='Ny cell' />";
				fcell.children[0].size = 7;
			} else {
				fcell.innerHTML = "<p>Ny cell</p>";
			}
			for(var c = 1; c < tools_marked.rows[0].cells.length; c++) {
				var cell = row.insertCell(-1);
				if(tools_marked.vars.editMode == true) {
					cell.innerHTML = "<input type='text' value='Ny cell' />";
					cell.children[0].size = 7;
				} else {
					cell.innerHTML = "<p>Ny cell</p>";
				}
			}
			tools_updTableBorders();
		} else {
			tools_marked.deleteRow(-1);
			if(tools_marked.rows.length == 0) {
				tools_del();
			} else {
				tools_updTableBorders();
			}
		}
		tools_updateCodearea();
	}
}
function tools_tableCell(type) {
	if(tools_marked != -1) {
		if(type == "add") {
			for(var v in tools_marked.rows) {
				if((v != "length") && (v != "item") && (v != "namedItem")) {
					var row = tools_marked.rows[v];
					var cell = row.insertCell(-1);
					if(tools_marked.vars.editMode == true) {
						cell.innerHTML = "<input type='text' value='Ny cell' />";
						cell.children[0].size = 7;
					} else {
						cell.innerHTML = "<p>Ny cell</p>";
					}
				}
			}
			tools_updTableBorders();
		} else {
			for(var c = 0; c < tools_marked.rows.length; c++) {
				tools_marked.rows[c].deleteCell(-1);
			}
			if(tools_marked.rows[0].cells.length == 0) {
				tools_del();
			}else {
				tools_updTableBorders();
			}
		}
		tools_updateCodearea();
	}
}
function tools_updTableBorders() {
	if(tools_marked != -1) {
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
}
function tools_tableBorder(type) {
	if(tools_marked != -1) {
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
		tools_updateCodearea();
	}
}
function tools_updMargin() {
	if(tools_marked != -1) {
		tools_marginEnd();
		var m = [];
		m[0] = obj("tool_marginu").value;
		m[1] = obj("tool_marginr").value;
		m[2] = obj("tool_margind").value;
		m[3] = obj("tool_marginl").value;
		tools_marked.style.margin = m[0]+"px "+m[1]+"px "+m[2]+"px "+m[3]+"px";
	} else {
		popup("Inget element är valt");
	}
}
function tools_marginEnd() {
	if(tools_marked != -1) {
		if((obj("tool_marginu").value == "") || (obj("tool_marginu").value == "undefined")) {
			obj("tool_marginu").value = 0;
		}
		if((obj("tool_marginr").value == "") || (obj("tool_marginr").value == "undefined")) {
			obj("tool_marginr").value = 0;
		}
		if((obj("tool_margind").value == "") || (obj("tool_margind").value == "undefined")) {
			obj("tool_margind").value = 0;
		}
		if((obj("tool_marginl").value == "") || (obj("tool_marginl").value == "undefined")) {
			obj("tool_marginl").value = 0;
		}
	}
}
function tools_list(todo) {
	if(tools_marked != -1) {
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
		tools_updateCodearea();
	}
}

function tools_getAllObjects(type) {
	if (typeof(type)==='undefined') type = "";
	var objects = [];
	for(var v in obj(pageContainer).children) {
		for(var v2 in tools_objects) {
			if(type != "") {
				if(obj(pageContainer).children[v].tagName == type) {
					objects.push(obj(pageContainer).children[v]);
				}
			} else {
				objects.push(obj(pageContainer).children[v]);
			}
		}
	}
	return objects;
}
function tools_updateImage(def) {
	if(tools_marked != -1) {
		if(typeof def === "undefined") {
			def = false;
		}
		if(obj("toolsImageUrl").value !== "false") {
			tools_marked.children[0].src = obj("toolsImageUrl").value;
			if(typeof tools_marked.children[1] === "undefined") {
				/*var p = document.createElement("P");
				p.classList.add("subtext");
				tools_marked.appendChild(p);*/
			}
			if(typeof tools_marked.children[1] !== "undefined") {
				for(var c in subtextsIndex) {
					if(subtextsIndex[c] == obj("toolsImageUrl").value) {
						tools_marked.children[1].innerHTML = subtexts[c];
					}
				}
			}
		} else if(def === true) {
			tools_marked.children[0].src = "img/tools_emptyimage.png";
			if(typeof tools_marked.children[1] !== "undefined") {
				tools_marked.children[1].innerHTML = "";
			}
		}
		tools_updateCodearea();
	}
}
function tools_updateCodearea() {
	if(tools_marked !== -1) {
		obj("codearea").value = tools_innerHTML(tools_marked);
		obj("codearea").rows = Math.ceil((obj("codearea").value.length)/30);
	}
}
function tools_editCode(set) {
	if(typeof set == "undefined") {
		if(obj("tools_code").classList.contains("disabledTool")) {
			tools_undisable(obj("tools_code"));
			tools_updateCodearea();
			tools_codeEditing = true;
		} else {
			tools_disable(obj("tools_code"));
			tools_codeEditing = false;
		}
	}
	if(set == true) {
		tools_undisable(obj("tools_code"));
		tools_updateCodearea();
	} else {
		tools_disable(obj("tools_code"));
	}
}
function tools_editAllCode() {
	if(obj("allTools").classList.contains("disabledTool")) {
		tools_undisable(obj("allTools"));
		tools_disable(obj("allCode"));
		tools_editMode = "GUI";
	} else {
		tools_mark("none");
		tools_disable(obj("allTools"));
		tools_undisable(obj("allCode"));
		var allCode = obj(pageContainer).cloneNode(true);
		for(var child in allCode.children) {
			var to = allCode.children[child];
			var or = obj(pageContainer).children[child];
			if(to.tagName == "DIV") {
				if(typeof or.vars !== "undefined") {
					if(typeof or.vars.moduleName !== "undefined") {
						to.innerHTML = "!MOD! "+or.vars.moduleName+" !ENDMOD!";
					}
				}
			}
			if(typeof to.id !== "undefined") {
				if(to.id.substring(0, 2) == "el") {
					to.removeAttribute("id");
					if(to.onclick == "function onclick(event) {\n  tools_mark(this);\n}") {
						to.removeAttribute("onclick");
					}
					to.removeAttribute("tabIndex");
					if(to.classList.contains("marked")) {
						to.classList.remove("marked");
					}
					if(to.classList.length == 0) {
						to.removeAttribute("class");
					}
				}
			}
		}
		obj("allCodeTextarea").value = allCode.innerHTML.trim();
		obj("allCodeTextarea").rows = Math.ceil((allCode.innerHTML.length)/32);
		tools_editMode = "CODE";
	}
}
function tools_updateAllCode() {
	obj(pageContainer).innerHTML = obj("allCodeTextarea").value;
	tools_load();
	popup("Sidan har uppdaterats");
}
function tools_updateCode() {
	if(tools_marked != -1) {
		if(tools_marked.tagName == "DIV") {
			if(typeof tools_marked.vars.moduleName !== "undefined") {
				popup("Ändrat från modul till DIV-element");
				tools_marked.vars.type = "DIV";
			}
		}
		tools_marked.innerHTML = obj("codearea").value;
		for(var c = 0; c < tools_marked.children.length; c++) {
			tools_disableEvents(tools_marked.children[c]);
		}
		//tools_mark(tools_marked);
	} else {
		popup("Inget element markerat");
	}
}

function tools_isNotEditorFunction(str) {
	if(typeof str === "function") {
		var s1 = "function onclick(event) {\n  tools_mark(this);\n}";
		var s2 = "function onclick(event) {\n  tools_mark(this); tools_followLink();\n}";
		if((str == s1) || (str == s2) || (str === null)) {
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
function tools_disableEvents(obj) {
	var oList = [obj];
	var sList = [];
	var oc = 0;
	var errC = 0;
	while(oList.length !== sList.length) {
		var found = false;
		for(var c2 in sList) {
			if(oList[oc].tagName === "IMG") {
				var check1 = oList[oc].src;
			} else {
				var check1 = oList[oc].innerHTML;
			}
			if(sList[c2].tagName === "IMG") {
				var check2 = sList[c2].src;
			} else {
				var check2 = sList[c2].innerHTML;
			}
			if(check1 === check2) {
				found = true;
			}
		}
		if(found === false) {
			var to = oList[oc];
			sList.push(to);
			for(var c2 = 0; c2 < to.children.length; c2++) {
				oList.push(to.children[c2]);
			}
			if(typeof to.vars === "undefined") {
				to.vars = [];
			}
			if(typeof to.vars.events === "undefined") {
				to.vars.events = [];
			}
			var evs = "";
			for(var c2 in to) {
				if(c2.substring(0, 2) == "on") {
					if(typeof to[c2] === "function") {
						if(tools_isNotEditorFunction(to.getAttribute(c2)) === true) {
							if(typeof o.vars === "undefined") {
								o.vars = [];
							}
							if(typeof o.vars.events === "undefined") {
								o.vars.events = [];
							}
							to.vars.events.push({"type": c2, "function": to.getAttribute(c2)});
							to.removeAttribute(c2);
							//to.setAttribute("data-events", c2);
						}
					}
				}
			}
		}
		oc++;
		if(errC == 1000) {
			alert("Ett fel har uppstått");
			oList = [];
			sList = [];
		}
		errC++;
	}
}
function tools_stripEvents(obj) {
	var oList = [obj];
	var sList = [];
	var oc = 0;
	var errC = 0;
	while(oList.length !== sList.length) {
		var found = false;
		for(var c2 in sList) {
			if(oList[oc].tagName === "IMG") {
				var check1 = oList[oc].src;
			} else {
				var check1 = oList[oc].innerHTML;
			}
			if(sList[c2].tagName === "IMG") {
				var check2 = sList[c2].src;
			} else {
				var check2 = sList[c2].innerHTML;
			}
			if(check1 === check2) {
				found = true;
			}
		}
		if(found === false) {
			var to = oList[oc];
			sList.push(to);
			for(var c2 = 0; c2 < to.children.length; c2++) {
				oList.push(to.children[c2]);
			}
			for(var c2 in to) {
				if(c2.substring(0, 2) == "on") {
					if(typeof to[c2] === "function") {
						to.removeAttribute(c2);
					}
				}
			}
		}
		oc++;
		if(errC == 1000) {
			alert("Ett fel har uppstått");
			oList = [];
			sList = [];
		}
		errC++;
	}
}
function tools_innerHTML(obj) {
	tools_enableEvents(obj);
	var content = obj.cloneNode(true);
	tools_disableEvents(obj);
	return content.innerHTML;
}
function tools_enableEvents(obj, ret) {
	if(typeof ret === "undefined") {
		ret = false;
	}
	var oList = [obj];
	var sList = [];
	var oc = 0;
	var errC = 0;
	while(oList.length !== sList.length) {
		var found = false;
		for(var c2 in sList) {
			if(oList[oc].tagName === "IMG") {
				var check1 = oList[oc].src;
			} else {
				var check1 = oList[oc].innerHTML;
			}
			if(sList[c2].tagName === "IMG") {
				var check2 = sList[c2].src;
			} else {
				var check2 = sList[c2].innerHTML;
			}
			if(check1 === check2) {
				found = true;
			}
		}
		if(found === false) {
			var to = oList[oc];
			sList.push(oList[oc]);
			for(var c2 = 0; c2 < oList[oc].children.length; c2++) {
				oList.push(oList[oc].children[c2]);
			}
			if(typeof to.vars !== "undefined") {
				if(typeof to.vars.events !== "undefined") {
					for(var c2 in to.vars.events) {
						to.setAttribute(to.vars.events[c2].type, to.vars.events[c2].function);
					}
				}
			}
		}
		oc++;
		if(errC == 1000) {
			alert("Ett fel har uppstått");
			oList = [];
			sList = [];
		}
		errC++;
	}
	if(ret === true) {
		return obj;
	}
}
