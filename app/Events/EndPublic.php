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

class EndPublic
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $user;
    public $product_code_id;
    public $service_title;
    public $service_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $product_code_id, $service_title, $service_id)
    {
        $this->user = $user;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
        $this->service_id = $service_id;
    }
}
