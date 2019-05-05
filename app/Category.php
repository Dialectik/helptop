<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слага

class Category extends Model
{
    use Sluggable;
    
    protected $fillable = ['title', 'code', 'section_id'];//указываем массив каких данных сохранять в таблицу при создании новой категории
    
    //РОДИТЕЛЬСКАЯ связь - создание связи категории с разделом
    public function section()
    {
		return $this->belongsTo(Section::class);  //принадлежит разделу
	}
    
        
	
	//ДОЧЕРНЯЯ связь - связь категории с видами услуг
    public function kinds()
    {
		return $this->hasMany(Kind::class);	//имеет много	
	}
	
	//ДОЧЕРНЯЯ связь - связь категории с услугой
    public function services()
    {
		return $this->hasMany(Service::class);	//имеет много	
	}
	
	
	//формирование слага
	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}
    
    //Вывод раздела, в который входит категория
	public function getSectionTitle()
	{
		return ($this->section != null) 
                ?   $this->section->title
                :   'Нет раздела';
	}
	       
    //вывод айди раздела для данной категории
    public function getSectionID()
    {
        return $this->section != null ? $this->section->id : null;
    }
    
    //вывод кода раздела для данной категории
    public function getSectionCode()
    {
        return $this->section != null ? $this->section->code : null;
    }
    
    //установить код раздела для данной категории
    public function setCategoryCode($request)
    {
        return  $request->pre_code != null ? $request->pre_code . $request->code : null;
    }
    
    //вывод коненой части кода категории
    public function getCatEndCode()
    {
        return $this->code[2] . $this->code[3];
    }
    
    
    
}
