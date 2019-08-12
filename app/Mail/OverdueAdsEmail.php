<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class OverdueAdsEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $service_id;
    public $product_code_id;
    public $service_title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $product_code_id, $service_title, $service_id)
    {
        $this->user = $user;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
        $this->service_id = $service_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.blurbs.delete_overdue')
        	->subject(config('app.name') . ": Закінчився термін реклами для послуги")
        	->from(config('mail.from.address'));
    }
}
