<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['service_id', 'bidding_type', 'price_fin', 'number_unit', 'user_seller_id', 'user_buyer_id'];
    
    //РОДИТЕЛЬСКАЯ связь - услуга
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
	
	
	
}
