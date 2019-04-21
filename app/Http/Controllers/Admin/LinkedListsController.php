<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
	
	
}
