<?php

function reloadPage() {
	echo '<div style="display:none;"><meta http-equiv="refresh" content="0"></div>';
}

function convertToListItems($string) {
	$list_of_ingredients = '';
	$string = preg_replace("/[\r\n]+/", "\n", $string);
	$string = explode("\n", $string);
	foreach ($string as $item) {
		$list_of_ingredients .= '<li>' . $item . '</li>';
	}
	return $list_of_ingredients;
}