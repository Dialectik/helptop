<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class UnreadMessages
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $user;
    public $product_code_id;
    public $service_title;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $product_code_id, $service_title)
    {
        $this->user = $user;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
    }
}
