<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GuestController extends Controller
{
    public function index()
	{
		if (Auth::viaRemember()) {
			return redirect('/');
		}else{
			return view('welcome');
		}
		
	}






}
