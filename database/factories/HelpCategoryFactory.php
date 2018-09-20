<?php

use Faker\Generator as Faker;

$factory->define(App\Models\HelpCategory::class, function (Faker $faker) {
    return [
        'title_ru' => $faker->word,
        'title_en' => $faker->word,
    ];
});
