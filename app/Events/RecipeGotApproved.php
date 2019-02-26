<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RecipeGotApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipe;

    /**
     * @param Recipe $recipe
     * @param string $message
     * @return void
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }
}
