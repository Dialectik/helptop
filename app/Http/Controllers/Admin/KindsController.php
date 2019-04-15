<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KindsController extends Controller
{
    
    public function index()
    {
        $kinds = Kind::all();
    	return view('admin.kinds.index', ['kinds' => $kinds]);
    }
    
    public function create()
    {
        $sections = Section::all();
        
        return view('admin.kinds.create', [
        	'sections' => $sections,
        	
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
    		'title'	=>	'required',          //обязательно
    		'section_id' => 'required',
    		'category_id' => 'required'
    	]);

    	Kind::create($request->all());
    	return redirect()->route('kinds.index');
    }
    
    public function edit($id)
    {
        $kind = Kind::find($id);
        $categories = Category::all();
    	$sections = Section::all();
    	return view('admin.kinds.edit', [
    		'kind'=>$kind,
    		'categories'=>$categories,
    		'sections'=>$sections    		
    		]);
    }
    
    
}
