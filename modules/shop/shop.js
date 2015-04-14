function shop_shoppingCartAdd(name, url, price) {
	ajax("modules/shop/addtocart.php?name="+name+"&url="+url, "GET", "shop_shoppingCartAdd2", [name, url, price]);
	//shop_shoppingCartAdd2("true", [name, url, price]);
}
function shop_shoppingCartAdd2(txt, args) {
	if(txt === "true") {
		shop_addToCart(args[0], args[1], args[2]);
	} else {
		alert("Det gick inte att lägga till produkten i kundvagnen. Försök gärna igen.");
	}
}
function shop_addToCart(name, url, price) {
	var cart = obj("shoppingCartList");
	var mode = "list";
	var start = obj("cartTotPrice").innerHTML.indexOf(" ")+1;
	var tot = obj("cartTotPrice").innerHTML.substring(start, obj("cartTotPrice").innerHTML.indexOf(" ", start));
	var currency = obj("cartTotPrice").innerHTML.substring(obj("cartTotPrice").innerHTML.indexOf(" ", start))
	tot = Math.round((parseFloat(tot)+price)*100)/100;
	obj("cartTotPrice").innerHTML = "Totalt "+tot+" "+currency;
	if(cart.children[0].tagName !== "P") {
		if(cart.children[0].children[0].children.length === 4) {
			cart.innerHTML = "<p>4 produkter</p>";
		} else {
			var tobj = cart.children[0].children[0].children[0].children[0];
		}
	}
	if(cart.children[0].tagName === "P") {
		if(cart.children[0].innerHTML === "Inga produkter") {
			cart.innerHTML = "<table><tbody></tbody></table>";
		}else {
			var count = cart.innerHTML.substring(3, cart.innerHTML.indexOf(" ", 3));
			mode = "count";
		}
	}
	if(mode === "list") {
		var p = document.createElement("A");
		var hid = document.createElement("INPUT");
		hid.type = "hidden";
		hid.id = "price"+cart.children.length;
		hid.value = price;
		var td = document.createElement("TD");
		var tr = document.createElement("TR");
		var td2 = document.createElement("TD");
		td2.innerHTML = "<img src=\"img/button_minus_15.png\" class=\"imgbutton\" onclick=\"shop_shoppingCartRemove('"+url+"');\">";
		p.innerHTML = name;
		p.href = "p_"+url;
		p.style.display = "block";
		td.appendChild(p);
		td.appendChild(hid);
		tr.appendChild(td2);
		tr.appendChild(td);
		cart.children[0].children[0].appendChild(tr);
	} else {
		count = parseInt(count)+1;
		cart.innerHTML = "<p>"+count+" produkter</p>";
	}
	obj("shoppingCart").style.background = "#8f8";
	obj("shoppingCart").style.boxShadow = "0 0 50px #fff";
	clearTimeout(shop_colorTimeout);
	shop_colorTimeout = setTimeout(function() {
		obj("shoppingCart").style.background = "#fff";
		obj("shoppingCart").style.boxShadow = "0 0 0px #fff";
	}, 400);
}
function shop_shoppingCartRemove(url) {
	ajax("modules/shop/delcart.php?url="+url, "GET", "shop_shoppingCartRemove2", url);
	//shop_shoppingCartAdd2("true", [name, url, price]);
}
var shop_colorTimeout;
function shop_shoppingCartRemove2(txt, url) {
	for(var c = 0; c < obj("shoppingCartList").children[0].children[0].children.length; c++) {
		var o = obj("shoppingCartList").children[0].children[0].children[c];
		var link = o.children[1].children[0].href;
		link = link.substring(link.indexOf("p_")+2);
		if(url === link) {
			o.parentNode.removeChild(o);
			var cart = obj("shoppingCartList");
			var start = obj("cartTotPrice").innerHTML.indexOf(" ")+1;
			var tot = obj("cartTotPrice").innerHTML.substring(start, obj("cartTotPrice").innerHTML.indexOf(" ", start));
			var currency = obj("cartTotPrice").innerHTML.substring(obj("cartTotPrice").innerHTML.indexOf(" ", start));
			var price = o.children[1].children[1].value;
			tot = Math.round((parseFloat(tot)-price)*100)/100;
			obj("cartTotPrice").innerHTML = "Totalt "+tot+" "+currency;
			clearTimeout(shop_colorTimeout);
			if(obj("shoppingCartList").children[0].children[0].children.length === 0) {
				obj("shoppingCartList").innerHTML = "Inga produkter";
				obj("shoppingCart").style.background = "#f88";
				obj("shoppingCart").style.boxShadow = "0 0 50px #fff";
				shop_colorTimeout = setTimeout(function() {
					obj("shoppingCart").style.background = "#fff";
					obj("shoppingCart").style.boxShadow = "0 0 0px #fff";
				}, 400);
			} else {
				obj("shoppingCart").style.background = "#fcc";
				obj("shoppingCart").style.boxShadow = "0 0 50px #fff";
				shop_colorTimeout = setTimeout(function() {
					obj("shoppingCart").style.background = "#fff";
					obj("shoppingCart").style.boxShadow = "0 0 0px #fff";
				}, 400);
			}
			break;
		}
	}
	if(obj("shoppingCartList").children.length === 0) {
		obj("shoppingCartList").innerHTML = "<p>Inga produkter</p>";
	}
}
