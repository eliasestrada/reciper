<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

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
