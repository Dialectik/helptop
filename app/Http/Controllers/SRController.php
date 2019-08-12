<?php

namespace App\Http\Controllers;

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
use App\BiddingType;
use Illuminate\Http\Request;
use App\Reting;
use App\Basket;
use Auth;

class SRController extends Controller
{
    //Вывод по кускам информации из БД услуг - первая итерация
    public function _request(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'created_at', 'date_off', 'bidding_type', 'price_current', 'price_buy_now', 'price_sell_now', 'place_id', 'user_id', 'blurb_type_id', 'category_id', 'section_id');
		$sort_column = "created_at";
		$sort_direction = "desc";
		$model_search = "Service";
		$table_q = "title";
		$services_on_page = $request->services_on_page;
		if(isset($services_on_page)) { $chunk = $services_on_page; }else{ $chunk = 50; }
		$rowarr = 0;
		$rowarrdat = 0;
		$rowarrbs = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		$kind_title = Kind::where('id', $kind_id)->pluck('title')->first();
		$kind = Kind::find($kind_id);
		$category_title = Category::where('id', $category_id)->pluck('title')->first();
		$section_title = Section::where('id', $section_id)->pluck('title')->first();
		$sections = Section::all();
		$bidding_types = BiddingType::all();
		$bidding_id = $request->bidding_type;
		$bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		if(isset($request->bidding_bs)){$bidding_bs = $request->bidding_bs;}else{$bidding_bs = null;};
		$region = $request->region;
		$city = $request->city;
		$district = $request->district;
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
		if(!isset($_COOKIE["date_offset"])){
			if(isset($request->date_offset)){$date_offset = $request->date_offset;}
			if(isset($request->date_offset_c)){$date_offset = $request->date_offset_c;}
			if(isset($request->date_offset_s)){$date_offset = $request->date_offset_s;}
			if(isset($request->date_offset_p)){$date_offset = $request->date_offset_p;}
			if(isset($request->date_offset_f)){$date_offset = $request->date_offset_f;}
			setcookie("date_offset", $date_offset, time()+3600);
		}else{$date_offset = $_COOKIE["date_offset"];}
		
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;
		
		//Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
		
		if(isset($_COOKIE["district"])){
			$districtCOOKIE = $_COOKIE["district"];
		}else{$districtCOOKIE = null;}
		
		if(isset($_COOKIE["city"])){
			$cityCOOKIE = $_COOKIE["city"];
		}else{$cityCOOKIE = null;}
		
		if(isset($_COOKIE["region"])){
			$regionCOOKIE = $_COOKIE["region"];
		}else{$regionCOOKIE = null;}
		
		//Установка Cookies с названием города и области
		if($districtCOOKIE != $district || $cityCOOKIE != $city || !isset($_COOKIE["city"]) || $regionCOOKIE != $region || !isset($_COOKIE["region"]) || !isset($_COOKIE["city_id"]) || !isset($_COOKIE["region_id"])){
			if(isset($request->district)){
				setcookie("district", $request->district, time()+3600);
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
		        $city = $request->city;
		        setcookie("city_id", $city_id, time()+3600);
			}elseif(isset($request->city)){
				setcookie("city", $request->city, time()+3600);
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
		        setcookie("city_id", $city_id, time()+3600);
		        setcookie("district", null, time()+3600);
		        $district = null;
		        $city = $request->city;
			}else{
				$city = null;
				$city_id = null;
				$district = null;
				setcookie("district", null, time()+3600);
				setcookie("city_id", null, time()+3600);
				setcookie("city", null, time()+3600);
			}
		}else{
			$city_id = $_COOKIE["city_id"];
		}
		
