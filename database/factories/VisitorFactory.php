<?php

use App\Models\Visitor;

$factory->define(Visitor::class, function () {
    return ['ip' => mt_rand(100, 999) . '.' . mt_rand(0, 255) . '.0.1'];
});
