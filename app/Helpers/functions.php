<?php

function convertToListItems( $string )
{
	$string = explode("\n", preg_replace("/[\r\n]+/", "\n", $string));

	$list_of_ingredients = array_map(function($item) {
		return '<li>' . $item . '</li>';
	}, $string);

	return implode('', array_values($list_of_ingredients));
}

function user()
{
	return auth()->user();
}

function styleTimestamp( $path )
{
	try {
		$timestamp = '?v=' . File::lastModified(public_path() . $path);
	}
	catch (Exception $e)
	{
		$timestamp = '';
	}
	return '<link rel="stylesheet" href="' . $path . $timestamp . '">';
}

function scriptTimestamp( $path )
{
	try {
		$timestamp = '?v=' . File::lastModified(public_path() . $path);
	}
	catch (Exception $e)
	{
		$timestamp = '';
	}
	return '<script defer type="text/javascript" src="' . $path . $timestamp . '"></script>';
}