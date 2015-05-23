<?php
class date {
	static private $_monthes = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	static public function dateFromDatepick($date) {
		//Nice?)
		return date('Y-m-d H:i:s', strtotime($date));
	}
	static public function dateToDatepick($date) {
		//not really?)
		return date('Y-m-d H:i', strtotime($date));
	}
}