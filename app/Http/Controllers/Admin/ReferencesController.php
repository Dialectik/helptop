<?php

namespace App\Http\Controllers\Admin;

use App\Reference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $references = Reference::select('id', 'title', 'section_ref', 'updated_at')->get();
    	return view('admin.references.index', ['references'	=>	$references]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.references.create');
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
            'title' =>'required',
            'content' =>'required',
        ]);
        $reference = Reference::create($request->all());
        $reference->save();
        return redirect()->route('references.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reference = Reference::find($id);
        return view('admin.references.show', [
        	'reference' => $reference,
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
        $reference = Reference::find($id);
        return view('admin.references.edit', [
        	'reference' => $reference,
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
            'title' =>'required',
            'content' =>'required',
        ]);
        $reference = Reference::find($id);
        $reference->update($request->all());
        //Изменение слага перед сохранением по мотивам измененного названия
        $reference->slug = str_slug($reference->title);
        
        $reference->save();
        return redirect()->route('references.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reference::find($id)->delete();
        return redirect()->route('references.index');
    }
}
