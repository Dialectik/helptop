<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductCodeExcessEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $kind_id;
        
    public $kind;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($kind_id, $kind)
    {
        $this->kind_id = $kind_id;
        $this->kind = $kind;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin.prodcodexcess')
        			->subject('Превышен лимит количества объявлений для одного из видов услуг!');
    }
}
