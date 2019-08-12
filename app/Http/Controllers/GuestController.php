<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use App\BiddingType;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use App\ServiceDesc;
use App\Reting;
use App\Basket;

class GuestController extends Controller
{
    public function index()
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
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where('status', 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where('status', 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where('status', 1)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where('status', 1)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where('status', 1)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where('status', 1)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where('status', 1)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where('status', 1)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where('status', 1)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where('status', 1)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where('status', 1)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->take("3")->get();
			$servicesRec1 = Service::where('status', 1)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where('status', 1)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where('status', 1)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where('status', 1)->whereNull("blurb_type_id")->inRandomOrder()->take("3");
			$servicesCarS = Service::where('status', 1)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
							->union($secondCarS)
							->union($thirdCarS)
							->union($fourthCarS)
							->get();
		}
		
		//Если ВЫБРАНА область и НЕ выбран город
		if(isset($region_id) && !isset($city_id)){
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where('status', 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where('status', 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where('status', 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->take("3")->get();
			$servicesRec1 = Service::where('status', 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where('status', 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where('status', 1)->whereNull("blurb_type_id")->where("region_id", $region_id)->inRandomOrder()->take("3");
			$servicesCarS = Service::where('status', 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
							->union($secondCarS)
							->union($thirdCarS)
							->union($fourthCarS)
							->get();
		}
		
		//Если ВЫБРАН город
		if(isset($city_id)){
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('date_on', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('date_on', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where('status', 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where('status', 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where('status', 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->take("3")->get();
			$servicesRec1 = Service::where('status', 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->orderBy('date_on', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where('status', 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where('status', 1)->where("city_id", $city_id)->inRandomOrder()->take("3");
			$servicesCarS = Service::where('status', 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
							->union($secondCarS)
							->union($thirdCarS)
							->union($fourthCarS)
							->get();
		}
		
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
		
		if (Auth::viaRemember()) {
			return redirect('/');
		}else{
			return view('welcome', [
        	'sections' => $sections,
        	'bidding_types' => $bidding_types,
        	'address' => $address,
        	'categories' => $categories,
        	'kinds' => $kinds,
        	'servicesLidBuy' => $servicesLidBuy,
        	'servicesLidSell' => $servicesLidSell,
        	'servicesMidBuy' => $servicesMidBuy,
        	'servicesMidSell' => $servicesMidSell,
        	'servicesStaBuy' => $servicesStaBuy,
        	'servicesStaSell' => $servicesStaSell,
        	'servicesBuy' => $servicesBuy,
        	'servicesSell' => $servicesSell,
			'servicesLidRec' => $servicesLidRec,
			'servicesLidRec1' => $servicesLidRec1,
			'servicesMidRec' => $servicesMidRec,
			'servicesMidRec1' => $servicesMidRec1,
			'servicesStaRec' => $servicesStaRec,
			'servicesStaRec1' => $servicesStaRec1,
			'servicesRec' => $servicesRec,
			'servicesRec1' => $servicesRec1,
			'servicesLidCar' => $servicesLidCar,
			'servicesCarS' => $servicesCarS,
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






}
