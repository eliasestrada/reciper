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

function facebookTimeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60 ); // value 60 is seconds
    $hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400); //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800); // 7*24*60*60;
    $months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
    
    if ($seconds <= 60) {
        return "Только что";
    } elseif ($minutes <=60) {
		if ($minutes == 1) {
			return "Минуту назад";
		} elseif ($minutes >= 2 && $minutes <= 4) {
            return $minutes . " минуты назад";
		} else {
            return "$minutes минут назад";
        }
    } elseif ($hours <= 24) {
        if ($hours == 1) {
            return "Час назад";
        } elseif ($hours >= 2 && $hours <= 4) {
			return $hours . " часа назад";
		} else {
            return $hours . " часов назад";
        }
    } elseif ($days <= 7) {
        if ($days == 1) {
            return "Вчера";
		} elseif ($days >= 2 && $days <= 4) {
			return $days . " дня назад";
		} else {
            return $days . " дней назад";
        }
    } elseif ($weeks <= 4.3) {
        if ($weeks == 1) {
            return "Неделю назад";
        } elseif ($weeks >= 2 && $weeks <= 4) {
			return $weeks . " недели назад";
		} else {
            return $weeks . " недель назад";
        }
    } elseif ($months <= 12) {
        if ($months == 1) {
            return "Месяц назад";
        } elseif ($months >= 2 && $months <= 4) {
			return $months . " месяца назад";
		} else {
            return $months . " месяцев назад";
        }
    } else {
        if ($years == 1) {
            return "Год назад";
        } elseif ($years >= 2 && $years <= 4) {
			return $years . " года назад";
		} else {
            return $years . " лет назад";
        }
    }
}