<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Deal;

class DealNew
{
    use Dispatchable, SerializesModels;

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
	public $bidding_title;
	public $service_description;
	public $author_granted_received;
	public $initiator_granted_received;
	public $date_initial_user;
	public $date_deadline_user;
	public $date_deadline_pay;
	public $payment;
	public $deal_id;

    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Deal $deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $bidding_title, $service_description, $author_granted_received, $initiator_granted_received, $date_initial_user, $date_deadline_user, $date_deadline_pay, $payment, $deal_id)
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
        $this->bidding_title = $bidding_title;
        $this->service_description = $service_description;
        $this->author_granted_received = $author_granted_received;
        $this->initiator_granted_received = $initiator_granted_received;
        $this->date_initial_user = $date_initial_user;
        $this->date_deadline_user = $date_deadline_user;
        $this->date_deadline_pay = $date_deadline_pay;
        $this->payment = $payment;
        $this->deal_id = $deal_id;

    }
}
