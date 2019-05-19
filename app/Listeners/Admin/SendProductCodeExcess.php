<?php

namespace App\Listeners\Admin;

use App\Events\Admin\ProductCodeExcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Admin\ProductCodeExcessEmail;
use Mail;

class SendProductCodeExcess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Событие - отправка сообщения о том, что превышено число товарных кодов услуг 
     * определенного вида более 8000. Требуется вмешетельство администратора
     * 
     * @param  ProductCodeExcess  $event
     * @return void
     */
    public function handle(ProductCodeExcess $event)
    {
        Mail::to(env('MAIL_ADMIN_EMAIL'))->send(new ProductCodeExcessEmail($event->kind_id, $event->kind));
    }        
}
