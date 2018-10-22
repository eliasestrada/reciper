<?php

use App\Models\HelpCategory;

$factory->define(HelpCategory::class, function () {
    return [
        'title_ru' => 'Название' . rand(),
        'title_en' => 'Title ' . rand(),
    ];
});
