<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слага

class Section extends Model
{
    use Sluggable;
    
    protected $fillable = ['title', 'code', 'keywords', 'description'];//указываем массив каких данных сохранять в таблицу при создании нового раздела
    
    	
	//ДОЧЕРНЯЯ связь - связь раздела с категорией
    public function categories()
    {
		return $this->hasMany(Category::class);	//имеет много	
	}
	
	//ДОЧЕРНЯЯ связь - связь раздела с видами услуг
    public function kinds()
    {
		return $this->hasMany(Kind::class);	//имеет много	
	}
	
	//ДОЧЕРНЯЯ связь - связь раздела с услугами
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
}
