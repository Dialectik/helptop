<?php

namespace App\Listeners;

use App\Events\DealAccept;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\DealAcceptAuthorEmail;
use Mail;

class SendDealAcceptAuthor
{
    
    public function handle(DealAccept $event)
    {
        Mail::to($event->user_author)->send(new DealAcceptAuthorEmail($event->deal, $event->user_author, $event->user_initiator, $event->deal_code, $event->author_seller_buyer, $event->product_code_id, $event->service_title, $event->initiator_seller_buyer, $event->initiator_name, $event->author_name, $event->deal_id, $event->you_contr_initiator, $event->you_contr_author, $event->accepted_initiator, $event->accepted_author, $event->accept_you_contr_initiator, $event->accept_you_contr_author, $event->stage_deal, $event->deal_completed));
    }
}
