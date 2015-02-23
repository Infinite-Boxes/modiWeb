function o(ut) {
	document.getElementById("lol").innerHTML = ut;
}
function edit(id) {
	ajax("modules/elements/gettexts.php?id="+id, "editFinal");
	document.getElementById("admineditid").value = id;
	show("adminedit", "show");
	document.getElementById("adminedittextarea").focus();
}
function editFinal(txt) {
	document.getElementById("adminedittextarea").value = txt;
}
var elements = [];
function full(element) {
	var o = document.getElementById(element).style;
	if(o.width != "100%") {
		o.left = "150px";
		o.top = "100px";
		o.width = "100%";
		o.height = window.innerHeight+"px";
		document.getElementById(element).childNodes[1].childNodes[7].childNodes[1].style.height = (window.innerHeight-80)+"px";
		document.getElementById(element).childNodes[1].childNodes[7].childNodes[1].style.width = "100%";
	} else {
		o.left = "50%";
		o.top = "50%";
		o.width = "auto";
		o.height = "200px";
		document.getElementById(element).childNodes[1].childNodes[7].childNodes[1].style.height = "100%";
	}
}
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
		if(type === "show") {
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
