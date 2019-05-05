<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;  //модуль конвертации дат
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{
    public function _request(Request $request)
    {
		$services = Service::orderBy('date_on', 'desc')->take(100)->get();
//        $services = Service::whereBetween('price_start', [1, 100])->take(100)->get();
		$date_offset = $request->get('date_offset');
		
		return view('admin.services.request')->with([
		  'services' => $services,
		  'date_offset' => $date_offset
		]);
	}
}
