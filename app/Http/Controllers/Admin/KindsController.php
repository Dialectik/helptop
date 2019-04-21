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
    		'code' => 'required|min:1|numeric',   //обязательно значение, не менее 1, только цифры
    		'section_id' => 'required',
    		'category_id' => 'required'
    	]);

    	$kind = Kind::create($request->all());
    	$kind->code = $kind->setKindCode($request);
    	$kind->save();
    	
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
