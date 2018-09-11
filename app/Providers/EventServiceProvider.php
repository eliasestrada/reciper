<?php

namespace App\Providers;

use Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        'App\Events\RecipeIsReady' => [
            'App\Listeners\SendSms',
        ],
        'App\Events\RecipeGotApproved' => [
            'App\Listeners\AddPointsForRecipe',
        ],
        'App\Events\RecipeGotDrafted' => [
            'App\Listeners\RemovePointsForDrafting',
        ],
        'App\Events\RecipeGotLiked' => [
            'App\Listeners\AddPointsForLike',
        ],
        'App\Events\RecipeGotDisliked' => [
            'App\Listeners\RemovePointsForDislike',
        ],
        'App\Events\RecipeGotViewed' => [
            'App\Listeners\AddPointsForView',
        ],
    ];
}
