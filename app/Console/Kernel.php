<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Service;
use App\User;
use App\Blurb;
use App\Message;
use DateTime;
use DateTimeZone;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use App\Jobs\DeleteOverdueAds;  //задание очереди
use App\Jobs\DeleteEndPublication;  //задание очереди
use App\Jobs\HaveUnreadMessages;  //задание очереди

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        //
    ];

    
    protected function schedule(Schedule $schedule)
    {
		//Поднятие объявлений Лидер пакета в 01:00
		$schedule->call(function () {
			$servicesLid = Service::where('status', 1)->whereBetween('blurb_type_id', [11, 15])->get();
			$date_c = new DateTime();
			foreach($servicesLid as $service){
				$service->created_at = $date_c;
				$service->updated_at = $date_c;
				$service->save();
			}
		})->dailyAt('22:00');
		//Поднятие объявлений Лидер пакета в 08:00
		$schedule->call(function () {
			$servicesLid = Service::where('status', 1)->whereBetween('blurb_type_id', [11, 15])->get();
			$date_c = new DateTime();
			foreach($servicesLid as $service){
				$service->created_at = $date_c;
				$service->updated_at = $date_c;
				$service->save();
			}
		})->dailyAt('05:00');
		//Поднятие объявлений Лидер пакета в 16:00
		$schedule->call(function () {
			$servicesLid = Service::where('status', 1)->whereBetween('blurb_type_id', [11, 15])->get();
			$date_c = new DateTime();
			foreach($servicesLid as $service){
				$service->created_at = $date_c;
				$service->updated_at = $date_c;
				$service->save();
			}
		})->dailyAt('13:00');
		
		//Поднятие объявлений Сренего пакета в 00:30
		$schedule->call(function () {
			$servicesLid = Service::where('status', 1)->whereBetween('blurb_type_id', [6, 10])->get();
			$date_c = new DateTime();
			foreach($servicesLid as $service){
				$service->created_at = $date_c;
				$service->updated_at = $date_c;
				$service->save();
			}
		})->dailyAt('21:30');
				
		//Поднятие объявлений Старт пакета в 24:00
		$schedule->call(function () {
			$servicesLid = Service::where('status', 1)->whereBetween('blurb_type_id', [1, 5])->get();
			$date_c = new DateTime();
			foreach($servicesLid as $service){
				$service->created_at = $date_c;
				$service->updated_at = $date_c;
				$service->save();
			}
		})->dailyAt('21:00');
				
		
		//01:30 Отправка сообщ и прекращ рекламы для тех услуг период рекламы которых истек 
		$schedule->call(function () {
			$date_c = new DateTime();
			$blurbs = Blurb::where('date_off_blurb', '<', $date_c)->whereNotNull('blurb_type_id')->get();
			foreach($blurbs as $blurb){
				$user_id = $blurb->user_id;
				$user = User::find($user_id);
				$service_id = $blurb->service_id;
				$service = Service::find($service_id);
        		$product_code_id = $service->product_code_id;
        		$service_title = $service->title;
	    		//Отправка задачи по удалению не активированного пользователя в отложенную очередь
	    		dispatch(new DeleteOverdueAds($user, $product_code_id, $service_title, $service_id));
				//Перевод рекламной опции услуги в режим "Архивная" (истек срок)
				$blurb->status = 0;
				$blurb->save();
				//Удаление отметки о рекламе для услуги (отмена рекламы)
				$service->blurb_type_id = null;
				$service->save();
			}
		})->dailyAt('22:30');
//		$date = new DateTime($end_date, new DateTimeZone('UTC'));
//		})->everyMinute();

		
		//02:30 Отправка сообщ и прекращ публикации для тех услуг период публикации которых истек 
		$schedule->call(function () {
			$date_c = new DateTime();
			$services = Service::where('date_off', '<', $date_c)->where('status', 1)->get();
			foreach($services as $service){
				$user_id = $service->user_id;
				$user = User::find($user_id);
				$service_id = $service->id;
        		$product_code_id = $service->product_code_id;
        		$service_title = $service->title;
	    		//Отправка задачи по удалению не активированного пользователя в отложенную очередь
	    		dispatch(new DeleteEndPublication($user, $product_code_id, $service_title, $service_id));
				//Удаление отметки о публикации для услуги (отмена публикации)
				$service->rate_bidding_id = null;
				$service->status = 0;
				$service->save();
			}
//		})->dailyAt('15:06');
		})->dailyAt('23:30');
		
		
		//03:30 Отправка сообщ и прекращ публикации для тех услуг период публикации которых истек 
		$schedule->call(function () {
			//Если есть непрочтенные сообщения
	        $messages_u = Message::where('unread', 1)->whereNotNull('service_id')->get();
			$unread_users = array(); //Массив уникальных пользователей, которые не прочли сообщения
			//Есть сообщения со статусом "не прочтено"
			if(null != $messages_u){
				foreach($messages_u as $message){
				  	if(!in_array($message->recipient, $unread_users)){
						$user = User::find($message->recipient);
						$service_id = $message->service_id;
						$service = Service::find($service_id);
        				$product_code_id = $service->product_code_id;
        				$service_title = $service->title;
						//Отправка задачи по удалению не активированного пользователя в отложенную очередь
	    				dispatch(new HaveUnreadMessages($user, $product_code_id, $service_title));
						//Добавить уникального получателя в массив получателей уведомления о непрочитанных сообщениях
						array_push($unread_users, $message->recipient);
					}
				}

			}
//		})->dailyAt('16:32');
		})->dailyAt('00:30');
		
		
		
		
		
		
		
		
		
		
		
		
    }

    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
