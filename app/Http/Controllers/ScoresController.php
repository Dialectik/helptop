<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Score;
use App\User;
use App\Basket;
use App\Message;
use App\Events\ScoreAdd;
use Illuminate\Support\Collection;

class ScoresController extends Controller
{
    
    public function index()
    {
        $user_id = Auth::user()->id;
        $score_id = Score::where('user_id', $user_id)->orderBy('date_trans', 'desc')->pluck('id')->first();
        $score = Score::find($score_id);
        $scores = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->get();
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        return view('pages.scores.index', [
			'user_id' => $user_id,
			'score' => $score,
			'scores' => $scores,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($score_id)
    {
        $score = Score::find($score_id);
        $user_id = $score->user_id;
        
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
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        return view('pages.scores.show', [
			'user_id' => $user_id,
			'score' => $score,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    //Функция отправки реквизитов на почту пользователя для пополнения счета
    public function refill(Request $request){
		$user_id = $request->user_id;
		$balance = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first();
		if($balance == null){
			$balance = 0;
		}
		$score = Score::create($request->all());
		$score->cause = 6; //Не проведен - ожидается
		$score->balance = $balance;
		$score->date_trans = $score->updated_at;
		$score->save();
		
		//Подготовка данных для события - оправка сообщения пользователям о новой Сделке
        $user = $score->user->email;
		
		//Инициация события отправки сообщения пользователю с реквизитами для оплаты счета
    	event(new ScoreAdd($score, $user));
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		return view('pages.scores.refill', [
			'score' => $score,
			'user' => $user,
			'basket_mark' => $basket_mark,
		]);
	}
    
    
}
