<?php

namespace App\Listeners;

use App\Events\OverdueAds;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\OverdueAdsEmail;
use Mail;

class SendOverdueAds
{
    
    /**
     * Handle the event.
     *
     * @param  OverdueAds  $event
     * @return void
     */
    public function handle(OverdueAds $event)
    {
        Mail::to($event->user->email)->send(new OverdueAdsEmail($event->user, $event->product_code_id, $event->service_title, $event->service_id));
    }
}
