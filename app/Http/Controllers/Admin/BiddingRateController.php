<?php

namespace App\Http\Controllers\Admin;

use App\BiddingRate;
use App\BiddingType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BiddingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bidding_rates = BiddingRate::select('id', 'bidding_type', 'price_start', 'price_end', 'rate_bidding')->get();
        $bidding_types = BiddingType::all();
    	return view('admin.bidding_rates.index', [
    		'bidding_rates'	=> $bidding_rates,
    		'bidding_types' => $bidding_types,
    		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bidding_types = BiddingType::all();
        return view('admin.bidding_rates.create', [
    		'bidding_types' => $bidding_types,
    		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bidding_type' => 'required', 
            'price_start' => 'required', 
            'price_end' => 'required', 
            'rate_bidding' => 'required',
        ]);
        $bidding_rate = BiddingRate::create($request->all());
        $bidding_rate->save();
        return redirect()->route('bidding_rates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bidding_rates = BiddingRate::select('bidding_type', 'price_start', 'price_end', 'rate_bidding')->orderBy('price_end', 'asc')->get();
        $bidding_types = BiddingType::all();
        return view('admin.bidding_rates.show', [
        	'bidding_rates'	=> $bidding_rates,
    		'bidding_types' => $bidding_types,
    		'id' => $id,
          ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bidding_rate = BiddingRate::find($id);
        $bidding_types = BiddingType::all();
        return view('admin.bidding_rates.edit', [
        	'bidding_rate'	=> $bidding_rate,
    		'bidding_types' => $bidding_types,
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'bidding_type' => 'required', 
            'price_start' => 'required', 
            'price_end' => 'required', 
            'rate_bidding' => 'required',
        ]);
        $bidding_rate = BiddingRate::find($id);
        $bidding_rate->update($request->all());
        
        $bidding_rate->save();
        return redirect()->route('bidding_rates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BiddingRate::find($id)->delete();
        return redirect()->route('bidding_rates.index');
    }
}
