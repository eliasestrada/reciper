<?php

return [

    'recipes' => [
        'title' => ['min' => 3, 'max' => 85],
        'intro' => ['min' => 20, 'max' => 1000],
        'ingredients' => ['min' => 20, 'max' => 5000],
        'text' => ['min' => 200, 'max' => 10000],
    ],

    'docs' => [
        'title' => ['min' => 5, 'max' => 190],
        'text' => ['min' => 100, 'max' => 10000],
    ],

    'settings' => [
        'general' => [
            'about_me' => ['max' => 250],
            'name' => ['min' => 3, 'max' => 50],
        ],
        'password' => ['min' => 6, 'max' => 250],
    ],

    'feedback' => [
        'contact' => [
            'message' => ['min' => 20, 'max' => 2000],
        ],
        'ban' => [
            'message' => ['min' => 20, 'max' => 2000],
        ],
    ],

    'approves' => [
        'disapprove' => [
            'message' => ['min' => 10, 'max' => 2000],
        ],
    ],

];
