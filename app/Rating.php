<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    
    //РОДИТЕЛЬСКАЯ связь - создание связи рейтинга с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
    
    
    
    
    
}
