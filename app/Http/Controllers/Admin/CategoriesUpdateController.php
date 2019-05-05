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
    		'title'	=>	'required',              //обязательно значение
    		'code' => 'required|min:1|numeric',   //обязательно значение, не менее 1, только цифры
    		'section_id' => 'required'
    	]);

    	$category = Category::find($request->get('id'));
    	$category->update($request->all());
    	$category->code = $category->setCategoryCode($request);
    	$category->slug = str_slug($category->title);   //Изменение слага перед сохранением по мотивам измененного названия
    	$category->save();
    	return redirect()->route('categories.index');
    }
}
