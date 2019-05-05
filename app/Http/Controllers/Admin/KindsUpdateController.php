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
    	
    	//Обновить вид услуг в базе, если в форме "edit" он менялся
    	if($request->category_id_v != null & $request->category_id_v != $request->category_id){
			$kind->category_id = $request->category_id_v;
		}
    	$kind->code = $kind->setKindCode($request);
    	$kind->slug = str_slug($kind->title);   //Изменение слага перед сохранением по мотивам измененного названия
    	$kind->save();
    	return redirect()->route('kinds.index');
    }
}
