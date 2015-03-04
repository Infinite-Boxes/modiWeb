window.innerHeight = window.innerHeight || document.documentElement.clientHeight;
function o(ut) {
	//document.getElementById("output").innerHTML = document.getElementById("output").innerHTML+"<br />"+ut;
	alert(ut);
}
function obj(object) {
	if(typeof document.getElementById(object) !== "undefined") {
		return document.getElementById(object);
	}
}
function groupMinimize(object) {
	if(object.parentNode.id != "") {
		alert(object.parentNode.children[0].height);
	}
}
var popupTimer1 = false;
var popupTimer2 = false;
function popup(object, txt) {
	obj("popup").style.display = "block";
	obj("popup").innerHTML = txt;
	setTimeout(function(){
		obj("popup").style.opacity = 1;
	}, 1);
	if(popupTimer1 !== false) {
		clearTimeout(popupTimer1);
	}
	if(popupTimer2 !== false) {
		clearTimeout(popupTimer2);
	}
	popupTimer1 = setTimeout(function(){
		obj("popup").style.opacity = 0;
		popupTimer1 = false;
	}, 2500);
	popupTimer2 = setTimeout(function(){
		obj("popup").style.display = "none";
		popupTimer2 = false;
	}, 3000);
	var e = event;
	setTimeout(function(){
		var yp = ((e.clientY - 30) - obj("popup").offsetHeight);
		var xp = (e.clientX - (obj("popup").offsetWidth / 2));
		if(yp < 0) {
			yp = 0;
		}
		obj("popup").style.top = yp+"px";
		obj("popup").style.left = xp+"px";
	}, 1);
}
function edit(id) {
	ajax("modules/elements/gettexts.php?id="+id, "editFinal");
	document.getElementById("admineditid").value = id;
	document.getElementById("admineditfullid").value = id;
	show("adminedit", true);
	document.getElementById("adminedittextarea").focus();
}
function editFinal(txt) {
	document.getElementById("adminedittextarea").value = txt;
	document.getElementById("admineditfulltextarea").value = txt;
}
var elements = [];
function show(element, type) {
	if (typeof(type)==='undefined') type = "none";
	var el = document.getElementById(element).style;
	if(type === "none") {
		if(el.display == "block") {
			el.display = "none";
		} else {
			el.display = "block";
		}
	} else {
		if(type === true) {
			el.display = "block";
		} else {
			el.display = "none";
		}
	}
}
var mousemoving = "";
var mousex = 0;
var mousey = 0;
var elx = 0;
var ely = 0;
function startDrag(event, element) {
	mousex = event.clientX;
	mousey = event.clientY;
	mousemoving = element;
	document.addEventListener("mousemove", moving);
	document.addEventListener("mouseup", function() {
		document.removeEventListener("mousemove", moving); 
	});
	ely = document.getElementById(element).style.top;
	elx = document.getElementById(element).style.left;
	event.preventDefault();
	return false;
}
function moving(event) {
	var elobj = document.getElementById(mousemoving);
	var el = elobj.style;
	if((el.top == "") || (el.top == "50%")) {
		ely = window.innerHeight/2;
		elx = window.innerWidth/2;
	} else {
		ely = parseInt(el.top.toString().slice(0, -2));
		elx = parseInt(el.left.toString().slice(0, -2));
	}
	var tempy = ely+(event.clientY-mousey);
	var tempx = elx+(event.clientX-mousex);
	if(tempx < 150) {
		tempx = 150;
	} else if(tempx > window.innerWidth-((elobj.clientWidth)-150)) {
		tempx = window.innerWidth-((elobj.clientWidth)-150);
	}
	if(tempy < 100) {
		tempy = 100;
	} else if(tempy > window.innerHeight-((elobj.clientHeight)-(100-document.getElementById("footer").clientHeight))) {
		tempy = window.innerHeight-((elobj.clientHeight)-(100-document.getElementById("footer").clientHeight));
	}
	el.top = tempy+"px";
	el.left = tempx+"px";
	mousey = event.clientY;
	mousex = event.clientX;
}

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
						disabled.push(tools_tools[cat][tool]);
						tools_undisable(tools_tools[cat][tool]);
						if(cat != tools_marked.children[0].tagName) {
							var newTool = true;		// fix flyt-swaping
							for(var temp in tools_tools[tools_marked.children[0].tagName]) {
								if(tools_tools[tools_marked.children[0].tagName][temp] == tools_tools[cat][tool]) {
									newTool = false;
								}
							}
							if(newTool === true) {
								tools_disable(tools_tools[cat][tool]);
							}
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
		text = object.src;
		obj("toolsContent").value = "";
	}
}
function tools_change() {
	if(tools_marked !== -1) {
		eltype = tools_marked.children[0].tagName;
		if(eltype == "P") {
			tools_marked.innerHTML = "<p>"+obj("toolsContent").value+"</p>";
		} else if(eltype == "H1") {
			tools_marked.innerHTML = "<h1>"+obj("toolsContent").value+"</h1>";
		} else if(eltype == "H2") {
			tools_marked.innerHTML = "<h2>"+obj("toolsContent").value+"</h2>";
		} else if(eltype == "H3") {
			tools_marked.innerHTML = "<h3>"+obj("toolsContent").value+"</h3>";
		}
	}
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
		} else {
			tools_marked.style.float = "none";
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
function tools_updMenu(type) {
	if (typeof(type)==='undefined') type = "";
	if(type == "") {
		
	}
}
function str_replace(find, replace, str) {
	while(str.indexOf(find) != -1) {
		str = str.replace(find, replace);
	}
	return str;
}
function formatContent(string) {
	return string;
}

function loaded(page) {
	if(page == "pages") {
		document.getElementById("pageeditor").innerHTML = pageeditcontent;
		tools_changeTools();
	}
}
var loadedVar = "";
var pageeditcontent = "";
var editElements = 0;
window.onload = function() {
	loaded(loadedVar);
};
// --- Ajax ---
function xhrObj(){
    try {
        return new XMLHttpRequest();
    }catch(e){}
    try {
        return new ActiveXObject("Msxml3.XMLHTTP");
    }catch(e){}
    try {
        return new ActiveXObject("Msxml2.XMLHTTP.6.0");
    }catch(e){}
    try {
        return new ActiveXObject("Msxml2.XMLHTTP.3.0");
    }catch(e){}
    try {
        return new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){}
    try {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }catch(e){}
    return null;
}
function ajax(doc, callback, args) {
	if (typeof(args)==='undefined') args = "";
	var xhr = xhrObj();
	if(xhr) {
		xhr.onreadystatechange=function() {
			if (xhr.readyState==4 && xhr.status==200) {
				window[callback](xhr.responseText, args);
			}
		}
		xhr.open("GET", doc, true);
		xhr.send();
	} else {
		alert("Stödjer inte Ajax");
	}
}
