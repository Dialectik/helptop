<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;  //модуль конвертации дат
use App\Service;
use App\Section;
use App\Category;
use App\Kind;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'content'   =>  'required',
            'date'  =>  'required',
            'image' =>  'nullable|image'
        ]);

        $service = Service::add($request->all());
        $service->uploadImage($request->file('image'));
//        $service->setCategory($request->get('category_id'));
        $service->toggleFeatured($request->get('is_featured'));
        $date_on = new Carbon();
        $period = $request->get('period');
		$date_off = $date_on->addDays($period);
		$this->date_on = $date_on;          //Установить дату начала публикации услуги
		$this->date_off = $date_off;        //Установить дату окончания публикации услуги
		$this->save();

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
        $categories = Category::pluck('title', 'id')->all();
        $categorySer = Category::find($id);

        return view('admin.services.edit', compact(
            'categories',
            'service',
            'categorySer'
        
        ));

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
            'date'  =>  'required',
            'image' =>  'nullable|image'
        ]);

        $service = Service::find($id);
        $service->edit($request->all());
        $service->uploadImage($request->file('image'));
        $service->setCategory($request->get('category_id'));
        $service->toggleStatus($request->get('status'));
        $service->toggleFeatured($request->get('is_featured'));

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
