<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Score;

class ScoreAdd
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $score;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Score $score, $user)
    {
        $this->score = $score;
        $this->user = $user;
    }

    
}
