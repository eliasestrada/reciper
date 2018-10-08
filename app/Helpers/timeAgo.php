<?php

/**
 * @param string $date
 * @param string $param
 * @return string
 */
function time_ago($date, $param = null)
{
    $date = strtotime($date);
    $stf = 0;
    $cur_time = time();
    $diff = $cur_time - $date;

    $seconds = [trans('date.second'), trans('date.seconds'), trans('date.seconds2')];
    $minutes = [trans('date.minute'), trans('date.minutes'), trans('date.minutes2')];
    $hours = [trans('date.hour'), trans('date.hours'), trans('date.hours2')];
    $days = [trans('date.day'), trans('date.days'), trans('date.days2')];
    $weeks = [trans('date.week'), trans('date.weeks'), trans('date.weeks2')];
    $months = [trans('date.month'), trans('date.months'), trans('date.months2')];
    $years = [trans('date.year'), trans('date.years'), trans('date.years2')];
    $decades = [trans('date.decade'), trans('date.decades'), trans('date.decades2')];

    $phrase = [$seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades];
    $length = [1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600];

    for ($i = sizeof($length) - 1; ($i >= 0) && (($no = $diff / $length[$i]) <= 1); $i--);
    if ($i < 0) {
        $i = 0;
    }

    $_time = $cur_time - ($diff % $length[$i]);
    $no = floor($no);
    $value = sprintf("%d %s ", $no, getPhrase($no, $phrase[$i]));

    if (($stf == 1) && ($i >= 1) && (($cur_time - $_time) > 0)) {
        $value .= time_ago($_time);
    }

    if (isset($param) && $param == 'online') {
        $url_string = explode(' ', $value);

        if ($url_string[0] >= 0 && $url_string[0] <= 5) {
            if (in_array($url_string[1], $seconds) || in_array($url_string[1], $minutes)) {
                return;
            }
        }
    }
    return $value . ' ' . trans("date.ago");
}

function getPhrase($number, $titles)
{
    $cases = [2, 0, 1, 1, 1, 2];

    return $titles[
        ($number % 100 > 4 && $number % 100 < 20)
        ? 2
        : $cases[min($number % 10, 5)]
    ];
}
