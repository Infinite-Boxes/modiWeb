function dates_dayToWeekday(day) {
	if(day === 0) {
		day += 7;
	}
	return day-1;
}

function calendar_updCalendarText(element, year, month) {
	month = parseInt(month);
	element.children[2].value = year;
	element.children[3].value = month;
	element.children[0].children[1].innerHTML = year;
	element.children[1].children[1].innerHTML = calendar_months[month];
	var loadTxt = document.createElement("DIV");
	var w = element.children[5].offsetWidth;
	var h = element.children[5].offsetHeight;
	loadTxt.innerHTML = "<img style='margin-top: 25px;' src='img/loading_40_ani.gif'>";
	element.replaceChild(loadTxt, element.children[5]);
	element.children[5].style.width = w+"px";
	element.children[5].style.height = h+"px";
	element.children[5].style.textAlign = "center";
}
function calendar_setDate(date) {
	return date.substr(0, 4)+"-"+date.substr(4, 2)+"-"+date.substr(6, 2);
}
function calendar_setDateAndTime(date, time) {
	if(time.match(/[a-z]/i)) {
		time = "ERROR";
	}
	if(time.length < 4) {
		if(time.length < 3) {
			time = "ERROR";
		} else {
			time = "0"+time;
		}
	} else if((time > 2459) || (time.length > 4)) {
		time = "ERROR";
	} else if(parseInt(time.substr(2, 2)) > 59) {
		time = "ERROR";
	}
	if(time !== "ERROR") {
		time = time.substr(0, 2)+":"+time.substr(2, 2);
	}
	return date.substr(0, 4)+"-"+date.substr(4, 2)+"-"+date.substr(6, 2)+" "+time;
}
function calendar_changeYear(element, dir, recall) {
	year = element.children[2].value;
	month = element.children[3].value;
	if(dir === "+") {
		year ++;
	} else if(dir === "-") {
		year --;
	}
	date = year+month;
	calendar_updCalendarText(element, year, month);
	calendar_goDate(element, date, selectedDate, recall);
}
function calendar_changeMonth(element, dir, recall) {
	year = element.children[2].value;
	month = element.children[3].value;
	if(dir === "+") {
		month++;
		if(month > 12) {
			year++;
			month = 1;
		}
	} else if(dir === "-") {
		month--;
		if(month < 1) {
			year--;
			month = 12;
		}
	}
	date = year+month;
	calendar_updCalendarText(element, year, month);
	calendar_goDate(element, date, selectedDate, recall);
}
function calendar_goDate(element, date, pdate, recall) {
	ajax("func_dates_gets?gettype=calendarMove&date="+date+"&pdate="+pdate+"&recall="+recall, "GET", "calendar_updateCalendarElement", [element]);
}
function calendar_updateCalendarElement(txt, element) {
	var newObj = document.createElement("DIV");
	newObj.innerHTML = txt;
	element[0].replaceChild(newObj, element[0].children[5]);
}
