<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
