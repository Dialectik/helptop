<?php

namespace App\Mail;

use App\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DealAcceptAuthorEmail extends Mailable
{
    use Queueable, SerializesModels;

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
	public $you_contr_initiator;
	public $you_contr_author;
	public $accepted_initiator;
	public $accepted_author;
	public $accept_you_contr_initiator;
	public $accept_you_contr_author;
	public $stage_deal;
	public $deal_completed;
	
    
    public function __construct(Deal $deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $deal_id, $you_contr_initiator, $you_contr_author, $accepted_initiator, $accepted_author, $accept_you_contr_initiator, $accept_you_contr_author, $stage_deal, $deal_completed)
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
        $this->you_contr_initiator = $you_contr_initiator;
		$this->you_contr_author = $you_contr_author;
		$this->accepted_initiator = $accepted_initiator;
		$this->accepted_author = $accepted_author;
		$this->accept_you_contr_initiator = $accept_you_contr_initiator;
		$this->accept_you_contr_author = $accept_you_contr_author;
		$this->stage_deal = $stage_deal;
		$this->deal_completed = $deal_completed;
    }

    
    public function build()
    {
        return $this->markdown('emails.deals.deal_accept_author')
        	->subject(config('app.name') . ": підтверджено етап Угоди")
        	->from(config('mail.from.address'));
    }
}
