<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance
     */
    public function __construct()
    {
        //
    }

    // Build the message
    public function build()
    {
        return $this->markdown('emails.user_registered');
    }
}
