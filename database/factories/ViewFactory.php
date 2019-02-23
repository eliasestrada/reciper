<?php

use App\Models\Visitor;
use App\Models\Recipe;
use App\Models\View;

$factory->define(View::class, function () {
    return [
        'visits' => 0,
        'visitor_id' => factory(Visitor::class)->create(),
        'recipe_id' => factory(Recipe::class)->create(),
    ];
});