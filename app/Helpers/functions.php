<?php

function convertToListItems( $string ) {
	$string = explode("\n", preg_replace("/[\r\n]+/", "\n", $string));

	$list_of_ingredients = array_map(function($item) {
		return '<li>' . $item . '</li>';
	}, $string);

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

function setNameForRecipeImage($extension = null) {
	if ($extension) {
		return time() . '.' . $extension;
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