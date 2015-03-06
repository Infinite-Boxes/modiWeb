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
		if(object.parentNode.children[1].classList.contains("groupcontentDisabled")) {
			object.parentNode.children[1].classList.remove("groupcontentDisabled");
		} else {
			object.parentNode.children[1].classList.add("groupcontentDisabled");
		}
	}
}
var popupTimer1 = false;
var popupTimer2 = false;
function popup(txt) {
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
	var e = event;
	if(typeof e.clientX != "undefined") {
		popupTimer1 = setTimeout(function(){
			obj("popup").style.opacity = 0;
			popupTimer1 = false;
		}, 2500);
		popupTimer2 = setTimeout(function(){
			obj("popup").style.display = "none";
			popupTimer2 = false;
		}, 3000);
	} else {
		popupTimer1 = setTimeout(function(){
			obj("popup").style.opacity = 0;
			popupTimer1 = false;
		}, 4500);
		popupTimer2 = setTimeout(function(){
			obj("popup").style.display = "none";
			popupTimer2 = false;
		}, 5000);
	}
	if(typeof e.clientX != "undefined") {
		setTimeout(function(){
			var yp = ((e.clientY - 30) - obj("popup").offsetHeight);
			var xp = (e.clientX - (obj("popup").offsetWidth / 2));
			if(yp < 0) {
				yp = 0;
			}
			obj("popup").style.top = yp+"px";
			obj("popup").style.left = xp+"px";
		}, 1);
	} else {
		setTimeout(function(){
			obj("popup").style.top = "50%";
			obj("popup").style.left = "50%";
		}, 1);
	}
}
function hidePopup() {
	clearTimeout(popupTimer1);
	clearTimeout(popupTimer2);
	obj("popup").style.opacity = 0;
	popupTimer1 = false;
	popupTimer2 = setTimeout(function(){
		obj("popup").style.display = "none";
		popupTimer2 = false;
	}, 500);
}
function edit(id) {
	ajax("modules/elements/gettexts.php?id="+id, "GET", "editFinal");
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
function ajaxSupport() {
	if(xhrObj() == false) {
		return false;
	} else {
		return true;
	}
}
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
    return false;
}
function ajax(doc, type, callback, args, data) {
	if (typeof(args)==='undefined') args = "";
	if (typeof(data)==='undefined') data = false;
	if (typeof(type)==='undefined') type = "GET";
	var xhr = xhrObj();
	if(xhr) {
		xhr.onreadystatechange=function() {
			if (xhr.readyState==4 && xhr.status==200) {
				window[callback](xhr.responseText, args);
			}
		}
		xhr.open(type, doc, true);
		if(data != false) {
			xhr.send(data);
		} else {
			xhr.send();
		}
	} else {
		alert("Stödjer inte Ajax");
	}
}
