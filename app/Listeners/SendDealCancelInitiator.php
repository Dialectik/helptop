<?php

namespace App\Listeners;

use App\Events\DealCancel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\DealCancelInitiatorEmail;
use Mail;

class SendDealCancelInitiator
{
    
    
    public function handle(DealCancel $event)
    {
        Mail::to($event->user_initiator)->send(new DealCancelInitiatorEmail($event->deal, $event->user_author, $event->user_initiator, $event->deal_code, $event->author_seller_buyer, $event->product_code_id, $event->service_title, $event->initiator_seller_buyer, $event->initiator_name, $event->author_name, $event->deal_id));
    }
}
