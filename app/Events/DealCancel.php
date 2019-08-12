<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Deal;

class DealCancel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $deal;
    public $user_author;
    public $user_initiator;
    public $deal_code;
	public $author_seller_buyer;
	public $product_code_id;
	public $service_title;
	public $initiator_seller_buyer;
	public $initiator_name;
	public $author_name;
	public $deal_id;
    
    
    public function __construct(Deal $deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $deal_id)
    {
        $this->deal = $deal;
        $this->user_author = $user_author;
        $this->user_initiator = $user_initiator;
        $this->deal_code = $deal_code;
        $this->author_seller_buyer = $author_seller_buyer;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
        $this->initiator_seller_buyer = $initiator_seller_buyer;
        $this->initiator_name = $initiator_name;
        $this->author_name = $author_name;
        $this->deal_id = $deal_id;
    }

    
}
