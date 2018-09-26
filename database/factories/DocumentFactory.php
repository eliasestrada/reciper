<?php

use App\Models\Document;
use Faker\Generator as Faker;

cache()->flush();

$factory->define(Document::class, function (Faker $faker) {
    return [
        'title_ru' => $faker->sentence,
        'title_en' => $faker->sentence,
        'text_ru' => $faker->paragraph,
        'text_en' => $faker->paragraph,
        'ready_ru' => 1,
        'ready_en' => 1,
    ];
});
