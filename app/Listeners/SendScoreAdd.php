<?php

namespace App\Listeners;

use App\Events\ScoreAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ScoreAddEmail;
use Mail;

class SendScoreAdd
{
    
    /**
     * Handle the event.
     *
     * @param  ScoreAdd  $event
     * @return void
     */
    public function handle(ScoreAdd $event)
    {
        Mail::to($event->user)->send(new ScoreAddEmail($event->score, $event->user));
    }
}
