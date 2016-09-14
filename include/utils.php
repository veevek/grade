<?php


function get_or_default($arr, $key, $default) {
	if(isset($arr[$key])) {
		return $arr[$key];
	} else {
		return $default;
	}
}
