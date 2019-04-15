<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesDeleteController extends Controller
{
    public function destroy(Request $request)
    {
        Category::find($request->get('id'))->delete();
    	return redirect()->route('categories.index');
    }
}
