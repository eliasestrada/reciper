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
function to_array_of_list_items(?string $str): array
{
    $string_with_no_tags = strip_tags($str, '<li>');

    $array_of_lines = explode("\n", preg_replace("/[\r\n]+/", "\n", $string_with_no_tags));

    $array_without_empty_lines = array_filter($array_of_lines, function ($item) {
        return $item != '';
    });

    // Every array item wrapping with <li> tags
    $list_of_ingredients = array_map(function ($item) {
        return "<li>$item</li>";
    }, $array_without_empty_lines);

    return array_values($list_of_ingredients);
}

// Shortcut
function user()
{
    return auth()->user();
}

function LANG()
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
 * @codeCoverageIgnore
 * @param string
 * @return
 */
function style_timestamp(string $path): string
{
    try {
        $timestamp = '?v=' . \File::lastModified(public_path() . $path);
    } catch (Exception $e) {
        $timestamp = '';
    }
    return '<link rel="stylesheet" href="' . $path . $timestamp . '">';
}

/**
 * Adds version to script src if it was modified
 *
 * @codeCoverageIgnore
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
 * @param array $routes
 * @return string
 */
function active_if_route_is(array $routes): string
{
    foreach ($routes as $route) {
        if (request()->is(($route[0] == '/' && strlen($route) != 1) ? substr($route, 1) : $route)) {
            return 'active';
        }
    }
    return '';
}

/**
 * @param string $extention
 * @return string
 */
function set_image_name(string $extension = null): string
{
    if ($extension) {
        return time() . rand() . '.' . $extension;
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
 * @codeCoverageIgnore
 * @param bool|null $show_data
 * @return void
 */
function dump_sql(?bool $show_data = false): void
{
    \DB::listen(function ($query) use ($show_data) {
        dump($query->sql);
        if ($show_data) {
            dump($query->bindings);
        }
    });
}

/**
 * It returns visitor_id even if cookie is not set
 */
function visitor_id()
{
    if (request()->cookie('r_rotsiv')) {
        return request()->cookie('r_rotsiv');
    }
    $visitor_id = Visitor::whereIp(request()->ip())->value('id');
    \Cookie::queue('r_rotsiv', $visitor_id, 218400);

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
 * @codeCoverageIgnore
 * @param string $title
 * @param $link
 * @return string
 */
function help_link(string $title, $link): string
{
    return '<a href="' . \URL::to(is_int($link) ? '/help/' . $link : $link) . '" class="red-text text-hover">' . $title . ' <i class="fas fa-external-link-square-alt" style="font-size:10px;transform:translateY(-4.5px)"></i></a>';
}

/**
 * @param $exception
 * @param string $file
 * @return void
 */
function no_connection_error($exception, string $file): void
{
    logger()->error($exception->getMessage() . " in file $file.php");
    session()->flash('error', trans('messages.query_error'));
}
