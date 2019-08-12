<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deal;
use App\Message;
use App\Basket;
use Auth;


class MessagesController extends Controller
{
    
    public function index()
    {
        if(isset(Auth::user()->id)){
			$user_id = Auth::user()->id;
		}else{
			$user_id = null;
		}
        
        //Сообщения написанные авторизировавшимся пользователем
        $messages = Message::whereNotNull('service_id')
        	->where('hide', '<>', $user_id)
			->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->get();
        //Сообщения полученные от других пользователей
        $answer_messages = Message::whereNotNull('service_id')
        	->where('hide', '<>', $user_id)
			->where('recipient', $user_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        //Если есть непрочтенные сообщения
        $messages_u = Message::where('unread', 1)
        	->whereNotNull('service_id')
			->where('recipient', Auth::user()->id)
        	->get();
		if(null != $messages_u){
			$message_mark = 'id="testElement"';  //Есть сообщения со статусом "не прочтено"
		}else{
			$message_mark = '';
		}
        $service_mark = Message::where('unread', 1)
        	->whereNotNull('service_id')
			->where('recipient', Auth::user()->id)
        	->pluck('service_id')
        	->first();
        
        return view('pages.messages.index', [
			'user_id' => $user_id,
			'messages' => $messages,
			'answer_messages' => $answer_messages,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
			'service_mark' => $service_mark,
			'message_mark' => $message_mark,
		]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' =>'required',
            'message' =>'required', 
	    ]);
	    
	    $message = Message::create($request->all());
	    //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
	    
	    //Сообщения, сохраняемые в рамках сделки
	    if($request->deal_id){
			$message->deal_id = $request->deal_id;
		    $message->save();  //Сохранение сообщения
		    
		    $deal = Deal::find($request->deal_id);
	        
		    return redirect()->route('deals.edit', $deal->id);
		}
		//Сообщения, сохраняемые в рамках общения по услуге
		if($request->service_id){
			$message->service_id = $request->service_id;
			$message->recipient = $request->recipient;
		    $message->save();  //Сохранение сообщения
	        
		    return redirect()->route('messages.show', $message->id);
		}
	    
    }

    
    public function show($id)
    {
        $message0 = Message::find($id);
        $service_id = $message0->service_id;
		$recipient = $message0->recipient;
        $user_id = $message0->user_id;
		$hide = $message0->hide;
		
        //Сообщения написанные двумя пользователями, один из которых авторизован
		$messages = Message::where(function ($query) use ($service_id, $user_id, $recipient) {
				$query->where('service_id', $service_id)
					  ->where('user_id', $user_id)
					  ->where('recipient', $recipient);
            })
        	->orWhere(function ($query) use ($service_id, $user_id, $recipient) {
				$query->where('service_id', $service_id)
					  ->where('user_id', $recipient)
					  ->where('recipient', $user_id);
            })
        	->orderBy('updated_at', 'asc')
        	->get();
        //Если есть сообщения по данной услуге - сделать все сообщения, направленные другим пользователем статусом "прочитаны"
        if($user_id == Auth::user()->id){
			$user_id_u = $user_id;
			$recipient_u = $recipient;
		}else{
			$user_id_u = $recipient;
			$recipient_u = $user_id;
		}
        
        $messages_u = Message::where('service_id', $service_id)
			->where('user_id', $recipient_u)
			->where('recipient', $user_id_u)
        	->get();
		
		if(null != $messages_u){
			foreach($messages_u as $mes){
				$mes->unread = 2;  //Присвоить статус "прочтено"
				$mes->save();
			}
		}		  
        
        $service_title = $message0->getServiceTitle();
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        //Переназначение переменной для передачи в вид
        $user_id = Auth::user()->id;
        if(Auth::user()->id == $message0->user_id){
			$recipient = $message0->recipient;
		}else{$recipient = $message0->user_id;}
        
        return view('pages.messages.show', [
			'user_id' => $user_id,
			'recipient' => $recipient,
			'service_title' => $service_title,
			'service_id' => $service_id,
			'messages' => $messages,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
		]);
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' =>'required',
            'message' =>'required', 
	    ]);
	    
	    $message = Message::create($request->all());
	    //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
	    
		//Сообщения, сохраняемые в рамках общения по услуге
		if($request->service_id){
			$message->service_id = $request->service_id;
			$message->recipient = $request->recipient;
		    $message->save();  //Сохранение сообщения
	        
		    return redirect()->route('messages.show', $message->id);
		}
    }

    
    public function destroy($id)
    {
		$message0 = Message::find($id);
		$service_id = $message0->service_id;
		$recipient = $message0->recipient;
		$user_id = $message0->user_id;
		$hide = $message0->hide;
		$second = Message::where('service_id', $service_id)
			->where('user_id', $recipient)
        	->where('recipient', $user_id);
		$messages = Message::where('service_id', $service_id)
			->where('user_id', $user_id)
        	->where('recipient', $recipient)
        	->union($second)
        	->get();

		
		if($hide == 0){
			foreach($messages as $mes){
				$mes->hide = Auth::user()->id;
				$mes->save();
			}
		}elseif($hide != 0 && $hide != Auth::user()->id){
			foreach($messages as $mes){
				$mes->delete();
			}
		}
        return redirect()->route('messages.index');
    }
}
