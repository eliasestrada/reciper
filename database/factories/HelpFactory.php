<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Help::class, function (Faker $faker) {
    return [
        'title_ru' => $faker->sentence(5),
        'title_en' => $faker->sentence(5),
        'text_ru' => $faker->realText(100),
        'text_en' => $faker->realText(100),
    ];
});
