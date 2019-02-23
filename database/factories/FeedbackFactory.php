<?php

use App\Models\Feedback;
use App\Models\Visitor;

$factory->define(Feedback::class, function () {
    return [
        'email' => rand(1000, 10000) . '@mail.com',
        'visitor_id' => factory(Visitor::class)->create()->id,
        'recipe_id' => null,
        'lang' => _(),
        'message' => str_random(100),
    ];
});

$factory->state(Feedback::class, 'report', [
    'is_report' => 1,
]);
