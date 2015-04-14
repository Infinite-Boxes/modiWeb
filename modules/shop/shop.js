function shop_shoppingCartAdd(name, url, price) {
	ajax("modules/shop/addtocart.php?name="+name+"&url="+url, "GET", "shop_shoppingCartAdd2", [name, url, price]);
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
	if(cart.children.length === 4) {
		cart.innerHTML = "<p>4 produkter</p>";
	}
	if(cart.innerHTML === "<p>Inga produkter</p>") {
		cart.innerHTML = "";
	} else if(cart.innerHTML.substring(cart.innerHTML.indexOf(" ", 3)+1, cart.innerHTML.indexOf(" ", 3)+10) === "produkter") {
		mode = "count";
		var count = cart.innerHTML.substring(3, cart.innerHTML.indexOf(" ", 3));
	}
	if(mode === "list") {
		var p = document.createElement("A");
		var del = document.createElement("A");
		p.innerHTML = name;
		p.href = "p_"+url;
		p.style.display = "block";
		cart.appendChild(p);
	} else {
		count = parseInt(count)+1;
		cart.innerHTML = "<p>"+count+" produkter</p>";
	}
	obj("shoppingCart").style.background = "#afa";
	obj("shoppingCart").style.boxShadow = "0 0 50px #fff";
	setTimeout(function() {
		obj("shoppingCart").style.background = "#fff";
	obj("shoppingCart").style.boxShadow = "0 0 0px #fff";
	}, 400);
}
