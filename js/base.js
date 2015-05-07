window.innerHeight = window.innerHeight || document.documentElement.clientHeight;
function o(ut) {
	document.getElementById("out").innerHTML = document.getElementById("out").innerHTML+"<br />"+ut;
	//alert(ut);
}
function obj(object) {
	if(document.getElementById(object) != null) {
		return document.getElementById(object);
	} else {
		return false;
	}
}
var dialogObj;
function dialog(txt, object) {
	if(dialogObj !== object) {
		dialogObj = object;
		obj("dialog").children[0].children[0].innerHTML = txt;
		obj("dialog").style.display = "block";
		obj("dialog").style.opacity = 1;
		event.preventDefault();
		return false;
	} else {
		alert("go");
	}
}
function dialogFinish(mode) {
	obj("dialog").style.opacity = 0;
	setTimeout(function() {
		obj("dialog").style.display = "none";
	}, 510);
	if(mode === true) {
		dialogObj.click();
	}
}
function fader(state) {
	if(typeof state == "undefined") {
		if(obj("grey").classList.contains("off")) {
			obj("grey").classList.remove("off");
		obj("grey").style.display = "none";
		} else {
		obj("grey").style.display = "block";
			obj("grey").classList.add("off");
		}
	} else if(state == "on") {
		obj("grey").style.display = "block";
		obj("grey").classList.remove("off");
	} else {
		obj("grey").classList.add("off");
		obj("grey").style.display = "none";
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
	if(typeof e != "undefined") {
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
	if(typeof e != "undefined") {
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
	setTimeout(function(){
		var y = obj("popup").style.top.substr(0, obj("popup").style.top.length-2);
		var x = obj("popup").style.left.substr(0, obj("popup").style.left.length-2);
		if(x < 0) {
			obj("popup").style.left = "0px";
		}
		if(y < 0) {
			obj("popup").style.top = "0px";
		}
	}, 60);
	setTimeout(function(){
		var y = obj("popup").style.top.substr(0, obj("popup").style.top.length-2);
		var x = obj("popup").style.left.substr(0, obj("popup").style.left.length-2);
		if(x < 0) {
			obj("popup").style.left = "0px";
		}
		if(y < 0) {
			obj("popup").style.top = "0px";
		}
	}, 110);
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
var menuList = [];
var menuTimer = "";
var menuCurrentPage = "";
var menuNextPage = "";
var prePage = "";
var transitionSpeed = 200;
var resetTimer = "";
function submenu(id) {
	if(menuNextPage === "") {
		menuNextPage = menuCurrentPage;
	}
	if(id !== menuNextPage) {
		if(typeof event !== "undefined") {
			if(event.fromElement === null) {
				var from = "LI";
			} else {
				var from = event.fromElement.tagName;
			}
			var currentTarget = event.currentTarget.tagName;
		} else {
			var currentTarget = "LI";
			var from = "LI";
		}
		if((currentTarget === "LI") && (from !== "A")) {
			if(menuTimer === "") {
				var object = obj("menu").childNodes[1];
				menuNextPage = id;
				resetResetTimer();
				var speed = transitionSpeed;
				if(prePage === "none") {
					speed = 0;
				} else {
					object.style.maxHeight = "0px";
				}
				if(id !== "none") {
					if(speed !== 0) {
						menuTimer = setTimeout(function() {
							for(var c = 0; c < obj("menu").children[1].children.length; c++) {
								obj("menu").children[1].children[c].style.display = "none";
							}
							if(menuNextPage !== "none") {
								obj("sub"+menuNextPage).style.display = "block";
							}
							object.style.maxHeight = "100px";
							menuTimer = setTimeout(function() {
								menuTimer = "";
							}, transitionSpeed);
						}, speed);
					} else {
						for(var c = 0; c < obj("menu").children[1].children.length; c++) {
							obj("menu").children[1].children[c].style.display = "none";
						}
						if(menuNextPage !== "none") {
							obj("sub"+menuNextPage).style.display = "block";
						}
						object.style.maxHeight = "100px";
						menuTimer = "";
					}
				}
			}
			prePage = id;
		}
	}
}
function resetResetTimer() {
	if(resetTimer !== null) {
		clearTimeout(resetTimer);
	}
	resetTimer = setTimeout(function() {
		submenu(menuCurrentPage);
	}, 2000);
}

function str_replace(find, replace, str) {
	while(str.indexOf(find) != -1) {
		str = str.replace(find, replace);
	}
	return str;
}
function formatContent(string) {
	return;
}

function scrollDistance() {
    var doc = document, w = window;
    var x, y, docEl;
    
    if ( typeof w.pageYOffset === 'number' ) {
        x = w.pageXOffset;
        y = w.pageYOffset;
    } else {
        docEl = (doc.compatMode && doc.compatMode === 'CSS1Compat')?
                doc.documentElement: doc.body;
        x = docEl.scrollLeft;
        y = docEl.scrollTop;
    }
    return {x:x, y:y};
}
function updUpdateButton(url, version) {
	ajax("http://"+url+"/version.php", "GET", "updUpdateButton2", [url, version]);
	ajax("http://"+url+"/news.php", "GET", "updNews");
}
function updUpdateButton2(txt, args) {
	if(txt > args[1]) {
		obj("updateButton").innerHTML = "<a href=\"http://"+args[0]+"/update\" target=\"_blank\" class=\"but_spin\"><img src=\"img/update.png\" class=\"imgbutton\" onmouseover=\"popup('Uppdatera ModiWeb');\"></a>";
	} else {
		obj("updateButton").innerHTML = "<img src=\"img/update_disabled.png\" class=\"imgbutton\" onmouseover=\"popup('Ni har den senaste versionen');\">";
	}
}
function updNews(txt) {
	obj("news").innerHTML = txt;
}
function openTab(o) {
	for(var c = 0; c < o.parentNode.parentNode.children.length; c++) {
		if(o.parentNode === o.parentNode.parentNode.children[c]) {
			if(o.parentNode.classList.contains("openedTab")) {
				o.parentNode.parentNode.children[c].classList.remove("openedTab");
			} else {
				o.parentNode.classList.add("openedTab");
			}
		} else {
			o.parentNode.parentNode.children[c].classList.remove("openedTab");
		}
	}
}
var baseTime = 3000;
function fadeNotice() {
	if(obj("msg") !== false) {
		if((noticeTimer1 !== null) || (noticeTimer2 !== null)) {
			clearTimeout(noticeTimer1);
			clearTimeout(noticeTimer2);
			obj("msg").style.opacity = 1;
		}
		noticeTimer1 = setTimeout(function() {
			obj("msg").style.opacity = 0;
		}, baseTime+(obj("msg").innerHTML.length*15));
		noticeTimer2 = setTimeout(function() {
			obj("msg").parentNode.removeChild(obj("msg"));
		}, baseTime+1000+(obj("msg").innerHTML.length*15));
	}
}


function recStatistics() {
	//ajax("functions/recordstatistic.php"+statVar, "GET", "formatContent");//popup
}
function loaded(page) {
	if(page == "pages") {
		tools_init();
	}
}
var loadedVar = "";
var pageeditcontent = "";
var editElements = 0;
var noticeTimer1;
var noticeTimer2;
window.onload = function() {
	var menu = obj("menu").cloneNode(true);
	obj("header").appendChild(menu);
	menu.id = "floatingMenu";
	menu.style.position = "fixed";
	menu.style.top = "0px";
	menu.style.display = "none";
	document.onscroll = function() {
		if(scrollDistance().y > obj("headerContent").clientHeight) {
			obj("floatingMenu").style.display = "block";
		} else {
			obj("floatingMenu").style.display = "none";
		}
	};
	fadeNotice();
	document.body.style.padding = "0px 0px "+(obj("footer").clientHeight)+"px";
	loaded(loadedVar);
	recStatistics();
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
		if(data !== false) {
			if(typeof data === "string") {
				xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			}
			xhr.send(data);
		} else {
			xhr.send();
		}
	} else {
		alert("Stödjer inte Ajax");
	}
}
