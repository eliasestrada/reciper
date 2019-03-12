<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserIsOnline
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
