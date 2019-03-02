<?php

use App\Models\HelpCategory;

$factory->define(HelpCategory::class, function () {
    return [
        'title_ru' => 'Название ' . string_random(7),
        'title_en' => 'Title ' . string_random(7),
    ];
});
