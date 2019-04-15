<?php

namespace App\Mail\Auth;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $password;   
       
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    
    public function build()
    {
        return $this->markdown('emails.auth.registration')
        	->subject(config('app.name') . ": Registration Notification")
        	->from(config('mail.from.address'));
    }
}
