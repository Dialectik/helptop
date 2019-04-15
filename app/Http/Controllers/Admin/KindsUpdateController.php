<?php

namespace App\Http\Controllers\Admin;

use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KindsUpdateController extends Controller
{
        public function update(Request $request)
    {
        $this->validate($request, [
    		'title'	=>	'required',          //обязательно
    		'section_id' => 'required',
    		'category_id' => 'required'
    	]);

    	$kind = Kind::find($request->get('id'));
    	$kind->update($request->all());
    	return redirect()->route('kinds.index');
    }
}
