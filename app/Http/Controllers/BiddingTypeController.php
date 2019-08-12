<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use App\BiddingType;
use App\ServiceDesc;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use App\Search;
use App\Reting;
use App\Basket;

class BiddingTypeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($bidding_type)
    {
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
        
        //Если не выбрана область и не выбран город
		if(!isset($region_id) && !isset($city_id)){
	        if($bidding_type == 22){  //Купить услуги
				$services = Service::where("status", 1)->orderBy('created_at', 'desc')->whereIn("bidding_type", [2,4,6,102])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}elseif($bidding_type == 23){ //Продать услуги
				$services = Service::where("status", 1)->orderBy('created_at', 'desc')->whereIn("bidding_type", [3,5,7,103])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}else{  //Конкретный тип торгов
				$bidding_id = $bidding_type;
		        $bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		        $services = Service::where("status", 1)->orderBy('created_at', 'desc')->where('bidding_type', $bidding_id)->take($services_on_page)->get();
		        if($bidding_id == 2) {$bidding_1 = 4; $bidding_2 = 6;}
		        if($bidding_id == 4) {$bidding_1 = 2; $bidding_2 = 6;}
		        if($bidding_id == 6) {$bidding_1 = 2; $bidding_2 = 4;}
		        if($bidding_id == 3) {$bidding_1 = 5; $bidding_2 = 7;}
		        if($bidding_id == 5) {$bidding_1 = 3; $bidding_2 = 7;}
		        if($bidding_id == 7) {$bidding_1 = 3; $bidding_2 = 5;}
		        //Объявления Lider пакета 11-15
				$secondLid = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdLid = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesLid = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondLid)
		        				->union($thirdLid)
		        				->get();
		        //Объявления Middle пакета 6-10
		        $secondMid = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdMid = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesMid = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondMid)
		        				->union($thirdMid)
		        				->get();
		        $bidding_bs = null;
			}
		}
        
        //Если ВЫБРАНА область и НЕ выбран город
		if(isset($region_id) && !isset($city_id)){
			if($bidding_type == 22){  //Купить услуги
				$services = Service::where("status", 1)->where("region_id", $region_id)->orderBy('created_at', 'desc')->whereIn("bidding_type", [2,4,6,102])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}elseif($bidding_type == 23){ //Продать услуги
				$services = Service::where("status", 1)->where("region_id", $region_id)->orderBy('created_at', 'desc')->whereIn("bidding_type", [3,5,7,103])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}else{  //Конкретный тип торгов
				$bidding_id = $bidding_type;
		        $bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		        $services = Service::where("status", 1)->where("region_id", $region_id)->orderBy('created_at', 'desc')->where('bidding_type', $bidding_id)->take($services_on_page)->get();
		        if($bidding_id == 2) {$bidding_1 = 4; $bidding_2 = 6;}
		        if($bidding_id == 4) {$bidding_1 = 2; $bidding_2 = 6;}
		        if($bidding_id == 6) {$bidding_1 = 2; $bidding_2 = 4;}
		        if($bidding_id == 3) {$bidding_1 = 5; $bidding_2 = 7;}
		        if($bidding_id == 5) {$bidding_1 = 3; $bidding_2 = 7;}
		        if($bidding_id == 7) {$bidding_1 = 3; $bidding_2 = 5;}
		        //Объявления Lider пакета 11-15
				$secondLid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdLid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesLid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondLid)
		        				->union($thirdLid)
		        				->get();
		        //Объявления Middle пакета 6-10
		        $secondMid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdMid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesMid = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondMid)
		        				->union($thirdMid)
		        				->get();
		        $bidding_bs = null;
			}
		}
        
        //Если ВЫБРАН город
		if(isset($city_id)){
			if($bidding_type == 22){  //Купить услуги
				$services = Service::where("status", 1)->where("city_id", $city_id)->orderBy('created_at', 'desc')->whereIn("bidding_type", [2,4,6,102])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}elseif($bidding_type == 23){ //Продать услуги
				$services = Service::where("status", 1)->where("city_id", $city_id)->orderBy('created_at', 'desc')->whereIn("bidding_type", [3,5,7,103])->take($services_on_page)->get();
				$servicesLid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$servicesMid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
				$bidding_id = null;
				$bidding_title = null;
				$bidding_bs = $bidding_type;
			}else{  //Конкретный тип торгов
				$bidding_id = $bidding_type;
		        $bidding_title = BiddingType::where('id', $bidding_id)->pluck('title')->first();
		        $services = Service::where("status", 1)->where("city_id", $city_id)->orderBy('created_at', 'desc')->where('bidding_type', $bidding_id)->take($services_on_page)->get();
		        if($bidding_id == 2) {$bidding_1 = 4; $bidding_2 = 6;}
		        if($bidding_id == 4) {$bidding_1 = 2; $bidding_2 = 6;}
		        if($bidding_id == 6) {$bidding_1 = 2; $bidding_2 = 4;}
		        if($bidding_id == 3) {$bidding_1 = 5; $bidding_2 = 7;}
		        if($bidding_id == 5) {$bidding_1 = 3; $bidding_2 = 7;}
		        if($bidding_id == 7) {$bidding_1 = 3; $bidding_2 = 5;}
		        //Объявления Lider пакета 11-15
				$secondLid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdLid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesLid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondLid)
		        				->union($thirdLid)
		        				->get();
		        //Объявления Middle пакета 6-10
		        $secondMid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_1)->inRandomOrder()->take("3");
				$thirdMid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_2)->inRandomOrder()->take("3");
		        $servicesMid = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->where("bidding_type", $bidding_id)->inRandomOrder()->take("3")
		        				->union($secondMid)
		        				->union($thirdMid)
		        				->get();
		        $bidding_bs = null;
			}
		}
        
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
		
        
    	return view('pages.services.index', [
        	'bidding_types' => $bidding_types,
        	'address' => $address,
        	'sections' => $sections,
        	'categories' => $categories,
        	'kinds' => $kinds,
        	'services' => $services,
        	'services_on_page' => $services_on_page,
        	'servicesLid' => $servicesLid,
			'servicesMid' => $servicesMid,
			'bidding_id' => $bidding_id,
			'bidding_title' => $bidding_title,
			'bidding_bs' => $bidding_bs,
			'city_id' => $city_id,
			'region_id' => $region_id,
			'city' => $city,
			'region' => $region,
			'district' => $district,
			'date_offset' => $date_offset,
			'basket_mark' => $basket_mark,

    		]);
    }
   
}
