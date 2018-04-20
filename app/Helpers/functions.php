<?php

function convertToListItems( $string )
{
	$string = explode("\n", preg_replace("/[\r\n]+/", "\n", $string));
	$list_of_ingredients = implode('', array_values($list_of_ingredients));

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
	return '<script defer type="text/javascript" src="' . $path . $timestamp . '"></script>';
}