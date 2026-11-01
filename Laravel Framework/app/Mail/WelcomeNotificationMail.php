<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $customMessage = 'Welcome to Laravel Framework Assignment!')
    {
        $this->user = $user;
        $this->customMessage = $customMessage;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to Laravel Music & Playlist System')
                    ->view('emails.welcome')
                    ->with([
                        'userName' => $this->user->name,
                        'userEmail' => $this->user->email,
                        'customMessage' => $this->customMessage,
                    ]);
    }
}
