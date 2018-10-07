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
            \App\Listeners\ClearCacheAfterCanceling::class,
            \App\Listeners\UpdateRecipeAfterCanceling::class,
        ],
        \App\Events\RecipeGotApproved::class => [
            \App\Listeners\AddExpForRecipe::class,
            \App\Listeners\SendApprovedNotification::class,
            \App\Listeners\ClearCacheAfterApproving::class,
            \App\Listeners\UpdateRecipeAfterApproving::class,
        ],
        \App\Events\RecipeGotDrafted::class => [
            \App\Listeners\RemoveExpForDrafting::class,
            \App\Listeners\ForgetCacheAfterDrafting::class,
        ],
        \App\Events\UserIsOnline::class => [
            \App\Listeners\UpdateUpdatedAtColumn::class,
            \App\Listeners\UpdateStrikeDays::class,
        ],
    ];
}
