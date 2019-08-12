<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BiddingRate extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['bidding_type', 'price_start', 'price_end', 'rate_bidding'];
    
    //РОДИТЕЛЬСКАЯ связь - типы торгов
	public function biddingType()
	{
		return $this->belongsTo(BiddingType::class, 'bidding_type');  //принадлежит типу торгов
	}
	
	//ДОЧЕРНЯЯ связь - с услугами
    public function services()
    {
		return $this->hasMany(Service::class, 'rate_bidding_id');	//имеет много	
	}
    
    //вывод названия типа торгов
    public function biddingTypeTitle()
    {
		return $this->biddingType != null ? $this->biddingType->title : null;
	}
}
