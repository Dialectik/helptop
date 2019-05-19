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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Admin\ProductCodeExcess;

class ServicesController extends Controller
{
    
    public function index()
    {
        $sections = Section::all();
        $bidding_types = BiddingType::all();
                        
        return view('admin.services.index', [
        	'sections' => $sections,
        	'bidding_types' => $bidding_types
        	
        ]);
    }

    
    public function create()
    {
        $sections = Section::all();
        //$date_on = date('Y-m-d H:i:s');  не использовать - дата задается в виде с помощью js
        $bidding_types = BiddingType::all();
		

        return view('admin.services.create', [
			'sections' => $sections,
			'bidding_types' => $bidding_types
            
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
        ]);

        $service = Service::add($request->all());
        $service->uploadImage($request->file('image'));
        $service->toggleFeatured($request->get('is_featured'));
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        $service->number_total = $request->get('number_total');
        $service->place_id = $request->get('place_id');
        $service->price_start = $request->get('price_start');
        $service->price_current = $request->get('price_start');
        $service->price_buy_now = $request->get('price_buy_now');
        $service->price_sell_now = $request->get('price_sell_now');
        $service->price_lower = $request->get('price_lower');
        $service->bet_step = $request->get('bet_step');
        
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
			$existing_desc->save();			//сохранение записи в дополнительной таблице описания услуги
		}else{
			//Создание нового объекта Описания услуги для сохранения доп описания и ID услуги
			$new_desc = new ServiceDesc;         
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$new_desc->content = $request->get('content');
			$new_desc->description = $request->get('description');
			$new_desc->value_service = $request->get('value_service');
			$new_desc->add_materials = $request->get('add_materials');
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
		
        
 		//Отправка сообщения о том, что скоро будет превышен лимит в кодировке услуг для определенного вида услуг
		$serviceCodeEnd = substr($request->product_code_id, 6, 4) * 1;
		if($serviceCodeEnd > 8000){
				$kind_id = $request->kind_id;
				$kind_title = Kind::where('id', $request->kind_id)->value('title');
				event(new ProductCodeExcess($kind_id, $kind_title));
			}
		

        return redirect()->route('services.index');
    }

   
    public function edit($id)
    {
        $service = Service::find($id);
        $sections = Section::all();
        $bidding_types = BiddingType::all();
        
        return view('admin.services.edit', [
        	'service' => $service,
        	'sections' => $sections,
        	'bidding_types' => $bidding_types
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
        //Изменение слага перед сохранением по мотивам измененного названия
        $service->slug = str_slug($service->title);               
    	$service->save();


		
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
			$existing_desc->save();			//сохранение записи в дополнительной таблице описания услуги
		}else{
			$new_desc = new ServiceDesc;         //Создание нового объекта Описания услуги для сохранения доп описания и ID услуги
			//Сохранение описания, количества, доп материалов в таблицу доп описания
			$new_desc->content = $request->get('content');
			$new_desc->description = $request->get('description');
			$new_desc->value_service = $request->get('value_service');
			$new_desc->add_materials = $request->get('add_materials');
			$new_desc->service_id = $service->id;
			$new_desc->save();  //сохранение записи в дополнительной таблице описания услуги
		}
		
		//Сохранение периодов предоставления услуги в таблице Distance
		//Поиск в таблице периодов предоставления записи для текущей услуги
        $distance_id = Distance::where('service_id', $id)->pluck('id')->first();
        if($distance_id){
			$distance = Distance::find($distance_id);
			$new_distance->period_initial = $request->get('period_initial');
			$new_distance->period_deadline = $request->get('period_deadline');
			$new_distance->schedule = $request->get('schedule');
			$new_distance->save();	//сохранение записи в таблице Distance
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
        
        
		
		


        return redirect()->route('services.index');
    }


    public function destroy($id)
    {
        Service::find($id)->remove();
        return redirect()->route('services.index');
    }
}
