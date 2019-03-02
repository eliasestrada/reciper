<?php

$factory->define(App\Models\Help::class, function () {
    return [
        'title_ru' => 'Название ' . string_random(7),
        'title_en' => 'Help title ' . string_random(7),
        'text_ru' => string_random(20),
        'text_en' => string_random(20),
    ];
});
