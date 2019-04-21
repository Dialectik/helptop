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
    		'code' => 'required|min:1|numeric',   //обязательно значение, не менее 1, только цифры
    		'section_id' => 'required',
    		'category_id' => 'required'
    	]);

    	$kind = Kind::find($request->get('id'));
    	$kind->update($request->all());
    	$kind->code = $kind->setKindCode($request);
    	$kind->save();
    	return redirect()->route('kinds.index');
    }
}
