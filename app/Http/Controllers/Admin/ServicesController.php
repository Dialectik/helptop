<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;  //модуль конвертации дат
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Admin\ProductCodeExcess;

class ServicesController extends Controller
{
    
    public function index()
    {
        $sections = Section::all();
                        
        return view('admin.services.index', [
        	'sections' => $sections
        	
        ]);
    }

    
    public function create()
    {
        $sections = Section::all();
        //$date_on = date('Y-m-d H:i:s');  не использовать - дата задается в виде с помощью js
        
		

        return view('admin.services.create', [
			'sections' => $sections
			
            
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
            'title' =>'required',
            'section_id' =>'required',
            'category_id' =>'required',
            'kind_id' =>'required',
            'bidding_type' =>'required',
            'content'   =>  'required',
            'period'  =>  'required',
            'date_on'  =>  'required',
            'date_off'  =>  'required',
            'image' =>  'nullable|image'
        ]);

        $service = Service::add($request->all());
        $service->uploadImage($request->file('image'));
        $service->toggleFeatured($request->get('is_featured'));
        
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        
		
		$serviceCodeEnd = substr($request->product_code_id, 6, 4) * 1;
		if($serviceCodeEnd > 8000){
				$kind_id = $request->kind_id;
				$kind_title = Kind::where('id', $request->kind_id)->value('title');
				event(new ProductCodeExcess($kind_id, $kind_title));
			}
		

        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        $sections = Section::all();
        
        return view('admin.services.edit', [
        	'service' => $service,
        	'sections' => $sections        	
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
            'content'   =>  'required',
            'period'  =>  'required',
            'date_on'  =>  'required',
            'date_off'  =>  'required',
            'image' =>  'nullable|image'
        ]);
		
        $service = Service::find($id);
        $service->edit($request->all());
        $service->uploadImage($request->file('image'));
        $service->toggleFeatured($request->get('is_featured'));
        
        //Перезаписать даты начала публикации и конца в базе
        $service->setDateOnAttribute($request->get('date_on'), $request->get('date_offset'));
        $service->setDateOffAttribute($request->get('date_off'), $request->get('date_offset'));
        
        //Обновить категорию и вид услуг в базе, если в форме "edit" они менялись
        if($request->category_id_v != null & $request->category_id_v != $request->category_id){
			$service->category_id = $request->category_id_v;
		}
        if($request->kind_id_v != null & $request->kind_id_v != $request->kind_id){
			$service->kind_id = $request->kind_id_v;
		}
        
        $service->slug = str_slug($service->title);               //Изменение слага перед сохранением по мотивам измененного названия
    	$service->save();

        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::find($id)->remove();
        return redirect()->route('services.index');
    }
}
