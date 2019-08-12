<?php

namespace App\Listeners;

use App\Events\DealCancel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\DealCancelAuthorEmail;
use Mail;

class SendDealCancelAuthor
{
    
    
    public function handle(DealCancel $event)
    {
        Mail::to($event->user_author)->send(new DealCancelAuthorEmail($event->deal, $event->user_author, $event->user_initiator, $event->deal_code, $event->author_seller_buyer, $event->product_code_id, $event->service_title, $event->initiator_seller_buyer, $event->initiator_name, $event->author_name, $event->deal_id));
    }
}
