<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слага

class BiddingType extends Model
{
    use Sluggable;
    
    protected $fillable = ['title', 'code'];//указываем массив каких данных сохранять в таблицу при создании нового типа торгов
    
    //ДОЧЕРНЯЯ связь - с услугами
    public function services()
    {
		return $this->hasMany(BiddingType::class, 'bidding_type');	//имеет много	
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
