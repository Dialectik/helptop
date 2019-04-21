<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{
    public function index()
    {
        $sections = Section::all();
    	return view('admin.sections.index', ['sections'	=>	$sections]);
    }
    
    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
    		'title'	=>	'required',              //обязательно значение
    		'code' => 'required|min:11|numeric'   //обязательно значение, не менее 11, только цифры
    	]);

    	Section::create($request->all());
    	return redirect()->route('sections.index');
    }
    
    public function edit($id)
    {
        $section = Section::find($id);
    	return view('admin.sections.edit', ['section'=>$section]);
    }
    

}
