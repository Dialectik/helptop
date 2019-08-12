<?php

namespace App\Jobs;

use Exception;
use App\User;
use App\Service;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Events\UnreadMessages;

class HaveUnreadMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $product_code_id;
    protected $service_title;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $product_code_id, $service_title)
    {
        $this->user = $user;
        $this->product_code_id = $product_code_id;
        $this->service_title = $service_title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $product_code_id = $this->product_code_id;
        $service_title = $this->service_title;
        //Инициация события отправки сообщения пользователям о прекращении публикации услуги
    	event(new UnreadMessages($user, $product_code_id, $service_title));
    }
}
