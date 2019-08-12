<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слагов
use Illuminate\Database\Eloquent\Collection;

class Reference extends Model
{
	use Sluggable;
	
	//указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['title', 'content', 'section_ref'];
	
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
