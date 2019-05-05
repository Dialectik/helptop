<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use App\Kind;
use App\Service;
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
	//Определить максимальное значение товарного кода услуги для данного вида услуг
	public function getSerCode(Request $request)
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
	}
	
	
}
