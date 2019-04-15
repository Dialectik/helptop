<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsUpdateController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
    		'title'	=>	'required' //обязательно
    	]);

    	$section = Section::find($request->get('id'));
    	$section->update($request->all());
    	return redirect()->route('sections.index');
    }
}
