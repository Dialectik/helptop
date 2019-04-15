<?php

namespace App\Events\Auth;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\User;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    public $user;
    
    public $password;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
