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
        \App\Events\RecipeIsReady::class => [
            \App\Listeners\SendSms::class,
        ],
        \App\Events\RecipeGotCanceled::class => [
            \App\Listeners\SendCanceledNotification::class,
        ],
        \App\Events\RecipeGotApproved::class => [
            \App\Listeners\AddExpForRecipe::class,
            \App\Listeners\SendApprovedNotification::class,
        ],
        \App\Events\RecipeGotDrafted::class => [
            \App\Listeners\RemoveExpForDrafting::class,
            \App\Listeners\ForgetCacheAfterDrafting::class,
        ],
        \App\Events\RecipeGotLiked::class => [
            \App\Listeners\AddExpForLike::class,
        ],
        \App\Events\RecipeGotDisliked::class => [
            \App\Listeners\RemoveExpForDislike::class,
        ],
        \App\Events\RecipeGotViewed::class => [
            \App\Listeners\AddExpForView::class,
        ],
    ];
}
