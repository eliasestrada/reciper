<?php

function convertToListItems( $string )
{
	$list_of_ingredients = '';
	$string = preg_replace("/[\r\n]+/", "\n", $string);
	$string = explode("\n", $string);
	foreach ($string as $item) {
		$list_of_ingredients .= '<li>' . $item . '</li>';
	}
	return $list_of_ingredients;
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
	return '<script type="text/javascript" src="' . $path . $timestamp . '"></script>';
}