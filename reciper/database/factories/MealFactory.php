<?php

$meal = [trans('home.breakfast'), trans('home.lunch'), trans('home.dinnner')];

$factory->define(App\Models\Meal::class, function () use ($meal) {
    return [
        'name_ru' => $meal[rand(0, 2)],
        'name_en' => $meal[rand(0, 2)],
    ];
});
