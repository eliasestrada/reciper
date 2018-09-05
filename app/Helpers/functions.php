<?php

/**
 * @param string $string
 * @return string
 */
function custom_strip_tags(string $string): string
{
    $allowed = '<h1><h2><h3><h4><h5><h6><p><br><br /><b><li><ol><ul><strong><span>';
    return strip_tags($string, $allowed);
}

/**
 * Takes string, adds li tags to every line separeted by "\n"
 * @param string $str
 * @return array
 */
function convert_to_array_of_list_items(?string $str): array
{
    $string = strip_tags($str, '<li>');

    // Convert from string to array
    $array = explode("\n", preg_replace("/[\r\n]+/", "\n", $string));

    // Every array item wrapping with <li> tags
    $list_of_ingredients = array_map(function ($item) {
        return '<li>' . $item . '</li>';
    }, $array);

    return array_values($list_of_ingredients);
}

// Shortcut
function user()
{
    return auth()->user();
}

// Shortcut
function lang()
{
    return app()->getLocale();
}

/**
 * @param integer $num1
 * @param integer $num2
 * @return string
 */
function set_as_selected_if_equal($num1, $num2): string
{
    return $num1 === $num2 ? 'selected' : '';
}

/**
 * Adds version to link href if it was modified
 *
 * @param string
 * @return
 */
function style_timestamp(string $path): string
{
    try {
        $timestamp = '?v=' . File::lastModified(public_path() . $path);
    } catch (Exception $e) {
        $timestamp = '';
    }
    return '<link rel="stylesheet" href="' . $path . $timestamp . '">';
}

/**
 * Adds version to script src if it was modified
 *
 * @param string
 * @return
 */
function script_timestamp(string $path): string
{
    try {
        $timestamp = '?v=' . File::lastModified(public_path() . $path);
    } catch (Exception $e) {
        $timestamp = '';
    }
    return '<script type="text/javascript" src="' . $path . $timestamp . '"></script>';
}

/**
 * @param string $route
 * @return string
 */
function active_if_route_is(string $route): string
{
    if ($route[0] == '/') {
        return request()->is(substr($route, 1)) ? 'active' : '';
    } else {
        return request()->is($route) ? 'active' : '';
    }
}

/**
 * Converts given parameters into a file name
 *
 * @param string $extention
 * @param string $slug
 * @return string
 */
function set_image_name(string $extension = null, string $slug = ''): string
{
    if ($extension) {
        return time() . '-' . $slug . '.' . $extension;
    }
    return 'default.jpg';
}

/**
 * This function is simply creates rating for user
 * --- For one recipe 1 point
 * --- For one like 0.1 point
 *
 * @param object $recipes
 * @param int $likes
 * @return float
 */
function get_rating_number($recipes, int $likes)
{
    $points_for_recipes = count($recipes);
    $points_for_likes = ($likes > 0) ? $likes / 10 : 0;

    $result = $points_for_recipes + $points_for_likes;

    return number_format($result, 1);
}

/**
 * Takes number and looks at it, if this number is between 1 thousand and 1 million
 * function returns this number with "тыс." after number, if its bigger it will
 * return this number with 'мил.' after.
 *
 * @param int $number
 * @return mixed
 */
function readable_number(int $number)
{
    if ($number >= 1000 && $number < 1000000):
        $number = substr($number, 0, -3) . '<br /><small>' . trans('users.thousand') . '</small>';
    elseif ($number >= 1000000):
        $number = substr($number, 0, -6) . '<br /><small>' . trans('users.million') . '</small>';
    endif;

    return $number;
}

/**
 * It takes date converted with timeAgo() function, and checks if second word after number
 * is "seconds". If yes it will return html green icon, otherwise red icon
 *
 * @param string $value
 * @return string
 */
function get_online_icon(string $value): string
{
    $seconds = [trans('date.second'), trans('date.seconds'), trans('date.seconds2')];
    $url_string = explode(' ', $value);

    if (in_array($url_string[1], $seconds)) {
        return '<span class="online-icon-on"></span>';
    }
    return '<span class="online-icon-off"></span>';
}

function get_sum_of_all_array_values()
{
    #
}
