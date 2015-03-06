function addImage_updateChosen(typ) {
	if(typ === false) {
		obj("currentImage").src = obj("currentUrl").value;
		obj("customUrl").value = "";
	} else if(typ == "custom") {
		obj("currentImage").src = obj("customUrl").value;
		var option = document.createElement("option");
		fil = obj("customUrl").value.split("/");
		option.text = fil[fil.length-1];
		option.value = obj("customUrl").value;
		obj("currentUrl").add(option);
		obj("currentUrl").selectedIndex = obj("currentUrl").length-1;
	}
}
function addImage_updSubtext() {
	if(obj("imagetextunder").value != "") {
		obj("subText").style.display = "block";
		obj("subText").innerHTML = obj("imagetextunder").value;
	} else {
		obj("subText").style.display = "none";
	}
}
function addImage_errorUrl() {
	obj("customUrl").value = "";
	obj("currentImage").src = "img/tools_emptyimage.png";
}
function uploadImage() {
	if(ajaxSupport() === true) {
		var file = obj("uploadFile").files[0];
		if(typeof file !== "undefined") {
			var name = file.name;
			obj("uploadWindow").innerHTML = "Laddar upp \""+name+"\". Stäng inte sidan!";
			
			var formData = new FormData();
			if (!file.type.match('image.*')) {
				obj("uploadWindow").innerHTML = "Filen är inte en bild";
			} else {
				formData.append("uploadFile", file, file.name);
				ajax("functions/uploadimage.php", "POST", "uploadDone", "", formData);
			}
		} else {
		popup("saveImage", "Ingen fil vald att ladda upp");
		}
		event.preventDefault();
		return false;
	}
}
function uploadDone(txt) {
	if(txt.substr(0, 6) == "ERROR_") {
		obj("uploadWindow").innerHTML = txt.substr(6);
	}else {
		obj("uploadWindow").innerHTML = "Uppladdningen lyckades!";
		var option = document.createElement("option");
		fil = txt.split(":::");
		option.text = fil[1];
		option.value = fil[0];
		obj("currentUrl").add(option);
		obj("currentUrl").selectedIndex = obj("currentUrl").length-1;
		addImage_updateChosen(false);
	}
}
function addImage_add() {
	if(obj("currentUrl").value == "") {
		popup("Ingen fil vald");
	} else if(obj("imagename").value.length == "") {
		popup("Du måste fylla i ett namn");
	} else if(obj("imagename").value.length < 3) {
		popup("För kort namn");
	} else if(obj("imagename").value.length > 54) {
		popup("För långt namn");
	} else if(obj("imagealt").value.length < 3) {
		popup("För kort alternativ text");
	} else {
		ajax("functions/addimage.php?file="+obj("currentUrl").value+"&name="+obj("imagename").value+"&alt="+obj("imagealt").value+"&sub="+obj("imagetextunder").value, "GET", "addImage_added");
	}
}
function addImage_added(txt) {
	if(txt == "ok") {
		popup("Bilden har registrerats");
		obj("currentUrl").remove(obj("currentUrl").selectedIndex);
		addImage_updateChosen(false);
		obj("imagename").value = "";
		obj("uploadForm").reset();
	} else {
		popup(txt.substr(6));
	}
}