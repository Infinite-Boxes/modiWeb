function addDrag(obj) {
	
}
function init() {
	var headerDrag = document.getElementById("headerDrag");
	headerDrag.addEventListener("click", function() {
		startDrag(headerDrag);
	});
}
window.addEventListener("load", init);