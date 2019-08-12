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


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

			
		//Установка Cookies с названием города и области
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

		
		//Если не выбрана область и не выбран город
		if(!isset($region_id) && !isset($city_id)){
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where("status", 1)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where("status", 1)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where("status", 1)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where("status", 1)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where("status", 1)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where("status", 1)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where("status", 1)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->take("3")->get();
			$servicesRec1 = Service::where("status", 1)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where("status", 1)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where("status", 1)->whereNull("blurb_type_id")->inRandomOrder()->take("3");
			$servicesCarS = Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
							->union($secondCarS)
							->union($thirdCarS)
							->union($fourthCarS)
							->get();
		}
		
		//Если ВЫБРАНА область и НЕ выбран город
		if(isset($region_id) && !isset($city_id)){
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where("status", 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where("status", 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where("status", 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->take("3")->get();
			$servicesRec1 = Service::where("status", 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where("status", 1)->whereNull("blurb_type_id")->where("region_id", $region_id)->inRandomOrder()->take("3");
			$servicesCarS = Service::where("status", 1)->where("region_id", $region_id)->whereNull("blurb_type_id")->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
							->union($secondCarS)
							->union($thirdCarS)
							->union($fourthCarS)
							->get();
		}
		
		//Если ВЫБРАН город
		if(isset($city_id)){
			//Объявления Lider пакета 11-15
			$servicesLidBuy = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("2")->get();
			$servicesLidSell = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("2")->get();
			$servicesLidRec = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->take("2")->get();
			$servicesLidRec1 = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->orderBy('created_at', 'desc')->skip(3)->take("2")->get();
			$servicesLidCar = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("1")->get();
			
			//Объявления Middle пакета 6-10
			$servicesMidBuy = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("1")->get();
			$servicesMidSell = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("1")->get();
			$servicesMidRec = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->take("1")->get();
			$servicesMidRec1 = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->orderBy('created_at', 'desc')->skip(3)->take("1")->get();
			
			//Объявления Старт пакета 1-5
			$servicesStaBuy = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesStaSell = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesStaRec = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->take("3")->get();
			$servicesStaRec1 = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			//Объявления Обычные
			$servicesBuy = Service::where("status", 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [2,4,6,102])->inRandomOrder()->take("3")->get();
			$servicesSell = Service::where("status", 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereIn("bidding_type", [3,5,7,103])->inRandomOrder()->take("3")->get();
			$servicesRec = Service::where("status", 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->take("3")->get();
			$servicesRec1 = Service::where("status", 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->orderBy('created_at', 'desc')->skip(3)->take("3")->get();
			
			
			$secondCarS = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])->inRandomOrder()->take("3");
			$thirdCarS = Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [1, 5])->inRandomOrder()->take("3");
			$fourthCarS = Service::where("status", 1)->where("city_id", $city_id)->inRandomOrder()->take("3");
			$servicesCarS = Service::where("status", 1)->where("city_id", $city_id)->whereNull("blurb_type_id")->whereBetween("blurb_type_id", [11, 15])->inRandomOrder()->take("2")
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
		if(!isset($_COOKIE["date_offset"])){
			if(isset($request->date_offset)){$date_offset = $request->date_offset;}
			if(isset($request->date_offset_c)){$date_offset = $request->date_offset_c;}
			if(isset($request->date_offset_s)){$date_offset = $request->date_offset_s;}
			if(isset($request->date_offset_p)){$date_offset = $request->date_offset_p;}
			setcookie("date_offset", $date_offset, time()+3600);
		}else{$date_offset = $_COOKIE["date_offset"];}
		
		
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
