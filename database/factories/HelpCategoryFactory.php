<?php

use App\Models\HelpCategory;

$factory->define(HelpCategory::class, function () {
    return [
        'title_ru' => 'Название ' . str_random(7),
        'title_en' => 'Title ' . str_random(7),
    ];
});