		//Установка Cookies с названием города и области
		if($regionCOOKIE != $region || !isset($_COOKIE["region"]) || !isset($_COOKIE["region_id"])){
			if(isset($request->region)){
				setcookie("region", $request->region, time()+3600);
				$second2 = Ukraine2::where('region', $request->region)->pluck('id');
		        $third2 = Ukraine3::where('region', $request->region)->pluck('id');
		        $fourth2 = Ukraine4::where('region', $request->region)->pluck('id');      
		        $region_id = Ukraine1::where('region', $request->region)->pluck('id')
		        					->union($second2)
		        					->union($third2)
		        					->union($fourth2)
		        					->first();
				setcookie("region_id", $region_id, time()+3600);
				$region = $request->region;
			}else{
				$region = null;
				$region_id = null;
				setcookie("region_id", null, time()+3600);
				setcookie("region", null, time()+3600);
			}
		}else{
			$region_id = $_COOKIE["region_id"];
		}
		
		
		//Ищем в любом случае среди опубликованных
		$where_2d_arr[$rowarr][0] = "status";
		$where_2d_arr[$rowarr][1] = "=";
		$where_2d_arr[$rowarr][2] = 1;
		$rowarr++;
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
			//Поиск по условию "Купить/Продать"
			if(isset($bidding_bs)){
				for($i=1;$i < 4;$i++){
					$where_bs_arr[$rowarrbs][0] = "bidding_type";
					$where_bs_arr[$rowarrbs][2] = $bidding_bs % 2 + 2 * $i;
					$rowarrbs++;
				}
			}
//			dd($where_bs_arr);
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
			//Сравнение по region_id
			if($region_id){  
				$where_2d_arr[$rowarr][0] = "region_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $region_id;
				$rowarr++;
			}
		}
		

		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}
		}else{
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
				}
			}else{
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
				}
			}
		}
		
		$start_id = $services->max('id');
		$end_id = $services->min('id');
		if($services_title && $in_content){
			$min_id = ServiceDesc::min('id');
			$max_id = ServiceDesc::max('id');
		}else{
			$min_id = Service::min('id');
			$max_id = Service::max('id');
		}
		
		
		//Объявления Lider пакета 11-15
        $services_bidding = '';
        isset($bidding_id) ? $bidding_p = $bidding_id : $bidding_p = null;
        isset($bidding_bs) ? $bidding_p = $bidding_bs : $bidding_p = null;
        if(isset($bidding_p)){
			$services_bidding = '->where("bidding_type", '.($bidding_p % 2 + 2).')->orWhere("bidding_type", '.($bidding_p % 2 + 4).')->orWhere("bidding_type", '.($bidding_p % 2 + 6).')';
		}
        
        $services_1 = '';
        $services_2 = '';
        $services_3 = '$fourthLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_4 = '$servicesLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_1 = '$secondLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdLid)->union($fourthLid)->get();';
		}
        if(isset($section_id)){
			$services_2 = '$thirdLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthLid)->get();';
		}
		if(isset($kind_id)){
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
		}
		eval($services_1);
        eval($services_2);
        eval($services_3);
        eval($services_4);
		
		//Объявления Middle пакета 6-10
		$services_5 = '';
        $services_6 = '';
        $services_7 = '$fourthMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_8 = '$servicesMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdMid)->union($fourthMid)->get();';
		}
        if(isset($section_id)){
			$services_6 = '$thirdMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthMid)->get();';
		}
		if(isset($kind_id)){
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
		}
        eval($services_5);
        eval($services_6);
        eval($services_7);
        eval($services_8);

		

		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}


		return view('pages.services.index')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'max_id' => $max_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'kind' => $kind,
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
				  'region_id' => $region_id,
				  'section_title' => $section_title,
				  'category_title' => $category_title,
				  'kind_title' => $kind_title,
				  'services_on_page' => $services_on_page,
				  'sections' => $sections,
				  'bidding_types' => $bidding_types,
				  'address' => $address,
				  'bidding_id' => $bidding_id,
				  'bidding_title' => $bidding_title,
				  'bidding_bs' => $bidding_bs,
				  'region' => $region,
				  'city' => $city,
				  'district' => $district,
				  'servicesLid' => $servicesLid,
				  'servicesMid' => $servicesMid,
				  'basket_mark' => $basket_mark,

			]);
	}
	
	
	//Вывод по кускам информации из БД услуг - прямой ход
	public function requestOffset(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'created_at', 'date_off', 'bidding_type', 'price_current', 'price_buy_now', 'price_sell_now', 'place_id', 'user_id', 'blurb_type_id', 'category_id', 'section_id');
		$sort_column = "created_at";
		$sort_direction = "asc";
		$model_search = "Service";
		$table_q = 'title';
		$services_on_page = $request->services_on_page;
		if(isset($services_on_page)) { $chunk = $services_on_page; }else{ $chunk = 50; }
		$rowarr = 0;
		$rowarrdat = 0;
		$rowarrbs = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		$kind_title = Kind::where('id', $kind_id)->pluck('title')->first();
		$kind = Kind::find($kind_id);
		$category_title = Category::where('id', $category_id)->pluck('title')->first();
		$section_title = Section::where('id', $section_id)->pluck('title')->first();
		$sections = Section::all();
		$bidding_types = BiddingType::all();
		$bidding_id = $request->bidding_type;
		$bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		if(isset($request->bidding_bs)){$bidding_bs = $request->bidding_bs;}else{$bidding_bs = null;};
		$region = $request->region;
		$city = $request->city;
		$district = $request->district;
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
		if(!isset($_COOKIE["date_offset"])){
			if(isset($request->date_offset)){$date_offset = $request->date_offset;}
			if(isset($request->date_offset_c)){$date_offset = $request->date_offset_c;}
			if(isset($request->date_offset_s)){$date_offset = $request->date_offset_s;}
			if(isset($request->date_offset_p)){$date_offset = $request->date_offset_p;}
			if(isset($request->date_offset_f)){$date_offset = $request->date_offset_f;}
			setcookie("date_offset", $date_offset, time()+3600);
		}else{$date_offset = $_COOKIE["date_offset"];}
		
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;
		
		//Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();

		//Сравнение по city_id
		$city_id = $request->city_id;
		//Сравнение по region_id
		$region_id = $request->region_id;

		//Ищем в любом случае среди опубликованных
		$where_2d_arr[$rowarr][0] = "status";
		$where_2d_arr[$rowarr][1] = "=";
		$where_2d_arr[$rowarr][2] = 1;
		$rowarr++;  
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
			//Поиск по условию "Купить/Продать"
			if(isset($bidding_bs)){
				for($i=1;$i < 4;$i++){
					$where_bs_arr[$rowarrbs][0] = "bidding_type";
					$where_bs_arr[$rowarrbs][2] = $bidding_bs % 2 + 2 * $i;
					$rowarrbs++;
				}
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
			//Сравнение по region_id
			if($region_id){  
				$where_2d_arr[$rowarr][0] = "region_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $region_id;
				$rowarr++;
			}
		}
	
		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}
		}else{
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
				}
			}else{
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
				}
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
		
		
		//Объявления Lider пакета 11-15
        $services_bidding = '';
        isset($bidding_id) ? $bidding_p = $bidding_id : $bidding_p = null;
        isset($bidding_bs) ? $bidding_p = $bidding_bs : $bidding_p = null;
        if(isset($bidding_p)){
			$services_bidding = '->where("bidding_type", '.($bidding_p % 2 + 2).')->orWhere("bidding_type", '.($bidding_p % 2 + 4).')->orWhere("bidding_type", '.($bidding_p % 2 + 6).')';
		}
        
        $services_1 = '';
        $services_2 = '';
        $services_3 = '$fourthLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_4 = '$servicesLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_1 = '$secondLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdLid)->union($fourthLid)->get();';
		}
        if(isset($section_id)){
			$services_2 = '$thirdLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthLid)->get();';
		}
		if(isset($kind_id)){
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
		}
		eval($services_1);
        eval($services_2);
        eval($services_3);
        eval($services_4);
		
		//Объявления Middle пакета 6-10
		$services_5 = '';
        $services_6 = '';
        $services_7 = '$fourthMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_8 = '$servicesMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdMid)->union($fourthMid)->get();';
		}
        if(isset($section_id)){
			$services_6 = '$thirdMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthMid)->get();';
		}
		if(isset($kind_id)){
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
		}
        eval($services_5);
        eval($services_6);
        eval($services_7);
        eval($services_8);
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		 
		 return view('pages.services.index')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'max_id' => $max_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'kind' => $kind,
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
				  'region_id' => $region_id,
				  'section_title' => $section_title,
				  'category_title' => $category_title,
				  'kind_title' => $kind_title,
				  'services_on_page' => $services_on_page,
				  'sections' => $sections,
				  'bidding_types' => $bidding_types,
				  'address' => $address,
				  'bidding_id' => $bidding_id,
				  'bidding_title' => $bidding_title,
				  'bidding_bs' => $bidding_bs,
				  'region' => $region,
				  'city' => $city,
				  'district' => $district,
				  'servicesLid' => $servicesLid,
				  'servicesMid' => $servicesMid,
				  'basket_mark' => $basket_mark,
				  
			]);
	}
	
	
	//Вывод по кускам информации из БД услуг - обратный ход
	public function requestOffsetReturn(Request $request)
    {
		$services_title = $request->services_title;
		if($request->product_code_id) {$product_code_id = str_replace('-', '', $request->product_code_id); 
			}else{$product_code_id = $request->product_code_id; }
		$select_columns = array('title', 'kind_id', 'date_on', 'created_at', 'date_off', 'bidding_type', 'price_current', 'price_buy_now', 'price_sell_now', 'place_id', 'user_id', 'blurb_type_id', 'category_id', 'section_id');
		$sort_column = "created_at";
		$sort_direction = "desc";
		$model_search = "Service";
		$table_q = 'title';
		$services_on_page = $request->services_on_page;
		if(isset($services_on_page)) { $chunk = $services_on_page; }else{ $chunk = 50; }
		$rowarr = 0;
		$rowarrdat = 0;
		$rowarrbs = 0;
		$kind_id = $request->kind_id;
		$category_id = $request->category_id;
		$section_id = $request->section_id;
		$kind_title = Kind::where('id', $kind_id)->pluck('title')->first();
		$kind = Kind::find($kind_id);
		$category_title = Category::where('id', $category_id)->pluck('title')->first();
		$section_title = Section::where('id', $section_id)->pluck('title')->first();
		$sections = Section::all();
		$bidding_types = BiddingType::all();
		$bidding_id = $request->bidding_type;
		$bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		if(isset($request->bidding_bs)){$bidding_bs = $request->bidding_bs;}else{$bidding_bs = null;};
		$region = $request->region;
		$city = $request->city;
		$district = $request->district;
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
		if(!isset($_COOKIE["date_offset"])){
			if(isset($request->date_offset)){$date_offset = $request->date_offset;}
			if(isset($request->date_offset_c)){$date_offset = $request->date_offset_c;}
			if(isset($request->date_offset_s)){$date_offset = $request->date_offset_s;}
			if(isset($request->date_offset_p)){$date_offset = $request->date_offset_p;}
			if(isset($request->date_offset_f)){$date_offset = $request->date_offset_f;}
			setcookie("date_offset", $date_offset, time()+3600);
		}else{$date_offset = $_COOKIE["date_offset"];}
		
		if($request->date_on_start) $date_on_start = Service::userInBaseDate($request->date_on_start, $date_offset);
		if($request->date_on_end) $date_on_end = Service::userInBaseDate($request->date_on_end, $date_offset);
		if($request->date_off_start) $date_off_start = Service::userInBaseDate($request->date_off_start, $date_offset);
		if($request->date_off_end) $date_off_end = Service::userInBaseDate($request->date_off_end, $date_offset);
		$bidding_type = $request->bidding_type;
		$price_f_min = $request->price_f_min;
		$price_f_max = $request->price_f_max;
		$price_s_min = $request->price_s_min;
		$price_s_max = $request->price_s_max;
		$in_content = $request->in_content;
		
		//Объединение запросов из таблиц адресов с одинаковыми наименованиями столбцов
        $second = Ukraine2::select('region')->distinct();
        $third = Ukraine3::select('region')->distinct();
        $fourth = Ukraine4::select('region')->distinct();        
        $address = Ukraine1::select('region')->distinct()
        			->union($second)
        			->union($third)
        			->union($fourth)
        			->get();
		
		//Сравнение по city_id
		$city_id = $request->city_id;
		//Сравнение по region_id
		$region_id = $request->region_id;
		
		//Ищем в любом случае среди опубликованных
		$where_2d_arr[$rowarr][0] = "status";
		$where_2d_arr[$rowarr][1] = "=";
		$where_2d_arr[$rowarr][2] = 1;
		$rowarr++;
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
			//Поиск по условию "Купить/Продать"
			if(isset($bidding_bs)){
				for($i=1;$i < 4;$i++){
					$where_bs_arr[$rowarrbs][0] = "bidding_type";
					$where_bs_arr[$rowarrbs][2] = $bidding_bs % 2 + 2 * $i;
					$rowarrbs++;
				}
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
			//Сравнение по region_id
			if($region_id){  
				$where_2d_arr[$rowarr][0] = "region_id";
				$where_2d_arr[$rowarr][1] = "=";
				$where_2d_arr[$rowarr][2] = $region_id;
				$rowarr++;
			}
		}

		//Вначале производим поиск по конкретной жестко закрепленной фразе
		if(empty($where_date_arr)){
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
			}
		}else{
			if(isset($bidding_bs)){
				$services = Search::hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
			}else{
				$services = Search::hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
			}
		}
		//Если предыдущий поиск не удачен - ищем по наличию всех слов из фразы, стоящих в любом порядке
		foreach($services as $service){if($id = $service->id){	}	} //Присвоение в операторе IF
		if(empty($id) && ($services_title)){
			if(empty($where_date_arr)){
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr);
				}
			}else{
				if(isset($bidding_bs)){
					$services = Search::middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr);
				}else{
					$services = Search::middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr);
				}
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
	
		
		//Объявления Lider пакета 11-15
        $services_bidding = '';
        isset($bidding_id) ? $bidding_p = $bidding_id : $bidding_p = null;
        isset($bidding_bs) ? $bidding_p = $bidding_bs : $bidding_p = null;
        if(isset($bidding_p)){
			$services_bidding = '->where("bidding_type", '.($bidding_p % 2 + 2).')->orWhere("bidding_type", '.($bidding_p % 2 + 4).')->orWhere("bidding_type", '.($bidding_p % 2 + 6).')';
		}
        
        $services_1 = '';
        $services_2 = '';
        $services_3 = '$fourthLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_4 = '$servicesLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_1 = '$secondLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdLid)->union($fourthLid)->get();';
		}
        if(isset($section_id)){
			$services_2 = '$thirdLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthLid)->get();';
		}
		if(isset($kind_id)){
			$services_4 = '$servicesLid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
		}
		eval($services_1);
        eval($services_2);
        eval($services_3);
        eval($services_4);
		
		//Объявления Middle пакета 6-10
		$services_5 = '';
        $services_6 = '';
        $services_7 = '$fourthMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
        $services_8 = '$servicesMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->get();';
        if(isset($category_id)){
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($thirdMid)->union($fourthMid)->get();';
		}
        if(isset($section_id)){
			$services_6 = '$thirdMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3");';
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($fourthMid)->get();';
		}
		if(isset($kind_id)){
			$services_8 = '$servicesMid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])'.$services_bidding.'->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
		}
        eval($services_5);
        eval($services_6);
        eval($services_7);
        eval($services_8);
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}

		 return view('pages.services.index')->with([
				  'services' => $services,
				  'date_offset' => $date_offset,
				  'start_id' => $start_id,
				  'end_id' => $end_id,
				  'min_id' => $min_id,
				  'max_id' => $max_id,
				  'services_title' => $services_title,
				  'product_code_id' => $product_code_id,
				  'kind_id' => $kind_id,
				  'kind' => $kind,
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
				  'region_id' => $region_id,
				  'section_title' => $section_title,
				  'category_title' => $category_title,
				  'kind_title' => $kind_title,
				  'services_on_page' => $services_on_page,
				  'sections' => $sections,
				  'bidding_types' => $bidding_types,
				  'address' => $address,
				  'bidding_id' => $bidding_id,
				  'bidding_title' => $bidding_title,
				  'bidding_bs' => $bidding_bs,
				  'region' => $region,
				  'city' => $city,
				  'district' => $district,
				  'servicesLid' => $servicesLid,
				  'servicesMid' => $servicesMid,
				  'basket_mark' => $basket_mark,
				  
			]);
	}
	

	
	
	
}
