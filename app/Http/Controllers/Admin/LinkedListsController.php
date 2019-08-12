<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use App\Kind;
use App\Service;
use App\Ukraine1;
use App\Ukraine2;
use App\Ukraine3;
use App\Ukraine4;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Admin\ProductCodeExcess;

class LinkedListsController extends Controller
{
    public function getCategory(Request $request)
    {
		
		$categories = Category::where('section_id', $request->section_id)->pluck('title', 'id');
		
		return response()->json($categories);
	}
	
	public function getKind(Request $request)
    {
		$kinds = Kind::where('category_id', $request->category_id)->pluck('title', 'id');
		
		return response()->json($kinds);
	}
	
	public function getCat(Request $request)
    {
		
		$categories = Category::where('section_id', $request->section_id)->pluck('title', 'id');
		
		return response()->json($categories);
	}
	
	
	public function getSectionCode(Request $request)
	{
		$sectionCode = Section::where('id', $request->section_id)->value('code');
		return response()->json($sectionCode);
	}
	
	public function getCategoryCode(Request $request)
	{
		$categoryCode = Category::where('id', $request->category_id)->value('code');
		return response()->json($categoryCode);
	}
	
	//Определить максимальное значение товарного кода услуги для данного вида услуг - ФУНКЦИЯ перенесена в КОНТРОЛЛЕР ServicesController
	/*public function getSerCode(Request $request)
	{
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
		
		
		return response()->json($serviceCode);
	}*/
	
	//Определение списка городов для выбранной области
	public function getCities(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('region', $request->region)->pluck('city');
        $third = Ukraine3::where('region', $request->region)->pluck('city');
        $fourth = Ukraine4::where('region', $request->region)->pluck('city');        
        $cities = Ukraine1::where('region', $request->region)->pluck('city')
        			->union($second)
        			->union($third)
        			->union($fourth);
		
		$cities_ar[0] = $cities[0];
		foreach($cities as $city){
			if(!in_array($city, $cities_ar)){
				array_push($cities_ar, $city);
			}
		}
		sort($cities_ar); //Сортировка городов по возрастанию
		
		return response()->json($cities_ar);
	}
	
	//Определение списка районов для выбранных городов
	public function getDistricts(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('district');
        $third = Ukraine3::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('district');
        $fourth = Ukraine4::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('district');        
        $districts = Ukraine1::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('district')
        			->union($second)
        			->union($third)
        			->union($fourth);
		
		$districts_ar[0] = $districts[0];
		foreach($districts as $district){
			if(!in_array($district, $districts_ar)){
				array_push($districts_ar, $district);
			}
		}
		sort($districts_ar); //Сортировка районов по возрастанию
		
		return response()->json($districts_ar);
	}
	
	//Определение списка улиц для выбранного города, когда такой город в области один
	public function getStreets(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('street');
        $third = Ukraine3::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('street');
        $fourth = Ukraine4::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('street');        
        $streets = Ukraine1::where('city', $request->city)
        			->where('region', $request->region)
        			->pluck('street')
        			->union($second)
        			->union($third)
        			->union($fourth);
		
		$streets_ar[0] = $streets[0];
		foreach($streets as $street){
			if(!in_array($street, $streets_ar)){
				array_push($streets_ar, $street);
			}
		}
		sort($streets_ar); //Сортировка улиц по возрастанию
		
		return response()->json($streets_ar);
	}
	
	//Определение списка улиц для выбранного города, когда таких городов в области несколько (в разных районах)
	public function getStreetd(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->pluck('street');
        $third = Ukraine3::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->pluck('street');
        $fourth = Ukraine4::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->pluck('street');        
        $streets = Ukraine1::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->pluck('street')
        			->union($second)
        			->union($third)
        			->union($fourth);
		
		$streets_ar[0] = $streets[0];
		foreach($streets as $street){
			if(!in_array($street, $streets_ar)){
				array_push($streets_ar, $street);
			}
		}
		sort($streets_ar); //Сортировка улиц по возрастанию
		
		return response()->json($streets_ar);
	}
	
	//Определение списка домов на улице в городе, когда такой город в области один
	public function getHouse(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('region', $request->region)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');
        $third = Ukraine3::where('region', $request->region)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');
        $fourth = Ukraine4::where('region', $request->region)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');        
        $houses = Ukraine1::where('region', $request->region)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house')
        			->union($second)
        			->union($third)
        			->union($fourth);

		$houses_ar = array();
		foreach($houses as $house){
			$exp_houses = explode(",", $house);
			if($exp_houses[1] == null){
				$exp_houses[0] = $house;
			}
			foreach($exp_houses as $exp_house){
				array_push($houses_ar, $exp_house);
			}			
		}
		sort($houses_ar); //Сортировка номеров домов по возрастанию
		
		return response()->json($houses_ar);
	}
	
	//Определение списка домов на улице в городе, когда таких городов в области несколько (в разных районах)
	public function getHoused(Request $request)
    {
		//Объединение запросов из таблиц с одинаковыми наименованиями столбцов
        $second = Ukraine2::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');
        $third = Ukraine3::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');
        $fourth = Ukraine4::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house');        
        $houses = Ukraine1::where('region', $request->region)
        			->where('district', $request->district)
        			->where('city', $request->city)
        			->where('street', $request->street)
        			->pluck('house')
        			->union($second)
        			->union($third)
        			->union($fourth);

		$houses_ar = array();
		foreach($houses as $house){
			$exp_houses = explode(",", $house);
			if($exp_houses[1] == null){
				$exp_houses[0] = $house;
			}
			foreach($exp_houses as $exp_house){
				array_push($houses_ar, $exp_house);
			}			
		}
		sort($houses_ar); //Сортировка номеров домов по возрастанию
		
		return response()->json($houses_ar);
	}
	
	
}
