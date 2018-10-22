<?php

$factory->define(App\Models\Help::class, function () {
    return [
        'title_ru' => 'Название #' . rand(),
        'title_en' => 'Help title #' . rand(),
        'text_ru' => str_random(20),
        'text_en' => str_random(20),
    ];
});
