<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Basket;


class ContactController extends Controller
{
    public function contactForm()
    {
		//Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		return view('pages.contact', [
			'basket_mark' => $basket_mark,
		]);
	}
}
