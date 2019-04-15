<?php

namespace App\Http\Controllers\Admin;

use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KindsDeleteController extends Controller
{
    public function destroy(Request $request)
    {
        Kind::find($request->get('id'))->delete();
    	return redirect()->route('kinds.index');
    }
}
