<?php

namespace App\Jobs;

use Exception;
use App\User;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DeleteUnactivatedAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    
    public function __construct($id_user)
    {
        $this->id = $id_user;
    }

    /**
     * Удаление пользователя, не активированного через сутки после регистрации.
     * 
     * ### НЕ ЗАБЫТЬ установить на сервере Supervisor и настроить запуск заданий очередей ###
     *
     * @return void
     */
    public function handle()
    {
        $user_id = $this->id;
        $user = User::find($user_id);
        if($user->remember_token == NULL)
        {
			$user->remove();
		}

    }
    
    public function failed()
    {
		//Отправка админу сообщения о провале задачи
	}
}
