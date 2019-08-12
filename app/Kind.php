<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слага

class Kind extends Model
{
    use Sluggable;
    
    protected $fillable = ['title', 'code', 'section_id', 'category_id', 'keywords', 'description'];//указываем массив каких данных сохранять в таблицу при создании нового вида услуг
    
    //РОДИТЕЛЬСКАЯ связь - создание связи вида услуг с разделом
    public function section()
    {
		return $this->belongsTo(Section::class);  //принадлежит разделу
	}
    
    //РОДИТЕЛЬСКАЯ связь - создание связи вида услуг с категорией
    public function category()
    {
		return $this->belongsTo(Category::class);  //принадлежит категории
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
	
	
	
	//Вывод раздела, в который входит вид услуг
	public function getSectionTitle()
	{
		return ($this->section != null) 
                ?   $this->section->title
                :   'Нет раздела';
	}
	       
    //вывод айди раздела для данного вида услуг
    public function getSectionID()
    {
        return $this->section != null ? $this->section->id : null;
    }
    
    
    //Вывод категории, в которую входит вид услуг
	public function getCategoryTitle()
    {
        return ($this->category != null) 
                ?   $this->category->title
                :   'Нет категории';
    }
	       
    //вывод айди категории для данного вида услуг
    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }
    
    //вывод кода категории для данного вида услуги
    public function getCategoryCode()
    {
        return $this->category != null ? $this->category->code : null;
    }
    
    //установить код вида услуг для данной категории
    public function setKindCode($request)
    {
        return  $request->cat_code != null ? $request->cat_code . $request->code : null;
    }
    
    //вывод коненой части кода вида услуг
    public function getKindEndCode()
    {
        return $this->code[4] . $this->code[5];
    }
    
}
