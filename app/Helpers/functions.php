<?php

function customStripTags($str) {
	$allowed = '<h1><h2><h3><h4><h5><h6><p><br><br /><b><li><ol><ul><strong><span>';
	return strip_tags($str, $allowed);
}

function convertToListItems($str) {
	$string = strip_tags($str, '<li>');

	// Convert from string to array
	$array = explode("\n", preg_replace("/[\r\n]+/", "\n", $string));

	// Every array item wrapping with <li> tags
	$list_of_ingredients = array_map(function($item) {
		return '<li>' . $item . '</li>';
	}, $array);

	// Converting array back to string
	return implode('', array_values($list_of_ingredients));
}


function user() {
	return auth()->user();
}


function locale() {
	return app()->getLocale();
}

function selectedIfEqual($number1, $number2) {
	return $number1 === $number2 ? 'selected' : '';
}

function styleTimestamp($path) {
	try {
		$timestamp = '?v=' . File::lastModified(public_path() . $path);
	}
	catch (Exception $e)
	{
		$timestamp = '';
	}
	return '<link rel="stylesheet" href="' . $path . $timestamp . '">';
}


function scriptTimestamp( $path ) {
	try {
		$timestamp = '?v=' . File::lastModified(public_path() . $path);
	}
	catch (Exception $e)
	{
		$timestamp = '';
	}
	return '<script type="text/javascript" src="' . $path . $timestamp . '"></script>';
}


function activeIfRouteIs($route) {
    return request()->is($route) ? 'active' : '';
}

function setImageName($extension = null, $slug = '') {
	if ($extension) {
		return time() . '-' . $slug . '.' . $extension;
	}
	return 'default.jpg';
}

function getRatingNumber($recipes, $likes) {
	$points_for_recipes = count($recipes);
	$points_for_likes = $likes / 10;

	$result = $points_for_recipes + $points_for_likes;

	return number_format($result, 1);
}

function readableNumber($number) {
	if ($number >= 1000 && $number < 1000000):
		$number = substr($number, 0, -3) . '<br /><small>' . trans('users.thousand') . '</small>';
	elseif ($number >= 1000000):
		$number = substr($number, 0, -6) . '<br /><small>' . trans('users.million') . '</small>';
	endif;

	return $number;
}

function getOnlineIcon($value) {
	$seconds = [trans('date.second'), trans('date.seconds'), trans('date.seconds2')];
	$url_string = explode(' ', $value);

	if (in_array($url_string[1], $seconds)) {
		return '<span class="online-icon-on"></span>';
	}
	return '<span class="online-icon-off"></span>';
}

function getDataNotifMarkup($data) {
	return !empty($data) ? 'data-notif=' . $data : '';
}