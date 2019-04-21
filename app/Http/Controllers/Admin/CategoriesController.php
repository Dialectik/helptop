<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
    	$categories = Category::all();
    	return view('admin.categories.index', ['categories'	=>	$categories]);
    }

    public function create()
    {
    	$sections = Section::all();
    	return view('admin.categories.create', ['sections'	=>	$sections]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'title'	=>	'required',              //обязательно значение
    		'code' => 'required|min:1|numeric',   //обязательно значение, не менее 1, только цифры
    		'section_id' => 'required'
    	]);

		

    	$category = Category::create($request->all());
    	$category->code = $category->setCategoryCode($request);
    	$category->save();
    	return redirect()->route('categories.index');
    }
       
    public function edit($id)
    {
    	$category = Category::find($id);
    	$sections = Section::all();
    	return view('admin.categories.edit', [
    		'category'=>$category,
    		'sections'=>$sections    		
    		]);
    }

    
}
