<?php

namespace App\Listeners;

use App\Events\EndPublic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EndPublicEmail;
use Mail;

class SendEndPublic
{
    
    /**
     * Handle the event.
     *
     * @param  EndPublic  $event
     * @return void
     */
    public function handle(EndPublic $event)
    {
        Mail::to($event->user->email)->send(new EndPublicEmail($event->user, $event->product_code_id, $event->service_title, $event->service_id));
    }
}
