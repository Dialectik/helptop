<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;  //модуль конвертации дат
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use App\BiddingType;
use App\ServiceDesc;
use App\Distance;
use App\Address;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Admin\ProductCodeExcess;

class ServicesController extends Controller
{
    
    public function index()
    {
        $sections = Section::all();
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
                        
        return view('admin.services.index', [
        	'sections' => $sections,
        	'bidding_types' => $bidding_types,
        	'address' => $address
        	
        ]);
    }

    
    public function create()
    {
        $sections = Section::all();
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
        
        return view('admin.services.create', [
			'sections' => $sections,
			'bidding_types' => $bidding_types,
			'address' => $address
			
            
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
        $service->toggleFeatured($request->get('is_featured'));
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
		
		if($request->get('status') != $service->status){
			$service->togglePablic($request->get('status'));
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

        return redirect()->route('services.index');
    }

   
    public function edit($id)
    {
        $service = Service::find($id);
        $sections = Section::all();
        $bidding_types = BiddingType::all();
        //Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $uaddress = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
        
        return view('admin.services.edit', [
        	'service' => $service,
        	'sections' => $sections,
        	'bidding_types' => $bidding_types,
        	'uaddress' => $uaddress
        ]);

    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' =>'required',
            'period'  =>  'required',
            'date_on'  =>  'required',
            'date_off'  =>  'required',
            'image' =>  'nullable|image',
            'bidding_type' =>'required',
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
		
        $service = Service::find($id);
        $service->edit($request->all());
        $service->uploadImage($request->file('image'));
        $service->toggleFeatured($request->get('is_featured'));
        //Перезаписать даты начала публикации и конца в базе
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        $service->number_total = $request->get('number_total');
        $service->place_id = $request->get('place_id');
        $service->price_start = $request->get('price_start');
        if($request->get('price_start') > $service->price_current){
			$service->price_current = $request->get('price_start');
		}
        $service->price_buy_now = $request->get('price_buy_now');
        $service->price_sell_now = $request->get('price_sell_now');
        $service->price_lower = $request->get('price_lower');
        $service->bet_step = $request->get('bet_step');
        
        //Обновить категорию и вид услуг в базе, если в форме "edit" они менялись
        if($request->category_id_v != null & $request->category_id_v != $request->category_id){
			$service->category_id = $request->category_id_v;
		}
        if($request->kind_id_v != null & $request->kind_id_v != $request->kind_id){
			$service->kind_id = $request->kind_id_v;
		}
	
        if($request->get('status') != $service->status){
			$service->togglePablic($request->get('status'));
		}
        
        //Изменение слага перед сохранением по мотивам измененного названия
        $service->slug = str_slug($service->title);    
        
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
        $existing_desc_find = ServiceDesc::where('service_id', $id)->pluck('service_id')->first(); 
        if($existing_desc_find){
			$id_sd = ServiceDesc::where('service_id', $id)->pluck('id')->first();
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
			$new_desc = new ServiceDesc;         //Создание нового объекта Описания услуги для сохранения доп описания и ID услуги
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
		if($address->district){
			$second0 = Ukraine2::where('region', $request->region)
								->where('district', $address->district)
								->where('city', $address->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $address->region)
								->where('district', $address->district)
								->where('city', $address->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $address->region)
								->where('district', $address->district)
								->where('city', $address->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $address->region)
								->where('district', $address->district)
								->where('city', $address->city)->pluck('id')
	        					->union($second0)
	        					->union($third0)
	        					->union($fourth0)
	        					->first();
		}else{
			$second0 = Ukraine2::where('region', $address->region)
								->where('city', $address->city)->pluck('id');
	        $third0 = Ukraine3::where('region', $address->region)
								->where('city', $address->city)->pluck('id');
	        $fourth0 = Ukraine4::where('region', $address->region)
								->where('city', $address->city)->pluck('id');      
	        $city_id = Ukraine1::where('region', $address->region)
								->where('city', $address->city)->pluck('id')
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

		
		//Сохранить отредактированную услугу
		$service->save();

        return redirect()->route('services.index');
    }


    public function destroy($id)
    {
        Service::find($id)->remove();
        return redirect()->route('services.index');
    }
}
