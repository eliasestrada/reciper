<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeGotApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipe;
    public $user;

    /**
     * @param Recipe $recipe
     * @param string $message
     * @param int $user_id
     * @return void
     */
    public function __construct(Recipe $recipe, int $user_id)
    {
        $this->recipe = $recipe;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
