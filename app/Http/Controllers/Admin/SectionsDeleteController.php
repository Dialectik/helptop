<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsDeleteController extends Controller
{
    public function destroy(Request $request)
    {
        Section::find($request->get('id'))->delete();
    	return redirect()->route('sections.index');
    }
}
