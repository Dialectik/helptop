<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слагов

class BlurbType extends Model
{
    use Sluggable;
    
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['title', 'type_blurb', 'period_blurb', 'code', 'blurb_price'];
    
    //ДОЧЕРНЯЯ связь - реклама
	public function blurbs()
    {
		return $this->hasMany(Blurb::class, 'blurb_type');		//имеет много
	}
	
	//применение функции френдли-ссылок на страницы
	public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
	
}
