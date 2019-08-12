<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deal;
use App\Service;
use App\Basket;
use App\BiddingType;
use App\Message;
use App\User;
use DateTime;
use DateTimeZone;
use DateInterval;
use Auth;
use App\Events\DealNew;
use App\Events\DealAccept;
use App\Events\DealCancel;

class DealsController extends Controller
{
    
    public function index()
    {
        $deals = Deal::where('hide', '<>', Auth::user()->id)
        	->where(function ($query) {
                $query->where('initiator', Auth::user()->id)
                      ->orWhere('author', Auth::user()->id);
            })
        	->get();
        $bidding_types = BiddingType::all();
        foreach($deals as $deal){$id = $deal->id; break;}
        if(isset($id)){
        	$deals_is = 1;
        }else{
			$deals_is = null;
		}
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        
        return view('pages.deals.index', [
        	'deals' => $deals,
        	'bidding_types' => $bidding_types,
        	'deals_is' => $deals_is,
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
        $this->validate($request, [
            'service_id' =>'required',
            'number_unit' =>'required', 
            'basket_id' =>'required', 
	    ]);
		$service = Service::find($request->service_id);
		$basket = Basket::find($request->basket_id);
        $delta = $service->number_total - $request->number_unit;
        
        $initiator = $basket->initiator;  //ID Инициатора сделки (нажавшего кнопку)
        $author = $service->user_id;      //ID автора услуги
        $bidding_type = $request->bidding_type;
        $service_id = $request->service_id;
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        if(($delta > 0 || $delta == 0) && ($bidding_type == 2 || $bidding_type == 3)){ //Купить/Продать сразу
			$deal = Deal::create($request->all());
	        $deal->total_cost = $request->number_unit * $request->price_fin;
	        $basket->delete();  //Удаление уже не нужной корзины
	        //Передача параметров от услуги к сделке
	        $deal->initiator = $initiator;		//ID Инициатора сделки (нажавшего кнопку)
	        $deal->author = $author;			//ID автора услуги
	        $deal->status_deal = 1;				//Сделка "В процессе"
	        $date = new DateTime();				//Взять текущую дату
	        $service->distance->period_initial ? $period_initial = $service->distance->period_initial : $period_initial = 0;
	        $date->add(new DateInterval('P'.$period_initial.'D'));	//Вычисляем Начальную дату предоставления услуги 
	        if($date){$deal->date_initial = $date;}	//Сохранить Начальную дату предоставления услуги в сделке
	        $date = new DateTime();				//Взять текущую дату
	        $service->distance->period_deadline ? $period_deadline = $service->distance->period_deadline : $period_deadline = 0;
	        $date->add(new DateInterval('P'.$period_deadline.'D'));	//Вычисляем Конечную дату, когда может быть предоставлена услуга
	        if($date){$deal->date_deadline = $date;}	//Сохранить Конечную дату, когда может быть предоставлена услуга
	        $date_initial = $deal->date_initial->format("Y-m-d H:i:s");
        	$date_deadline = $deal->date_deadline->format("Y-m-d H:i:s");
       
	        
	        $deal_create = 1;
	        $service->number_total = $delta;
	        if($delta == 0){
				$service->status = 0; //Услуга отправляется в архив, торги закрываются
			}
			$service->save();
			$deal->save();  //Сохранение сделки
			
			
			//Подготовка данных для события - оправка сообщения пользователям о новой Сделке
	        null !== $deal->authorUser->email  ? $user_author = $deal->authorUser->email : $user_author = '';
			null !== $deal->initiatorUser->email ? $user_initiator = $deal->initiatorUser->email : $user_initiator = '';
			$deal_id = $deal->id;
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
			null !== ($deal->authorUser->name) ? $author_name = $deal->authorUser->name : $author_name = '';
			null !== ($deal->initiatorUser->name) ? $initiator_name = $deal->initiatorUser->name : $initiator_name = '';
			if($deal->author == $deal->user_seller_id){
				$author_seller_buyer = 'Продавець';
				$initiator_seller_buyer = 'Покупець';
				$author_granted_received = 'НАДАНА';
				$initiator_granted_received = 'ОТРИМАНА';
			}else{
				$author_seller_buyer = 'Покупець';
				$initiator_seller_buyer = 'Продавець';
				$author_granted_received = 'ОТРИМАНА';
				$initiator_granted_received = 'НАДАНА';
			}
			null !== ($deal->service->product_code_id) ? $product_code_id = (substr($deal->service->product_code_id, 0, 6) . '-' . substr($deal->service->product_code_id, 6, 4)) : $product_code_id = '';
			null !== ($deal->service->title) ? $service_title = $deal->service->title : $service_title = '';
			null !== ($deal->getDescription()) ? $service_description = $deal->getDescription() : $service_description = '';
			null !== ($deal->biddingTypeTitle()) ? $bidding_title = $deal->biddingTypeTitle() : $bidding_title = '';
			null !== ($deal->getDateWH($date_initial, $date_offset)) ? $date_initial_user = $deal->getDateWH($date_initial, $date_offset) : $date_initial_user = '';
			null !== ($deal->getDateWH($date_deadline, $date_offset)) ? $date_deadline_user = $deal->getDateWH($date_deadline, $date_offset) : $date_deadline_user = '';
			if($deal->getTermsPayment()){
      			if($deal->getTermsPayment() == 1){$payment = 'Предоплата';}
      			if($deal->getTermsPayment() == 2){$payment = 'Оплата после/в момент получения услуги';}
      			if($deal->getTermsPayment() == 3){$payment = 'Аванс';}
      			if($deal->getTermsPayment() == 4){$payment = 'Поэтапная оплата';}
      			if($deal->getTermsPayment() == 5){$payment = 'Любой способ оплаты';}
			}
			if($deal->getTermsPayment() == 1 || $deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4){
				$date_deadline_pay = $deal->getDateWH($deal->getDateMiddle($date_initial, $date_deadline), $date_offset);
			}else{
				$date_deadline_pay = $date_deadline_user;
			}
	        
	        //Инициация события отправки сообщения пользователям о создании новой Сделки
	    event(new DealNew($deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $bidding_title, $service_description, $author_granted_received, $initiator_granted_received, $date_initial_user, $date_deadline_user, $date_deadline_pay, $payment, $deal_id));
			
			
	        
	        return view('pages.deals.edit', [
        		'deal' => $deal,
        		'deal_create' => $deal_create,
        		'deal_code' => $deal_code,
        		'service_id' => $service_id,
        		'date_offset' => $date_offset,
        		'date_initial' => $date_initial,
        		'date_deadline' => $date_deadline,
        	]);
		}elseif(($delta > 1 || $delta == 1) && ($bidding_type == 6 || $bidding_type == 7) ){ // Аукцион + купить сразу
			$deal = Deal::create($request->all());
	        $deal->total_cost = $request->number_unit * $request->price_fin;
	        $basket->delete();  //Удаление уже не нужной корзины
	        //Передача параметров от услуги к сделке
	        $deal->initiator = $initiator;		//ID Инициатора сделки (нажавшего кнопку)
	        $deal->author = $author;			//ID автора услуги
	        $deal->status_deal = 1;				//Сделка "В процессе"
	        $date = new DateTime();				//Взять текущую дату
	        $service->distance->period_initial ? $period_initial = $service->distance->period_initial : $period_initial = 0;
	        $date->add(new DateInterval('P3D'));	//Вычисляем Начальную дату предоставления услуги 
	        if($date){$deal->date_initial = $date;}	//Сохранить Начальную дату предоставления услуги в сделке
	        $date = new DateTime();				//Взять текущую дату
	        $service->distance->period_deadline ? $period_deadline = $service->distance->period_deadline : $period_deadline = 0;
	        $date->add(new DateInterval('P7D'));	//Вычисляем Конечную дату, когда может быть предоставлена услуга
	        if($date){$deal->date_deadline = $date;}	//Сохранить Конечную дату, когда может быть предоставлена услуга
	        $date_initial = $deal->date_initial->format("Y-m-d H:i:s");
        	$date_deadline = $deal->date_deadline->format("Y-m-d H:i:s");
	        
	        
	        $deal_create = 1;
	        $service->number_total = $delta;
	        $service->save();
	        $deal->save();  //Сохранение сделки
	        
	        
	        //Подготовка данных для события - оправка сообщения пользователям о новой Сделке
	        null !== $deal->authorUser->email  ? $user_author = $deal->authorUser->email : $user_author = '';
			null !== $deal->initiatorUser->email ? $user_initiator = $deal->initiatorUser->email : $user_initiator = '';
			$deal_id = $deal->id;
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
			null !== ($deal->authorUser->name) ? $author_name = $deal->authorUser->name : $author_name = '';
			null !== ($deal->initiatorUser->name) ? $initiator_name = $deal->initiatorUser->name : $initiator_name = '';
			if($deal->author == $deal->user_seller_id){
				$author_seller_buyer = 'Продавець';
				$initiator_seller_buyer = 'Покупець';
				$author_granted_received = 'НАДАНА';
				$initiator_granted_received = 'ОТРИМАНА';
			}else{
				$author_seller_buyer = 'Покупець';
				$initiator_seller_buyer = 'Продавець';
				$author_granted_received = 'ОТРИМАНА';
				$initiator_granted_received = 'НАДАНА';
			}
			null !== ($deal->service->product_code_id) ? $product_code_id = (substr($deal->service->product_code_id, 0, 6) . '-' . substr($deal->service->product_code_id, 6, 4)) : $product_code_id = '';
			null !== ($deal->service->title) ? $service_title = $deal->service->title : $service_title = '';
			null !== ($deal->getDescription()) ? $service_description = $deal->getDescription() : $service_description = '';
			null !== ($deal->biddingTypeTitle()) ? $bidding_title = $deal->biddingTypeTitle() : $bidding_title = '';
			null !== ($deal->getDateWH($date_initial, $date_offset)) ? $date_initial_user = $deal->getDateWH($date_initial, $date_offset) : $date_initial_user = '';
			null !== ($deal->getDateWH($date_deadline, $date_offset)) ? $date_deadline_user = $deal->getDateWH($date_deadline, $date_offset) : $date_deadline_user = '';
			if($deal->getTermsPayment()){
      			if($deal->getTermsPayment() == 1){$payment = 'Предоплата';}
      			if($deal->getTermsPayment() == 2){$payment = 'Оплата после/в момент получения услуги';}
      			if($deal->getTermsPayment() == 3){$payment = 'Аванс';}
      			if($deal->getTermsPayment() == 4){$payment = 'Поэтапная оплата';}
      			if($deal->getTermsPayment() == 5){$payment = 'Любой способ оплаты';}
			}
			if($deal->getTermsPayment() == 1 || $deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4){
				$date_deadline_pay = $deal->getDateWH($deal->getDateMiddle($date_initial, $date_deadline), $date_offset);
			}else{
				$date_deadline_pay = $date_deadline_user;
			}
	        
	        //Инициация события отправки сообщения пользователям о создании новой Сделки
	    event(new DealNew($deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $bidding_title, $service_description, $author_granted_received, $initiator_granted_received, $date_initial_user, $date_deadline_user, $date_deadline_pay, $payment, $deal_id));
	        
	        		        
	        return view('pages.deals.edit', [
        		'deal' => $deal,
        		'deal_create' => $deal_create,
        		'deal_code' => $deal_code,
        		'service_id' => $service_id,
        		'date_offset' => $date_offset,
        		'date_initial' => $date_initial,
        		'date_deadline' => $date_deadline,
        	]);
		}else{
			//Не достаточно единиц услуги
			$deal_create = 3;
			$service_id = $request->service_id;
			return view('pages.deals.edit', [
        		'deal_create' => $deal_create,
        		'service_id' => $service_id,
        		'date_offset' => $date_offset,
        	]);
		}
        
        
        
        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deal = Deal::find($id);
        if(null != $deal && ($deal->author == Auth::user()->id || $deal->initiator == Auth::user()->id)){
			$date_initial = $deal->date_initial;
	        $date_deadline = $deal->date_deadline;
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
		}else{
			return abort(404);
		}
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        $deal_create = 1;
        
        return view('pages.deals.show', [
        	'deal' => $deal,
        	'deal_code' => $deal_code,
        	'date_offset' => $date_offset,
        	'date_initial' => $date_initial,
        	'date_deadline' => $date_deadline,
        	'deal_create' => $deal_create,
        	'basket_mark' => $basket_mark,
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
        $deal = Deal::find($id);
        if(null != $deal && ($deal->author == Auth::user()->id || $deal->initiator == Auth::user()->id)){
	        $date_initial = $deal->date_initial;
	        $date_deadline = $deal->date_deadline;
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
		}else{
			return abort(404);
		}
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        $messages = Message::where('deal_id', $deal->id)->orderBy('created_at', 'asc')->get();
        
        
        return view('pages.deals.edit', [
        	'deal' => $deal,
        	'deal_code' => $deal_code,
        	'date_offset' => $date_offset,
        	'messages' => $messages,
        	'date_initial' => $date_initial,
        	'date_deadline' => $date_deadline,
        	'basket_mark' => $basket_mark,
          ]);
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
        $deal = Deal::find($id);
		$hide = $deal->hide;
        
        if($hide == 0){
			$deal->hide = Auth::user()->id;
			$deal->save();
		}elseif($hide != 0 && $hide != Auth::user()->id){
			$deal->delete();
		}
        
        return redirect()->route('deals.index');
    }
    
    
    //Подтверждение этапов сделки
    public function prove(Request $request)
    {
		$date_c = new DateTime();
		$sig = $request->sig;
		$id = $request->deal_id;
		$deal = Deal::find($id);
		
		if($sig == 'sig_approved_seller'){
			$deal->sig_approved_seller = 1;
			$deal->date_approved_seller = $date_c;
			if($deal->author == $deal->user_seller_id){
				if($deal->sig_approved_buyer == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
			}else{
				if($deal->sig_approved_buyer == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження умов угоди';
		}
		if($sig == 'sig_pay0_seller'){
			$deal->sig_pay0_seller = 1;
			$deal->date_pay0_seller = $date_c;
			if($deal->author == $deal->user_seller_id){
				if($deal->sig_pay0_buyer == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
			}else{
				if($deal->sig_approved_buyer == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Передоплата';
		}
		if($sig == 'sig_pay_seller'){
			$deal->sig_pay_seller = 1;
			$deal->date_pay_seller = $date_c;
			if($deal->author == $deal->user_seller_id){
				if($deal->sig_pay_buyer == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
			}else{
				if($deal->sig_approved_buyer == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження остаточної Оплати';
		}
		if($sig == 'sig_serv_seller'){
			$deal->sig_serv_seller = 1;
			$deal->date_serv_seller = $date_c;
			if($deal->author == $deal->user_seller_id){
				if($deal->sig_serv_buyer == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
			}else{
				if($deal->sig_approved_buyer == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження надання послуги';
		}
		
		if($sig == 'sig_approved_buyer'){
			$deal->sig_approved_buyer = 1;
			$deal->date_approved_buyer = $date_c;
			if($deal->author == $deal->user_buyer_id){
				if($deal->sig_approved_seller == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
				$accept_you_contr_initiator = '';
			}else{
				if($deal->sig_approved_seller == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження умов угоди';
		}
		if($sig == 'sig_pay0_buyer'){
			$deal->sig_pay0_buyer = 1;
			$deal->date_pay0_buyer = $date_c;
			if($deal->author == $deal->user_buyer_id){
				if($deal->sig_pay0_seller == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
				$accept_you_contr_initiator = '';
			}else{
				if($deal->sig_approved_seller == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Передоплата';
		}
		if($sig == 'sig_pay_buyer'){
			$deal->sig_pay_buyer = 1;
			$deal->date_pay_buyer = $date_c;
			if($deal->author == $deal->user_buyer_id){
				if($deal->sig_pay_seller == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
				$accept_you_contr_initiator = '';
			}else{
				if($deal->sig_approved_seller == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження остаточної Оплати';
		}
		if($sig == 'sig_serv_buyer'){
			$deal->sig_serv_buyer = 1;
			$deal->date_serv_buyer = $date_c;
			if($deal->author == $deal->user_buyer_id){
				if($deal->sig_serv_seller == 1){
					$accept_you_contr_author = 'Ваш контрагент також підтвердив виконання даного етапу';
					$accept_you_contr_initiator = 'Ви також підтвердили виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
					$accept_you_contr_initiator = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
				}
				$accept_you_contr_initiator = '';
			}else{
				if($deal->sig_approved_seller == 1){
					$accept_you_contr_author = 'Ви також підтвердили виконання даного етапу';
					$accept_you_contr_initiator = 'Ваш контрагент також підтвердив виконання даного етапу';
				}else{
					$accept_you_contr_author = "Ви поки що НЕ підтвердили виконання даного етапу. Ви можете зв'язатись з вашим контрагентом для з'ясування обставин";
					$accept_you_contr_initiator = "Ваш контрагент поки що НЕ підтвердив виконання даного етапу. Ви можете зв'язатись з ним для з'ясування обставин";
				}
			}
			$stage_deal = 'Підтвердження надання послуги';
		}
		$deal->save();
		
		
		//Подготовка данных для события - оправка сообщения пользователям о новой Сделке
		if($sig == 'sig_approved_seller' || $sig == 'sig_pay0_seller' || $sig == 'sig_pay_seller' || $sig == 'sig_serv_seller'){
			if($deal->author == $deal->user_seller_id){
				$you_contr_initiator = 'Ваш контрагент';
				$you_contr_author = 'Ви';
				$accepted_initiator = 'підтвердив';
				$accepted_author = 'підтвердили';
			}else{
				$you_contr_initiator = 'Ви';
				$you_contr_author = 'Ваш контрагент';
				$accepted_initiator = 'підтвердили';
				$accepted_author = 'підтвердив';
			}
		}
		if($sig == 'sig_approved_buyer' || $sig == 'sig_pay0_buyer' || $sig == 'sig_pay_buyer' || $sig == 'sig_serv_buyer'){
			if($deal->author == $deal->user_buyer_id){
				$you_contr_initiator = 'Ваш контрагент';
				$you_contr_author = 'Ви';
				$accepted_initiator = 'підтвердив';
				$accepted_author = 'підтвердили';
			}else{
				$you_contr_initiator = 'Ви';
				$you_contr_author = 'Ваш контрагент';
				$accepted_initiator = 'підтвердили';
				$accepted_author = 'підтвердив';
			}
		}
		
		if($deal->getTermsPayment()){
  			if($deal->getTermsPayment() == 1){
  				$payment = 'Предоплата';
  				if($deal->sig_pay0_buyer == 1 && $deal->sig_pay0_seller == 1 && $deal->sig_approved_seller == 1 && $deal->sig_approved_buyer == 1 && $deal->sig_serv_seller == 1 && $deal->sig_serv_buyer == 1){
					$deal_completed = 'Угода завершена. Тепер Ви можете залишити відгук про контрагента';
					$deal->status_deal = 2;
				}else{
					$deal_completed = '';
					if($deal->sig_pay0_seller == 1 && $deal->sig_serv_seller == 1 && $deal->sig_approved_seller == 1){$deal->status_deal = 3;}
					if($deal->sig_pay0_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_buyer == 1){$deal->status_deal = 4;}
				}
  			}
  			if($deal->getTermsPayment() == 2 || $deal->getTermsPayment() == 5){
  				$payment = 'Оплата после/в момент получения услуги';
  				$payment = 'Любой способ оплаты';
  				if($deal->sig_pay_buyer == 1 && $deal->sig_pay_seller == 1 && $deal->sig_approved_seller == 1 && $deal->sig_approved_buyer == 1 && $deal->sig_serv_seller == 1 && $deal->sig_serv_buyer == 1){
					$deal_completed = 'Угода завершена. Тепер Ви можете залишити відгук про контрагента';
					$deal->status_deal = 2;
				}else{
					$deal_completed = '';
					if($deal->sig_pay_seller == 1 && $deal->sig_serv_seller == 1 && $deal->sig_approved_seller == 1){$deal->status_deal = 3;}
					if($deal->sig_pay_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_buyer == 1){$deal->status_deal = 4;}
				}
  			}
  			if($deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4){
  				$payment = 'Аванс';
  				$payment = 'Поэтапная оплата';
  				if($deal->sig_pay0_buyer == 1 && $deal->sig_pay0_seller == 1 && $deal->sig_pay_buyer == 1 && $deal->sig_pay_seller == 1 && $deal->sig_approved_seller == 1 && $deal->sig_approved_buyer == 1 && $deal->sig_serv_seller == 1 && $deal->sig_serv_buyer == 1){
					$deal_completed = 'Угода завершена. Тепер Ви можете залишити відгук про контрагента';
					$deal->status_deal = 2;
				}else{
					$deal_completed = '';
					if($deal->sig_pay0_seller == 1 && $deal->sig_pay_seller == 1 && $deal->sig_serv_seller == 1 && $deal->sig_approved_seller == 1){$deal->status_deal = 3;}
					if($deal->sig_pay0_buyer == 1 && $deal->sig_pay_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_buyer == 1){$deal->status_deal = 4;}
				}
  			}
		}
		$deal->save();
		
        null !== $deal->authorUser->email  ? $user_author = $deal->authorUser->email : $user_author = '';
		null !== $deal->initiatorUser->email ? $user_initiator = $deal->initiatorUser->email : $user_initiator = '';
		$deal_id = $deal->id;
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
		null !== ($deal->authorUser->name) ? $author_name = $deal->authorUser->name : $author_name = '';
		null !== ($deal->initiatorUser->name) ? $initiator_name = $deal->initiatorUser->name : $initiator_name = '';
		if($deal->author == $deal->user_seller_id){
			$author_seller_buyer = 'Продавець';
			$initiator_seller_buyer = 'Покупець';
		}else{
			$author_seller_buyer = 'Покупець';
			$initiator_seller_buyer = 'Продавець';
		}
		null !== ($deal->service->product_code_id) ? $product_code_id = (substr($deal->service->product_code_id, 0, 6) . '-' . substr($deal->service->product_code_id, 6, 4)) : $product_code_id = '';
		null !== ($deal->service->title) ? $service_title = $deal->service->title : $service_title = '';

        //Инициация события отправки сообщения пользователям о подтверждении этапа сделки
    event(new DealAccept($deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $deal_id, $you_contr_initiator, $you_contr_author, $accepted_initiator, $accepted_author, $accept_you_contr_initiator, $accept_you_contr_author, $stage_deal, $deal_completed));
		
		
		return redirect()->route('deals.edit', $id);
	}
    
    
    
    //Аннулирование сделки
    public function annul(Request $request)
    {
		$this->validate($request, [
            'status_deal' =>'required',
            'deal_id' =>'required', 
	    ]);
	    
	    $id = $request->deal_id;
		$deal = Deal::find($id);
	    if($deal->getTermsPayment() == 1){
			if($deal->sig_pay0_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay0_seller == 0 && $deal->sig_serv_seller == 0){
				$deal->status_deal = 5;
				$deal_create = 4; //Сделка аннулирована
			}else{
				$deal_create = 5; //Сделка не может быть аннулирована
			}
		}
		if($deal->getTermsPayment() == 2 || $deal->getTermsPayment() == 5){
			if($deal->sig_pay_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay_seller == 0 && $deal->sig_serv_seller == 0){
				$deal->status_deal = 5;
				$deal_create = 4; //Сделка аннулирована
			}else{
				$deal_create = 5; //Сделка не может быть аннулирована
			}
		}
		if($deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4){
			if($deal->sig_pay_buyer == 0 && $deal->sig_pay0_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay_seller == 0 && $deal->sig_pay0_seller == 0 && $deal->sig_serv_seller == 0){
				$deal->status_deal = 5;
				$deal_create = 4; //Сделка аннулирована
			}else{
				$deal_create = 5; //Сделка не может быть аннулирована
			}
		}
		$deal->save();
		
		
		//Подготовка данных для события - оправка сообщения пользователям о новой Сделке
        null !== $deal->authorUser->email  ? $user_author = $deal->authorUser->email : $user_author = '';
		null !== $deal->initiatorUser->email ? $user_initiator = $deal->initiatorUser->email : $user_initiator = '';
		$deal_id = $deal->id;
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
		null !== ($deal->authorUser->name) ? $author_name = $deal->authorUser->name : $author_name = '';
		null !== ($deal->initiatorUser->name) ? $initiator_name = $deal->initiatorUser->name : $initiator_name = '';
		if($deal->author == $deal->user_seller_id){
			$author_seller_buyer = 'Продавець';
			$initiator_seller_buyer = 'Покупець';
		}else{
			$author_seller_buyer = 'Покупець';
			$initiator_seller_buyer = 'Продавець';
		}
		null !== ($deal->service->product_code_id) ? $product_code_id = (substr($deal->service->product_code_id, 0, 6) . '-' . substr($deal->service->product_code_id, 6, 4)) : $product_code_id = '';
		null !== ($deal->service->title) ? $service_title = $deal->service->title : $service_title = '';
				
		
		//Инициация события отправки сообщения пользователям об аннулировании сделки
    	event(new DealCancel($deal, $user_author, $user_initiator, $deal_code, $author_seller_buyer, $product_code_id, $service_title, $initiator_seller_buyer, $initiator_name, $author_name, $deal_id));
		
		
		return redirect()->route('deals.index');
	}
    
    
    
    
    
}
