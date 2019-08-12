<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Score;

class ScoreAddEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $score;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Score $score, $user)
    {
        $this->score = $score;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.scores.refill')
        	->subject(config('app.name') . ": реквізити для поповнення рахунку")
        	->from(config('mail.from.address'));
    }
}
