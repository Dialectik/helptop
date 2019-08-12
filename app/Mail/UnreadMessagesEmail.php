<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class UnreadMessagesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $product_code_id;
    public $service_title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $product_code_id, $service_title)
    {
        $this->user = $user;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.messages.unread_messages')
        	->subject(config('app.name') . ": У Вас є нові повідомлення від користувачів")
        	->from(config('mail.from.address'));
    }
}
