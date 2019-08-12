<?php

namespace App\Listeners;

use App\Events\UnreadMessages;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UnreadMessagesEmail;
use Mail;

class SendUnreadMessages
{
    
    /**
     * Handle the event.
     *
     * @param  UnreadMessages  $event
     * @return void
     */
    public function handle(UnreadMessages $event)
    {
        Mail::to($event->user->email)->send(new UnreadMessagesEmail($event->user, $event->product_code_id, $event->service_title));
    }
}
