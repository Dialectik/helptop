<?php

namespace App\Http\Controllers\Admin;

use App\BlurbType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlurbTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blurb_types = BlurbType::select('id', 'title', 'type_blurb', 'period_blurb', 'code', 'blurb_price')->get();
    	return view('admin.blurb_types.index', ['blurb_types'	=>	$blurb_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blurb_types.create');
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
            'title' => 'required', 
            'type_blurb' => 'required',
            'period_blurb' => 'required', 
            'code' => 'required', 
            'blurb_price' => 'required',
        ]);
        $blurb_type = BlurbType::create($request->all());
        $blurb_type->save();
        return redirect()->route('blurb_types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blurb_types = BlurbType::select('id', 'type_blurb', 'blurb_price')->get();
        return view('admin.blurb_types.show', [
        	'blurb_types' => $blurb_types,
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
        $blurb_type = BlurbType::find($id);
        return view('admin.blurb_types.edit', [
        	'blurb_type' => $blurb_type,
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
            'title' => 'required', 
            'type_blurb' => 'required',
            'period_blurb' => 'required', 
            'code' => 'required', 
            'blurb_price' => 'required',
        ]);
        $blurb_type = BlurbType::find($id);
        $blurb_type->update($request->all());
        //Изменение слага перед сохранением по мотивам измененного названия
        $blurb_type->slug = str_slug($blurb_type->title); 
        
        $blurb_type->save();
        return redirect()->route('blurb_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlurbType::find($id)->delete();
        return redirect()->route('blurb_types.index');
    }
}
