<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deal;
use App\Rating;
use App\Basket;
use App\User;
use Auth;
use DateTime;
use DateTimeZone;
use DateInterval;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(Auth::check()){
			$deal = Deal::find($request->deal_id);
			if($deal->id){
				if($deal->id < 10){
					$deal_code = '0' . '0' . '0' . '0' . '0' . '0' . '0' . $deal->id;
				}elseif($deal->id < 100){
					$deal_code = '0' . '0' . '0' . '0' . '0' . '0' . $deal->id;
				}elseif($deal->id < 1000){
					$deal_code = '0' . '0' . '0' . '0' . '0' . $deal->id;
				}elseif($deal->id < 10000){
					$deal_code = '0' . '0' . '0' . '0' . $deal->id;
				}elseif($deal->id < 100000){
					$deal_code = '0' . '0' . '0' . $deal->id;
				}elseif($deal->id < 1000000){
					$deal_code = '0' . '0' . $deal->id;
				}elseif($deal->id < 10000000){
					$deal_code = '0' . $deal->id;
				}else{
					$deal_code = $deal->id;
				}
			}
			
	        if($request->user_auditor_id){
				$user_auditor_id = $request->user_auditor_id;
			}else{$user_auditor_id = Auth::user()->id;}
	        
	        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
	        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
	        
	        $rating_ini = Rating::where('user_auditor_id', $user_auditor_id)->where('deal_id', $request->deal_id)->pluck('deal_id')->first();
	        $rating_id = Rating::where('user_auditor_id', $user_auditor_id)->where('deal_id', $request->deal_id)->pluck('id')->first();
	        $rating_find = Rating::find($rating_id);
	        
	        if($rating_ini && $rating_ini == $deal->id && (null != $rating_find->review && $rating_find->local_star != 0 && $rating_find->local_price != 0 && $rating_find->local_availab != 0 && $rating_find->local_descr != 0 && $rating_find->local_term != 0 && $rating_find->local_contact != 0 && $rating_find->local_recom != 0)){ //Если у пользователя сделки есть уже отзыв по данной сделке, и завершен
				$rating_create = 4;  //По данной сделке пользователь уже оставлял отзыв и завершил его
				return view('pages.ratings.edit', [
		        	'rating_create' => $rating_create,
		        ]);
			}elseif($rating_ini && $rating_ini == $deal->id){ //Если у пользователя сделки есть уже отзыв по данной сделке, но не завершен
	        	$rating = Rating::find($rating_id);
	        	if($request->local_star) $rating->local_star = $request->local_star;
	        	if($request->local_price) $rating->local_price = $request->local_price;
	        	if($request->local_availab) $rating->local_availab = $request->local_availab;
	        	if($request->local_descr) $rating->local_descr = $request->local_descr;
	        	if($request->local_term) $rating->local_term = $request->local_term;
	        	if($request->local_contact) $rating->local_contact = $request->local_contact;
	        	if($request->local_recom) $rating->local_recom = $request->local_recom;
	        	if($request->review) $rating->review = $request->review;
	        	if($request->message) $rating->message = $request->message;
	        	
	        	if($request->user_rated_id){
					$user_rated_id = $request->user_rated_id;
				}else{$user_rated_id = $rating->user_rated_id;}
	        	
	        	//Расчет показателей рейтинга
	        	$date_start = new DateTime();				//Взять текущую дату
	        	$date_start->sub(new DateInterval('P365D'));	//Вычисляем дату, которая на 12 месяцев раньше текущей
	        	$rating_star_5 = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('local_star', 5)->where('status', 1)->count();
	        	$rating_count = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('status', 1)->count();
	        	$rating_price_3 = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('local_price', 3)->where('status', 1)->count();
	        	$rating_availab_3 = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('local_availab', 3)->where('status', 1)->count();
	        	$rating_descr_3 = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('local_descr', 3)->where('status', 1)->count();
	        	$rating_term_3 = Rating::where('user_rated_id', $user_rated_id)->where('created_at', '>', $date_start)->where('local_term', 3)->where('status', 1)->count();
	        	if($rating_count > 9){
					$rating->rating_star = ($rating_star_5 * 100) / $rating_count;
					$rating->rating_price = ($rating_price_3 * 100) / $rating_count;
					$rating->rating_availab = ($rating_availab_3 * 100) / $rating_count;
					$rating->rating_descr = ($rating_descr_3 * 100) / $rating_count;
					$rating->rating_term = ($rating_term_3 * 100) / $rating_count;
				}

	        	$rating_create = 1;
			}else{  //По данной сделке пользователь еще не оставлял отзыв
				$rating = Rating::create($request->all());
		        $rating_create = 1;
		        $rating->service_id = $request->service_id;
		        $rating->deal_id = $request->deal_id;
		        $rating->status = 1;
					
				$rating_create = 1;

		        

			}
	        $rating->save(); //Сохранение рейтинга
	        
	        //dd($rating->rating_term);
	        
	        return view('pages.ratings.edit', [
        		'rating_create' => $rating_create,
        		'rating' => $rating,
        		'deal' => $deal,
        		'date_offset' => $date_offset,
        		'deal_code' => $deal_code,
        	]);
		}else{
			$rating_create = 2;
			return view('pages.ratings.edit', [
	        	'rating_create' => $rating_create,
	        ]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $rating_id = Rating::where('user_rated_id', $user_id)->where('status', 1)->pluck('id')->first();
        $rating = Rating::find($rating_id);
		$date_start = new DateTime();				//Взять текущую дату
	    $date_start->sub(new DateInterval('P182D'));	//Вычисляем дату, которая на 6 месяцев раньше текущей
		$ratings = Rating::where('user_rated_id', $user_id)->where('created_at', '>', $date_start)->where('status', 1)->get();
		$rating_count = Rating::where('user_rated_id', $user_id)->where('created_at', '>', $date_start)->where('status', 1)->count();
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
	    isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
		
		$user = User::find($user_id);
        
        return view('pages.ratings.show', [
        	'rating' => $rating,
        	'ratings' => $ratings,
        	'rating_count' => $rating_count,
        	'date_offset' => $date_offset,
        	'basket_mark' => $basket_mark,
        	'user' => $user,
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

   
    public function update(Request $request, $id)
    {
        $rating = Rating::find($id);
		$date_start = new DateTime();				//Взять текущую дату
	    $date_start->sub(new DateInterval('P182D'));	//Вычисляем дату, которая на 6 месяцев раньше текущей
		$ratings = Rating::where('user_rated_id', $request->user_rated_id)->where('created_at', '>', $date_start)->where('status', 1)->get();
		$rating_count = Rating::where('user_rated_id', $request->user_rated_id)->where('created_at', '>', $date_start)->where('status', 1)->count();
		$rating->message = $request->message;
		$rating->save(); //Запись ответа автора услуги на отзыв
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
	    isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;

        return view('pages.ratings.show', [
        	'rating' => $rating,
        	'ratings' => $ratings,
        	'rating_count' => $rating_count,
        	'date_offset' => $date_offset,
        	'basket_mark' => $basket_mark,
        ]);
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
}
