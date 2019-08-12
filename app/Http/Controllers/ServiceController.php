<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use App\BiddingType;
use App\BiddingRate;
use App\BlurbType;
use App\Blurb;
use App\ServiceDesc;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use App\Search;
use App\Reting;
use App\User;
use App\Score;
use App\Distance;
use App\Address;
use App\Basket;
use App\Message;

class ServiceController extends Controller
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

    //Создать услугу продажи
    public function mysellcreate()
    {
        $sections = Section::all();
        $bidding_types = BiddingType::whereIn('id', [2, 4, 6])->get();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        $sell_buy = 1;  //Я продааю
        $user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$services_free = Service::where('user_id', $user_id)->where('status', 1)->where('rate_bidding_id', null)->count();
    	//Тарифы публикации и рекламы
    	$bidding_rate1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_price1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	
    	$blurb_types = BlurbType::all();
    	$blurb_prises_0 = BlurbType::pluck('blurb_price');
    	$blurb_prises = '';
    	foreach($blurb_prises_0 as $bpr){
			$blurb_prises .= $bpr;
			$blurb_prises .= ',';
		}
		$blurb_periods_0 = BlurbType::pluck('period_blurb');
    	$blurb_periods = '';
    	foreach($blurb_periods_0 as $bpe){
			$blurb_periods .= $bpe;
			$blurb_periods .= ',';
		}
    	
    	//*** Количество БЕСПЛАТНО публикуемых услуг ***
    	if($services_free < 3){
			$allow_free = true;
		}else{$allow_free = false;}
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке

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
        
        return view('pages.services.create', [
			'sections' => $sections,
			'bidding_types' => $bidding_types,
			'address' => $address,
			'sell_buy' => $sell_buy,
			'user' => $user,
			'allow_free' => $allow_free,
			'bidding_rate1' => $bidding_rate1,
			'bidding_rate2' => $bidding_rate2,
			'bidding_rate3' => $bidding_rate3,
			'bidding_rate4' => $bidding_rate4,
			'bidding_price1' => $bidding_price1,
			'bidding_price2' => $bidding_price2,
			'bidding_price3' => $bidding_price3,
			'bidding_price4' => $bidding_price4,
			'blurb_types' => $blurb_types,
			'blurb_prises' => $blurb_prises,
			'blurb_periods' => $blurb_periods,
			'balance0' => $balance0,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
        ]);
    }
    
    //Создать услугу покупки
    public function mybuycreate()
    {
        $sections = Section::all();
        $bidding_types = BiddingType::whereIn('id', [3, 5, 7])->get();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        $sell_buy = 2;  //Я покупаю
        $user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$services_free = Service::where('user_id', $user_id)->where('status', 1)->where('rate_bidding_id', null)->count();
    	//Тарифы публикации и рекламы
    	$bidding_rate1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_price1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	
    	$blurb_types = BlurbType::all();
    	$blurb_prises_0 = BlurbType::pluck('blurb_price');
    	$blurb_prises = '';
    	foreach($blurb_prises_0 as $bpr){
			$blurb_prises .= $bpr;
			$blurb_prises .= ',';
		}
		$blurb_periods_0 = BlurbType::pluck('period_blurb');
    	$blurb_periods = '';
    	foreach($blurb_periods_0 as $bpe){
			$blurb_periods .= $bpe;
			$blurb_periods .= ',';
		}
    	
    	//*** Количество БЕСПЛАТНО публикуемых услуг ***
    	if($services_free < 3){
			$allow_free = true;
		}else{$allow_free = false;}
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке

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
        
        return view('pages.services.create', [
			'sections' => $sections,
			'bidding_types' => $bidding_types,
			'address' => $address,
			'sell_buy' => $sell_buy,
			'user' => $user,
			'allow_free' => $allow_free,
			'bidding_rate1' => $bidding_rate1,
			'bidding_rate2' => $bidding_rate2,
			'bidding_rate3' => $bidding_rate3,
			'bidding_rate4' => $bidding_rate4,
			'bidding_price1' => $bidding_price1,
			'bidding_price2' => $bidding_price2,
			'bidding_price3' => $bidding_price3,
			'bidding_price4' => $bidding_price4,
			'blurb_types' => $blurb_types,
			'blurb_prises' => $blurb_prises,
			'blurb_periods' => $blurb_periods,
			'balance0' => $balance0,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
        ]);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' =>'required',
            'section_id' =>'required',
            'category_id' =>'required',
            'kind_id' =>'required',
            'bidding_type' =>'required',            
            'period'  =>  'required',
            'date_on'  =>  'required',
            'date_off'  =>  'required',
            'image' =>  'nullable|image',
            'number_total' => 'required',
            'place_id' => 'required',
        	'content' => 'required',
        	'description' => 'required',
        	'value_service' => 'required',
        	'period_initial' => 'required',
        	'period_deadline' => 'required',
        	'result' => 'required',
        	'availability' => 'required',
        	'terms_payment' => 'required'
        ]);

		
        $service = Service::add($request->all());
        $service->uploadImage($request->file('image'));
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        $service->number_total = $request->get('number_total');
        $service->place_id = $request->get('place_id');
        if($request->get('price_start')){
			$service->price_start = $request->get('price_start');
			$service->price_current = $request->get('price_start');
		}
        if($request->get('price_buy_now'))  {$service->price_buy_now = $request->get('price_buy_now');}
		if($request->get('price_sell_now'))  {$service->price_sell_now = $request->get('price_sell_now');}
		if($request->get('price_lower'))  {$service->price_lower = $request->get('price_lower');}
		if($request->get('bet_step'))  {$service->bet_step = $request->get('bet_step');}
		
		
		//*** Платная публикация и реклама ***
		$price_start = $request->price_start;
		$price_buy_now = $request->price_buy_now;
		$price_sell_now = $request->price_sell_now;
		$price_max = $price_start;
		if($price_max < $price_buy_now){$price_max = $price_buy_now;}
		if($price_max < $price_sell_now){$price_max = $price_sell_now;}
		//Платная публикация
		$bidding_rate_id = BiddingRate::where('bidding_type', $request->bidding_type)->where('price_start', '<', $price_max)->where('price_end', '>', $price_max)->pluck('id')->first();
		$bidding_rate_price = BiddingRate::where('bidding_type', $request->bidding_type)->where('price_start', '<', $price_max)->where('price_end', '>', $price_max)->pluck('rate_bidding')->first();
		
		if(null != $bidding_rate_id){ //Если выбрана платная публикация
			$bidding_rate = $bidding_rate_price;
			$rate_bidding_id = $bidding_rate_id;
		}else{
			$bidding_rate = 0;
			$rate_bidding_id = null;
		}
		//Реклама
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
		$delta = $balance0 - $bidding_rate - $blurb_rate; 
		
		//*** Публикация услуги ***
		if($request->allow_public == 1 && $request->accept){  
			$service->status = 1; //Если это бесплатная публикация и нажата кнопка Опубликовать - присвоить статус Опубликована
			$status = 'Услуга опубликована бесплатно';
		}elseif(($delta > 0 || $delta == 0) && $request->accept){
			$service->status = 1;  //Публикуем платную услугу
			$status = 'Услуга опубликована по тарифу '.$bidding_rate.' грн';
			$service->rate_bidding_id = $rate_bidding_id;  //Сохранить в услуге ID платной опции публикации
			//Списываем со счета деньги за публикацию
			$score = Score::create($request->all());
			$score->cause = 4; //Оплата публикации
			$score->balance = $balance0 - $bidding_rate;
			$score->expense = $bidding_rate;
			$score->service_id = $service->id;
			$score->date_trans = $score->updated_at;
			$score->save(); 
		}else{
			$service->status = 0;
			$status = 'Услуга не опубликована - сохранена в архивных. Проверьте достаточно ли средств на счету для публикации платной услуги. Поставьте галочку о согласии с условиями и тарифами при публикации';
		}
		//Если на платную публикацию или/и рекламу не достаточно средств - не публикуем
		if(($delta > 0 || $delta == 0) && $request->accept){ 
			if(null != $blurb_type){  //Если на рекламу достаточно средств - создаем рекламу
				$service->blurb_type_id = $blurb_type_id; //Зпись в таблице услуг о том, что для данной услуги есть реклама
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
				
				//Если период публикации рекламы меньше периода рекламы - увеличить период публикации услуги и сдвинуть конечную дату
				if($service->period < $blurb_type->period_blurb){
					$service->period = $blurb_type->period_blurb;
					$service->setDateOffAttribute($request->get('date_off_blurb'), $request->get('date_offset'));
				}
			}
		}
		

        //Определить максимальное значение товарного кода услуги для данного вида услуг
        $serviceMaxCode = Service::where('kind_id', $request->kind_id)->max('product_code_id');
		$kind_code = Kind::where('id', $request->kind_id)->value('code');
		if($serviceMaxCode)
		{
			$serviceCode = substr($serviceMaxCode, 6, 4) * 1 + 1;

			if($serviceCode < 10){
				$serviceCode = $kind_code . '0' . '0' . '0' . $serviceCode;
				}elseif($serviceCode < 100){
					$serviceCode = $kind_code . '0' . '0' . $serviceCode;
					}elseif($serviceCode < 1000){
						$serviceCode = $kind_code . '0' . $serviceCode;
						}else{
							$serviceCode = $kind_code . $serviceCode;
							}
		}else{
			$serviceCode = $kind_code . '0001';
		}        
        //Присвоение товарного кода новой услуге
        $service->product_code_id = $serviceCode;
        
        
        //Сохранение дополнительного описания услуг в таблице ServiceDesc
        //Поиск в таблице доп описания записи для текущей услуги
        $existing_desc_find = ServiceDesc::where('service_id', $service->id)->pluck('service_id')->first(); 
        if($existing_desc_find){
			$id_sd = ServiceDesc::where('service_id', $service->id)->pluck('id')->first();
			$existing_desc = ServiceDesc::find($id_sd);
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$existing_desc->content = $request->get('content');					
			$existing_desc->description = $request->get('description');
			$existing_desc->value_service = $request->get('value_service');
			$existing_desc->add_materials = $request->get('add_materials');
			$existing_desc->duration = $request->get('duration');
			$existing_desc->result = $request->get('result');
			$existing_desc->availability = $request->get('availability');
			$existing_desc->terms_payment = $request->get('terms_payment');
			$existing_desc->terms_provision = $request->get('terms_provision');
			$existing_desc->slogan = $request->get('slogan');
			//автоматически ставить галочку «Расширяемая услуга» при указании необходимых дополнительных материалах
			if($request->get('add_materials')){
				$existing_desc->expandable = 1;
			}else{
				$existing_desc->expandable = $request->get('expandable');
			}
        	$existing_desc->scalable = $request->get('scalable');
			$existing_desc->add_terms = $request->get('add_terms');
			$existing_desc->save();			//сохранение записи в дополнительной таблице описания услуги
		}else{
			//Создание нового объекта Описания услуги для сохранения доп описания и ID услуги
			$new_desc = new ServiceDesc;         
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$new_desc->content = $request->get('content');
			$new_desc->description = $request->get('description');
			$new_desc->value_service = $request->get('value_service');
			$new_desc->add_materials = $request->get('add_materials');
			$new_desc->duration = $request->get('duration');
			$new_desc->result = $request->get('result');
			$new_desc->availability = $request->get('availability');
			$new_desc->terms_payment = $request->get('terms_payment');
			$new_desc->terms_provision = $request->get('terms_provision');
			$new_desc->add_terms = $request->get('add_terms');
			$new_desc->slogan = $request->get('slogan');
			//автоматически ставить галочку «Расширяемая услуга» при указании необходимых дополнительных материалах
			if($request->get('add_materials')){
				$new_desc->expandable = 1;
			}else{
				$new_desc->expandable = $request->get('expandable');
			}
        	$new_desc->scalable = $request->get('scalable');
			$new_desc->service_id = $service->id;
			$new_desc->save();  //сохранение записи в дополнительной таблице описания услуги
		}
		
		
		//Сохранение периодов предоставления услуги в таблице Distance
        //Создание нового объекта периодов предоставления услуги для сохранения в таблице Distance
		$distance = new Distance;
		$distance->service_id = $service->id;
		$distance->user_id = $service->user_id;
		$distance->period_initial = $request->get('period_initial');
		$distance->period_deadline = $request->get('period_deadline');
		$distance->schedule = $request->get('schedule');
		$distance->save();	//сохранение записи в таблице Distance
		
		
		//Сохранение адресов предоставления услуги в таблице Address
        //Создание нового объекта адресов предоставления услуги для сохранения в таблице Address
		$new_address = new Address;
		$new_address->service_id = $service->id;
		//user_id не заполняется специально, чтобы отличать адреса услуг от адресов пользователей
		$new_address->region = $request->get('region');
		$new_address->district = $request->get('district');
		$new_address->city = $request->get('city');
		$new_address->street = $request->get('street');
		$new_address->house = $request->get('house');
		$new_address->save();
		
		
		//Сохранение city_id
		if($request->get('district')){
			$second0 = Ukraine2::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id')
	        					->union($second0)
	        					->union($third0)
	        					->union($fourth0)
	        					->first();
		}else{
			$second0 = Ukraine2::where('region', $request->region)
								->where('city', $request->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $request->region)
								->where('city', $request->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $request->region)
								->where('city', $request->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $request->region)
								->where('city', $request->city)->pluck('id')
	        					->union($second0)
	        					->union($third0)
	        					->union($fourth0)
	        					->first();
		}
		$service->city_id = $city_id;
		
		
		//Сохранение region_id
		$second2 = Ukraine2::where('region', $request->region)->pluck('id');
        $third2 = Ukraine3::where('region', $request->region)->pluck('id');
        $fourth2 = Ukraine4::where('region', $request->region)->pluck('id');      
        $region_id = Ukraine1::where('region', $request->region)->pluck('id')
        					->union($second2)
        					->union($third2)
        					->union($fourth2)
        					->first();
		$service->region_id = $region_id;
		
        
 		//Отправка сообщения о том, что скоро будет превышен лимит в кодировке услуг для определенного вида услуг
		$serviceCodeEnd = substr($request->product_code_id, 6, 4) * 1;
		if($serviceCodeEnd > 8000){
				$kind_id = $request->kind_id;
				$kind_title = Kind::where('id', $request->kind_id)->value('title');
				event(new ProductCodeExcess($kind_id, $kind_title));
			}
		

		//Сохранить новую услугу
		$service->save();

        return redirect()->route('service.show', $service->id)->with('status', $status);
    }

    
    public function show($id)
    {
        $service = Service::find($id);
        $bidding_types = BiddingType::all();
        $sections = Section::all();
        
        //ID города, области
        if(isset($request->region_id)){
			$region_id = $request->region_id;
		}elseif(isset($_COOKIE["region_id"])){
			$region_id = $_COOKIE["region_id"];
		}else{
			$region_id = null;
		}
		if(isset($request->region)){
			$region = $request->region;
		}elseif(isset($_COOKIE["region"])){
			$region = $_COOKIE["region"];
		}elseif(isset($region_id)){
			$second2 = Ukraine2::where('id', $region_id)->pluck('region');
	        $third2 = Ukraine3::where('id', $region_id)->pluck('region');
	        $fourth2 = Ukraine4::where('id', $region_id)->pluck('region');      
	        $region = Ukraine1::where('id', $region_id)->pluck('region')
	        					->union($second2)
	        					->union($third2)
	        					->union($fourth2)
	        					->first();
		}else{
			$region = null;
		}
		//Город
		if(isset($request->city_id)){
			$city_id = $request->city_id;
		}elseif(isset($_COOKIE["city_id"])){
			$city_id = $_COOKIE["city_id"];
		}else{
			$city_id = null;
		}
		if(isset($request->city)){
			$city = $request->city;
		}elseif(isset($_COOKIE["city"])){
			$city = $_COOKIE["city"];
		}elseif(isset($city_id)){
			$second2 = Ukraine2::where('id', $city_id)->pluck('city');
	        $third2 = Ukraine3::where('id', $city_id)->pluck('city');
	        $fourth2 = Ukraine4::where('id', $city_id)->pluck('city');      
	        $city = Ukraine1::where('id', $city_id)->pluck('city')
	        					->union($second2)
	        					->union($third2)
	        					->union($fourth2)
	        					->first();
		}else{
			$city = null;
		}
		//Район
		if(isset($request->district)){
			$district = $request->district;
		}elseif(isset($_COOKIE["district"])){
			$district = $_COOKIE["district"];
		}else{
			$district = null;
		}
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        //Тарифы публикации и рекламы
		$blurb_types = BlurbType::all();
    	$blurb_prises_0 = BlurbType::pluck('blurb_price');
    	$blurb_prises = '';
    	foreach($blurb_prises_0 as $bpr){
			$blurb_prises .= $bpr;
			$blurb_prises .= ',';
		}
		$blurb_periods_0 = BlurbType::pluck('period_blurb');
    	$blurb_periods = '';
    	foreach($blurb_periods_0 as $bpe){
			$blurb_periods .= $bpe;
			$blurb_periods .= ',';
		}
        
        //Баланс по последней сделке
        if(isset(Auth::user()->id)){
			$user_id = Auth::user()->id;
			$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first();
		}else{
			$user_id = null;
			$balance0 = 0;
		}
		//Дата окончания услуги в текстовом формате
		$date_off = $service->date_off;
		$date_off_str = date("Y", strtotime($date_off)).'-'.date("m", strtotime($date_off)).'-'.date("d", strtotime($date_off)).' '.date("H", strtotime($date_off)).':'.date("i", strtotime($date_off)).':'.date("s", strtotime($date_off));
		
        
        return view('pages.services.show', [
        	'service' => $service,
        	'sections' => $sections,
        	'bidding_types' => $bidding_types,
        	'city_id' => $city_id,
			'region_id' => $region_id,
			'city' => $city,
			'region' => $region,
			'district' => $district,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,
			'blurb_prises' => $blurb_prises,
			'blurb_periods' => $blurb_periods,
			'balance0' => $balance0,
			'user_id' => $user_id,
			'blurb_types' => $blurb_types,
			'date_off_str' => $date_off_str,
        	
        ]);
    }

    
    //Редактировать услугу продажи
    public function myselledit($id)
    {
        $service = Service::find($id);
        $sections = Section::all();
        $bidding_types = BiddingType::whereIn('id', [2, 4, 6])->get();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $uaddress = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        $sell_buy = 1;  //Я продаю
        $user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$services_free = Service::where('user_id', $user_id)->where('status', 1)->where('rate_bidding_id', null)->count();
    	//Тарифы публикации и рекламы
    	$bidding_rate1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_price1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [2, 4, 6, 102])->orderBy('id')->pluck('price_start')->first();
    	
    	$blurb_types = BlurbType::all();
    	$blurb_prises_0 = BlurbType::pluck('blurb_price');
    	$blurb_prises = '';
    	foreach($blurb_prises_0 as $bpr){
			$blurb_prises .= $bpr;
			$blurb_prises .= ',';
		}
		$blurb_periods_0 = BlurbType::pluck('period_blurb');
    	$blurb_periods = '';
    	foreach($blurb_periods_0 as $bpe){
			$blurb_periods .= $bpe;
			$blurb_periods .= ',';
		}
    	
    	//*** Количество БЕСПЛАТНО публикуемых услуг ***
    	if($services_free < 3){
			$allow_free = true;
		}else{$allow_free = false;}
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке

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
        
        return view('pages.services.edit', [
			'service' => $service,
			'sections' => $sections,
			'bidding_types' => $bidding_types,
			'uaddress' => $uaddress,
			'sell_buy' => $sell_buy,
			'user' => $user,
			'allow_free' => $allow_free,
			'bidding_rate1' => $bidding_rate1,
			'bidding_rate2' => $bidding_rate2,
			'bidding_rate3' => $bidding_rate3,
			'bidding_rate4' => $bidding_rate4,
			'bidding_price1' => $bidding_price1,
			'bidding_price2' => $bidding_price2,
			'bidding_price3' => $bidding_price3,
			'bidding_price4' => $bidding_price4,
			'blurb_types' => $blurb_types,
			'blurb_prises' => $blurb_prises,
			'blurb_periods' => $blurb_periods,
			'balance0' => $balance0,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
        ]);
    }
    
    
	//Редактировать услугу продажи
    public function mybuyedit($id)
    {
        $service = Service::find($id);
        $sections = Section::all();
        $bidding_types = BiddingType::whereIn('id', [3, 5, 7])->get();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $uaddress = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        $sell_buy = 2;  //Я покупаю
        $user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$services_free = Service::where('user_id', $user_id)->where('status', 1)->where('rate_bidding_id', null)->count();
    	//Тарифы публикации и рекламы
    	$bidding_rate1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_rate4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('rate_bidding')->first();
    	$bidding_price1 = BiddingRate::whereBetween('price_start', [0, 20])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price2 = BiddingRate::whereBetween('price_start', [21, 150])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price3 = BiddingRate::whereBetween('price_start', [151, 500])->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	$bidding_price4 = BiddingRate::where('price_start', '>', 501)->whereIn('bidding_type', [3, 5, 7, 103])->orderBy('id')->pluck('price_start')->first();
    	
    	$blurb_types = BlurbType::all();
    	$blurb_prises_0 = BlurbType::pluck('blurb_price');
    	$blurb_prises = '';
    	foreach($blurb_prises_0 as $bpr){
			$blurb_prises .= $bpr;
			$blurb_prises .= ',';
		}
		$blurb_periods_0 = BlurbType::pluck('period_blurb');
    	$blurb_periods = '';
    	foreach($blurb_periods_0 as $bpe){
			$blurb_periods .= $bpe;
			$blurb_periods .= ',';
		}
    	
    	//*** Количество БЕСПЛАТНО публикуемых услуг ***
    	if($services_free < 3){
			$allow_free = true;
		}else{$allow_free = false;}
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке

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
        
        return view('pages.services.edit', [
			'service' => $service,
			'sections' => $sections,
			'bidding_types' => $bidding_types,
			'uaddress' => $uaddress,
			'sell_buy' => $sell_buy,
			'user' => $user,
			'allow_free' => $allow_free,
			'bidding_rate1' => $bidding_rate1,
			'bidding_rate2' => $bidding_rate2,
			'bidding_rate3' => $bidding_rate3,
			'bidding_rate4' => $bidding_rate4,
			'bidding_price1' => $bidding_price1,
			'bidding_price2' => $bidding_price2,
			'bidding_price3' => $bidding_price3,
			'bidding_price4' => $bidding_price4,
			'blurb_types' => $blurb_types,
			'blurb_prises' => $blurb_prises,
			'blurb_periods' => $blurb_periods,
			'balance0' => $balance0,
			'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' =>'required',
            'section_id' =>'required',	//В контроллере админа отсутствует требование наличия
            'category_id' =>'required',	//В контроллере админа отсутствует требование наличия
            'kind_id' =>'required',		//В контроллере админа отсутствует требование наличия
            'bidding_type' =>'required',            
            'period'  =>  'required',
            'date_on'  =>  'required',
            'date_off'  =>  'required',
            'image' =>  'nullable|image',
            'number_total' => 'required',
            'place_id' => 'required',
        	'content' => 'required',
        	'description' => 'required',
        	'value_service' => 'required',
        	'period_initial' => 'required',
        	'period_deadline' => 'required',
        	'result' => 'required',
        	'availability' => 'required',
        	'terms_payment' => 'required'
        ]);

		
        $service = Service::findOrFail($id);
        $service->edit($request->all());
        $service->uploadImage($request->file('image'));
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        $service->number_total = $request->get('number_total');
        $service->place_id = $request->get('place_id');
        if($request->get('price_start')){
			$service->price_start = $request->get('price_start');
			if($request->get('price_start') > $service->price_current){
				$service->price_current = $request->get('price_start');
			}
		}
        if($request->get('price_buy_now'))  {$service->price_buy_now = $request->get('price_buy_now');}
		if($request->get('price_sell_now'))  {$service->price_sell_now = $request->get('price_sell_now');}
		if($request->get('price_lower'))  {$service->price_lower = $request->get('price_lower');}
		if($request->get('bet_step'))  {$service->bet_step = $request->get('bet_step');}
		
		//Обновить категорию и вид услуг в базе, если в форме "edit" они менялись
        if($request->category_id_v != null & $request->category_id_v != $request->category_id){
			$service->category_id = $request->category_id_v;
		}
        if($request->kind_id_v != null & $request->kind_id_v != $request->kind_id){
			$service->kind_id = $request->kind_id_v;
		}
		
		//Изменение слага перед сохранением по мотивам измененного названия
        $service->slug = str_slug($service->title);
		
		
		//*** Платная публикация и реклама ***
		$price_start = $request->price_start;
		$price_buy_now = $request->price_buy_now;
		$price_sell_now = $request->price_sell_now;
		$price_max = $price_start;
		if($price_max < $price_buy_now){$price_max = $price_buy_now;}
		if($price_max < $price_sell_now){$price_max = $price_sell_now;}
		//Платная публикация
		$bidding_rate_id = BiddingRate::where('bidding_type', $request->bidding_type)->where('price_start', '<', $price_max)->where('price_end', '>', $price_max)->pluck('id')->first();
		$bidding_rate_price = BiddingRate::where('bidding_type', $request->bidding_type)->where('price_start', '<', $price_max)->where('price_end', '>', $price_max)->pluck('rate_bidding')->first();
		
		if(null != $bidding_rate_id){ //Если выбрана платная публикация
			$bidding_rate = $bidding_rate_price;
			$rate_bidding_id = $bidding_rate_id;
		}else{
			$bidding_rate = 0;
			$rate_bidding_id = null;
		}
		//Реклама
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
		$balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); 
		//Проверка достаточности средств на счету для оплаты публикации и рекламы
		$delta = $balance0 - $bidding_rate - $blurb_rate; 
		
		//*** Публикация услуги ***
		if($request->allow_public == 1 && $request->accept){  
			$service->status = 1; //Если это бесплатная публикация и нажата кнопка Опубликовать - присвоить статус Опубликована
			$status = 'Услуга опубликована бесплатно';
		}elseif(($delta > 0 || $delta == 0) && $request->accept){
			$service->status = 1;  //Публикуем платную услугу
			$status = 'Услуга опубликована по тарифу '.$bidding_rate.' грн';
			$service->rate_bidding_id = $rate_bidding_id;  //Сохранить в услуге ID платной опции публикации
			//Списываем со счета деньги за публикацию
			$score = Score::create($request->all());
			$score->cause = 4; //Оплата публикации
			$score->balance = $balance0 - $bidding_rate;
			$score->expense = $bidding_rate;
			$score->service_id = $service->id;
			$score->date_trans = $score->updated_at;
			$score->save(); 
		}else{
			$service->status = 0;
			$status = 'Услуга не опубликована - сохранена в архивных. Проверьте достаточно ли средств на счету для публикации платной услуги. Поставьте галочку о согласии с условиями и тарифами при публикации';
		}
		//Если на платную публикацию или/и рекламу не достаточно средств - не публикуем
		if(($delta > 0 || $delta == 0) && $request->accept){ 
			if(null != $blurb_type){  //Если на рекламу достаточно средств - создаем рекламу
				$service->blurb_type_id = $blurb_type_id; //Зпись в таблице услуг о том, что для данной услуги есть реклама
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
				
				//Если период публикации рекламы меньше периода рекламы - увеличить период публикации услуги и сдвинуть конечную дату
				if($service->period < $blurb_type->period_blurb){
					$service->period = $blurb_type->period_blurb;
					$service->setDateOffAttribute($request->get('date_off_blurb'), $request->get('date_offset'));
				}
			}
		}
		

        //Определить максимальное значение товарного кода услуги для данного вида услуг
        $serviceMaxCode = Service::where('kind_id', $request->kind_id)->max('product_code_id');
		$kind_code = Kind::where('id', $request->kind_id)->value('code');
		if($serviceMaxCode)
		{
			$serviceCode = substr($serviceMaxCode, 6, 4) * 1 + 1;

			if($serviceCode < 10){
				$serviceCode = $kind_code . '0' . '0' . '0' . $serviceCode;
				}elseif($serviceCode < 100){
					$serviceCode = $kind_code . '0' . '0' . $serviceCode;
					}elseif($serviceCode < 1000){
						$serviceCode = $kind_code . '0' . $serviceCode;
						}else{
							$serviceCode = $kind_code . $serviceCode;
							}
		}else{
			$serviceCode = $kind_code . '0001';
		}        
        //Присвоение товарного кода новой услуге
        $service->product_code_id = $serviceCode;
        
        
        //Сохранение дополнительного описания услуг в таблице ServiceDesc
        //Поиск в таблице доп описания записи для текущей услуги
        $existing_desc_find = ServiceDesc::where('service_id', $service->id)->pluck('service_id')->first(); 
        if($existing_desc_find){
			$id_sd = ServiceDesc::where('service_id', $service->id)->pluck('id')->first();
			$existing_desc = ServiceDesc::find($id_sd);
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$existing_desc->content = $request->get('content');					
			$existing_desc->description = $request->get('description');
			$existing_desc->value_service = $request->get('value_service');
			$existing_desc->add_materials = $request->get('add_materials');
			$existing_desc->duration = $request->get('duration');
			$existing_desc->result = $request->get('result');
			$existing_desc->availability = $request->get('availability');
			$existing_desc->terms_payment = $request->get('terms_payment');
			$existing_desc->terms_provision = $request->get('terms_provision');
			$existing_desc->slogan = $request->get('slogan');
			//автоматически ставить галочку «Расширяемая услуга» при указании необходимых дополнительных материалах
			if($request->get('add_materials')){
				$existing_desc->expandable = 1;
			}else{
				$existing_desc->expandable = $request->get('expandable');
			}
        	$existing_desc->scalable = $request->get('scalable');
			$existing_desc->add_terms = $request->get('add_terms');
			$existing_desc->save();			//сохранение записи в дополнительной таблице описания услуги
		}else{
			//Создание нового объекта Описания услуги для сохранения доп описания и ID услуги
			$new_desc = new ServiceDesc;         
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$new_desc->content = $request->get('content');
			$new_desc->description = $request->get('description');
			$new_desc->value_service = $request->get('value_service');
			$new_desc->add_materials = $request->get('add_materials');
			$new_desc->duration = $request->get('duration');
			$new_desc->result = $request->get('result');
			$new_desc->availability = $request->get('availability');
			$new_desc->terms_payment = $request->get('terms_payment');
			$new_desc->terms_provision = $request->get('terms_provision');
			$new_desc->add_terms = $request->get('add_terms');
			$new_desc->slogan = $request->get('slogan');
			//автоматически ставить галочку «Расширяемая услуга» при указании необходимых дополнительных материалах
			if($request->get('add_materials')){
				$new_desc->expandable = 1;
			}else{
				$new_desc->expandable = $request->get('expandable');
			}
        	$new_desc->scalable = $request->get('scalable');
			$new_desc->service_id = $service->id;
			$new_desc->save();  //сохранение записи в дополнительной таблице описания услуги
		}
		
		
		//Сохранение периодов предоставления услуги в таблице Distance
		//Поиск в таблице периодов предоставления записи для текущей услуги
        $distance_id = Distance::where('service_id', $id)->pluck('id')->first();
        if($distance_id){
			$distance = Distance::find($distance_id);
			$distance->period_initial = $request->get('period_initial');
			$distance->period_deadline = $request->get('period_deadline');
			$distance->schedule = $request->get('schedule');
			$distance->save();	//сохранение записи в таблице Distance
		}else{
			//Создание нового объекта периодов предоставления услуги для сохранения в таблице Distance
			$new_distance = new Distance;
			$new_distance->service_id = $service->id;
			$new_distance->user_id = $service->user_id;
			$new_distance->period_initial = $request->get('period_initial');
			$new_distance->period_deadline = $request->get('period_deadline');
			$new_distance->schedule = $request->get('schedule');
			$new_distance->save();	//сохранение записи в таблице Distance
		}
		
		
		//Обновить область, город, район, улицу и дом в базе, если в форме "edit" они менялись
		//Поиск в таблице Address записи для текущей услуги
		$address_id = Address::where('service_id', $id)->pluck('id')->first();
		if($address_id){
			$address = Address::find($address_id);
			$address->region = $request->get('region');
			if($request->district_v != null & $request->district_v != $request->district){
				$address->district = $request->district_v;
			}
			if($request->district_er){  //Если адрес изменен так, что район теперь указывать не нужно
				$address->district = null;
			}
			if($request->city_v != null & $request->city_v != $request->city){
				$address->city = $request->city_v;
			}
			if($request->street_v != null & $request->street_v != $request->street){
				$address->street = $request->street_v;
			}
			if($request->house_v != null & $request->house_v != $request->house){
				$address->house = $request->house_v;
			}	
			$address->save();	//сохранение записи в таблице Distance
		}else{
			//Сохранение адресов предоставления услуги в таблице Address
	        //Создание нового объекта адресов предоставления услуги для сохранения в таблице Address
			$address = new Address;
			$address->service_id = $service->id;
			//user_id не заполняется специально, чтобы отличать адреса услуг от адресов пользователей
			$address->region = $request->get('region');
			$address->district = $request->get('district_v');
			$address->city = $request->get('city_v');
			$address->street = $request->get('street_v');
			$address->house = $request->get('house_v');
			$address->save();
		}
		
		
		//Сохранение city_id
		if($request->get('district')){
			$second0 = Ukraine2::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $request->region)
								->where('district', $request->district)
								->where('city', $request->city)->pluck('id')
	        					->union($second0)
	        					->union($third0)
	        					->union($fourth0)
	        					->first();
		}else{
			$second0 = Ukraine2::where('region', $request->region)
								->where('city', $request->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $request->region)
								->where('city', $request->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $request->region)
								->where('city', $request->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $request->region)
								->where('city', $request->city)->pluck('id')
	        					->union($second0)
	        					->union($third0)
	        					->union($fourth0)
	        					->first();
		}
		$service->city_id = $city_id;
		
		
		//Сохранение region_id
		$second2 = Ukraine2::where('region', $request->region)->pluck('id');
        $third2 = Ukraine3::where('region', $request->region)->pluck('id');
        $fourth2 = Ukraine4::where('region', $request->region)->pluck('id');      
        $region_id = Ukraine1::where('region', $request->region)->pluck('id')
        					->union($second2)
        					->union($third2)
        					->union($fourth2)
        					->first();
		$service->region_id = $region_id;
		
        
 		//Отправка сообщения о том, что скоро будет превышен лимит в кодировке услуг для определенного вида услуг
		$serviceCodeEnd = substr($request->product_code_id, 6, 4) * 1;
		if($serviceCodeEnd > 8000){
				$kind_id = $request->kind_id;
				$kind_title = Kind::where('id', $request->kind_id)->value('title');
				event(new ProductCodeExcess($kind_id, $kind_title));
			}
		

		//Сохранить измененную услугу
		$service->save();

        return redirect()->route('service.show', $service->id)->with('status', $status);
    }

    //Удаление услуги в разделе Я продаю
    public function destroymysell($id)
    {
        Service::find($id)->remove();
        return redirect()->route('service.mysell');
    }
    
    //Удаление услуги в разделе Я покупаю
    public function destroymybuy($id)
    {
        Service::find($id)->remove();
        return redirect()->route('service.mybuy');
    }
    
    //Показать Мои продажи
    public function mysell()
    {
    	//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        $user_id = Auth::user()->id;
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
    
    	if($user_id){
    		$user = User::find($user_id);
    		$services = Service::where('user_id', $user_id)->whereIn('bidding_type', [2, 4, 6, 102])->where('status', 1)->orderBy('date_off', 'desc')->get();
    		$services_a = Service::where('user_id', $user_id)->whereIn('bidding_type', [2, 4, 6, 102])->where('status', 0)->orderBy('date_off', 'desc')->get();
    		$sell_buy = 1;
    		
    		
			return view('pages.services.myindex')->with([
					  'services' => $services,
					  'services_a' => $services_a,
					  'date_offset' => $date_offset,
					  'user' => $user,
					  'sell_buy' => $sell_buy,
					  'basket_mark' => $basket_mark,
				]);
		}else{
			$user = null;
			$sell_buy = null;
			$services = null;
			$services_a = null;
			return view('pages.services.myindex')->with([
					  'services' => $services,
					  'date_offset' => $date_offset,
					  'user' => $user,
					  'sell_buy' => $sell_buy,
					  'basket_mark' => $basket_mark,
				]);
		}
	    	
    }
    
    //Показать Мои покупки
    public function mybuy()
    {
    	//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        $user_id = Auth::user()->id;
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
    
    	if($user_id){
    		$user = User::find($user_id);
    		$services = Service::where('user_id', $user_id)->whereIn('bidding_type', [3, 5, 7, 103])->where('status', 1)->orderBy('date_off', 'desc')->get();
    		$services_a = Service::where('user_id', $user_id)->whereIn('bidding_type', [3, 5, 7, 103])->where('status', 0)->orderBy('date_off', 'desc')->get();
    		$sell_buy = 2;
    		
			return view('pages.services.myindex')->with([
					  'services' => $services,
					  'services_a' => $services_a,
					  'date_offset' => $date_offset,
					  'user' => $user,
					  'sell_buy' => $sell_buy,
					  'basket_mark' => $basket_mark,
				]);
		}else{
			$user = null;
			$sell_buy = null;
			$services = null;
			$services_a = null;
			return view('pages.services.myindex')->with([
					  'services' => $services,
					  'date_offset' => $date_offset,
					  'user' => $user,
					  'sell_buy' => $sell_buy,
					  'basket_mark' => $basket_mark,
				]);
		}
	    	
    }
    
    //Показать все услуги выбранного пользователя
    public function showuservice($user_id)
    {
    	//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
    
		$user = User::find($user_id);
		$status = 'Показаны все услуги автора '.$user->name;
		$services = Service::where('user_id', $user_id)->where('status', 1)->orderBy('date_off', 'desc')->get();
		$sections = Section::all();
 		$categories = Category::all();
		$kinds = Kind::all();
        $bidding_types = BiddingType::all();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        $services_on_page = 50;
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
	    		
		return view('pages.services.index', [
				'services' => $services,
				'date_offset' => $date_offset,
				'bidding_types' => $bidding_types,
	        	'address' => $address,
	        	'sections' => $sections,
	        	'categories' => $categories,
	        	'kinds' => $kinds,
				'services_on_page' => $services_on_page,
				'status' => $status,
				'basket_mark' => $basket_mark,
			]);
    }
    
    
    
    
    
}
