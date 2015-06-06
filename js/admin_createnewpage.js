var menuItem = false;
var sub = false;
var originLink = false;
function createMenuItem() {
	if(menuItem !== false) {
		menuItem.parentNode.removeChild(menuItem);
		menuItem = false;
	}
	if(originLink !== false) {
		for(var c = 0; c < obj("menu").children[0].children[0].children.length; c++) {
			if(obj("menu").children[0].children[0].children[c].children[0].getAttribute("href") === obj("menuItemSub").value) {
				obj("menu").children[0].children[0].children[c].setAttribute("onmouseover", "submenu('none');");
				originLink = false;
			}
		}
	}
	var appendTo = obj(menuid).children[0];
	if(obj("menuItemSub").value !== "null") {
		obj("submenus").appendChild(obj("sub"+obj("menuItemSub").value));
		appendTo = obj("sub"+obj("menuItemSub").value);
		for(var c = 0; c < obj("menu").children[0].children[0].children.length; c++) {
			if(obj("menu").children[0].children[0].children[c].children[0].getAttribute("href") === obj("menuItemSub").value) {
				originLink = obj("menu").children[0].children[0].children[c].getAttribute("onmouseover");
				obj("menu").children[0].children[0].children[c].setAttribute("onmouseover", "submenu('"+obj("menuItemSub").value+"');");
			}
		}
	}
	if(obj("menuItemName").value !== "") {
		menuItem = document.createElement("LI");
		var a = document.createElement("A");
		menuItem.appendChild(a);
		menuItem.classList.add("td");
		menuItem.classList.add("link");
		menuItem.classList.add("markedMenu");
		a.href = "#";
		a.innerHTML = obj("menuItemName").value;
		if(obj("menuItemOrder").value !== "") {
			var pos = false;
			for(var c = 0; c < appendTo.children[0].children.length; c++) {
				if(pos === false) {
					var url = appendTo.children[0].children[c].children[0].getAttribute("href");
					if(orderList[url] > obj("menuItemOrder").value) {
						pos = c;
					}
				}
			}
			if(pos !== false) {
				appendTo.children[0].insertBefore(menuItem, obj(menuid).children[0].children[0].children[pos]);
			} else {
				appendTo.children[0].appendChild(menuItem);
			}
		} else {
			appendTo.children[0].appendChild(menuItem);
		}
	}
}