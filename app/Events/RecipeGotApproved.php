<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
