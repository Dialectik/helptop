<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;  //модуль конвертации дат
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use App\ServiceDesc;
use App\Search;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{
    //Вывод по кускам информации из БД услуг - первая итерация
    public function _request(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'date_off');
		$sort_column = "date_on";
		$sort_direction = "desc";
		$model_search = "Service";
		$table_q = "title";
		$chunk = 50;
		$rowarr = 0;
		$rowarrdat = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $request->date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $request->date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $request->date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $request->date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;
		
		//Сравнение по city_id
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

		$where_2d_arr = array();//Объявление пустого массива для дальнейшего заполнения		
		if(isset($request->status)){
			if($request->status){
				//Ищем среди опубликованных
				$where_2d_arr[$rowarr][0] = "status";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = 1;
				$rowarr++;
			}
		}
		
		//Условия для поиска по запросу в БД
		if(isset($product_code_id)){  //Если задан товарный код услуги - остальные условия не учитывать
			$where_2d_arr[$rowarr][0] = "product_code_id";
			$where_2d_arr[$rowarr][1] = "=";
			$where_2d_arr[$rowarr][2] = $product_code_id;
			$rowarr++;
		}elseif($services_title && $in_content){  //Если осуществляется поиск по описанию услуги в таблице ServiceDesc
			$model_search = "ServiceDesc";
			$select_columns = array('content', 'service_id', 'created_at');
			$sort_column = "created_at";
			$where_2d_arr[$rowarr][0] = "content";
			$where_2d_arr[$rowarr][1] = "LIKE";
			$where_2d_arr[$rowarr][2] = $services_title;
			$rowarr++;
		}else{
			if($services_title && !$in_content){  //Если осуществляется поиск по названию 
				$where_2d_arr[$rowarr][0] = $table_q;
				$where_2d_arr[$rowarr][1] = "LIKE";
				$where_2d_arr[$rowarr][2] = $services_title;
				$rowarr++;
			}
			//Блок поиска по разделам, категориям и видам услуг
			if($kind_id){  //Если при поиске указан вид услуг
				$where_2d_arr[$rowarr][0] = "kind_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $kind_id;
				$rowarr++;
			}
			if($category_id && !$kind_id){  //Если при поиске указана категория
				$where_2d_arr[$rowarr][0] = "category_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $category_id;
				$rowarr++;
			}
			if($section_id && !$category_id){  //Если при поиске указан раздел
				$where_2d_arr[$rowarr][0] = "section_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $section_id;
				$rowarr++;
			}
			//Блок поиска по датам
			if(isset($date_on_start)){  //Дата больше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_on_start;
				$rowarrdat++;
			}
			if(isset($date_on_end)){  //Дата меньше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_on_end;
				$rowarrdat++;
			}
			if(isset($date_off_start)){  //Дата больше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_off_start;
				$rowarrdat++;
			}
			if(isset($date_off_end)){  //Дата меньше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_off_end;
				$rowarrdat++;
			}
			//Поиск по типу торгов
			if($bidding_type){  
				$where_2d_arr[$rowarr][0] = "bidding_type";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $bidding_type;
				$rowarr++;
			}
			//Блок поиска по ценам
				//Цена больше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_min) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_max) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_min) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_max) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_min) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_s_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_max) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_s_max;
				$rowarr++;
			}
			//Сравнение по city_id
			if($city_id){  
				$where_2d_arr[$rowarr][0] = "city_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $city_id;
				$rowarr++;
			}
		}
		

		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
		}else{
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}else{
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}
		
		$start_id = $services->max('id');
		$end_id = $services->min('id');
		$date_offset = $request->get('date_offset');
		if($services_title && $in_content){
			$min_id = ServiceDesc::min('id');
			$max_id = ServiceDesc::max('id');
		}else{
			$min_id = Service::min('id');
			$max_id = Service::max('id');
		}

		return view('admin.services.request')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'max_id' => $max_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'category_id' => $category_id,
				  'section_id' => $section_id,
				  'date_on_start' => $request->date_on_start,
				  'date_on_end' => $request->date_on_end,
				  'date_off_start' => $request->date_off_start,
				  'date_off_end' => $request->date_off_end,
				  'bidding_type' => $bidding_type,
				  'price_f_min' => $price_f_min,
				  'price_f_max' => $price_f_max,
				  'price_s_min' => $price_s_min,
				  'price_s_max' => $price_s_max,
				  'in_content' => $in_content,
				  'city_id' => $city_id,

			]);
	}
	
	
	//Вывод по кускам информации из БД услуг - прямой ход
	public function requestOffset(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'date_off');
		$sort_column = "date_on";
		$sort_direction = "asc";
		$model_search = "Service";
		$table_q = 'title';
		$chunk = 50;
		$rowarr = 0;
		$rowarrdat = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $request->date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $request->date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $request->date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $request->date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;

		//Сравнение по city_id
		$city_id = $request->city_id;

		$where_2d_arr = array();//Объявление пустого массива для дальнейшего заполнения
		if(isset($request->status)){
			if($request->status){
				//Ищем среди опубликованных
				$where_2d_arr[$rowarr][0] = "status";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = 1;
				$rowarr++;
			}
		}
		  
		//Условия для поиска по запросу в БД
		if(isset($product_code_id)){  //Если задан товарный код услуги - остальные условия не учитывать
			$where_2d_arr[$rowarr][0] = "product_code_id";
			$where_2d_arr[$rowarr][1] = "=";
			$where_2d_arr[$rowarr][2] = $product_code_id;
			$rowarr++;
		}elseif($services_title && $in_content){  //Если осуществляется поиск по описанию услуги в таблице ServiceDesc
			$model_search = "ServiceDesc";
			$select_columns = array('content', 'service_id', 'created_at');
			$sort_column = "created_at";
			//Если не выходим за пределы значений ID
			if($request->end_id > $request->min_id && $request->end_id){
				$sort_direction = "desc";
				$where_2d_arr[$rowarr][0] = "id";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $request->end_id;
				$rowarr++;
			}
			$where_2d_arr[$rowarr][0] = "content";
			$where_2d_arr[$rowarr][1] = "LIKE";
			$where_2d_arr[$rowarr][2] = $services_title;
			$rowarr++;
		}else{
			if($services_title){  //Если осуществляется поиск по названию
				$where_2d_arr[$rowarr][0] = $table_q;
				$where_2d_arr[$rowarr][1] = "LIKE";
				$where_2d_arr[$rowarr][2] = $services_title;
				$rowarr++;
			}
			//Если не выходим за пределы значений ID
			if($request->end_id > $request->min_id && $request->end_id){
				$sort_direction = "desc";
				$where_2d_arr[$rowarr][0] = "id";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $request->end_id;
				$rowarr++;
			}
			//Блок поиска по разделам, категориям и видам услуг
			if($kind_id){  //Если при поиске указан вид услуг
				$where_2d_arr[$rowarr][0] = "kind_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $kind_id;
				$rowarr++;
			}
			if($category_id && !$kind_id){  //Если при поиске указана категория
				$where_2d_arr[$rowarr][0] = "category_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $category_id;
				$rowarr++;
			}
			if($section_id && !$category_id){  //Если при поиске указан раздел
				$where_2d_arr[$rowarr][0] = "section_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $section_id;
				$rowarr++;
			}
			//Блок поиска по датам
			if(isset($date_on_start)){  //Дата больше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_on_start;
				$rowarrdat++;
			}
			if(isset($date_on_end)){  //Дата меньше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_on_end;
				$rowarrdat++;
			}
			if(isset($date_off_start)){  //Дата больше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_off_start;
				$rowarrdat++;
			}
			if(isset($date_off_end)){  //Дата меньше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_off_end;
				$rowarrdat++;
			}
			//Поиск по типу торгов
			if($bidding_type){  
				$where_2d_arr[$rowarr][0] = "bidding_type";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $bidding_type;
				$rowarr++;
			}
			//Блок поиска по ценам
				//Цена больше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_min) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_max) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_min) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_max) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_min) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_s_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_max) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_s_max;
				$rowarr++;
			}
			//Сравнение по city_id
			if($city_id){  
				$where_2d_arr[$rowarr][0] = "city_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $city_id;
				$rowarr++;
			}
		}
	
		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
		}else{
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}else{
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}		
		
		if($request->end_id > $request->min_id && $request->end_id){
			$min_id = $request->min_id;
			$max_id = $request->max_id;
		}else{
			if($services_title && $in_content){
				$min_id = ServiceDesc::min('id');
				$max_id = ServiceDesc::max('id');
			}else{
				$min_id = Service::min('id');
				$max_id = Service::max('id');
			}
		}		
		$start_id = $services->max('id');
		$end_id = $services->min('id');
		$date_offset = $request->get('date_offset');
		 
		 return view('admin.services.request')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'max_id' => $max_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'category_id' => $category_id,
				  'section_id' => $section_id,
				  'date_on_start' => $request->date_on_start,
				  'date_on_end' => $request->date_on_end,
				  'date_off_start' => $request->date_off_start,
				  'date_off_end' => $request->date_off_end,
				  'bidding_type' => $bidding_type,
				  'price_f_min' => $price_f_min,
				  'price_f_max' => $price_f_max,
				  'price_s_min' => $price_s_min,
				  'price_s_max' => $price_s_max,
				  'in_content' => $in_content,
				  'city_id' => $city_id,
				  
			]);
	}
	
	
	//Вывод по кускам информации из БД услуг - обратный ход
	public function requestOffsetReturn(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'date_off');
		$sort_column = "date_on";
		$sort_direction = "desc";
		$model_search = "Service";
		$table_q = 'title';
		$chunk = 50;
		$rowarr = 0;
		$rowarrdat = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $request->date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $request->date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $request->date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $request->date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;
		
		//Сравнение по city_id
		$city_id = $request->city_id;
		
		$where_2d_arr = array();//Объявление пустого массива для дальнейшего заполнения
		if(isset($request->status)){
			if($request->status){
				//Ищем среди опубликованных
				$where_2d_arr[$rowarr][0] = "status";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = 1;
				$rowarr++;
			}
		}
		
		//Условия для поиска по запросу в БД
		if(isset($product_code_id)){  //Если задан товарный код услуги - остальные условия не учитывать
			$where_2d_arr[$rowarr][0] = "product_code_id";
			$where_2d_arr[$rowarr][1] = "=";
			$where_2d_arr[$rowarr][2] = $product_code_id;
			$rowarr++;
		}elseif($services_title && $in_content){  //Если осуществляется поиск по описанию услуги в таблице ServiceDesc
			$model_search = "ServiceDesc";
			$select_columns = array('content', 'service_id', 'created_at');
			$sort_column = "created_at";
			//Если id меньше максимального (не выходит из диапазона)
			if($request->start_id < $request->max_id && $request->start_id){
				$sort_direction = "asc";
				$where_2d_arr[$rowarr][0] = "id";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $request->start_id;
				$rowarr++;
			}
			$where_2d_arr[$rowarr][0] = "content";
			$where_2d_arr[$rowarr][1] = "LIKE";
			$where_2d_arr[$rowarr][2] = $services_title;
			$rowarr++;
		}else{
			if($services_title){  //Если осуществляется поиск по названию
				$where_2d_arr[$rowarr][0] = $table_q;
				$where_2d_arr[$rowarr][1] = "LIKE";
				$where_2d_arr[$rowarr][2] = $services_title;
				$rowarr++;
			}
			//Если id меньше максимального (не выходит из диапазона)
			if($request->start_id < $request->max_id && $request->start_id){
				$sort_direction = "asc";
				$where_2d_arr[$rowarr][0] = "id";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $request->start_id;
				$rowarr++;
			}
			//Блок поиска по разделам, категориям и видам услуг
			if($kind_id){  //Если при поиске указан вид услуг
				$where_2d_arr[$rowarr][0] = "kind_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $kind_id;
				$rowarr++;
			}
			if($category_id && !$kind_id){  //Если при поиске указана категория
				$where_2d_arr[$rowarr][0] = "category_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $category_id;
				$rowarr++;
			}
			if($section_id && !$category_id){  //Если при поиске указан раздел
				$where_2d_arr[$rowarr][0] = "section_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $section_id;
				$rowarr++;
			}
			//Блок поиска по датам
			if(isset($date_on_start)){  //Дата больше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_on_start;
				$rowarrdat++;
			}
			if(isset($date_on_end)){  //Дата меньше которой должен быть начальный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_on";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_on_end;
				$rowarrdat++;
			}
			if(isset($date_off_start)){  //Дата больше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = ">";
				$where_date_arr[$rowarrdat][2] = $date_off_start;
				$rowarrdat++;
			}
			if(isset($date_off_end)){  //Дата меньше которой должен быть конечный срок публикации
				$where_date_arr[$rowarrdat][0] = "date_off";
				$where_date_arr[$rowarrdat][1] = "<";
				$where_date_arr[$rowarrdat][2] = $date_off_end;
				$rowarrdat++;
			}
			//Поиск по типу торгов
			if($bidding_type){  
				$where_2d_arr[$rowarr][0] = "bidding_type";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $bidding_type;
				$rowarr++;
			}
			//Блок поиска по ценам
				//Цена больше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_min) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Купить сразу
			if(isset($price_f_max) && ($bidding_type == 2 || $bidding_type == 6)){  
				$where_2d_arr[$rowarr][0] = "price_buy_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_min) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_f_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть фиксированная цена Продать сразу
			if(isset($price_f_max) && ($bidding_type == 3 || $bidding_type == 7)){  
				$where_2d_arr[$rowarr][0] = "price_sell_now";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_f_max;
				$rowarr++;
			}
				//Цена больше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_min) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = ">";
				$where_2d_arr[$rowarr][2] = $price_s_min;
				$rowarr++;
			}
				//Цена меньше которой должна быть Начальная цена в Аукционе или Тендере
			if(isset($price_s_max) && ($bidding_type != 2 && $bidding_type != 3)){  
				$where_2d_arr[$rowarr][0] = "price_start";
				$where_2d_arr[$rowarr][1] = "<";
				$where_2d_arr[$rowarr][2] = $price_s_max;
				$rowarr++;
			}
			//Сравнение по city_id
			if($city_id){  
				$where_2d_arr[$rowarr][0] = "city_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $city_id;
				$rowarr++;
			}
		}

		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
		}else{
			$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}else{
				$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}		
	
		if($request->start_id < $request->max_id && $request->start_id){
			$min_id = $request->min_id;
			$max_id = $request->max_id;
		}else{
			if($services_title && $in_content){
				$min_id = ServiceDesc::min('id');
				$max_id = ServiceDesc::max('id');
			}else{
				$min_id = Service::min('id');
				$max_id = Service::max('id');
			}
		}		
		$start_id = $services->max('id');
		$end_id = $services->min('id');
		$date_offset = $request->get('date_offset');

		 return view('admin.services.request')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'max_id' => $max_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'category_id' => $category_id,
				  'section_id' => $section_id,
				  'date_on_start' => $request->date_on_start,
				  'date_on_end' => $request->date_on_end,
				  'date_off_start' => $request->date_off_start,
				  'date_off_end' => $request->date_off_end,
				  'bidding_type' => $bidding_type,
				  'price_f_min' => $price_f_min,
				  'price_f_max' => $price_f_max,
				  'price_s_min' => $price_s_min,
				  'price_s_max' => $price_s_max,
				  'in_content' => $in_content,
				  'city_id' => $city_id,
				  
			]);
	}
	

	
	
	
}
