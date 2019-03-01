<?php

$factory->define(App\Models\Help::class, function () {
    return [
        'title_ru' => 'Название ' . str_random(7),
        'title_en' => 'Help title ' . str_random(7),
        'text_ru' => str_random(20),
        'text_en' => str_random(20),
    ];
});
