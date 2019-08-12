<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blurb;
use App\BlurbType;
use App\Score;
use App\Service;
use App\User;
use App\Basket;
use App\Events\ScoreAdd;
use Illuminate\Support\Collection;
use Auth;
use App\Message;

class BlurbsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $blurbs = Blurb::orderBy('date_off_blurb', 'desc')->where('user_id', $user_id)->where('status', 1)->get();
        $blurbs_arr = Blurb::orderBy('date_off_blurb', 'desc')->where('user_id', $user_id)->where('status', 0)->get();
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		
        
        return view('pages.blurbs.index', [
			'user_id' => $user_id,
			'blurbs' => $blurbs,
			'blurbs_arr' => $blurbs_arr,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
			
		]);
    }
    
    
    public function store(Request $request)
    {
		$this->validate($request, [
            'blurb_type_id' =>'required',
            'user_id' =>'required',
            'service_id' =>'required',
            'date_on_blurb' =>'required',
            'date_off_blurb' =>'required',
 

        ]);
		
		//*** Реклама ***
		$blurb_type = BlurbType::find($request->blurb_type_id);
		if(null != $blurb_type){ //Если выбрана рекламная опция
			$blurb_rate = $blurb_type->blurb_price;
			$blurb_type_id = $blurb_type->id;
		}else{
			$blurb_rate = 0;
			$blurb_type_id = null;
		}
		$user_id = $request->user_id;
		//Баланс по последней транзакции
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); 
		//Проверка достаточности средств на счету для оплаты публикации и рекламы
		$delta = $balance0 - $blurb_rate; 
		
		//Если на рекламу не достаточно средств - не публикуем
		if($delta > 0 || $delta == 0){ 
			if(null != $blurb_type){  //Если на рекламу достаточно средств - создаем рекламу
				$service = Service::find($request->service_id);
				$service->blurb_type_id = $blurb_type_id; //Запись в таблице услуг о том, что для данной услуги есть реклама
				$blurb = Blurb::create($request->all());
				$blurb->blurb_cost = $blurb_rate;
				$blurb->service_id = $service->id;
				$blurb->setDateOnAttribute($request->get('date_on_blurb'), $request->get('date_offset'));
        		$blurb->setDateOffAttribute($request->get('date_off_blurb'), $request->get('date_offset'));
				$blurb->blurb_type = $blurb_type_id;
				$blurb->save();
				
				//Списываем со счета деньги за рекламу
				$score_r = Score::create($request->all());
				$score_r->cause = 5; //Оплата рекламы
				//Баланс по последней транзакции
				$balance00 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first();
				$score_r->balance = $balance00 - $blurb_rate;
				$score_r->expense = $blurb_rate;
				$score_r->service_id = $service->id;
				$score_r->date_trans = $score_r->updated_at;
				$score_r->save(); 
				
				$service->save();
				$status = 'Для данной услуги успешно запущена реклама';
			}
		}else{
			$status = 'Реклама для у слуги не создана! Проверьте достаточно ли средств на счету для рекламирования услуги
';
		}
		
		
		
		
		
		return redirect()->route('service.show', $service->id)->with('status', $status);
	}
    
    
    public function show($id)
    {
        $blurb = Blurb::find($id);
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Если есть непрочтенные сообщения
        $messages_u = Message::where('unread', 1)
			->where('recipient', Auth::user()->id)
        	->get();
		
		if(isset($messages_u)){foreach($messages_u as $mes){if($id_m = $mes->id){	}	};}
		if(isset($id_m)){
			$message_mark = 'id="testElement"';  //Есть сообщения со статусом "прочтено"
		}else{
			$message_mark = '';
		}
        
        if(null != $blurb){
			$user_id = $blurb->user_id;
		}else{$user_id = null;}
		
		return view('pages.blurbs.show', [
			'user_id' => $user_id,
			'blurb' => $blurb,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
		]);
	        
    }
    
    //Переадресация с сообщением при нажатии кнопки Рекламировать продажи
    public function adversell()
    {
		$status = 'Для рекламирования услуги нажмите значек &nbsp; <i class="fa fa-magnet"></i> &nbsp; напротив выбранной услуги';		
		
		return redirect()->route('service.mysell')->with('status', $status);
	}
	//Переадресация с сообщением при нажатии кнопки Рекламировать покупки
	public function adverbuy()
    {
		$status = 'Для рекламирования услуги нажмите значек &nbsp; <i class="fa fa-magnet"></i> &nbsp; напротив выбранной услуги';		
		
		return redirect()->route('service.mybuy')->with('status', $status);
	}
	
	
	public function destroy($id)
    {
        $blurb = Blurb::find($id);
		$blurb->delete();
        
        return redirect()->route('blurbs.index');
    }
    
    
    
    
}
