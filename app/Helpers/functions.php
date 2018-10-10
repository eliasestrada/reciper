<?php

use App\Models\Visitor;

/**
 * @param string $string
 * @return string
 */
function custom_strip_tags(string $string): string
{
    $allowed = '<h1><h2><h3><h4><h5><h6><p><br><br><b><li><ol><ul><strong><span>';
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
        $time = time();
        return "{$time}-{$slug}.{$extension}";
    }
    return 'default.jpg';
}

/**
 * Takes number and looks at it, if this number is between 1 thousand and 1 million
 * function returns this number with "тыс." after number, if its bigger it will
 * return this number with 'мил.' after.
 *
 * @param mixed $number
 * @return mixed
 */
function readable_number($number)
{
    if ($number < 900) {
        // 0 - 900
        $new_number = number_format($number);
        $suffix = '';
    } else if ($number < 900000) {
        // 0.9k-850k
        $new_number = number_format($number / 1000);
        $suffix = trans('users.thousand');
    } else if ($number < 900000000) {
        // 0.9m-850m
        $new_number = number_format($number / 1000000);
        $suffix = trans('users.million');
    } else if ($number < 900000000000) {
        // 0.9b-850b
        $new_number = number_format($number / 1000000000);
        $suffix = trans('users.billion');
    } else {
        // 0.9t+
        $new_number = number_format($number / 1000000000000);
        $suffix = trans('users.trillion');
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    $dotzero = '.' . str_repeat('0', 1);
    $new_number = str_replace($dotzero, '', $new_number);

    return "$new_number<br><small>$suffix</small>";
}

/**
 * It takes date converted with time_ago() function, and checks if second word after number
 * is "seconds". If yes it will return html green icon, otherwise red icon
 *
 * @param string $value
 * @return string
 */
function get_online_icon(string $value): string
{
    $seconds = [trans('date.second'), trans('date.seconds'), trans('date.seconds2')];
    $minutes = [trans('date.minute'), trans('date.minutes'), trans('date.minutes2')];
    $url_string = explode(' ', $value);

    if (in_array($url_string[1], $seconds)) {
        return '<span class="online-icon-on"></span>';
    }
    if ($url_string[0] >= 0 && $url_string[0] <= 5 && in_array($url_string[1], $minutes)) {
        return '<span class="online-icon-on"></span>';
    }
    return '<span class="online-icon-off"></span>';
}

/**
 * Function for debuging queries
 * @return void
 */
function dump_sql(): void
{
    \DB::listen(function ($query) {
        dump($query->sql);
        dump($query->bindings);
    });
}

function dump_cache()
{
    $filesystem = \Cache::getStore()->getFilesystem();
    $keys = [];
    foreach ($filesystem->allFiles(\Cache::getDirectory()) as $file1) {
        if (is_dir($file1->getPath())) {
            foreach ($filesystem->allFiles($file1->getPath()) as $file2) {
                $keys = array_merge($keys, [$file2->getRealpath() => unserialize(substr(\File::get($file2->getRealpath()), 10))]);
            }
        }
    }
    dump($keys);
}
/**
 * It returns visitor_id even if cookie is not set
 */
function visitor_id()
{
    if (request()->cookie('rotsiv')) {
        return request()->cookie('rotsiv');
    }
    $visitor_id = Visitor::whereIp(request()->ip())->value('id');
    \Cookie::queue('rotsiv', $visitor_id, 218400);

    return $visitor_id;
}

/**
 * @param string $header
 * @param string $message
 * @param string $color
 * @return string
 */
function tip(string $header, string $message, string $color = 'green-text'): string
{
    return '<br><br><span class="' . $color . '"><b>' . $header . ':</b> ' . $message . '<span>';
}

/**
 * @param string $title
 * @param $link
 * @return string
 */
function help_link(string $title, $link): string
{
    return '<a href="' . \URL::to(is_int($link) ? '/help/' . $link : $link) . '" class="text-hover">' . $title . '</a>';
}
