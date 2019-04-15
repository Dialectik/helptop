<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слага

class Category extends Model
{
    use Sluggable;
    
    protected $fillable = ['title', 'section_id'];//указываем массив каких данных сохранять в таблицу при создании новой категории
    
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
    
}
