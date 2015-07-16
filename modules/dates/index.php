<?php
class dates {
	static private $calId = 0;
	static public function timeSince($timestamp) {
		$time = time()-strtotime($timestamp);
		$tokens = array (
			31536000 => 'y',
			2592000 => 'm',
			604800 => 'w',
			86400 => 'd',
			3600 => 'h',
			60 => 'min',
			1 => 'sec'
		);
		$ret = "";
		$strings = [
			"y" => ["år", "år"],
			"m" => ["månad", "månader"],
			"w" => ["vecka", "veckor"],
			"d" => ["dag", "dagar"],
			"h" => ["timme", "timmar"],
			"min" => ["minut", "minuter"],
			"sec" => ["sekund", "sekunder"],
		];
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			if($numberOfUnits > 1) {
				$str = $strings[$text][1];
			} else {
				$str = $strings[$text][0];
			}
			$ret = $numberOfUnits." ".$str." sedan";
			break;
		}
		return $ret;
	}
	static public function calendar($jsCall = false, $pickable = false, $withTime = false, $startDate = false, $pickedDate = false, $changeable = true, $justTable = false) {
		if(!isset($startDate)) {
			$startDate = date("Ymd");
		} elseif($startDate === false) {
			$startDate = date("Ymd");
		}
		if(!isset($pickedDate)) {
			$pickedDate = "00000000";
		} elseif($pickedDate === false) {
			$pickedDate = "00000000";
		}
		if($pickable === false) {
			$pickable = "";
		} else {
			$pickable = " pickabledate";
		}
		if($jsCall === false) {
			$jsCall = "";
		}
		$ret = "";
		$initialClock = date("Hi");
		if($justTable !== true) {
			$ret .= "<div id=\"calendar".self::$calId."\" class=\"calendar".$pickable."\">";
		}
		$year = substr($startDate, 0, 4);
		$month = substr($startDate, 4, 2);
		$day = substr($startDate, 6, 2);
		if($day === false) {
			$day = 1;
		}
		$startTime = mktime(0,0,0,$month,$day,$year);
		$prevMonth = strtotime("-1 month", $startTime);
		$nextMonth = strtotime("+1 month", $startTime);
		if(($changeable === true) && ($justTable === false)) {
			$ret .= "<div class=\"calendarYear\">
				<div><img src=\"img/arrow_15_left.png\" onclick=\"calendar_changeYear(this.parentNode.parentNode.parentNode, '-', '".$jsCall."');\"></div>
				<p>".date("Y", $startTime)."</p>
				<div><img src=\"img/arrow_15_right.png\" onclick=\"calendar_changeYear(this.parentNode.parentNode.parentNode, '+', '".$jsCall."');\"></div>
			</div>";
			$ret .= "<div class=\"calendarMonth\">
				<div><img src=\"img/arrow_15_left.png\" onclick=\"calendar_changeMonth(this.parentNode.parentNode.parentNode, '-', '".$jsCall."');\"></div>
				<h3>".date("F", $startTime)."</h3>
				<div><img src=\"img/arrow_15_right.png\" onclick=\"calendar_changeMonth(this.parentNode.parentNode.parentNode, '+', '".$jsCall."');\"></div>
			</div>";
		}
		$fdotm = mktime(0,0,0,$month,1,$year);
		$dotw = date("N", $fdotm)-1;
		if($dotw !== 0) {
			$counterDay = -$dotw;
		} else {
			$counterDay = 0;
		}
		if($justTable === false) {
			$ret .= "<input type=\"hidden\" value=\"".$year."\">";
			$ret .= "<input type=\"hidden\" value=\"".$month."\">";
		}
		if($justTable === false) {
			$ret .= "<script>
				var selectedDate = '".$startDate."';
				var calendar_months = [];";
			for($c = 1; $c <= 12; $c++) {
				$ret .= "calendar_months[".$c."] = '".date("F", mktime(0,0,0,$c,1,2000))."';
";
			}
			$ret .= "
			</script>";
		}
		$ret .= "<table id=\"calendarTable\">";
		$cDay = $counterDay+1;
		$ret .= "<tr>";
		$weekdays = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
		for($weekday = 1; $weekday <= 7; $weekday++) {
			$ret .= "<th style=\"text-align: center;\"><p>".lang::getText($weekdays[$weekday-1]."_extrashort")."</p></th>";
		}
		$ret .= "</tr>";
		for($week = 1; $week <= 6; $week++) {
			$ret .= "<tr>";
			for($weekday = 1; $weekday <= 7; $weekday++) {
				if($cDay <= 0) {
					$ret .= "<td class=\"dateSquare otherMonth\"><p>".(date("t", $prevMonth)-(-$cDay))."</p></td>";
				} elseif($cDay > date("t", $startTime)) {
					$ret .= "<td class=\"dateSquare otherMonth\"><p>".($cDay-date("t", $startTime))."</p></td>";
				} else {
					$classes = [];
					if(($year.str_pad($month, 2, "0", STR_PAD_LEFT).str_pad($cDay, 2, "0", STR_PAD_LEFT)) === $pickedDate) {
						array_push($classes, "pickedDate");
					}
					if(($year.str_pad($month, 2, "0", STR_PAD_LEFT).str_pad($cDay, 2, "0", STR_PAD_LEFT)) === date("Ymd")) {
						array_push($classes, "currentDate");
					}
					$classTxt = "";
					if(count($classes) > 0) {
						$classTxt = " class=\"".implode(" ", $classes)."\"";
					}
					$ret .= "<td class=\"dateSquare\"><p".$classTxt;
					if($pickable !== "") {
						$ret .= " onclick=\"{
						for(var y = 0; y < this.parentNode.parentNode.parentNode.children.length; y++) {
							for(var x = 0; x < this.parentNode.parentNode.children.length; x++) {
								this.parentNode.parentNode.parentNode.children[y].children[x].children[0].classList.remove('pickedDate');
							}
						}
						this.classList.add('pickedDate');
						selectedDate = '".$year.str_pad($month, 2, "0", STR_PAD_LEFT).str_pad($cDay, 2, "0", STR_PAD_LEFT)."';";
						if($withTime === true) {
							$ret .= $jsCall."(calendar_setDateAndTime(selectedDate, this.parentNode.parentNode.parentNode.parentNode.parentNode.children[6].children[0].value));";
						} else {
							$ret .= $jsCall."(calendar_setDate(selectedDate));";
						}
						$ret .= "}\"";
					}
					$ret .= ">".$cDay."</p></td>";
				}
				$cDay++;
			}
			$ret .= "</tr>";
		}
		$ret .= "</table>";
		if($justTable === false) {
			if($withTime === true) {
				$ret .= "<p>".lang::getText("time").": <input id=\"testId\" type=\"text\" value=\"".$initialClock."\" onchange=\"".$jsCall."(calendar_setDateAndTime(selectedDate, this.parentNode.parentNode.children[6].children[0].value));\" oninput=\"".$jsCall."(calendar_setDateAndTime(selectedDate, this.parentNode.parentNode.children[6].children[0].value));\" onkeyup=\"".$jsCall."(calendar_setDateAndTime(selectedDate, this.parentNode.parentNode.children[6].children[0].value));\" size=4></p>";
			}
			$ret .= "</div>";
		}
		self::$calId ++;
		return $ret;
	}
}
