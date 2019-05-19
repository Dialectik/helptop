<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //РОДИТЕЛЬСКАЯ связь - пользователь продавец
    public function userSeller()
    {
		return $this->belongsTo(User::class, 'user_seller_id');  //принадлежит 
	}
	//РОДИТЕЛЬСКАЯ связь - пользователь покупатель
    public function userBuyer()
    {
		return $this->belongsTo(User::class, 'user_buyer_id');  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - сделка
    public function deal()
    {
		return $this->belongsTo(Deal::class);  //принадлежит 
	}
	
    
    
    
    
    
    
}
