function addImage_updSubtext() {
	obj("subText").innerHTML = obj("imagealt").value;
}
function addImage_errorUrl() {
	obj("customUrl").value = "";
	obj("currentImage").src = "img/tools_emptyimage.png";
}
function editImage_save(id) {
	if(obj("imagename").value.length == "") {
		popup("Du måste fylla i ett namn");
	} else if(obj("imagename").value.length < 3) {
		popup("För kort namn");
	} else if(obj("imagename").value.length > 54) {
		popup("För långt namn");
	} else if(obj("imagealt").value.length < 3) {
		popup("För kort alternativ text");
	} else {
		popup("Sparar bild...");
		fader("on");
		ajax("functions/updimage.php?id="+id+"&name="+obj("imagename").value+"&alt="+obj("imagealt").value, "GET", "editImage_saved");
	}
}
function editImage_saved(txt) {
	if(txt == "ok") {
		popup("Bilden har uppdaterats");
		setTimeout(function() {
			window.location.replace("admin_images");
		}, 2000);
	} else {
		popup(txt.substr(6));
		setTimeout(function() {
			fader("off");
		}, 100);
	}
}