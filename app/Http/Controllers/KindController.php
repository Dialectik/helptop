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
use Cookie;
use App\Reting;
use App\Basket;

class KindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::all();
        $section_id = Kind::where('id', $id)->pluck('section_id')->first();
        $section_title = Section::where('id', $section_id)->pluck('title')->first();
		$categories = Category::all();
		$category_id = Kind::where('id', $id)->pluck('category_id')->first();
        $category_title = Category::where('id', $category_id)->pluck('title')->first();
		$kinds = Kind::all();
		$kind_title = Kind::where('id', $id)->pluck('title')->first();
		$kind = Kind::find($id);
        $bidding_types = BiddingType::all();
        $kind_id = $id;
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
	        $services = Service::where("status", 1)->orderBy('created_at', 'desc')->where('kind_id', $id)->take($services_on_page)->get();
	        
	        //Объявления Lider пакета 11-15
	        $services_1 = '$secondLid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_2 = '$thirdLid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_3 = '$fourthLid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [11, 15])';
	        $services_4 = '$servicesLid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_bidding = '';
	        if(isset($bidding_id)){
				if($bidding_id == 2 || $bidding_id == 4 || $bidding_id == 6){
					$services_bidding = '->whereIn("bidding_type", [2,4,6])';
				}
				if($bidding_id == 3 || $bidding_id == 5 || $bidding_id == 7){
					$services_bidding = '->whereIn("bidding_type", [3,5,7])';
				}
			}
			$services_1 .= $services_bidding;
			$services_1 .= '->inRandomOrder()->take("3");';
			$services_2 .= $services_bidding;
			$services_2 .= '->inRandomOrder()->take("3");';
			$services_3 .= $services_bidding;
			$services_3 .= '->inRandomOrder()->take("3");';
			$services_4 .= $services_bidding;
			$services_4 .= '->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
	        eval($services_1);
	        eval($services_2);
	        eval($services_3);
	        eval($services_4);
			
			//Объявления Middle пакета 6-10
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_6 = '$thirdMid = App\\Service::where("status", 1)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_7 = '$fourthMid = App\\Service::where("status", 1)->whereBetween("blurb_type_id", [6, 10])';
	        $services_8 = '$servicesMid = App\\Service::where("status", 1)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_5 .= $services_bidding;
			$services_5 .= '->inRandomOrder()->take("3");';
			$services_6 .= $services_bidding;
			$services_6 .= '->inRandomOrder()->take("3");';
			$services_7 .= $services_bidding;
			$services_7 .= '->inRandomOrder()->take("3");';
			$services_8 .= $services_bidding;
			$services_8 .= '->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
	        eval($services_5);
	        eval($services_6);
	        eval($services_7);
	        eval($services_8);
		}
		
		//Если ВЫБРАНА область и НЕ выбран город
		if(isset($region_id) && !isset($city_id)){
			$services = Service::where("status", 1)->where("region_id", $region_id)->orderBy('created_at', 'desc')->where('kind_id', $id)->take($services_on_page)->get();
	        
	        //Объявления Lider пакета 11-15
	        $services_1 = '$secondLid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_2 = '$thirdLid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_3 = '$fourthLid = App\\Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [11, 15])';
	        $services_4 = '$servicesLid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_bidding = '';
	        if(isset($bidding_id)){
				if($bidding_id == 2 || $bidding_id == 4 || $bidding_id == 6){
					$services_bidding = '->whereIn("bidding_type", [2,4,6])';
				}
				if($bidding_id == 3 || $bidding_id == 5 || $bidding_id == 7){
					$services_bidding = '->whereIn("bidding_type", [3,5,7])';
				}
			}
			$services_1 .= $services_bidding;
			$services_1 .= '->inRandomOrder()->take("3");';
			$services_2 .= $services_bidding;
			$services_2 .= '->inRandomOrder()->take("3");';
			$services_3 .= $services_bidding;
			$services_3 .= '->inRandomOrder()->take("3");';
			$services_4 .= $services_bidding;
			$services_4 .= '->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
	        eval($services_1);
	        eval($services_2);
	        eval($services_3);
	        eval($services_4);
			
			//Объявления Middle пакета 6-10
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_6 = '$thirdMid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_7 = '$fourthMid = App\\Service::where("status", 1)->where("region_id", $region_id)->whereBetween("blurb_type_id", [6, 10])';
	        $services_8 = '$servicesMid = App\\Service::where("status", 1)->where("region_id", $region_id)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_5 .= $services_bidding;
			$services_5 .= '->inRandomOrder()->take("3");';
			$services_6 .= $services_bidding;
			$services_6 .= '->inRandomOrder()->take("3");';
			$services_7 .= $services_bidding;
			$services_7 .= '->inRandomOrder()->take("3");';
			$services_8 .= $services_bidding;
			$services_8 .= '->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
	        eval($services_5);
	        eval($services_6);
	        eval($services_7);
	        eval($services_8);
		}
		
		//Если ВЫБРАН город
		if(isset($city_id)){
			$services = Service::where("status", 1)->where("city_id", $city_id)->orderBy('created_at', 'desc')->where('kind_id', $id)->take($services_on_page)->get();
	        
	        //Объявления Lider пакета 11-15
	        $services_1 = '$secondLid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_2 = '$thirdLid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_3 = '$fourthLid = App\\Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [11, 15])';
	        $services_4 = '$servicesLid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [11, 15])';
	        $services_bidding = '';
	        if(isset($bidding_id)){
				if($bidding_id == 2 || $bidding_id == 4 || $bidding_id == 6){
					$services_bidding = '->whereIn("bidding_type", [2,4,6])';
				}
				if($bidding_id == 3 || $bidding_id == 5 || $bidding_id == 7){
					$services_bidding = '->whereIn("bidding_type", [3,5,7])';
				}
			}
			$services_1 .= $services_bidding;
			$services_1 .= '->inRandomOrder()->take("3");';
			$services_2 .= $services_bidding;
			$services_2 .= '->inRandomOrder()->take("3");';
			$services_3 .= $services_bidding;
			$services_3 .= '->inRandomOrder()->take("3");';
			$services_4 .= $services_bidding;
			$services_4 .= '->inRandomOrder()->take("3")->union($secondLid)->union($thirdLid)->union($fourthLid)->get();';
	        eval($services_1);
	        eval($services_2);
	        eval($services_3);
	        eval($services_4);
			
			//Объявления Middle пакета 6-10
			$services_5 = '$secondMid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("category_id", '.$category_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_6 = '$thirdMid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("section_id", '.$section_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_7 = '$fourthMid = App\\Service::where("status", 1)->where("city_id", $city_id)->whereBetween("blurb_type_id", [6, 10])';
	        $services_8 = '$servicesMid = App\\Service::where("status", 1)->where("city_id", $city_id)->where("kind_id", '.$kind_id.')->whereBetween("blurb_type_id", [6, 10])';
	        $services_5 .= $services_bidding;
			$services_5 .= '->inRandomOrder()->take("3");';
			$services_6 .= $services_bidding;
			$services_6 .= '->inRandomOrder()->take("3");';
			$services_7 .= $services_bidding;
			$services_7 .= '->inRandomOrder()->take("3");';
			$services_8 .= $services_bidding;
			$services_8 .= '->inRandomOrder()->take("3")->union($secondMid)->union($thirdMid)->union($fourthMid)->get();';
	        eval($services_5);
	        eval($services_6);
	        eval($services_7);
	        eval($services_8);
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
        	'section_id' => $section_id,
        	'section_title' => $section_title,
        	'categories' => $categories,
        	'category_id' => $category_id,
        	'category_title' => $category_title,
        	'kinds' => $kinds,
        	'kind_id' => $kind_id,
        	'kind' => $kind,
        	'kind_title' => $kind_title,
        	'services' => $services,
        	'services_on_page' => $services_on_page,
        	'servicesLid' => $servicesLid,
			'servicesMid' => $servicesMid,
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
