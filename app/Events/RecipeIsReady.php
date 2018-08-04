<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeIsReady
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipe;

    /** Create a new event instance */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe->title;
    }
}
