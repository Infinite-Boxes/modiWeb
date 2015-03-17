<?php
class dates {
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
}
