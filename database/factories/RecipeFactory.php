<?php

use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
		'user_id'       => 1,
		'category_id'   => 1,
        'title'         => $faker->catchPhrase,
		'intro'         => $faker->text(200),
		'ingredients'   => str_replace(' ', '</li><li>', $faker->text(40)) . '</li>',
		'text'          => str_replace(' ', '</li><li>', $faker->text(100)) . '</li>',
		'time'          => rand(10, 160),
		'ready'         => 1,
		'approved'      => 1,
		'image'         => 'default.jpg'
    ];
});
