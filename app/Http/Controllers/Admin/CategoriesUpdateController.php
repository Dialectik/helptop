<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesUpdateController extends Controller
{
    public function update(Request $request)
    {
    	$this->validate($request, [
    		'title'	=>	'required',          //обязательно
    		'section_id' => 'required'
    	]);

    	$category = Category::find($request->get('id'));
    	$category->update($request->all());
    	return redirect()->route('categories.index');
    }
}
