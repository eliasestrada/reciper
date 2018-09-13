<?php

use App\Models\Visitor;
use Faker\Generator as Faker;

$factory->define(Visitor::class, function (Faker $faker) {
    return [
        'ip' => $faker->ipv4,
    ];
});
