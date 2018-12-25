<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeGotCanceled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipe;
    public $message;

    /**
     * @param Recipe $recipe
     * @param string $message
     * @return void
     */
    public function __construct(Recipe $recipe, string $message)
    {
        $this->recipe = $recipe;
        $this->message = $message;
    }
}
