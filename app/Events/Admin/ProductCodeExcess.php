<?php

namespace App\Events\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Kind;


class ProductCodeExcess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
	public $kind_id;
    
    public $kind;
    
    /**
     * Событие - отправка сообщения о том, что превышено число товарных кодов услуг определенного вида более 8000. Требуется вмешетельство администратора
     * 
     * @return void
     */
    public function __construct($kind_id, $kind)
    {
        $this->kind_id = $kind_id;
        $this->kind = $kind;        
    }

   
}
