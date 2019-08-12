<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Basket;
use App\Service;


class BasketsController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()) {
	        $this->validate($request, [
	            'service_id' =>'required',
	            'bidding_type' =>'required', 
	            'price_fin' =>'required', 
	            'number_unit' =>'required', 
	            'user_seller_id' =>'required', 
	            'user_buyer_id' =>'required',
	            
	        ]);
	        $service = Service::find($request->service_id);
	        $delta = $service->number_total - $request->number_unit;
	        $bidding_type = $request->bidding_type;
	        $initiator = $request->initiator;
	        $basket_ini = Basket::where('initiator', $initiator)->pluck('initiator')->first();
	        
			
	        if($basket_ini && $basket_ini == $initiator ){ //Если у инициатора сделки есть не закрытая корзина - выводим предупреждение
	        	$basket_create = 4;
				return view('pages.baskets.edit', [
		        	'basket_create' => $basket_create,
		        ]);
			}else{
		        if(($delta > 0 || $delta == 0) && ($bidding_type == 2 || $bidding_type == 3)){ //Купить сразу
					$basket = Basket::create($request->all());
			        $basket->total_cost = $request->number_unit * $request->price_fin;
			        $basket->initiator = $initiator;
			        $basket->save();
			        
			        $basket_create = 1;
			        			        
			        return view('pages.baskets.edit', [
			        	'basket_create' => $basket_create,
			        	'service' => $service,
			        	'basket' => $basket,
			        ]);
				}elseif(($delta > 1 || $delta == 1) && ($bidding_type == 6 || $bidding_type == 7) ){ // Аукцион + купить сразу
					$basket = Basket::create($request->all());
			        $basket->total_cost = $request->number_unit * $request->price_fin;
			        $basket->initiator = $initiator;
			        $basket->save();
			        
			        $basket_create = 1;
			        			        		        
			        return view('pages.baskets.edit', [
			        	'basket_create' => $basket_create,
			        	'service' => $service,
			        	'basket' => $basket,
			        ]);
				}else{
					//Не достаточно единиц услуги
					$basket_create = 3;
					$service_id = $request->service_id;
					return view('pages.baskets.edit', [
			        	'basket_create' => $basket_create,
			        	'service_id' => $service_id,
			        ]);
				}
			}

		}else{
			//Пользователь не вошел в аккаунт
			$basket_create = 2;
			return view('pages.baskets.edit', [
	        	'basket_create' => $basket_create,
	        ]);
		}		
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    if(Auth::check()) {
	        $basket_id = Basket::where('initiator', $id)->pluck('id')->first();
	        if($basket_id){  //Если в корзине что-то есть
				$basket = Basket::find($basket_id);
	        	$basket_create = 1;
	        	$service = Service::find($basket->service_id);
			}else{
				$basket_create = null;
				$basket = null;
				$service = null;				
			}
	        
	        //Показать наличие в корзине услуг - корзина зеленого цвета
	        $basket_mark = 'id="testElement1"';
	        
	        return view('pages.baskets.edit', [
	        	'basket_create' => $basket_create,
	        	'service' => $service,
	        	'basket' => $basket,
	        	'basket_mark' => $basket_mark,
			]);
		}else{
			//Пользователь не вошел в аккаунт
			$basket_create = 2;
			return view('pages.baskets.edit', [
	        	'basket_create' => $basket_create,
	        ]);
		}
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
        Basket::find($id)->delete();
        
        $basket_create = 10;
        return view('pages.baskets.edit', [
	        	'basket_create' => $basket_create,
	        ]);
    }
}
