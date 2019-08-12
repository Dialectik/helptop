<?php

namespace App\Listeners;

use App\Events\DealNew;
use App\Mail\DealNewInitiatorEmail;
use Mail;

class SendDealNewInitiator
{
    
    public function handle(DealNew $event)
    {
        Mail::to($event->user_initiator)->send(new DealNewInitiatorEmail($event->deal, $event->user_author, $event->user_initiator, $event->deal_code, $event->author_seller_buyer, $event->product_code_id, $event->service_title, $event->initiator_seller_buyer, $event->initiator_name, $event->author_name, $event->bidding_title, $event->service_description, $event->author_granted_received, $event->initiator_granted_received, $event->date_initial_user, $event->date_deadline_user, $event->date_deadline_pay, $event->payment, $event->deal_id));
    }
}
