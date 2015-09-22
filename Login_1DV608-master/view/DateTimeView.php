<?php

class DateTimeView {


	public function show() {

		$timeArray = getdate();
		$timeString = $timeArray["weekday"] . ', the ' . $timeArray["mday"] . 'th of '. $timeArray["month"] .' '. $timeArray["year"] .
		', The time is ' . $timeArray["hours"] . ':'. $timeArray["minutes"] .':'. $timeArray["seconds"];

		return '<p>' . $timeString . '</p>';
	}
}