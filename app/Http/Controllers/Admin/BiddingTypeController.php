<?php

namespace App\Http\Controllers\Admin;

use App\BiddingType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BiddingTypeController extends Controller
{
    
    public function index()
    {
        $bidding_types = BiddingType::all();
    	return view('admin.bidding_types.index', ['bidding_types'	=>	$bidding_types]);
    }

   
    public function create()
    {
        return view('admin.bidding_types.create');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
    		'title'	=>	'required',              //обязательно значение
    		'code' => 'required|min:11|numeric'   //обязательно значение, не менее 11, только цифры
    	]);

    	BiddingType::create($request->all());
    	return redirect()->route('bidding_type.index');
    }
    
    public function edit($id)
    {
        $bidding_type = BiddingType::find($id);
    	return view('admin.bidding_types.edit', ['bidding_type'=>$bidding_type]);
    }
   
    public function update(Request $request, $id)
    {
        $this->validate($request, [
    		'title'	=>	'required',              //обязательно
    		'code' => 'required|min:11|numeric'   //обязательно значение, не менее 11, только цифры
    	]);

    	$bidding_type = BiddingType::find($id);
    	$bidding_type->update($request->all());
    	$bidding_type->slug = str_slug($bidding_type->title);   //Изменение слага перед сохранением по мотивам измененного названия
    	$bidding_type->save();
    	return redirect()->route('bidding_type.index');
    }

    public function destroy($id)
    {
        BiddingType::find($id)->delete();
    	return redirect()->route('bidding_type.index');
    }
}
