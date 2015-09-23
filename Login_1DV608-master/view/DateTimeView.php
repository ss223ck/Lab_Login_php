<?php

class DateTimeView {


	public function show() {

		$timeArray = getdate();
		$timeString = $timeArray["weekday"] . ', the ' . date('jS') . ' of '. $timeArray["month"] .' '. $timeArray["year"] .
		', The time is ' . $timeArray["hours"] . ':'. $timeArray["minutes"] .':'. $timeArray["seconds"];

		return '<p>' . $timeString . '</p>';
	}
}