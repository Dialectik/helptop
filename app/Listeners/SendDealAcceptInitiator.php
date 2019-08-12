<?php

namespace App\Listeners;

use App\Events\DealAccept;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\DealAcceptInitiatorEmail;
use Mail;

class SendDealAcceptInitiator
{
    
    public function handle(DealAccept $event)
    {
        Mail::to($event->user_initiator)->send(new DealAcceptInitiatorEmail($event->deal, $event->user_author, $event->user_initiator, $event->deal_code, $event->author_seller_buyer, $event->product_code_id, $event->service_title, $event->initiator_seller_buyer, $event->initiator_name, $event->author_name, $event->deal_id, $event->you_contr_initiator, $event->you_contr_author, $event->accepted_initiator, $event->accepted_author, $event->accept_you_contr_initiator, $event->accept_you_contr_author, $event->stage_deal, $event->deal_completed));
    }
}
