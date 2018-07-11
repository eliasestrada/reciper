<?php

use App\Models\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
	$faker_ru = \Faker\Factory::create('ru_RU');

    return [
		'title_ru' => $faker_ru->realText(10),
		'text_ru' => $faker_ru->realText(1000),
		'title_en' => $faker->title,
		'text_en' => $faker->text
    ];
});
